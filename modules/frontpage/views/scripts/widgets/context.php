<?php $list_spaces = $this->context(NULL, 'matrix'); ?>

<?php foreach ($list_spaces as $category => $spaces) { ?>
    <?php if (count($spaces) <> 0) { ?>
        <br />
        <b>[<?= $this->typeSpace($category) ?>]</b>
        <?php foreach ($spaces as $space) { ?>
            <br />[<?= $this->recipient($space) ?>]
        <?php } ?>
    <?php } ?>
<?php } ?>
<br />
