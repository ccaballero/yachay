<?php

class Subjects_IndexController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('subjects', 'list');

        $gestions = Yeah_Adapter::getModel('gestions');
        $subjects = Yeah_Adapter::getModel('subjects');
        $gestion = $gestions->findByActive();

        $this->view->model = $subjects;
        $this->view->gestion = $gestion;

        $subjects2 = array();

        if (!empty($gestion)) {
            $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
            $subjects1 = $subjects->selectAll($gestion->ident);
            foreach ($subjects1 as $subject) {
                if ($subject->status == 'active' || Yeah_Acl::hasPermission('subjects', 'lock') || Yeah_Acl::hasPermission('subjects', 'moderate')) {
                    switch ($subject->visibility) {
                        case 'public':
                            $subjects2[] = $subject;
                            break;
                        case 'register':
                            if ($USER->role != 1) {
                                $subjects2[] = $subject;
                            }
                            break;
                        case 'private':
                            if ($USER->role != 1) {
                                if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                } else if ($subject->moderator == $USER->ident) {
                                    $subjects2[] = $subject;
                                } else {
                                    $assign = $assignement->findBySubjectAndUser($subject->ident, $USER->ident);
                                    if (!empty($assign)) {
                                        $subjects2[] = $subject;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
            $this->view->assignement = $assignement;
        }
        $this->view->subjects = $subjects2;

        history('subjects');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        }
        breadcrumb($breadcrumb);
    }
}
