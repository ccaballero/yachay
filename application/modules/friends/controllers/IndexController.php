<?php

class Friends_IndexController extends Yachay_Action
{
    public function friendsAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $friends = $model_friends->selectFriendsByUser($USER->ident);

        $request = $this->getRequest();

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->friends = $friends;

        history('friends');
        breadcrumb();
    }

    public function followingsAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $followings = $model_friends->selectFollowingsByUser($USER->ident);

        $request = $this->getRequest();

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->followings = $followings;

        history('friends/followings');
        breadcrumb();
    }

    public function followersAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $model_users = new Users();
        $model_friends = new Friends();
        $followers = $model_friends->selectFollowersByUser($USER->ident);

        $request = $this->getRequest();

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->followers = $followers;

        history('friends/followers');
        breadcrumb();
    }
}
