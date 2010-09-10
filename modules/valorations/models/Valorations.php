<?php

class modules_valorations_models_Valorations
{
    public function addActivity($score) {
        global $USER;

        $model_users = Yeah_Adapter::getModel('users');
        $user = $model_users->findByIdent($USER->ident);

        $user->activity = $user->activity + $score;
        $user->save();
    }

    public function decreaseActivity($score) {
        global $USER;

        $model_users = Yeah_Adapter::getModel('users');
        $user = $model_users->findByIdent($USER->ident);

        $user->activity = $user->activity - $score;
        $user->save();
    }

    public function addSociability($contact, $score1, $score2) {
        global $USER;

        $model_users = Yeah_Adapter::getModel('users');
        $user = $model_users->findByIdent($USER->ident);

        $user->sociability = $user->sociability + $score1;
        $user->save();

        $contact->sociability = $contact->sociability + $score2;
        $contact->save();
    }

    public function decreaseSociability($contact, $score1, $score2) {
        global $USER;

        $model_users = Yeah_Adapter::getModel('users');
        $user = $model_users->findByIdent($USER->ident);

        $user->sociability = $user->sociability - $score1;
        $user->save();

        $contact->sociability = $contact->sociability + $score2;
        $contact->save();
    }
}
