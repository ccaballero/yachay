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

<dl>
    <dt><a href="<?= $this->url(array(), 'friends_friends') ?>">Amigos (<?= count($friends) ?>)</a></dt>
<?php if (count($friends) != 0) { ?>
    <dd>
    <?php foreach ($friends as $friend) { ?>
        <ul>
        <?php if ($count < $limit) { ?>
            <?php $user = $users_model->findByIdent($friend->friend); ?>
            <li class="align_left">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            <?php $count++; ?>
            </li>
        <?php } ?>
        </ul>
    <?php } ?>
<?php $count = 0; ?>
    </dd>
<?php } else { ?>
    <dd>No se encontraron contactos</dd>
<?php } ?>

    <dt><a href="<?= $this->url(array(), 'friends_followings') ?>">Solicitudes (<?= count($followings) ?>)</a></dt>
<?php if (count($followings) != 0) { ?>
    <dd>
    <?php foreach ($followings as $following) { ?>
        <ul>
        <?php if ($count < $limit) { ?>
            <?php $user = $users_model->findByIdent($following->friend); ?>
            <li class="align_left">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            <?php $count++; ?>
            </li>
        <?php } ?>
        </ul>
    <?php } ?>
<?php $count = 0; ?>
    </dd>
<?php } else { ?>
    <dd>No se encontraron contactos</dd>
<?php } ?>

    <dt><a href="<?= $this->url(array(), 'friends_followers') ?>">Peticiones (<?= count($followers) ?>)</a></dt>
<?php if (count($followers) != 0) { ?>
    <dd>
<?php foreach ($followers as $follower) { ?>
        <ul>
        <?php if ($count < $limit) { ?>
            <?php $user = $users_model->findByIdent($follower->user); ?>
            <li class="align_left">
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                    <img src="<?= $CONFIG->media_base . '../users/thumbnail_small/' . $user->getAvatar() ?>" title="<?= $this->utf2html($user->getfullName()) ?>" alt="<?= $this->utf2html($user->getfullName()) ?>" />
                </a>
            <?php $count++; ?>
            </li>
        <?php } ?>
        </ul>
    <?php } ?>
    </dd>
<?php } else { ?>
    <dd>No se encontraron contactos</dd>
<?php } ?>
