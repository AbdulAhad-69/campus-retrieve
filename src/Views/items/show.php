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

                        <h3 class="font-bold text-gray-900 mb-4">Incoming Requests (<?= count($claims) ?>)</h3>

                        <?php if (empty($claims)): ?>
                            <div class="bg-gray-50 p-4 rounded-lg text-gray-500 text-sm text-center border border-gray-200">
                                No requests yet.
                            </div>
                        <?php else: ?>
                            <div class="space-y-3">
                                <?php foreach ($claims as $claim): ?>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-bold text-gray-900"><?= htmlspecialchars($claim['full_name']) ?></p>
                                                <p class="text-xs text-gray-500 mb-2"><?= date('M d, g:i a', strtotime($claim['created_at'])) ?></p>
                                                <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded block w-full">
                                                    "<?= htmlspecialchars($claim['message']) ?>"
                                                </p>
                                            </div>
                                        </div>

                                        <?php if ($item['status'] !== 'Resolved'): ?>
                                            <div class="flex space-x-2 mt-3">
                                                <form action="/campus-retrieve/public/claim/decide" method="POST" class="flex-1">
                                                    <input type="hidden" name="claim_id" value="<?= $claim['id'] ?>">
                                                    <input type="hidden" name="action" value="accept">
                                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded transition">
                                                        Accept & Resolve
                                                    </button>
                                                </form>
                                                <form action="/campus-retrieve/public/claim/decide" method="POST" class="flex-1">
                                                    <input type="hidden" name="claim_id" value="<?= $claim['id'] ?>">
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold py-2 rounded transition">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-3 text-xs text-green-600 font-bold uppercase tracking-wide">
                                                ✓ Request Accepted
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>

                        <?php if (isset($_GET['success']) && $_GET['success'] == 'claimed'): ?>
                            <div class="p-4 bg-green-50 text-green-700 rounded-lg mb-4 border border-green-200">
                                Request sent! The student will contact you.
                            </div>
                        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'already_claimed'): ?>
                            <div class="p-4 bg-yellow-50 text-yellow-700 rounded-lg mb-4 border border-yellow-200">
                                You have already sent a request for this item.
                            </div>
                        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'item_resolved'): ?>
                            <div class="p-4 bg-red-50 text-red-700 rounded-lg mb-4 border border-red-200">
                                Cannot claim: This item is already resolved.
                            </div>
                        <?php endif; ?>

                        <?php if ($item['status'] == 'Resolved'): ?>
                            <div class="w-full bg-gray-100 text-gray-500 font-bold py-4 rounded-lg border border-gray-200 text-center cursor-not-allowed">
                                🔒 This item is resolved
                            </div>
                        <?php else: ?>
                            <details class="group">
                                <summary class="list-none cursor-pointer">
                                    <div class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition text-center">
                                        <?= $item['type'] == 'Found' ? 'Claim This Item' : 'I Found This!' ?>
                                    </div>
                                </summary>
                                <div class="mt-4 p-6 bg-gray-50 rounded-xl border border-gray-200 animate-fade-in">
                                    <form action="/campus-retrieve/public/claim/submit" method="POST">
                                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Message to <?= htmlspecialchars($item['full_name']) ?></label>
                                        <textarea name="message" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                                        <button type="submit" class="mt-3 w-full bg-gray-900 hover:bg-black text-white font-bold py-2 rounded-lg transition">Send Request</button>
                                    </form>
                                </div>
                            </details>
                        <?php endif; ?>

                        <div class="mt-4 text-center">
                            <a href="mailto:<?= htmlspecialchars($item['email']) ?>" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Or email them directly</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>