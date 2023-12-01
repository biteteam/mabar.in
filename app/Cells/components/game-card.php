<div class="group/game-card transition-all duration-300 overflow-hidden rounded-xl sm:rounded-2xl md:rounded-3xl bg-vulcan-800 bg-opacity-50 shadow-lg border border-vulcan-700 hover:shadow-2xl">
    <div class="flex items-center relative">
        <div class="absolute h-full w-full bg-black/30 z-10 opacity-0 group-hover/game-card:opacity-100 transition-all duration-700"></div>
        <img class="object-cover w-full h-full" src="<?= $game->image ?>" alt="<?= $game->name ?>">
        <?php if (auth()->isLoggedIn()) : ?>
            <?php if ($game->creator_id == auth()->user()->id) : ?>
                <a href="<?= base_url("/game/$game->code/edit") ?>" class="absolute top-0 left-0 z-20 text-xs lg:text-sm text-center py-1 lg:py-1.5 px-5 font-medium rounded-br-xl transition focus:outline-none bg-sky-600 bg-clip-padding backdrop-filter backdrop-blur-lg bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-sky-500 hover:border-sky-500 hover:text-white cursor-pointer shadow-lg">
                    Edit
                </a>
                <a href="<?= base_url("/game/$game->code/delete") ?>" class="absolute <?= (!$game->is_verified && auth()->user()->role == "admin") ? "top-9" : "top-0" ?> right-0 z-20 text-xs lg:text-sm text-center py-1 lg:py-1.5 px-5 font-medium rounded-bl-xl transition focus:outline-none bg-pink-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-pink-500 hover:border-pink-500 hover:text-white cursor-pointer shadow-lg">
                    Hapus
                </a>
            <?php endif ?>
        <?php endif ?>

        <?php if (!$game->is_verified && auth()->isUser()) : ?>
            <span class="absolute top-0 left-0 z-20 text-xs lg:text-sm text-center py-1 lg:py-1.5 px-3 font-medium rounded-br-xl transition focus:outline-none bg-orange-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-orange-500 hover:border-orange-500 hover:text-white cursor-pointer shadow-lg">
                Belum di Verifikasi Admin
            </span>
        <?php endif ?>
        <?php if (!$game->is_verified && auth()->isAdmin()) : ?>
            <a href="<?= base_url("/game/$game->code/verify") ?>" class="absolute top-0 rounded-bl-xl right-0 z-20 text-xs lg:text-sm text-center py-1 lg:py-1.5 px-3 font-medium transition focus:outline-none bg-purple-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-purple-500 hover:border-purple-500 hover:text-white cursor-pointer shadow-lg">
                Perlu Verifikasi
            </a>
        <?php endif ?>
    </div>
    <div class="flex flex-col w-full bg-vulcan-800 px-2 md:px-3 py-2 md:py-3 border-t h-full border-vulcan-600">
        <div>
            <p class="text-base md:text-lg line-clamp-1 hover:line-clamp-none text-slate-100"><?= $game->name ?></p>
            <div class="flex w-full my-2 border-t border-vulcan-500/60"></div>
            <span class="text-sm transition duration-700 line-clamp-3 hover:line-clamp-none text-slate-200"><?= $game->description ?></span>
        </div>
        <div class="flex flex-col lg:flex-row w-full mt-5 items-center justify-between gap-y-1.5">
            <a href="<?= base_url("/team?game={$game->code}") ?>" class="text-xs lg:text-sm text-center w-full lg:w-auto py-1 lg:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600/50 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer">
                Team
            </a>
            <a href="<?= base_url("/team/add?game={$game->code}") ?>" class="text-xs lg:text-sm text-center w-full lg:w-auto py-1 lg:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer">
                Buat Team
            </a>
        </div>
    </div>
</div>