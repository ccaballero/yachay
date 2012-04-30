<?php if ($this->USER->role <> 1) { ?>
<form method="post" action="<?php echo $this->config->resources->frontController->baseUrl ?>/filter_spaces" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />
<?php } ?>

<?php $list_spaces = $this->context(NULL, 'matrix'); ?>
<?php if (count($list_spaces)) { ?>
    <dl>
    <?php foreach ($list_spaces as $category => $spaces) { ?>
        <?php if (count($spaces) <> 0) { ?>
            <dt><?php echo $this->typeSpace($category) ?></dt>
            <dd>
                <ul>
            <?php foreach ($spaces as $space) { ?>
                <li><?php if ($this->USER->role <> 1) { ?><input type="checkbox" name="spaces[]" value="<?php echo $space ?>" <?php echo !in_array($space, explode(',', $this->USER->spaces)) ? 'checked="checked"':'' ?>/>&nbsp;<?php } ?><?php echo $this->recipient($space) ?></li>
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
