<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->communities)) { ?>
    <?= $this->paginator($this->communities, $this->route) ?>
    <div id="block">
    <?php foreach ($this->communities as $community) { ?>
        <?= $this->partial('index/community-webarte.php', array('community' => $community, 'USER' => $this->USER, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <?= $this->paginator($this->communities, $this->route) ?>
<?php } else { ?>
    <p>No existen communidades registradas</p>
<?php } ?>
