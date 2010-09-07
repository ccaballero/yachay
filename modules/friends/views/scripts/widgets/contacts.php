<?php
    global $USER;
    global $CONFIG;

    $friends_model = Yeah_Adapter::getModel('friends');
    $users_model = Yeah_Adapter::getModel('users');

    $count = 0;
    $limit = 5;
    $friends = $friends_model->selectByUser($USER->ident);
?>

<?php if (count($friends) != 0) { ?>

<table width="100%">
    <?php foreach ($friends as $friend) { ?>
    <?php if ($count <= $limit) { ?>
        <?php $user = $users_model->findByIdent($friend->friend); ?>
        <tr>
            <td width="50px" valign="top" rowspan="2">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            </td>
            <td valign="top">
                [<a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>"><?= $this->utf2html($user->label) ?></a>]
                Act: <?= $user->activity ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <?= $user->getFullName() ?>
            </td>
        </tr>
        <?php $count++; ?>
    <?php } ?>
    <?php } ?>
    <tr>
        <td colspan="2">
            <center><a href="<?= $this->url(array(), 'friends_list') ?>">[Ver todos]</a></center>
        </td>
    </tr>
</table>

<?php } else { ?>
<p>No se encontraron contactos</p>
<?php } ?>
