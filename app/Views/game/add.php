<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <form class="flex flex-col lg:flex-row w-full bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10"
              action="<?= url_to('game.add') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="flex flex-col w-full lg:w-1/2 px-4 py-6 md:px-6 md:py-8">
                <input id="game_creator" name="game_creator" type="hidden" value="<?= set_value('game_creator', $userAuth->id) ?>">
                <input id="game_verified" name="game_verified" type="hidden" value="<?= set_value('game_verified', $userAuth->isAdmin) ?>">
                <input id="game_image" name="game_image" type="hidden"
                       value="<?= set_value('game_image', base_url('/img/game/league-of-legends-icon.jpg')) ?>">
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'game_name',
                        'label' => 'Nama Game',
                        'type' => 'text',
                        'placeholder' => 'League of Legends',
                        'value' => set_value('game_name'),
                        'errorMessage' => !empty($error->game_name) ? $error->game_name : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'game_code',
                        'label' => 'Kode Game',
                        'type' => 'text',
                        'placeholder' => 'league-of-legends',
                        'mathParentSlug' => 'game_name',
                        'value' => set_value('game_code'),
                        'errorMessage' => !empty($error->game_code) ? $error->game_code : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'game_description',
                        'label' => 'Deskripsi Game',
                        'type' => 'textarea',
                        'placeholder' => 'League of Legends adalah sebuah game yang...',
                        'rows' => 5,
                        'value' => set_value('game_description'),
                        'errorMessage' => !empty($error->game_description) ? $error->game_description : null,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'name' => 'game_max_player',
                        'label' => 'Maksimal Player',
                        'type' => 'number',
                        'placeholder' => '5',
                        'mathParentSlug' => null,
                        'value' => set_value('game_max_player'),
                        'errorMessage' => !empty($error->game_max_player) ? $error->game_max_player : null,
                    ]) ?>
                </div>

                <?php if (!empty($error->global || $error->game_image || $error->game_creator)) : ?>
                <div class="mb-2 -mt-6 w-full">
                    <span class="text-xs text-red-400 font-medium ml-0.5"><?= esc($error->global || $error->game_image || $error->game_creator) ?></span>
                </div>
                <?php endif; ?>

                <button class="flex font-semibold h-10 w-full items-center justify-center space-x-2 rounded-md border px-4 text-sm transition-all focus:outline-none bg-blue-500 border-transparent bg-bg-blue-400/80 text-white hover:bg-blue-400/90 hover:border-blue-400 hover:text-white disabled:hover:bg-blue-400/80 disabled:border:bg-slate-400 disabled:opacity-80 disabled:cursor-wait"
                        type="submit">
                    <p>Tambahkan</p>
                </button>
            </div>
            <div class="group/upload-image relative transition-all duration-700 flex w-full aspect-square md:aspect-video lg:h-auto lg:w-1/2 rounded-b-xl rounded-t-2xl md:rounded-t-2xl border-t lg:border-l lg:border-t-0 border-slate-700 lg:border-slate-800 lg:rounded-none lg:rounded-r-xl lg:rounded-l-3xl bg-elephant-800 bg-opacity-10 opacity-80 bg-center object-cover overflow-hidden"
                 id="preview-game-image"
                 style="background-repeat: no-repeat; background-position: center; background-image: url(<?= base_url('/img/game/league-of-legends-icon.jpg') ?>);">
                <div class="absolute w-full h-full justify-center items-center bg-black/50" target-wrapper-role="upload-image-input">
                    <div class="relative w-full h-full">
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <input class="hidden" type="file" target-id="game_image" target-name="game_image" uri-upload="<?= url_to('game.upload-image') ?>"
                                   accept=".png, .jpg, .jpeg">
                            <button class="flex flex-col gap-2 transition-all duration-700 text-white bg-vulcan-600 border border-vulcan-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-70 rounded-xl p-4 md:p-8 outline-none ring-0 opacity-100 group-hover/upload-image:opacity-100"
                                    type="button" role="upload-image-input" target-input="game_image" target-preview="preview-game-image">
                                <i class="fa-solid fa-upload text-xl md:text-2xl mx-auto"></i>
                                <span class="text-xs md:text-base text-center font-semibold">Ganti Gambar Game</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
