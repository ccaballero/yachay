<?php global $USER; ?>
<h1>Conjunto: <?= $this->utf2html($this->groupset->label) ?>
    <?php if ($this->groupset->author == $USER->ident) { ?>
    <i><a href="<?= $this->url(array('groupset' => $this->groupset->ident), 'groupsets_groupset_edit') ?>">[Editar]</a></i>
    <?php } ?>
</h1>

<h2>Grupos asignados</h2>
<?php 
if (count($this->subjects)) {
    foreach ($this->subjects as $subject) {
        $subject_label = '<b>' . $this->utf2html($subject->label) . '</b><br />';
        $group_label = '';
        foreach ($this->groups[$subject->ident] as $group) {
            foreach ($this->groupset_groups as $groupset_group) {
	        	if ($group->ident == $groupset_group->ident) {
	        	    $group_label .= '<a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a><br />';
				}
			}
		}
		if (!empty($group_label)) {
		    echo $subject_label . $group_label;
		}
    }
} else {
	echo '<p>No existen asignaciones suyas en ninguna materia.</p>';
}
