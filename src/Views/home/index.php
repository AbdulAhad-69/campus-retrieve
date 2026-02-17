<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<style type="text/tailwindcss">
    @layer components {
        .stat-card { @apply bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4; }
        .icon-box { @apply p-3 rounded-lg text-white; }
        .section-title { @apply text-xl font-bold text-gray-800 mb-6 flex items-center; }
    }
</style>

<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">
            Hello, <?= htmlspecialchars($userName) ?> 👋
        </h1>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'posted'): ?>
            <div class="mt-4 p-4 bg-green-50 text-green-700 border border-green-200 rounded-lg">
                Item posted successfully!
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="stat-card">
                <div class="icon-box bg-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Lost Items</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['lost_count'] ?? 0 ?></p>
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
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['found_count'] ?? 0 ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon-box bg-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Resolved</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['resolved_count'] ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="section-title">Recently Added</h2>

    <?php if (empty($recentItems)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <p class="text-gray-500">No items found yet.</p>
        </div>
    <?php else: ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($recentItems as $item): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">

                    <div class="h-48 bg-gray-100 relative">
                        <?php if ($item['image_path']): ?>
                            <img src="/campus-retrieve/public/uploads/<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        <?php endif; ?>

                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide 
                                <?= $item['type'] == 'Lost' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                            <?= $item['type'] ?>
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide"><?= htmlspecialchars($item['category_name']) ?></span>
                            <span class="text-xs text-gray-400"><?= date('M d', strtotime($item['created_at'])) ?></span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($item['description']) ?></p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-xs text-gray-500 truncate max-w-[100px]"><?= htmlspecialchars($item['location']) ?></span>
                            </div>
                            <a href="/campus-retrieve/public/item?id=<?= $item['id'] ?>" class="text-blue-600 text-sm font-medium hover:text-blue-800">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>