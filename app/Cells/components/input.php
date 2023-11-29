<div class="relative">
    <label class="block mb-2 text-sm font-medium text-white" for="<?= $name ?>"><?= $label ?></label>
    <input class="border text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>" value="<?= $value ?>" placeholder="<?= $placeholder ?>" <?= !empty($required) ? 'required' : '' ?> />

    <?php if (!empty($type == 'password')) : ?>
        <button type="button" aria-label="password-show" class="absolute transition-colors duration-300 top-9 right-3 text-xl <?= empty($errorMessage) ? "text-vulcan-400 hover:text-vulcan-300" : "text-red-200/70 hover:text-red-200" ?>">
            <i class="fa-solid fa-eye inline"></i>
            <i class="fa-solid fa-eye-slash hidden"></i>
        </button>
    <?php endif; ?>

    <?php if (!empty($errorMessage)) : ?>
        <span class="text-xs text-red-400 font-medium ml-0.5"><?= esc($errorMessage) ?></span>
    <?php endif; ?>
</div>