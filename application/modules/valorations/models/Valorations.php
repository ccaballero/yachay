<?php

class Valorations
{
    public function addActivity($score) {
        $user = Zend_Registry::get('user');

        $model_users = new Users();
        $user = $model_users->findByIdent($user->ident);

        $user->activity = $user->activity + $score;
        $user->save();
    }

    public function decreaseActivity($score, $ident = null) {
        $user = Zend_Registry::get('user');
        if (empty($ident)) {
            $ident = $user->ident;
        }

        $model_users = new Users();
        $user = $model_users->findByIdent($ident);

        $user->activity = $user->activity - $score;
        $user->save();
    }

    public function addSociability($contact, $score1, $score2) {
        $user = Zend_Registry::get('user');

        $model_users = new Users();
        $user = $model_users->findByIdent($user->ident);

        $user->sociability = $user->sociability + $score1;
        $user->save();

        $contact->sociability = $contact->sociability + $score2;
        $contact->save();
    }

    public function decreaseSociability($contact, $score1, $score2) {
        $user = Zend_Registry::get('user');

        $model_users = new Users();
        $user = $model_users->findByIdent($user->ident);

        $user->sociability = $user->sociability - $score1;
        $user->save();

        $contact->sociability = $contact->sociability - $score2;
        $contact->save();
    }

    public function addParticipation($score) {
        $user = Zend_Registry::get('user');

        $model_users = new Users();
        $user = $model_users->findByIdent($user->ident);

        $user->participation = $user->participation + $score;
        $user->save();
    }
    
    public function decreaseParticipation($score, $ident = null) {
        $user = Zend_Registry::get('user');
        if (empty($ident)) {
            $ident = $user->ident;
        }

        $model_users = new Users();
        $user = $model_users->findByIdent($ident);

        $user->participation = $user->participation - $score;
        $user->save();
    }

    public function addPopularity($user) {
        if (!empty($user)) {
            $model_users = new Users();
            $user = $model_users->findByIdent($user);

            $user->popularity = $user->popularity + 1;
            $user->save();
        }
    }

    public function decreasePopularity($user) {
        if (!empty($user)) {
            $model_users = new Users();
            $user = $model_users->findByIdent($user);

            $user->popularity = $user->popularity - 1;
            $user->save();
        }
    }
}
