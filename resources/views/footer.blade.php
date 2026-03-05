<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <x-application-logo class="h-8 w-8 fill-current text-indigo-600" />
                    <span class="text-lg font-bold text-white">{{ config('app.name') }}</span>
                </div>
                <p class="text-sm">Professional rentals for websites, web apps, mobile apps, and desktop apps made simple. Launch your digital solution in minutes.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-white">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('browse') }}" class="hover:text-white">Browse</a></li>
                    <li><a href="{{ route('how-it-works') }}" class="hover:text-white">How It Works</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-white">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-white">Contact</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Support</a></li>
                    <li><a href="#" class="hover:text-white">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
