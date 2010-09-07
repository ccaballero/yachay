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
}