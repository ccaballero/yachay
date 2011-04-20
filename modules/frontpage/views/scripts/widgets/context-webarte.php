<?php if ($this->USER->role <> 1) { ?>
<form method="post" action="<?= $this->CONFIG->wwwroot ?>filter_spaces" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
<?php } ?>

<?php $list_spaces = $this->context(NULL, 'matrix'); ?>
<?php if (count($list_spaces)) { ?>
    <dl>
    <?php foreach ($list_spaces as $category => $spaces) { ?>
        <?php if (count($spaces) <> 0) { ?>
            <dt><?= $this->typeSpace($category) ?></dt>
            <dd>
                <ul>
            <?php foreach ($spaces as $space) { ?>
                <li><?php if ($this->USER->role <> 1) { ?><input type="checkbox" name="spaces[]" value="<?= $space ?>" <?= !in_array($space, explode(',', $this->USER->spaces)) ? 'checked="checked"':'' ?>/>&nbsp;<?php } ?><?= $this->recipient($space) ?></li>
            <?php } ?>
                </ul>
            </dd>
        <?php } ?>
    <?php } ?>
    </dl>
    <?php if ($this->USER->role <> 1) { ?>
        <p class="center top_space"><input type="submit" value="Filtrar espacios" /></p>
    <?php } ?>
<?php } ?>

<?php if ($this->USER->role <> 1) { ?>
</form>
<?php } ?>
