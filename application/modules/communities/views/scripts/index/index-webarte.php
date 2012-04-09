<h1><?php echo $this->PAGE->label ?></h1>

<?php if (count($this->communities)) { ?>
    <?php echo $this->paginator($this->communities, $this->route) ?>
    <div id="block">
    <?php foreach ($this->communities as $community) { ?>
        <?php echo $this->partial('index/community-webarte.php', array('community' => $community, 'USER' => $this->USER, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->paginator($this->communities, $this->route) ?>
<?php } else { ?>
    <p>No existen communidades registradas</p>
<?php } ?>
