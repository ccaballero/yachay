<h1>Importar miembros: <?php echo $this->subject->label ?></h1>
<?php if (!empty($this->gestion)) { ?><p><span class="mark">Gestion: </span><?php echo $this->gestion->label ?></p><?php } ?>

<?php
if ($this->step == 1) {
    echo $this->partial('assign/import1-webarte.php', array());
} else {
    echo $this->partial('assign/import2-webarte.php', array('subject' => $this->subject, 'results' => $this->results, 'template' => $this->template));
}
