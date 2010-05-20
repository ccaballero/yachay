<?php

global $USER;
global $CONFIG;

$friends_model = Yeah_Adapter::getModel('friends');
$users_model = Yeah_Adapter::getModel('users');

$count = 0;
$limit = 5;
$friends = $friends_model->selectByUser($USER->ident);

if (count($friends) != 0) { ?>
<dl>
<?php foreach ($friends as $friend) { ?>
<?php if ($count <= $limit) { ?>
    <?php $user = $users_model->findByIdent($friend->friend); ?>
	<dt>
		<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
        <?= $this->utf2html($user->label) ?>
		</a>
	</dt>
	<dd>
		<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
		<img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
		</a>
	</dd>
	<?php $count++; ?>
<?php } ?>
<?php } ?>
</dl>
<center><a href="<?= $this->url(array(), 'friends_list') ?>">[Ver todos]</a></center>
<?php 
} else {
    echo '<p>No se encontraron contactos</p>';
}
?>
