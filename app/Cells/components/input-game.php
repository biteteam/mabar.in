<div class="relative">
    <?php if (!empty($label)) : ?>
        <label class="block mb-2 text-[15px] font-medium text-white" for="<?= esc($name) ?>"><?= esc($label) ?></label>
    <?php endif ?>
    <input id="<?= esc($name) ?>" name="<?= esc($name) ?>" type="hidden" value="<?= !empty($value) ? esc($value) : $gameSelected->id ?>">

    <div class="relative flex flex-col w-full transition-all duration-1000 overflow">
        <div control="game-input" control-input="<?= esc($name) ?>" control-expand-element="game-input-<?= esc($name) ?>" class="flex w-full transition-colors duration-500 items-center border text-sm rounded-lg md:rounded-xl outline-none game-input overflow-hidden cursor-pointer shadow-lg z-10">
            <div class="w-auto h-full">
                <div class="flex h-full w-16 md:w-20 lg:w-20 p-[5px]">
                    <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                        <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                        <img class="h-full w-full object-cover z-0" src="<?= esc($gameSelected->image) ?>" alt="<?= esc($gameSelected->name) ?>">
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-1.5 gap-0.5 md:gap-1">
                <h2 class="text-sm lg:text-base truncate text-slate-300 font-semibold"><?= esc($gameSelected->name) ?></h2>
                <p style="line-height: 1.4;" class="text-xs md:text-sm line-clamp-2 text-slate-300/70 font-medium"><?= esc($gameSelected->description) ?></p>
            </div>
        </div>
        <div control="game-input-<?= esc($name) ?>" control-expanded="false" class="transition-all duration-500 game-input-expander rounded-b-xl bg-[#302f6c] bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 overflow-hidden -mt-5 pt-4">
            <div class="flex flex-col w-full h-full mt-2 pt-4 pb-6 px-4 overflow-y-auto">
                <?php if (!empty($placeholder)) : ?>
                    <label class="block mb-4 pb-2 border-b border-[#423f93] text-sm font-semibold text-slate-200"><?= $placeholder ?></label>
                <?php endif; ?>
                <div class="flex flex-col gap-3 w-full h-auto">
                    <?php foreach ($games as $game) : ?>
                        <button type="button" data-game-id="<?= $game->id ?>" class="flex w-full items-center group/game-list transition-all duration-500 <?= ($gameSelected->id == $game->id) ? "selected game-input-list-color" : "game-input-list-color" ?> text-start border text-sm rounded-lg lg:rounded-xl outline-none overflow-hidden cursor-pointer">
                            <div class="w-auto h-full">
                                <div class="flex h-full w-16 md:w-[75px] p-[5px]">
                                    <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                                        <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                                        <img class="h-full w-full object-cover z-0" src="<?= esc($game->image) ?>" alt="<?= esc($game->name) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-1.5 gap-0.5">
                                <h2 class="text-sm truncate text-slate-300/90 font-medium md:font-semibold"><?= esc($game->name) ?></h2>
                                <p style="line-height: 1.4;" class="text-xs line-clamp-2 group-hover/game-list:line-clamp-2 text-slate-300/60 md:font-medium"><?= esc($game->description) ?></p>
                            </div>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const showTargetExpandElement = (element, show) => {
        if (show) {
            element.setAttribute('control-expanded', 'hide')
            element.classList.replace('game-input-expander-show', 'game-input-expander')
        } else {
            element.setAttribute('control-expanded', 'show')
            element.classList.replace('game-input-expander', 'game-input-expander-show')
        }
    }

    const handlePreviewSelected = (previewElement, selectedElement) => {
        const previewElImage = previewElement.querySelector('img')
        const selectedElImage = selectedElement.querySelector('img');
        previewElImage.setAttribute('src', selectedElImage?.getAttribute('src'))
        previewElImage.setAttribute('alt', selectedElImage?.getAttribute('alt'))

        previewElement.querySelector('h2').textContent = selectedElement.querySelector('h2').textContent
        previewElement.querySelector('p').textContent = selectedElement.querySelector('p').textContent
    }

    const handleExpandAndChangeGameInput = () => {
        const gameInputs = document.querySelectorAll('[control="game-input"]');
        gameInputs.forEach(gameInput => {
            const targetInputElement = document.querySelector(`input[name="${gameInput.getAttribute('control-input')}"]`);
            const targetExpandElement = document.querySelector(`[control="${gameInput.getAttribute('control-expand-element')}"]`);
            let isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';

            // Show on init
            if (isExpand) showTargetExpandElement(targetExpandElement, false);

            let gameListSelected = null;
            const gameLists = targetExpandElement.querySelectorAll('[data-game-id]')
            gameLists.forEach(gameList => {
                if (gameList.classList.contains('selected')) gameListSelected = gameList;

                gameList.addEventListener('click', () => {
                    const gameId = Number(gameList.getAttribute('data-game-id'));

                    handlePreviewSelected(gameInput, gameList);
                    targetInputElement.value = gameId;
                    gameList?.classList?.add('selected');
                    gameListSelected?.classList?.remove('selected');
                    gameListSelected = gameList;
                    gameInput.click();
                })

            })

            gameInput.addEventListener('click', (e) => {
                isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';
                showTargetExpandElement(targetExpandElement, isExpand);
            })
        })
    }


    handleExpandAndChangeGameInput();

    // const loadInterval = setInterval(() => {
    //     if (document.readyState == "complete") {
    //         handleExpandAndChangeGameInput();
    //         clearInterval(loadInterval);
    //     }
    // }, 400)
</script>