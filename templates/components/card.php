<div class="block rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow hover:shadow-lg transition overflow-hidden">
    <?php if(isset($img)): ?>
        <img src="<?= $img ?>" class="w-full h-48 object-cover" alt="<?= $title ?>">
    <?php endif; ?>
    <div class="p-5">
        <h3 class="font-semibold text-xl mb-2 text-text dark:text-text"><?= $title ?></h3>
        <p class="text-gray-700 dark:text-gray-300 opacity-90"><?= $summary ?></p>
    </div>
</div>

