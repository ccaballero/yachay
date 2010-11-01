<?php

$friends_model = Yeah_Adapter::getModel('friends');
$users_model = Yeah_Adapter::getModel('users');

$count = 0;
$limit = 4;
$friends = $friends_model->selectFriendsByUser($this->user->ident);
$followings = $friends_model->selectFollowingsByUser($this->user->ident);
$followers = $friends_model->selectFollowersByUser($this->user->ident);

echo '<br /><b>Amigos</b>';
if (count($friends) != 0) {
    echo '<table width="100%">';
    foreach ($friends as $friend) {
        if ($count < $limit) {
            $user = $users_model->findByIdent($friend->friend);
            echo '<tr><td width="50px" valign="top" rowspan="2">';
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' .
                 '<img src="' . $this->config->media_base . '../users/thumbnail_small/' . $user->getAvatar() . '" title="" alt="" /></a>';
            echo '</td><td valign="top">';
            echo '[<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->label . '</a>]&nbsp;' . $user->getFullName();
            echo '</td></tr><tr><td valign="top">';
            echo "Act:{$user->activity} Par:{$user->participation} Soc:{$user->sociability} Pop:{$user->popularity}";
            echo '</td></tr>';
            $count++;
        }
    };
    $count = 0;
    echo '<tr><td colspan="2"><center><a href="' . $this->url(array(), 'friends_friends') . '">[Ver todos]</a></center></td></tr></table>';
} else {
    echo '<p>No se encontraron contactos</p>';
}

echo '<b>Solicitudes</b>';
if (count($followings) != 0) {
    echo '<table width="100%">';
    foreach ($followings as $following) {
        if ($count < $limit) {
            $user = $users_model->findByIdent($following->friend);
            echo '<tr><td width="50px" valign="top" rowspan="2">';
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' .
                 '<img src="' . $this->config->media_base . '../users/thumbnail_small/' . $user->getAvatar() . '" title="" alt="" /></a>';
            echo '</td><td valign="top">';
            echo '[<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->label . '</a>]&nbsp;' . $user->getFullName();
            echo '</td></tr><tr><td valign="top">';
            echo "Act:{$user->activity} Par:{$user->participation} Soc:{$user->sociability} Pop:{$user->popularity}";
            echo '</td></tr>';
            $count++;
        }
    }
    $count = 0;
    echo '<tr><td colspan="2"><center><a href="' . $this->url(array(), 'friends_followings') . '">[Ver todos]</a></center></td></tr></table>';
} else {
    echo '<p>No se encontraron contactos</p>';
}

echo '<b>Peticiones</b>';
if (count($followers) != 0) {
    echo '<table width="100%">';
    foreach ($followers as $follower) {
        if ($count < $limit) {
            $user = $users_model->findByIdent($follower->user);
            echo '<tr><td width="50px" valign="top" rowspan="2">';
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' .
                 '<img src="' . $this->config->media_base . '../users/thumbnail_small/' . $user->getAvatar() . '" title="" alt="" /></a>';
            echo '</td><td valign="top">';
            echo '[<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->label . '</a>]&nbsp;' . $user->getFullName();
            echo '</td></tr><tr><td valign="top">';
            echo "Act:{$user->activity} Par:{$user->participation} Soc:{$user->sociability} Pop:{$user->popularity}";
            echo '</td></tr>';
            $count++;
        }
    }
    echo '<tr><td colspan="2"><center><a href="' . $this->url(array(), 'friends_followers') . '">[Ver todos]</a></center></td></tr></table>';
} else {
    echo '<p>No se encontraron contactos</p>';
}
