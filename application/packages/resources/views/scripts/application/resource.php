<?php

if ($this->acl('resources', 'view')) {
    echo '<h2>Publicaciones</h2>';
    if (count($this->resources)) {
        echo '<center>';
        echo $this->paginator($this->resources, $this->route);
        echo '<table width="100%">';
        foreach ($this->resources as $resource) {
            echo '<tr><td>';

            if ($this->acl('users', 'view')) {
                echo '<b><a href="' . $this->url(array('user' => $resource->getAuthor()->url), 'users_user_view') . '">' . $resource->getAuthor()->getFullName() . '</a></b>';
            } else {
                echo '<b>' . $resource->getAuthor()->getFullName() . '</b>';
            }
            echo '</td><td align="right">' . $this->timestamp($resource->tsregister) . '</td></tr><tr>';

            echo '<td colspan="2">';
            $extended = $resource->getExtended();
            echo $this->partial($extended->__type . '.php', array($extended->__type => $extended, 'config' => $this->config));
            echo '</td></tr><tr><td>';

            if (isset($resource->viewers)) {
                echo 'Visitas (' . $resource->viewers . ') | ';
            }
            echo 'Comentarios (' . $resource->comments . ') | ';
            echo 'Valoración (' . $resource->ratings . '/' . $resource->raters . ') | ';
            echo '[<a href="' . $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') . '">Ver mas</a>]';
            if ($this->acl('resources', 'drop')) {
                echo '[<a href="' . $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_drop') . '">Eliminar</a>]';
            }
            echo '</td><td align="right">';
            if (isset($resource->recipient)) {
                echo $this->recipient($resource->recipient);
            }
            echo '</td></tr><tr><td colspan="3">&nbsp;</td></tr>';
        }
        echo '</table>';
        echo $this->paginator($this->resources, $this->route);
        echo '</center>';
    } else {
        echo '<p>No se registraron recursos aún.</p>';
    }
}
