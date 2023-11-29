<div>
    <label class="block mb-2 text-sm font-medium text-white" for="<?= $name ?>"><?= $label ?></label>
    <input class="border text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" id="<?= $name ?>"
           name="<?= $name ?>" type="<?= $type ?>" value="<?= $value ?>" placeholder="<?= $placeholder ?>" <?= !empty($required) ? 'required' : '' ?> />

    <?php if (!empty($errorMessage)) : ?>
    <span class="text-xs text-red-400 font-medium ml-0.5"><?= esc($errorMessage) ?></span>
    <?php endif; ?>
</div>
