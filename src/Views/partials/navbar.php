<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <a href="/campus-retrieve/public/home" class="flex-shrink-0 flex items-center">
                    <span class="text-blue-600 text-2xl font-bold tracking-tighter">CR</span>
                    <span class="ml-2 text-xl font-bold text-gray-900 hidden md:block">CampusRetrieve</span>
                </a>
            </div>

            <div class="hidden md:flex flex-1 items-center justify-center px-8">
                <div class="w-full max-w-lg relative">
                    <input type="text" class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" placeholder="Search for lost items...">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="/campus-retrieve/public/post" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Post Item
                </a>

                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                            <?= substr($_SESSION['user_name'] ?? 'U', 0, 1) ?>
                        </div>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                        <a href="/campus-retrieve/public/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>