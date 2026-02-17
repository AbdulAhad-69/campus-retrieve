<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">

        <div class="w-full md:w-1/4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Filter Results</h3>

                <form action="/campus-retrieve/public/browse" method="GET">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                        <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. Wallet">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">All Types</option>
                            <option value="Lost" <?= (isset($_GET['type']) && $_GET['type'] == 'Lost') ? 'selected' : '' ?>>Lost Items</option>
                            <option value="Found" <?= (isset($_GET['type']) && $_GET['type'] == 'Found') ? 'selected' : '' ?>>Found Items</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="category" value="" class="text-blue-600 focus:ring-blue-500" <?= empty($_GET['category']) ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm text-gray-700">All Categories</span>
                            </label>
                            <?php foreach ($categories as $cat): ?>
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="<?= $cat['id'] ?>" class="text-blue-600 focus:ring-blue-500"
                                        <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'checked' : '' ?>>
                                    <span class="ml-2 text-sm text-gray-700"><?= $cat['name'] ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-sm transition">
                            Apply Filters
                        </button>
                        <a href="/campus-retrieve/public/browse" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-lg text-sm transition text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full md:w-3/4">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
                <?php
                $count = count($items);
                echo $count . " Result" . ($count !== 1 ? 's' : '');
                ?>
            </h1>

            <?php if (empty($items)): ?>
                <div class="bg-white rounded-xl p-12 text-center border border-gray-200">
                    <p class="text-gray-500 text-lg">No items match your search.</p>
                    <p class="text-gray-400 text-sm mt-2">Try adjusting your filters or search terms.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    <?php foreach ($items as $item): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                            <div class="h-48 bg-gray-100 relative">
                                <?php if ($item['image_path']): ?>
                                    <img src="/campus-retrieve/public/uploads/<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                <?php endif; ?>
                                <span class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-bold uppercase 
                                    <?= $item['type'] == 'Lost' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= $item['type'] ?>
                                </span>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="text-xs font-bold text-blue-600 uppercase mb-1"><?= htmlspecialchars($item['category_name']) ?></div>
                                <h3 class="font-bold text-gray-900 text-lg mb-2 truncate"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-1"><?= htmlspecialchars($item['description']) ?></p>
                                <a href="/campus-retrieve/public/item?id=<?= $item['id'] ?>" class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-2 rounded-lg border border-gray-200 transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>