<div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-12 sm:px-6">
    <div class="mb-8">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
        </a>
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] overflow-hidden sm:rounded-2xl">
        {{ $slot }}
    </div>
</div>
