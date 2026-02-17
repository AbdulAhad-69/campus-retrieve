<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        <a href="/campus-retrieve/public/home" class="text-blue-600 hover:underline">&larr; Back to Dashboard</a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="md:flex">

            <div class="md:w-1/2 bg-gray-100 relative min-h-[400px]">
                <?php if ($item['image_path']): ?>
                    <img src="/campus-retrieve/public/uploads/<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover absolute inset-0">
                <?php else: ?>
                    <div class="flex items-center justify-center h-full text-gray-400 font-medium">No Image Provided</div>
                <?php endif; ?>

                <div class="absolute top-6 left-6">
                    <span class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider shadow-sm 
                        <?= $item['type'] == 'Lost' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' ?>">
                        <?= htmlspecialchars($item['type']) ?>
                    </span>
                </div>
            </div>

            <div class="md:w-1/2 p-10 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-bold text-blue-600 uppercase tracking-wide">
                            <?= htmlspecialchars($item['category_name']) ?>
                        </span>
                        <span class="text-sm text-gray-400">
                            Posted <?= date('M d, Y', strtotime($item['created_at'])) ?>
                        </span>
                    </div>

                    <h1 class="text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                        <?= htmlspecialchars($item['title']) ?>
                    </h1>

                    <div class="flex items-center mb-6 text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium"><?= htmlspecialchars($item['location']) ?></span>
                    </div>

                    <div class="prose text-gray-600 mb-8">
                        <h3 class="text-sm font-bold text-gray-900 uppercase mb-2">Description</h3>
                        <p class="leading-relaxed"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg mr-4">
                            <?= substr($item['full_name'], 0, 1) ?>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Posted by</p>
                            <p class="text-sm font-bold text-gray-900"><?= htmlspecialchars($item['full_name']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-100">
                    <?php if ($_SESSION['user_id'] == $item['user_id']): ?>
                        <button class="w-full bg-gray-200 text-gray-700 font-bold py-4 rounded-lg cursor-not-allowed">
                            This is your post
                        </button>
                    <?php else: ?>
                        <div class="grid grid-cols-2 gap-4">
                            <?php if ($item['type'] == 'Found'): ?>
                                <button onclick="alert('Claim Feature Coming Next!')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                                    Claim Item
                                </button>
                            <?php else: ?>
                                <button onclick="alert('Contact Feature Coming Next!')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                                    I Found This!
                                </button>
                            <?php endif; ?>

                            <a href="mailto:<?= htmlspecialchars($item['email']) ?>" class="flex items-center justify-center border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg transition">
                                Email Student
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>