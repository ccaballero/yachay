<?php
    global $USER;
    global $CONFIG;

    $friends_model = Yeah_Adapter::getModel('friends');
    $users_model = Yeah_Adapter::getModel('users');

    $count = 0;
    $limit = 4;
    $friends = $friends_model->selectFriendsByUser($USER->ident);
    $followings = $friends_model->selectFollowingsByUser($USER->ident);
    $followers = $friends_model->selectFollowersByUser($USER->ident);
?>

<br />
<b>Amigos</b>
<?php if (count($friends) != 0) { ?>

<table width="100%">
<?php foreach ($friends as $friend) { ?>
    <?php if ($count < $limit) { ?>
        <?php $user = $users_model->findByIdent($friend->friend); ?>
        <tr>
            <td width="50px" valign="top" rowspan="2">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            </td>
            <td valign="top">
                [<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>"><?= $this->utf2html($user->label) ?></a>]
                &nbsp;<?= $user->getFullName() ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                Act:<?= $user->activity ?>
                Par:<?= $user->participation ?>
                Soc:<?= $user->sociability ?>
                Pop:<?= $user->popularity ?>
            </td>
        </tr>
        <?php $count++; ?>
    <?php } ?>
<?php }; $count = 0; ?>
    <tr>
        <td colspan="2">
            <center><a href="<?= $this->url(array(), 'friends_friends') ?>">[Ver todos]</a></center>
        </td>
    </tr>
</table>

<?php } else { ?>
<p>No se encontraron contactos</p>
<?php } ?>

<b>Solicitudes</b>
<?php if (count($followings) != 0) { ?>

<table width="100%">
<?php foreach ($followings as $following) { ?>
    <?php if ($count < $limit) { ?>
        <?php $user = $users_model->findByIdent($following->friend); ?>
        <tr>
            <td width="50px" valign="top" rowspan="2">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            </td>
            <td valign="top">
                [<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>"><?= $this->utf2html($user->label) ?></a>]
                &nbsp;<?= $user->getFullName() ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                Act:<?= $user->activity ?>
                Par:<?= $user->participation ?>
                Soc:<?= $user->sociability ?>
                Pop:<?= $user->popularity ?>
            </td>
        </tr>
        <?php $count++; ?>
    <?php } ?>
<?php }; $count = 0; ?>
    <tr>
        <td colspan="2">
            <center><a href="<?= $this->url(array(), 'friends_followings') ?>">[Ver todos]</a></center>
        </td>
    </tr>
</table>

<?php } else { ?>
<p>No se encontraron contactos</p>
<?php } ?>

<b>Peticiones</b>
<?php if (count($followers) != 0) { ?>

<table width="100%">
<?php foreach ($followers as $follower) { ?>
    <?php if ($count < $limit) { ?>
        <?php $user = $users_model->findByIdent($follower->user); ?>
        <tr>
            <td width="50px" valign="top" rowspan="2">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            </td>
            <td valign="top">
                [<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>"><?= $this->utf2html($user->label) ?></a>]
                &nbsp;<?= $user->getFullName() ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                Act:<?= $user->activity ?>
                Par:<?= $user->participation ?>
                Soc:<?= $user->sociability ?>
                Pop:<?= $user->popularity ?>
            </td>
        </tr>
        <?php $count++; ?>
    <?php } ?>
<?php } ?>
    <tr>
        <td colspan="2">
            <center><a href="<?= $this->url(array(), 'friends_followers') ?>">[Ver todos]</a></center>
        </td>
    </tr>
</table>

<?php } else { ?>
<p>No se encontraron contactos</p>
<?php } ?>
