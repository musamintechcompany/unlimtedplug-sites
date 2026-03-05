<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-md font-semibold text-xs text-gray-700 dark:text-[#EDEDEC] uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-[#1a1a19] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-[#0a0a0a] disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
