<?php

echo '<h1>Paquete: ' . $this->package->label . '</h1>';
echo '<i><b>Estado:</b> ' . $this->status($this->package->status) . '</i>';
echo '<br />';
echo '<i><b>Tipo:</b> ' . $this->type($this->package->type) . '</i>';
echo '<p>' . $this->package->description . '</p>';
