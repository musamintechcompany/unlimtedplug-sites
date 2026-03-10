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
    document.getElementById('buy-options-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeBuyModal() {
    document.getElementById('buy-options-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openRentModal(pricing) {
    window.projectPricing = pricing || window.projectPricing;
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
    closeRentDurationModal,
    openShareModal: function() {
        document.body.style.overflow = 'hidden';
        document.getElementById('share-modal').classList.remove('hidden');
    },
    closeShareModal: function() {
        document.body.style.overflow = '';
        document.getElementById('share-modal').classList.add('hidden');
    },
    copyShareLink: function() {
        const link = document.getElementById('share-link');
        navigator.clipboard.writeText(link.value).then(() => {
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            setTimeout(() => {
                btn.textContent = originalText;
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 1500);
        });
    },
    openSystemSupportModal: function() {
        document.body.style.overflow = 'hidden';
        document.getElementById('system-support-modal').classList.remove('hidden');
    },
    closeSystemSupportModal: function() {
        document.body.style.overflow = '';
        document.getElementById('system-support-modal').classList.add('hidden');
    },
    openWhatsApp: function() {
        const phoneNumber = '447452792596';
        const projectName = document.querySelector('h1')?.textContent || 'Project';
        const projectId = document.querySelector('meta[name="project-id"]')?.content || '';
        const selectedOption = window.SELECTED_BUY_OPTION || 'general';
        const optionLabel = selectedOption === 'source' ? 'Source Code' : 'Hosting Package';
        const message = `Hi, I am interested in the ${optionLabel} option for ${projectName} from Unlimited Plug Sites. Project ID: ${projectId}. Option: ${btoa(selectedOption)}`;
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    },
    proceedToSupport: function() {
        window.projectShow.closeBuyModal();
        window.projectShow.openSystemSupportModal();
    }
};

// Expose modal functions globally for inline onclick
window.closeBuyModal = closeBuyModal;
window.closeRentModal = closeRentModal;
window.closeRentDurationModal = closeRentDurationModal;

// Renewal Modal Functions
let renewalData = {};

window.handleRenewClick = function(status, rentalId, projectId, durationValue, durationType, originalCost, expiresAt, userBalance) {
    if (status === 'active') {
        return; // Tooltip already shown via CSS
    }
    if (status === 'on_hold' || status === 'expired') {
        window.openRenewModal(rentalId, projectId, durationValue, durationType, originalCost, expiresAt, userBalance);
    }
};

window.openRenewModal = function(rentalId, projectId, durationValue, durationType, originalCost, expiresAt, userBalance) {
    document.body.style.overflow = 'hidden';
    document.getElementById('renewModal').classList.remove('hidden');
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('renewForm').classList.add('hidden');
    
    window.RENTAL_DATA = { id: rentalId, projectId, durationValue, durationType, originalCost, expiresAt, userBalance };
    
    fetch(`/api/projects/${projectId}/check`)
        .then(response => response.json())
        .then(data => {
            if (!data.exists) {
                showRenewError('Project no longer available');
                return;
            }
            renewalData = {
                currentPricing: data.pricing,
                durationType: durationType
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
    
    const durationType = renewalData.durationType;
    const priceMap = {
        'daily': renewalData.currentPricing.pricing_24h,
        'weekly': renewalData.currentPricing.pricing_7d,
        'monthly': renewalData.currentPricing.pricing_30d,
        'yearly': renewalData.currentPricing.pricing_365d
    };
    
    const pricePerUnit = priceMap[durationType];
    const displayType = durationType === 'daily' ? 'day' : durationType === 'weekly' ? 'week' : durationType === 'monthly' ? 'month' : 'year';
    const displayTypePlural = displayType + 's';
    
    renewalData.durationType = durationType;
    renewalData.pricePerUnit = pricePerUnit;
    
    document.getElementById('originalPrice').textContent = `${window.RENTAL_DATA.originalCost} cr`;
    document.getElementById('currentPrice').textContent = `${pricePerUnit} cr/${displayType}`;
    document.getElementById('durationType').textContent = displayTypePlural;
    
    calculateRenewal();
}

window.calculateRenewal = function() {
    const quantity = parseInt(document.getElementById('durationInput').value) || 1;
    const totalCost = quantity * renewalData.pricePerUnit;
    
    document.getElementById('totalCost').textContent = `${totalCost} credits`;
    
    const currentExpiry = new Date(window.RENTAL_DATA.expiresAt);
    let newExpiry = new Date(currentExpiry);
    
    const daysMap = {yearly: 365, monthly: 30, weekly: 7, daily: 1};
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
};;

window.submitRenewal = function() {
    const quantity = parseInt(document.getElementById('durationInput').value) || 1;
    const button = document.getElementById('renewButton');
    const cancelBtn = document.getElementById('renew-cancel-btn');
    
    button.disabled = true;
    cancelBtn.classList.add('hidden');
    button.classList.add('w-full');
    document.getElementById('renew-spinner').classList.remove('hidden');
    document.getElementById('renew-text').textContent = 'Authenticating...';
    
    // Step 1: Authenticating (500ms)
    setTimeout(() => {
        document.getElementById('renew-text').textContent = 'Validating...';
    }, 500);
    
    // Step 2: Validating (1000ms)
    setTimeout(() => {
        document.getElementById('renew-text').textContent = 'Processing...';
    }, 1000);
    
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
            showRenewalSuccess(data.message, data.new_expiry);
        } else {
            showRenewalError(data.error || 'Failed to renew');
            button.disabled = false;
            cancelBtn.classList.remove('hidden');
            button.classList.remove('w-full');
            document.getElementById('renew-spinner').classList.add('hidden');
            document.getElementById('renew-text').textContent = 'Confirm';
        }
    })
    .catch(() => {
        showRenewalError('An error occurred');
        button.disabled = false;
        cancelBtn.classList.remove('hidden');
        button.classList.remove('w-full');
        document.getElementById('renew-spinner').classList.add('hidden');
        document.getElementById('renew-text').textContent = 'Confirm';
    });
};

function showRenewalSuccess(message, newExpiry) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="text-center py-12 px-6">
            <svg class="h-12 w-12 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-3 text-base font-semibold text-gray-900 dark:text-[#EDEDEC]">Renewal Successful</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">${message}</p>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">New expiry: ${new Date(newExpiry).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
            <button onclick="closeRenewModal(); location.reload();" class="mt-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                Okay
            </button>
        </div>
    `;
}

function showRenewalError(message) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="text-center py-12 px-6">
            <svg class="h-12 w-12 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="mt-3 text-base font-semibold text-gray-900 dark:text-[#EDEDEC]">Renewal Failed</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">${message}</p>
            <button onclick="closeRenewModal()" class="mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                Close
            </button>
        </div>
    `;
}

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
    window.BASE_CREDITS = credits;
    window.selectPackage(credits + bonus, amount, button);
};

/**
 * Select credit package and initiate payment
 */
window.selectPackage = function(credits, amount, button, baseCredits = null) {
    const buttonText = button.querySelector('.button-text');
    const buttonSpinner = button.querySelector('.button-spinner');
    buttonText.textContent = 'Processing...';
    buttonSpinner.classList.remove('hidden');
    button.disabled = true;
    
    // Store base credits for notification
    window.BASE_CREDITS = baseCredits || credits;
    
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
    const baseCredits = window.BASE_CREDITS || credits;
    const price = (baseCredits / 10) * pricePerTen;
    
    console.log('Verifying payment:', {transactionId, credits, baseCredits, currency, price});
    fetch('/credits/verify-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            transaction_id: transactionId,
            credits: credits,
            base_credits: baseCredits,
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

// ============================================
// RENTAL CREDENTIALS VISIBILITY TOGGLE
// ============================================
// These functions manage credential display on rental details page
// Full values are stored in data-* attributes to avoid embedding sensitive data in HTML

/**
 * Toggle Admin URL visibility
 * Masks/unmasks URL by showing last 4 characters only when hidden
 * Uses data-full-url attribute to store complete URL
 */
window.toggleAdminUrlVisibility = function() {
    const display = document.getElementById('admin-url');
    const eyeIcon = document.getElementById('admin-url-eye-icon');
    const eyeSlashIcon = document.getElementById('admin-url-eye-slash-icon');
    const fullUrl = display.getAttribute('data-full-url');
    
    if (display.textContent.includes('*')) {
        display.textContent = fullUrl;
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        display.textContent = '*'.repeat(fullUrl.length - 4) + fullUrl.substring(fullUrl.length - 4);
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
};

/**
 * Toggle App URL visibility
 * Shows/hides full URL
 * Uses data-full-url attribute to store complete URL
 */
window.toggleAppUrlVisibility = function() {
    const display = document.getElementById('app-url');
    const eyeIcon = document.getElementById('app-url-eye-icon');
    const eyeSlashIcon = document.getElementById('app-url-eye-slash-icon');
    const fullUrl = display.getAttribute('data-full-url');
    
    if (display.textContent === fullUrl) {
        display.textContent = fullUrl.substring(0, 4) + '*'.repeat(fullUrl.length - 8) + fullUrl.substring(fullUrl.length - 4);
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    } else {
        display.textContent = fullUrl;
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    }
};

/**
 * Toggle Admin ID visibility
 * Shows/hides full ID
 * Uses data-full-id attribute to store complete ID
 */
window.toggleAdminIdVisibility = function() {
    const display = document.getElementById('admin-id-display');
    const eyeIcon = document.getElementById('admin-id-eye-icon');
    const eyeSlashIcon = document.getElementById('admin-id-eye-slash-icon');
    const fullId = display.getAttribute('data-full-id');
    
    // Toggle between masked and full view
    if (display.textContent === fullId) {
        // Currently showing full ID, mask it
        display.textContent = fullId.substring(0, 4) + '*'.repeat(fullId.length - 8) + fullId.substring(fullId.length - 4);
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    } else {
        // Currently masked, show full ID
        display.textContent = fullId;
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    }
};

/**
 * Toggle Email visibility
 * Shows/hides full email
 * Uses data-full-email attribute to store complete email
 */
window.toggleEmailVisibility = function() {
    const display = document.getElementById('admin-email');
    const eyeIcon = document.getElementById('email-eye-icon');
    const eyeSlashIcon = document.getElementById('email-eye-slash-icon');
    const fullEmail = display.getAttribute('data-full-email');
    
    // Toggle between masked and full view
    if (display.textContent === fullEmail) {
        // Currently showing full email, mask it
        display.textContent = fullEmail.substring(0, 4) + '*'.repeat(fullEmail.length - 8) + fullEmail.substring(fullEmail.length - 4);
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    } else {
        // Currently masked, show full email
        display.textContent = fullEmail;
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    }
};

/**
 * Toggle Password visibility
 * Switches input type between 'password' and 'text'
 */
window.togglePasswordVisibility = function() {
    const input = document.getElementById('admin-password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');
    
    // Toggle input type
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
};

/**
 * Copy Admin ID to clipboard
 * Retrieves full ID from data attribute and copies to clipboard
 * Shows "Copied!" feedback for 1.5 seconds
 */
window.copyAdminId = function() {
    const adminId = document.getElementById('admin-id-display').getAttribute('data-full-id');
    navigator.clipboard.writeText(adminId).then(() => {
        const element = document.getElementById('admin-id-display');
        const originalText = element.textContent;
        // Show feedback
        element.textContent = 'Copied!';
        element.classList.add('text-green-600');
        // Restore original text after 1.5 seconds
        setTimeout(() => {
            element.textContent = originalText;
            element.classList.remove('text-green-600');
        }, 1500);
    });
};

/**
 * Copy credential to clipboard
 * Handles copying from data attributes for masked fields
 * @param {string} elementId - ID of element to copy from
 */
window.copyToClipboard = function(elementId) {
    const element = document.getElementById(elementId);
    let textToCopy = element.textContent;
    
    // For masked fields, get full value from data attribute
    if (elementId === 'admin-url' || elementId === 'app-url') {
        textToCopy = element.getAttribute('data-full-url');
    } else if (elementId === 'admin-email') {
        textToCopy = element.getAttribute('data-full-email');
    }
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        const originalText = element.textContent;
        // Show feedback
        element.textContent = 'Copied!';
        element.classList.add('text-green-600');
        // Restore original text after 1.5 seconds
        setTimeout(() => {
            element.textContent = originalText;
            element.classList.remove('text-green-600');
        }, 1500);
    });
};

/**
 * Copy Password to clipboard
 * Copies password value from input field
 * Shows checkmark icon feedback for 1.5 seconds
 */
window.copyPassword = function() {
    const input = document.getElementById('admin-password');
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = document.getElementById('copy-password-btn');
        const originalHTML = btn.innerHTML;
        // Show checkmark feedback
        btn.innerHTML = '<svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
        // Restore original icon after 1.5 seconds
        setTimeout(() => {
            btn.innerHTML = originalHTML;
        }, 1500);
    });
};

/**
 * Refresh credentials from server
 * Calls backend to regenerate admin credentials
 * Updates email and admin URL display with new values
 * Shows loading spinner and success/error message
 */
window.refreshCredentials = function() {
    const btn = document.getElementById('refresh-btn');
    const statusMsg = document.getElementById('status-message');
    btn.disabled = true;
    // Show loading spinner
    btn.innerHTML = '<svg class="w-4 h-4 inline animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';

    // Extract rental ID from URL path
    const rentalId = window.location.pathname.split('/').pop();
    // Call backend to refresh credentials
    fetch(`/rentals/${rentalId}/update-credentials`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                // Update email display
                document.getElementById('admin-email').textContent = data.data.email;
                // Update admin URL if provided
                if (data.data.admin_url) {
                    const urlElement = document.getElementById('admin-url');
                    urlElement.setAttribute('data-full-url', data.data.admin_url);
                    urlElement.href = data.data.admin_url;
                    urlElement.className = 'block font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all text-blue-600 dark:text-blue-400 hover:underline';
                }
                // Show success message
                statusMsg.textContent = '✓ Credentials updated successfully';
                statusMsg.className = 'p-3 rounded text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            } else {
                // Show error message
                statusMsg.textContent = '✗ Failed to update credentials';
                statusMsg.className = 'p-3 rounded text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
            }
        })
        .catch(() => {
            // Show error on network failure
            statusMsg.textContent = '✗ An error occurred';
            statusMsg.className = 'p-3 rounded text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        })
        .finally(() => {
            // Show message and restore button
            statusMsg.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Refresh';
            // Auto-hide message after 5 seconds
            setTimeout(() => statusMsg.classList.add('hidden'), 5000);
        });
};



/**
 * Toggle theme between light and dark mode
 * Saves preference to database via AJAX
 */
window.toggleTheme = function() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    const newTheme = isDark ? 'light' : 'dark';
    
    // Update HTML class immediately
    if (isDark) {
        html.classList.remove('dark');
    } else {
        html.classList.add('dark');
    }
    
    // Save to database
    fetch('/theme/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ theme: newTheme })
    });
};

/**
 * Toggle notifications sidebar
 */
window.toggleNotifications = function() {
    const nav = document.querySelector('[x-data*="notificationsOpen"]');
    if (nav && nav.__x) {
        nav.__x.$data.notificationsOpen = !nav.__x.$data.notificationsOpen;
    }
};

// ============================================
// NOTIFICATION FUNCTIONS
// ============================================

/**
 * Mark all notifications as read in database
 */
window.markAllAsReadNow = function() {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
};


// ============================================
// SCROLL-TRIGGERED ANIMATIONS
// ============================================

/**
 * Initialize scroll-triggered animations for elements with data-animation attribute
 * Supports staggered delays via data-animation-delay attribute
 * Applies animation classes on scroll intersection
 */
document.addEventListener('DOMContentLoaded', function() {
    // Buy modal option selection
    document.querySelectorAll('.buy-option').forEach(option => {
        option.addEventListener('click', function() {
            const optionId = this.getAttribute('data-id');
            document.querySelectorAll('.buy-option').forEach(el => {
                el.classList.remove('border-blue-500', 'bg-blue-50');
                el.classList.add('border-gray-200');
                el.querySelector('.checkbox-icon').innerHTML = '';
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-blue-500', 'bg-blue-50');
            this.querySelector('.checkbox-icon').innerHTML = '<svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
            window.SELECTED_BUY_OPTION = optionId;
            document.getElementById('buy-continue-btn').disabled = false;
        });
    });
    
    // Initialize custom price on credits page
    if (document.getElementById('customAmount')) {
        calculateCustomPrice();
    }
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                const delay = (entry.target.dataset.animationDelay || 0) * 100;
                setTimeout(() => {
                    entry.target.classList.remove('opacity-0');
                    const animationClass = entry.target.dataset.animation || 'animate-fade-in-up';
                    entry.target.classList.add(animationClass);
                }, delay);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animation]').forEach(el => observer.observe(el));
});
