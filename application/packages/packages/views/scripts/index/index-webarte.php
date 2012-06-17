<h1><?php echo $this->page->label ?></h1>
<?php foreach ($this->packages as $package) { ?>
    <div style="display: inline-block; width: 100px; height: 20px; border: solid 1px #000000; padding: 0.3em; margin: 0.3em;">
    <?php
        $title = $package->label;
        if ($this->acl('packages', 'view')) {
            $title = '<a href="' . $this->url(array('mod' => $package->url), 'packages_package_view') . '">' . $title . '</a>';
        }
    ?>
    <p><?php echo $title ?></p>
    <!--<dd><?php echo $package->description ?></dd>-->
    </div>
<?php } ?>
