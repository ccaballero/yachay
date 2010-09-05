<h1>Lista de contactos</h1>

<?php if (count($this->friends)) { ?>
    <dl>
    <?php foreach ($this->friends as $friend) { ?>
    <?php $user = $this->users->findByIdent($friend->friend); ?>
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
                <b><i>[<a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
            <b><i>Fecha de contacto: <?= $this->timestamp($friend->tsregister) ?></i></b>
            <a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>">
	            <b><i>[Retirar contacto]</i></b>
	    	</a>
        </dt>
        <dd>
            <table width="100%">
                <tr>
                    <td rowspan="4">
                        <img src="<?= $this->media . '../users/thumbnail_medium/' . $user->getAvatar() ?>" />
                    </td>
                    <td colspan="4"><b>Nombre Completo: </b><?= $this->utf2html($user->getFullName()) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Cargo: </b><?= $user->getRole()->label ?></td>
                    <td colspan="2"><b>Carrera: </b><?= $this->none($user->career) ?></td>
                </tr>
                <!--<tr>
                    <td><b>Conocimiento: </b><?= $user->knowledge ?></td>
                    <td><b>Participacion: </b><?= $user->participation ?></td>
                    <td><b>Popularidad: </b><?= $user->popularity ?></td>
                    <td><b>Actividad: </b><?= $user->activity ?></td>
                </tr>-->
                <tr>
                    <td colspan="4">&nbsp;<?= $user->interests ?></td>
                </tr>
            </table>
            <br />
        </dd>
    <?php } ?>
    </dl>
<?php } else { ?>
<p>No existen contactos registrados</p>
<?php } ?>
