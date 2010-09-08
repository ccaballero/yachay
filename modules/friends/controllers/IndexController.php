<?php

class Friends_IndexController extends Yeah_Action
{
    public function friendsAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $friends_model = Yeah_Adapter::getModel('friends');
        $friends = $friends_model->selectFriendsByUser($USER->ident);

        $users_model = Yeah_Adapter::getModel('users');
        $request = $this->getRequest();

        $this->view->users = $users_model;
        $this->view->model = $friends_model;
        $this->view->friends = $friends;

        history('friends');
        $breadcrumb = array();
        breadcrumb($breadcrumb);
    }

    public function followingsAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $friends_model = Yeah_Adapter::getModel('friends');
        $followings = $friends_model->selectFollowingsByUser($USER->ident);

        $users_model = Yeah_Adapter::getModel('users');
        $request = $this->getRequest();

        $this->view->users = $users_model;
        $this->view->model = $friends_model;
        $this->view->followings = $followings;

        history('friends/followings');
        $breadcrumb = array();
        breadcrumb($breadcrumb);
    }

    public function followersAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $friends_model = Yeah_Adapter::getModel('friends');
        $followers = $friends_model->selectFollowersByUser($USER->ident);

        $users_model = Yeah_Adapter::getModel('users');
        $request = $this->getRequest();

        $this->view->users = $users_model;
        $this->view->model = $friends_model;
        $this->view->followers = $followers;

        history('friends/followers');
        $breadcrumb = array();
        breadcrumb($breadcrumb);
    }
}
