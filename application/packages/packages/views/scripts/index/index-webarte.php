<h1><?php echo $this->page->label ?></h1>
<div id="tagcloud">
<?php foreach ($this->tree as $node) { ?>
    <?php echo str_repeat('<span class="box">&nbsp;</span>', $node['level']) ?>
    <?php
        $title = $node['node']->label;
        if ($this->acl('packages', 'view')) {
            $title = '<a href="' . $this->url(array('mod' => $node['node']->url), 'packages_package_view') . '">' . $title . '</a>';
        }
    ?>
    <span class="tag" href="#">
        <?php echo $title ?>
    </span>
        <?php echo $node['node']->description ?>
    <br />
<?php } ?>
</div>
