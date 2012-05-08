<?php

class Friends_IndexController extends Yachay_Controller_Action
{
    public function friendsAction() {
        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $friends = $model_friends->selectFriendsByUser($this->user->ident);

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->friends = $friends;

        $this->history('friends');
        $this->breadcrumb();
    }

    public function followingsAction() {
        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $followings = $model_friends->selectFollowingsByUser($this->user->ident);

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->followings = $followings;

        $this->history('friends/followings');
        $this->breadcrumb();
    }

    public function followersAction() {
        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $followers = $model_friends->selectFollowersByUser($this->user->ident);

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->followers = $followers;

        $this->history('friends/followers');
        $this->breadcrumb();
    }
}
