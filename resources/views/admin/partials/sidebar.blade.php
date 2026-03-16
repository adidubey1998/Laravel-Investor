<aside class="w-64 bg-gray-900 text-gray-200 min-h-screen">
    <div class="px-6 py-4 text-xl font-bold border-b border-gray-700">
        Investor CMS
    </div>

    <nav class="mt-4 px-4">
        <ul class="space-y-2">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    📊 Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.tabs.index') }}"
                   class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    🧩 Investor Tabs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}"
                   class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    📰 News
                </a>
            </li>
            <li class="border-t border-gray-700 my-3"></li>

            {{-- Hint --}}
            <li class="text-xs text-gray-400 px-4">
                Manage files inside each tab
            </li>

        </ul>
    </nav>
</aside>
