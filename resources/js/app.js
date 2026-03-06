import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Project Show Page Functions
let allImages = [];
let currentImageIndex = 0;

function initProjectShow(images) {
    allImages = images;
}

function changeMainImage(imageSrc, thumbnail) {
    document.getElementById('mainImage').src = imageSrc;
    document.querySelectorAll('[onclick*="changeMainImage"]').forEach(thumb => {
        thumb.classList.remove('ring-2', 'ring-blue-500');
    });
    thumbnail.classList.add('ring-2', 'ring-blue-500');
    currentImageIndex = allImages.indexOf(imageSrc);
}

function openFullscreen() {
    const mainImage = document.getElementById('mainImage');
    const modal = document.getElementById('fullscreen-modal');
    
    currentImageIndex = allImages.indexOf(mainImage.src);
    if (currentImageIndex === -1) currentImageIndex = 0;
    
    modal.innerHTML = `
        <button onclick="window.projectShow.closeFullscreen()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-white/10 hover:bg-white/20 p-2 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img id="fullscreen-image" src="${mainImage.src}" alt="" class="max-w-full max-h-[90vh] object-contain select-none" onclick="event.stopPropagation()">
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    const modal = document.getElementById('fullscreen-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

function openBuyModal() {
    document.getElementById('purchase-options-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeBuyModal() {
    document.getElementById('purchase-options-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openRentModal(pricing) {
    window.projectPricing = pricing;
    document.getElementById('rental-duration-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRentModal() {
    document.getElementById('rental-options-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function closeRentDurationModal() {
    document.getElementById('rental-duration-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function updateFullscreenImage() {
    const fullscreenImage = document.getElementById('fullscreen-image');
    if (fullscreenImage) {
        fullscreenImage.src = allImages[currentImageIndex];
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('fullscreen-modal');
    if (modal && !modal.classList.contains('hidden')) {
        if (e.key === 'Escape') {
            closeFullscreen();
        } else if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
            currentImageIndex--;
            updateFullscreenImage();
        } else if (e.key === 'ArrowRight' && currentImageIndex < allImages.length - 1) {
            currentImageIndex++;
            updateFullscreenImage();
        }
    }
});

// Expose to window
window.projectShow = {
    initProjectShow,
    changeMainImage,
    openFullscreen,
    closeFullscreen,
    toggleSection,
    openBuyModal,
    closeBuyModal,
    openRentModal,
    closeRentModal,
    closeRentDurationModal
};

// Expose modal functions globally for inline onclick
window.closeBuyModal = closeBuyModal;
window.closeRentModal = closeRentModal;
window.closeRentDurationModal = closeRentDurationModal;

// Renewal Modal Functions
let renewalData = {};

window.openRenewModal = function(rentalId, projectId, durationDays, originalCost, expiresAt, userBalance) {
    document.body.style.overflow = 'hidden';
    document.getElementById('renewModal').classList.remove('hidden');
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('renewForm').classList.add('hidden');
    
    window.RENTAL_DATA = { id: rentalId, projectId, durationDays, originalCost, expiresAt, userBalance };
    
    fetch(`/api/projects/${projectId}/check`)
        .then(response => response.json())
        .then(data => {
            if (!data.exists) {
                showRenewError('Project no longer available');
                return;
            }
            renewalData = {
                originalPricePerDay: originalCost / durationDays,
                currentPricing: data.pricing,
                durationDays: durationDays
            };
            showRenewForm();
        })
        .catch(() => showRenewError('Unable to check availability'));
};

window.closeRenewModal = function() {
    document.body.style.overflow = '';
    document.getElementById('renewModal').classList.add('hidden');
};

function showRenewError(message) {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('errorState').classList.remove('hidden');
    document.getElementById('errorMessage').textContent = message;
}

function showRenewForm() {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('renewForm').classList.remove('hidden');
    
    const durationDays = renewalData.durationDays;
    let durationType = 'days', pricePerUnit = renewalData.currentPricing.pricing_24h;
    
    if (durationDays >= 365) {
        durationType = 'years';
        pricePerUnit = renewalData.currentPricing.pricing_365d;
    } else if (durationDays >= 30) {
        durationType = 'months';
        pricePerUnit = renewalData.currentPricing.pricing_30d;
    } else if (durationDays >= 7) {
        durationType = 'weeks';
        pricePerUnit = renewalData.currentPricing.pricing_7d;
    }
    
    renewalData.durationType = durationType;
    renewalData.pricePerUnit = pricePerUnit;
    
    const originalTotal = renewalData.originalPricePerDay * durationDays;
    document.getElementById('originalPrice').textContent = `${originalTotal.toFixed(0)} cr`;
    document.getElementById('currentPrice').textContent = `${pricePerUnit} cr/${durationType.slice(0, -1)}`;
    document.getElementById('durationType').textContent = durationType;
    
    calculateRenewal();
}

window.calculateRenewal = function() {
    const quantity = parseInt(document.getElementById('durationInput').value) || 1;
    const totalCost = quantity * renewalData.pricePerUnit;
    
    document.getElementById('totalCost').textContent = `${totalCost} credits`;
    
    const currentExpiry = new Date(window.RENTAL_DATA.expiresAt);
    let newExpiry = new Date(currentExpiry);
    
    const daysMap = {years: 365, months: 30, weeks: 7, days: 1};
    newExpiry.setDate(newExpiry.getDate() + (quantity * daysMap[renewalData.durationType]));
    
    document.getElementById('newExpiry').textContent = newExpiry.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    
    const balance = window.RENTAL_DATA.userBalance || 0;
    const hasEnough = balance >= totalCost;
    const balanceEl = document.getElementById('userBalance');
    balanceEl.textContent = `${balance} cr`;
    balanceEl.className = hasEnough ? 'font-semibold text-green-600 dark:text-green-400' : 'font-semibold text-red-600 dark:text-red-400';
    
    document.getElementById('insufficientCredits').classList.toggle('hidden', hasEnough);
    document.getElementById('renewButton').disabled = !hasEnough;
    document.getElementById('renewButton').classList.toggle('opacity-50', !hasEnough);
};

window.submitRenewal = function() {
    const quantity = parseInt(document.getElementById('durationInput').value) || 1;
    const button = document.getElementById('renewButton');
    
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch(`/rentals/${window.RENTAL_DATA.id}/renew`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            quantity: quantity,
            duration_type: renewalData.durationType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Rental renewed successfully!');
            window.location.reload();
        } else {
            alert(data.error || 'Failed to renew');
            button.disabled = false;
            button.textContent = 'Confirm';
        }
    })
    .catch(() => {
        alert('An error occurred');
        button.disabled = false;
        button.textContent = 'Confirm';
    });
};

// Quill Editor Initialization
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Quill !== 'undefined' && document.getElementById('description')) {
        var quill = new Quill('#description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });
        
        // Load existing content if editing
        const existingContent = document.getElementById('description-input')?.value;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }
        
        // Save on form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                document.getElementById('description-input').value = quill.root.innerHTML;
            });
        }
    }
});

// Image Upload Handler
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    if (!dropZone) return;

    dropZone.addEventListener('click', () => imageInput.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropZone.addEventListener('dragover', () => {
        dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
    });

    dropZone.addEventListener('drop', (e) => {
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        imageInput.files = e.dataTransfer.files;
        previewImages();
    });

    imageInput.addEventListener('change', previewImages);

    function previewImages() {
        imagePreview.innerHTML = '';
        Array.from(imageInput.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition" onclick="this.parentElement.remove()">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
});


// ============================================
// CREDIT PURCHASE PAGE FUNCTIONS
// ============================================

/**
 * Calculate custom credit package price
 */
window.calculateCustomPrice = function() {
    const pricePerTen = window.CREDIT_CONFIG?.pricePerTen || 1;
    const currencySymbol = window.CREDIT_CONFIG?.currencySymbol || '$';
    
    const amount = parseInt(document.getElementById('customAmount').value) || 1000;
    const errorDiv = document.getElementById('customError');
    const bonusDiv = document.getElementById('customBonus');
    const button = document.getElementById('customButton');
    
    if (amount < 1000) {
        errorDiv.classList.remove('hidden');
        button.disabled = true;
        button.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        errorDiv.classList.add('hidden');
        button.disabled = false;
        button.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    let bonusPercent = amount >= 5000 ? 0.20 : 0.15;
    const bonus = Math.floor(amount * bonusPercent);
    bonusDiv.textContent = `+ ${bonus.toLocaleString()} Bonus Credits (${bonusPercent * 100}%)`;
    
    const price = (amount / 10) * pricePerTen;
    const priceElement = document.getElementById('customPrice');
    const formattedPrice = currencySymbol + price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    priceElement.textContent = formattedPrice;
    
    if (formattedPrice.length > 12) {
        priceElement.classList.remove('text-3xl');
        priceElement.classList.add('text-2xl');
    } else {
        priceElement.classList.remove('text-2xl');
        priceElement.classList.add('text-3xl');
    }
};

/**
 * Select custom credit package
 */
window.selectCustomPackage = function(button) {
    const pricePerTen = window.CREDIT_CONFIG?.pricePerTen || 1;
    const credits = parseInt(document.getElementById('customAmount').value) || 1000;
    if (credits < 1000) return;
    
    const amount = (credits / 10) * pricePerTen;
    let bonusPercent = credits >= 5000 ? 0.20 : 0.15;
    const bonus = Math.floor(credits * bonusPercent);
    window.selectPackage(credits + bonus, amount, button);
};

/**
 * Select credit package and initiate payment
 */
window.selectPackage = function(credits, amount, button) {
    const buttonText = button.querySelector('.button-text');
    const buttonSpinner = button.querySelector('.button-spinner');
    buttonText.textContent = 'Processing...';
    buttonSpinner.classList.remove('hidden');
    button.disabled = true;
    
    const config = window.CREDIT_CONFIG || {};
    
    FlutterwaveCheckout({
        public_key: config.publicKey,
        tx_ref: "CREDIT_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9),
        amount: amount,
        currency: config.currency,
        payment_options: "card,banktransfer,ussd",
        customer: {
            email: config.userEmail,
            name: config.userName,
        },
        customizations: {
            title: config.appName,
            description: credits + " Credits Purchase",
            logo: window.location.origin + "/favicon.svg",
        },
        meta: {
            project: "unlimitedplug-sites",
            user_id: config.userId,
            credits: credits,
        },
        callback: function(data) {
            if (data.status === "successful") {
                window.verifyPayment(data.transaction_id, credits);
            } else {
                window.location.href = '/dashboard?payment=failed';
            }
        },
        onclose: function() {
            buttonText.textContent = 'Purchase Now';
            buttonSpinner.classList.add('hidden');
            button.disabled = false;
        }
    });
};

/**
 * Set currency and reload page
 */
window.setCurrency = function(currency) {
    const dropdowns = document.querySelectorAll('[x-data]');
    dropdowns.forEach(dropdown => {
        if (dropdown.__x) {
            dropdown.__x.$data.open = false;
        }
    });
    
    document.querySelectorAll('#selected-currency, [id^="selected-currency"]').forEach(el => {
        if (el) el.textContent = currency;
    });
    
    document.querySelectorAll('[onclick^="setCurrency"]').forEach(btn => {
        btn.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400');
    });
    event.target.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400');
    
    fetch('/currency/set', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ currency: currency })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
};

/**
 * Verify payment after Flutterwave callback
 */
window.verifyPayment = function(transactionId, credits) {
    const config = window.CREDIT_CONFIG || {};
    const pricePerTen = config.pricePerTen || 1;
    const currency = config.currency || 'USD';
    const price = (credits / 10) * pricePerTen;
    
    console.log('Verifying payment:', {transactionId, credits, currency, price});
    fetch('/credits/verify-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            transaction_id: transactionId,
            credits: credits,
            currency: currency,
            price: price
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Verification response:', data);
        if (data.success) {
            window.location.href = '/dashboard?payment=success&credits=' + credits;
        } else {
            window.location.href = '/dashboard?payment=failed';
        }
    })
    .catch(error => {
        console.error('Verification error:', error);
        window.location.href = '/dashboard?payment=error';
    });
};

// Initialize custom price calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('customAmount')) {
        window.calculateCustomPrice();
    }
});

window.markAsRead = function(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
};

function openNotificationsSidebar() {
    const sidebar = document.getElementById('notificationsSidebar');
    const overlay = document.getElementById('notificationsSidebarOverlay');
    sidebar.style.display = 'flex';
    overlay.classList.remove('hidden');
    setTimeout(() => {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.add('opacity-100');
    }, 10);
}

function closeNotificationsSidebar() {
    const sidebar = document.getElementById('notificationsSidebar');
    const overlay = document.getElementById('notificationsSidebarOverlay');
    sidebar.classList.add('translate-x-full');
    overlay.classList.add('hidden');
    setTimeout(() => {
        sidebar.style.display = 'none';
    }, 300);
}
