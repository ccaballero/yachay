<?php

class Subjects_IndexController extends Yachay_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('subjects', 'list');

        $model_gestions = new Gestions();
        $model_subjects = new Subjects();

        $gestion = $model_gestions->findByActive();

        $this->view->model_subjects = $model_subjects;
        $this->view->gestion = $gestion;

        $subjects2 = array();
        $assign = array();

        if (!empty($gestion)) {
            $model_subjects_users = new Subjects_Users();
            $subjects1 = $model_subjects->selectAll($gestion->ident);

            foreach ($subjects1 as $subject) {
                $subject_user = $model_subjects_users->findBySubjectAndUser($subject->ident, $USER->ident);
                $type = '';
                if (!empty($subject_user)) {
                    $type = $subject_user->type;
                }
                if ($subject->moderator == $USER->ident) {
                    $type = 'moderator';
                }

                if ($subject->status == 'active' || $this->acl('subjects', 'lock') || $this->acl('subjects', 'moderate')) {
                    switch ($subject->visibility) {
                        case 'public':
                            $subjects2[] = $subject;
                            $assign[$subject->url] = $type;
                            break;
                        case 'register':
                            if ($USER->role != 1) {
                                $subjects2[] = $subject;
                                $assign[$subject->url] = $type;
                            }
                            break;
                        case 'private':
                            if ($USER->role != 1) {
                                if ($this->acl('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                    $assign[$subject->url] = $type;
                                } else if ($subject->moderator == $USER->ident) {
                                    $subjects2[] = $subject;
                                    $assign[$subject->url] = $type;
                                } else {
                                    if (!empty($subject_user)) {
                                        $subjects2[] = $subject;
                                        $assign[$subject->url] = $type;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }

        $this->view->subjects = $subjects2;
        $this->view->assign = $assign;

        $this->history('subjects');
        $breadcrumb = array();
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        breadcrumb($breadcrumb);
    }
}
