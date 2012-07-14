<h1>Paquete: <?php echo $this->package->label ?></h1>

<p>
    <span class="bold">Estado: </span><?php echo $this->status($this->package->status) ?><br />
    <span class="bold">Tipo: </span><?php echo $this->type($this->package->type) ?><br />
    <span class="bold">Descripción: </span>
    <?php echo $this->package->description ?>
</p>
