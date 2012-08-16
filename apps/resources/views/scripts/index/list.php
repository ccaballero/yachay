<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'resources_list') . '">Todas</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'notes'), 'resources_filtered') . '">Notas</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'links'), 'resources_filtered') . '">Enlaces</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'files'), 'resources_filtered') . '">Archivos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'events'), 'resources_filtered') . '">Eventos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'photos'), 'resources_filtered') . '">Fotografias</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'videos'), 'resources_filtered') . '">Videos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'feedback'), 'resources_filtered') . '">Sugerencias</a>]</td>';
if ($this->acl('subjects', 'teach')) {
    echo '<td>[<a href="' . $this->url(array('filter' => 'evaluations'), 'resources_filtered') . '">Evaluaciones</a>]</td>';
}
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->resources)) {
    echo '<table width="100%">';
    foreach ($this->resources as $resource) {
        echo '<tr>';
        echo '<td>' . $resource->getAuthor()->getFullName() . '</td>';
        echo '<td align="right">' . $this->timestamp($resource->tsregister) . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2">';
        $extended = $resource->getExtended();
        echo $this->partial($extended->__type . '.php', array($extended->__type => $extended));
        echo '</td></tr><tr><td>';
        echo '[<a href="' . $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_view') . '">Ver mas</a>]';
        if ($resource->amAuthor()) {
            echo '[<a href="' . $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_edit') . '">Editar</a>]';
            echo '[<a href="' . $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_delete') . '">Eliminar</a>]';
        }
        echo '</td>';
        echo '<td align="right">';
        if (isset($resource->recipient)) {
            echo $this->recipient($resource->recipient);
        }
        echo '</td></tr><tr><td colspan="3">&nbsp;</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No existen recursos registrados</p>';
}
echo '<hr />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'resources_list') . '">Todas</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'notes'), 'resources_filtered') . '">Notas</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'links'), 'resources_filtered') . '">Enlaces</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'files'), 'resources_filtered') . '">Archivos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'events'), 'resources_filtered') . '">Eventos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'photos'), 'resources_filtered') . '">Fotografias</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'videos'), 'resources_filtered') . '">Videos</a>]</td>';
echo '<td>[<a href="' . $this->url(array('filter' => 'feedback'), 'resources_filtered') . '">Sugerencias</a>]</td>';
if ($this->acl('subjects', 'teach')) {
    echo '<td>[<a href="' . $this->url(array('filter' => 'evaluations'), 'resources_filtered') . '">Evaluaciones</a>]</td>';
}
echo '</tr>';
echo '</table>';
