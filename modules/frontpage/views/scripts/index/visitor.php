<?php
    echo '<h1>' . $this->config->site . '</h1>';
    echo '<p>';
    echo 'Bienvenido a la red social donde puedes interactuar con estudiantes y docentes, buscar información de las respectivas materias de tu area de estudio y armar tu red de amigos o compañeros de grupo, disfruta de este sistema y esperamos enriquecer tus ideas y pensamientos.';
    echo '</p>';
    echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config));
