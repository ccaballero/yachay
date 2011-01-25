<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->users)) { ?>
    <?= $this->paginator($this->users, $this->route) ?>
    <div id="block">
    <?php foreach ($this->users as $user) { ?>
        <?= $this->partial('index/user-webarte.php', array('user' => $user, 'USER' => $this->USER, 'model_friends' => $this->model_friends, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <?= $this->paginator($this->users, $this->route) ?>
<?php } else { ?>
    <p>No existen usuarios registrados</p>
<?php } ?>
