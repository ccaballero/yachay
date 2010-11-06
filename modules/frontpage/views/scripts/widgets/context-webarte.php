<?php $list_spaces = $this->context(NULL, 'matrix'); ?>
<?php if (count($list_spaces)) { ?>
    <dl>
    <?php foreach ($list_spaces as $category => $spaces) { ?>
        <?php if (count($spaces) <> 0) { ?>
            <dt><?= $this->typeSpace($category) ?></dt>
            <dd>
                <ul>
            <?php foreach ($spaces as $space) { ?>
                <li><?= $this->recipient($space) ?></li>
            <?php } ?>
                </ul>
            </dd>
        <?php } ?>
    <?php } ?>
    </dl>
<?php } ?>
