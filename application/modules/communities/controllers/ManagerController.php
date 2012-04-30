<?php

class Communities_ManagerController extends Yachay_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('communities', 'list');
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        }

        $model_communities = new Communities();
        $communities = $model_communities->selectByAuthor($USER->ident);

        $this->view->model_communities = $model_communities;
        $this->view->communities = $communities;

        history('communities/manager');
        $breadcrumb = array();
        if ($this->acl('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');
        $this->view->community = new Communities_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_communities = new Communities();
            $model_tags = new Tags();
            $model_communities_users = new Communities_Users();

            $community = $model_communities->createRow();

            $community->label = $request->getParam('label');
            $community->url = convert($community->label);
            $community->mode = $request->getParam('mode');
            $community->description = $request->getParam('description');

            if ($community->isValid()) {
                $community->author = $USER->ident;
                $community->tsregister = time();
                $community->save();

                // add author to community's users
                $assignement = $model_communities_users->createRow();
                $assignement->community = $community->ident;
                $assignement->user = $USER->ident;
                $assignement->type = 'moderator';
                $assignement->status = 'active';
                $assignement->tsregister = time();
                $assignement->save();

                // config of avatar
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(APPLICATION_PATH . '/../public/media/upload');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('jpg', 'png', 'gif'));
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');

                    $thumbnail = new Yachay_Helpers_Thumbnail();

                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/communities/thumbnail_large/' . $community->ident . '.jpg', 200, 200);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/communities/thumbnail_medium/' . $community->ident . '.jpg', 100, 100);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/communities/thumbnail_small/' . $community->ident . '.jpg', 50, 50);

                    unlink($filename);
                    $community->avatar = true;
                    
                }

                // tagging
                $model_tags->tagging_community(array(), $request->getParam('tags'), $community);

                $community->save();
                $session->url = $community->url;

                $session->messages->addMessage("La comunidad {$community->label} se ha creado correctamente");
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($community->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->community = $community;
        }

        history('communities/new');
        $breadcrumb = array();
        if ($this->acl('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if ($this->acl('communities', 'enter')) {
            $breadcrumb['Administrador de comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();
            $model_communities_users = new Communities_Users();
            $model_communities_petitions = new Communities_Petitions();
            $model_tags_communities = new Tags_Communities();

            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $community = $model_communities->findByIdent($value);
                if (!empty($community) && $community->amAuthor()) {
                    $model_communities_users->deleteUsersInCommunity($community->ident);
                    if ($community->mode == 'close') {
                        $model_communities_petitions->deleteAplicantsInCommunity($community->ident);
                    }

                    $tags = $community->findTagsViaTags_Communities();
                    foreach ($tags as $tag) {
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $model_tags_communities->findByTagAndCommunity($tag->ident, $community->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }

                    $community->delete();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count comunidades");
        }
        $this->_redirect($this->view->currentPage());
    }
}
