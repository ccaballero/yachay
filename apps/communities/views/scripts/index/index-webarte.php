<h1><?php echo $this->page->label ?></h1>

<?php if (count($this->communities)) { ?>
    <?php echo $this->paginator($this->communities, $this->pager) ?>
    <div id="block">
    <?php foreach ($this->communities as $community) { ?>
        <?php echo $this->partial('index/community-webarte.php', array('community' => $community, 'user' => $this->user, 'config' => $this->config, 'template' => $this->template)) ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->paginator($this->communities, $this->pager) ?>
<?php } else { ?>
    <p>No existen communidades registradas</p>
<?php } ?>
