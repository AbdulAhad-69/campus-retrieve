<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8 flex items-center">
        <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold">
            <?= substr($_SESSION['user_name'], 0, 1) ?>
        </div>
        <div class="ml-6">
            <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($_SESSION['user_name']) ?></h1>
            <p class="text-gray-500">Student Member</p>
        </div>
    </div>

    <h2 class="text-xl font-bold text-gray-900 mb-6">My Posted Items</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
            <?= $_GET['msg'] == 'deleted' ? 'Item deleted successfully.' : 'Item marked as resolved.' ?>
        </div>
    <?php endif; ?>

    <?php if (empty($myItems)): ?>
        <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
            <p class="text-gray-500">You haven't posted anything yet.</p>
            <a href="/campus-retrieve/public/post" class="text-blue-600 font-bold mt-2 inline-block">Post an Item</a>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <ul class="divide-y divide-gray-200">
                <?php foreach($myItems as $item): ?>
                    <li class="p-6 flex flex-col md:flex-row md:items-center justify-between hover:bg-gray-50 transition">
                        
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="h-16 w-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                <?php if($item['image_path']): ?>
                                    <img src="/campus-retrieve/public/uploads/<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img</div>
                                <?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-bold text-gray-900"><?= htmlspecialchars($item['title']) ?></span>
                                    <span class="px-2 py-0.5 rounded text-xs font-bold uppercase 
                                        <?= $item['status'] == 'Resolved' ? 'bg-gray-100 text-gray-600' : ($item['type'] == 'Lost' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') ?>">
                                        <?= $item['status'] == 'Resolved' ? 'Resolved' : $item['type'] ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500"><?= date('M d, Y', strtotime($item['created_at'])) ?></p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <a href="/campus-retrieve/public/item?id=<?= $item['id'] ?>" class="text-gray-600 hover:text-blue-600 text-sm font-medium">View</a>
                            
                            <?php if($item['status'] !== 'Resolved'): ?>
                                <form action="/campus-retrieve/public/profile/resolve" method="POST" onsubmit="return confirm('Did you find this item? This will mark it as resolved.')">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Mark Resolved</button>
                                </form>
                            <?php endif; ?>

                            <form action="/campus-retrieve/public/profile/delete" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.')">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>