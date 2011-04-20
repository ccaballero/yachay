<?php

if (Yeah_Acl::hasPermission('resources', 'new')) {
    echo '<table width="100%"><tr>';
    echo '<td>[<a href="' . $this->url(array('filter' => 'notes'), 'resources_filtered') . '">Notas</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'notes_new') . '">Crear</a>]</small></td></tr>';
    echo '<td>[<a href="' . $this->url(array('filter' => 'links'), 'resources_filtered') . '">Enlaces</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'links_new') . '">Crear</a>]</small></td></tr>';
    echo '<tr><td>[<a href="' . $this->url(array('filter' => 'files'), 'resources_filtered') . '">Archivos</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'files_new') . '">Crear</a>]</small></td></tr>';
    echo '<tr><td>[<a href="' . $this->url(array('filter' => 'events'), 'resources_filtered') . '">Eventos</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'events_new') . '">Crear</a>]</small></td></tr>';
    echo '<tr><td>[<a href="' . $this->url(array('filter' => 'photos'), 'resources_filtered') . '">Fotografias</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'photos_new') . '">Crear</a>]</small></td></tr>';
    if (Yeah_Acl::hasPermission('videos', 'upload')) {
        echo '<tr><td>[<a href="' . $this->url(array('filter' => 'videos'), 'resources_filtered') . '">Videos</a>]</td>';
        echo '<td align="right"><small>[<a href="' . $this->url(array(), 'videos_new') . '">Crear</a>]</small></td></tr>';
    }
    echo '<tr><td>[<a href="' . $this->url(array('filter' => 'feedback'), 'resources_filtered') . '">Sugerencias</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'feedback_new') . '">Crear</a>]</small></td></tr>';
    if (Yeah_Acl::hasPermission('subjects', 'teach')) {
        echo '<tr><td>[<a href="' . $this->url(array('filter' => 'evaluations'), 'resources_filtered') . '">Evaluaciones</a>]</td>';
        echo '<td align="right"><small>[<a href="' . $this->url(array(), 'evaluations_new') . '">Crear</a>]</small></td></tr>';
        echo '<tr><td>[<a href="' . $this->url(array(), 'groupsets_manager') . '">Conjuntos</a>]</td>';
        echo '<td align="right"><small>[<a href="' . $this->url(array(), 'groupsets_new') . '">Crear</a>]</small></td></tr>';
    }
    echo '<tr><td>[<a href="' . $this->url(array(), 'invitations_manager') . '">Invitaciones</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'invitations_new') . '">Crear</a>]</small></td></tr>';
    echo '<tr><td colspan="2"><center>[<a href="' . $this->url(array(), 'resources_list') . '">Ver todos</a>]</center></td></tr></table>';
}
