<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="mt-4 md:mt-0 md:mb-6">
        <a class="text-xs lg:text-sm text-center w-auto py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
           href="<?= base_url('/game/add') ?>">
            <i class="fa-solid fa-plus mr-0.5"></i>
            Tambah Game
        </a>
    </div>

    <div class="flex flex-col w-full mt-8 sm:mt-3 md:mt-4 gap-8 md:gap-12">
        <?php if (!empty($games->own)) : ?>
        <div class="block w-full">
            <h2 class="text-lg font-medium leading-6 text-slate-100">Game yang kamu buat</h2>
            <div class="mt-4 grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                <?php foreach ($games->own as $game) : ?>
                <?= view_cell('GameCardCell', ['game' => $game]) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif ?>

        <?php if (!empty($games->all)) : ?>
        <div class="block w-full">
            <h2 class="text-lg font-medium leading-6 text-slate-100">Game <?= !empty($games->own) ? 'lainnya' : 'yang didukung' ?></h2>
            <div class="mt-4 grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                <?php foreach ($games->all as $game) : ?>
                <?= view_cell('GameCardCell', ['game' => $game]) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>
