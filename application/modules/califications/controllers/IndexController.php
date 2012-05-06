<?php

class Califications_IndexController extends Yachay_Action
{
    public function indexAction() {
        $request = $this->getRequest();

        $siss = $request->getParam('siss', '');

        if (!empty($siss)) {
            $model_gestions = new Gestions();
            $model_groups = new Groups();
            $model_users = new Users();
            $model_califications = new Califications();

            $current_gestion = $model_gestions->findByActive();
            $user = $model_users->findByCode($siss);

            if (!empty($user)) {
                $user_groups = $user->findGroupsViaGroups_Users($user->select()->where('type = ?', 'student'));

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
                        
                        $tests = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));
                        $test_evaluations[$group->ident] = $tests;

                        foreach ($tests as $test) {
                            if (!empty($test->formula)) {
                                $califications[$group->ident][$test->ident] = $model_califications->getCalification($group->ident, $user->ident, $evaluation->ident, $test);
                            } else {
                                $_calification = $model_califications->findCalification($group->ident, $user->ident, $evaluation->ident, $test->ident);
                                if (empty($_calification)) {
                                    $califications[$group->ident][$test->ident] = '--';
                                } else {
                                    $califications[$group->ident][$test->ident] = $_calification->calification;
                                }
                            }
                        }
                    }
                }

                $this->view->model = $model_califications;
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

        $this->history('califications');
        $this->breadcrumb();
    }
}
