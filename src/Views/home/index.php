<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<style type="text/tailwindcss">
    @layer components {
        .stat-card { @apply bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4; }
        .icon-box { @apply p-3 rounded-lg text-white; }
        .section-title { @apply text-xl font-bold text-gray-800 mb-6 flex items-center; }
    }
</style>

<div class="bg-gray-50 min-h-screen pb-12">
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl font-bold text-gray-900">
                Hello, <?= htmlspecialchars($userName) ?> 👋
            </h1>
            <p class="text-gray-500 mt-1">Here is what's happening on campus today.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="stat-card">
                    <div class="icon-box bg-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Lost Items</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="icon-box bg-green-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Found Items</p>
                        <p class="text-2xl font-bold text-gray-900">8</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="icon-box bg-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Returned</p>
                        <p class="text-2xl font-bold text-gray-900">142</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="section-title">Recently Found Items</h2>
            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">View All &rarr;</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No items found yet</h3>
            <p class="text-gray-500 mt-2">Be the first to report a found item and help the community.</p>
            <a href="/campus-retrieve/public/post" class="mt-4 inline-block px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Post Found Item
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>