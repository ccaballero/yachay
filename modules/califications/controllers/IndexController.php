<?php

class Califications_IndexController extends Yeah_Action
{
    public function indexAction() {
        $request = $this->getRequest();

        $siss = $request->getParam('siss', '');

        if (!empty($siss)) {
            $model_gestions = Yeah_Adapter::getModel('gestions');
            $model_groups = Yeah_Adapter::getModel('groups');
            $model_users = Yeah_Adapter::getModel('users');
            $model_califications = Yeah_Adapter::getModel('califications');

            $current_gestion = $model_gestions->findByActive();
            $user = $model_users->findByCode($siss);

            if (!empty($user)) {
                $user_groups = $user->findmodules_groups_models_GroupsViamodules_groups_models_Groups_Users($user->select()->where('type = ?', 'student'));

                $subjects = array();
                $groups = array();
                $evaluations = array();
                $test_evaluations = array();
                $califications = array();

                foreach ($user_groups as $group) {
                    $subject = $group->getSubject();
                    $gestion = $subject->getGestion();
                    if ($gestion->ident == $current_gestion->ident) {
                        $evaluation = $group->getEvaluation();

                        $subjects[$subject->ident] = $subject;
                        $groups[$subject->ident][] = $group;
                        $evaluations[$group->ident] = $evaluation;
                        
                        $tests = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));
                        $test_evaluations[$group->ident] = $tests;

                        foreach ($tests as $test) {
                            $_calification = $model_califications->findCalification($group->ident, $user->ident, $evaluation->ident, $test->ident);
                            if (empty($_calification)) {
                                $califications[$group->ident][$test->ident] = '--';
                            } else {
                                $califications[$group->ident][$test->ident] = $_calification->calification;
                            }
                        }
                    }
                }

                $this->view->gestion = $current_gestion;
                $this->view->user = $user;
                $this->view->subjects = $subjects;
                $this->view->groups = $groups;
                $this->view->evaluations = $evaluations;
                $this->view->test_evaluations = $test_evaluations;
                $this->view->califications = $califications;

            } else {
                $this->view->error = 'user invalid';
            }
        } else {
            $this->view->error = 'no user';
        }

        history('califications');
        breadcrumb();
    }
}
