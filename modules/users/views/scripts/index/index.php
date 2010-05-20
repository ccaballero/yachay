<h1>Lista de usuarios</h1>

<?php if (count($this->users)) { ?>
    <center><?= $this->paginator($this->users, $this->route) ?></center>
    <dl>
    <?php foreach ($this->users as $user) { ?>
        <dt>
            <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>">
                <b><?= $this->utf2html($user->label) ?></b>
            </a>
            <?php } else { ?>
                <b><?= $this->utf2html($user->label) ?></b>
            <?php } ?>
            &nbsp;
            <?php if (Yeah_Acl::hasPermission('users', 'edit')) { ?>
            <a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>">
                <b><i>[Editar]</i></b>
            </a>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
                <?php global $USER; ?>
	            <?php if ($USER->ident != $user->ident) { ?>
    		        <?php if ($this->friends->hasContact($USER->ident, $user->ident)) { ?>
            		<a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>">
	                	<b><i>[Retirar contacto]</i></b>
	    	        </a>
    	        	<?php } else { ?>
    	        	<a href="<?= $this->url(array('user' => $user->url), 'friends_add') ?>">
	                	<b><i>[Agregar contacto]</i></b>
	    	        </a>
    	        	<?php } ?>
        	    <?php } ?>
            <?php } ?>
        </dt>
        <dd>
            <table width="100%">
                <tr>
                    <td rowspan="4">
                        <img src="<?= $this->media . 'thumbnail_medium/' . $user->getAvatar() ?>" />
                    </td>
                    <td colspan="4"><b>Nombre Completo: </b><?= $this->utf2html($user->getFullName()) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Cargo: </b><?= $user->getRole()->label ?></td>
                    <td colspan="2"><b>Carrera: </b><?= $this->none($user->career) ?></td>
                </tr>
                <tr>
                    <td><b>Conocimiento: </b><?= $user->knowledge ?></td>
                    <td><b>Participacion: </b><?= $user->participation ?></td>
                    <td><b>Popularidad: </b><?= $user->popularity ?></td>
                    <td><b>Actividad: </b><?= $user->activity ?></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;<?= $user->interests ?></td>
                </tr>
            </table>
            <br />
        </dd>
    <?php } ?>
    </dl>
    <center><?= $this->paginator($this->users, $this->route) ?></center>
<?php } else { ?>
<p>No existen usuarios registrados</p>
<?php } ?>
