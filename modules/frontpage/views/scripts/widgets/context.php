<?php $list_spaces = $this->context(NULL, 'matrix'); ?>

<table width="100%">
<?php foreach ($list_spaces as $category => $spaces) { ?>
    <?php if (count($spaces) <> 0) { ?>
        <tr><td><b>[<?= $this->typeSpace($category) ?>]</b></td></tr>
        <?php foreach ($spaces as $space) { ?>
            <tr><td>* [<?= $this->recipient($space) ?>]</td></tr>
        <?php } ?>
    <?php } ?>
<?php } ?>
</table>