<?php

$model_friends = new Friends();
$model_users = new Users();

$count = 0;
$limit = 12;

$friends = $model_friends->selectFriendsByUser($this->USER->ident);
$followings = $model_friends->selectFollowingsByUser($this->USER->ident);
$followers = $model_friends->selectFollowersByUser($this->USER->ident);

$count_friends = count($friends);
$count_followings = count($followings);
$count_followers = count($followers);

?>

<h3><a href="<?= $this->url(array(), 'friends_friends') ?>">Amigos (<?= $count_friends ?>)</a></h3>
<?php if (count($friends) != 0) { ?>
    <ul>
    <?php foreach ($friends as $friend) { ?>
        <?php if ($count < $limit) { ?>
        <li class="left">
            <?php $user = $model_users->findByIdent($friend->friend); ?>
            <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                <img src="<?= $this->CONFIG->media_base . 'users/thumbnail_medium/' . $user->getAvatar() ?>" title="<?= $user->getFullName() ?>" alt="<?= $user->getFullName() ?>" />
            </a>
            <?php $count++; ?>
        </li>
        <?php } ?>
    <?php } ?>
    </ul>
    <?php $count = 0; ?>
<?php } else { ?>
    <p>No se encontraron contactos</p>
<?php } ?>
<div class="clear"></div>

<h3><a href="<?= $this->url(array(), 'friends_followings') ?>">Solicitudes (<?= $count_followings ?>)</a></h3>
<?php if (count($followings) != 0) { ?>
    <ul>
    <?php foreach ($followings as $following) { ?>
        <?php if ($count < $limit) { ?>
        <li class="left">
            <?php $user = $model_users->findByIdent($following->friend); ?>
            <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                <img src="<?= $this->CONFIG->media_base . 'users/thumbnail_medium/' . $user->getAvatar() ?>" title="<?= $user->getFullName() ?>" alt="<?= $user->getFullName() ?>" />
            </a>
            <?php $count++; ?>
        </li>
        <?php } ?>
    <?php } ?>
    </ul>
    <?php $count = 0; ?>
<?php } else { ?>
    <p>No se encontraron contactos</p>
<?php } ?>
<div class="clear"></div>

<h3><a href="<?= $this->url(array(), 'friends_followers') ?>">Peticiones (<?= $count_followers ?>)</a></h3>
<?php if (count($followers) != 0) { ?>
    <ul>
    <?php foreach ($followers as $follower) { ?>
        <?php if ($count < $limit) { ?>
        <li class="left">
            <?php $user = $model_users->findByIdent($follower->user); ?>
            <a href="<?= $this->url(array('user' => $user->url), 'users_user_view'); ?>">
                <img src="<?= $this->CONFIG->media_base . 'users/thumbnail_medium/' . $user->getAvatar() ?>" title="<?= $user->getFullName() ?>" alt="<?= $user->getFullName() ?>" />
            </a>
           <?php $count++; ?>
        </li>
        <?php } ?>
    <?php } ?>
    </ul>
<?php } else { ?>
    <p>No se encontraron contactos</p>
<?php } ?>
