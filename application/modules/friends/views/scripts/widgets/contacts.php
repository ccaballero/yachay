<?php

$model_friends = new Friends();
$model_users = new Users();

$count = 0;
$limit = 4;

$friends = $model_friends->selectFriendsByUser($this->USER->ident);
$followings = $model_friends->selectFollowingsByUser($this->USER->ident);
$followers = $model_friends->selectFollowersByUser($this->USER->ident);

echo '<br />';
echo '<b>Amigos</b>';
if (count($friends) != 0) {
    echo '<table width="100%">';
    foreach ($friends as $friend) {
        if ($count < $limit) {
            $user = $model_users->findByIdent($friend->friend);
            echo '<tr>';
            echo '<td valign="top">';
            echo '<b><a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->getFullName() . '</a></b>';
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
            $user = $model_users->findByIdent($following->friend);
            echo '<tr>';
            echo '<td valign="top">';
            echo '<b><a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->getFullName() . '</a></b>';
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
            $user = $model_users->findByIdent($follower->user);
            echo '<tr>';
            echo '<td valign="top">';
            echo '<b><a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->getFullName() . '</a></b>';
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
