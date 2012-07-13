<?php

class Templates_TemplateController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('templates', 'configure');

        $request = $this->getRequest();
        $label_template = $request->getParam('template');

        $model_templates = new Templates();
        $model_templates_users = new Templates_Users();

        $template = $model_templates->findByLabel($label_template);

        $this->requireExistence($template, 'template', 'template_template_view', 'frontpage_user');

        if ($request->isPost()) {
            $class = new StdClass();
            foreach ($request->getParams() as $param => $value) {
                if (strcasecmp(substr($param, 0, strlen('_')), '_') === 0) {
                    $param = substr($param, 1);
                    $class->{$param} = $value;
                }
            }

            $template_user = $model_templates_users->findByTemplateAndUser($template->ident, $this->user->ident);
            if (empty($template_user)) {
                $template_user = $model_templates_users->createRow();
                $template_user->template = $template->ident;
                $template_user->user = $this->user->ident;
            }

            $template_user->css_properties = json_encode($class);
            $template_user->save();

            $this->_helper->flashMessenger->addMessage('Tu plantilla se configuró correctamente');
            $this->_redirect($this->view->url(array('template' => $template->label), 'templates_template_view'));
        } else {
            $this->history('templates/view/' . $template->label);
        }

        $this->view->tpl = $template;

        $user_template = $model_templates_users->findByTemplateAndUser($template->ident, $this->user->ident);
        if (empty($user_template)) {
            $user_template = $template;
        }

        $this->view->properties = json_decode($user_template->css_properties, true);

        $breadcrumb = array();
        $breadcrumb['Temas'] = $this->view->url(array(), 'templates_list');
        $this->breadcrumb($breadcrumb);
    }

    public function switchAction() {
        $this->requirePermission('templates', 'switch');

        $model_users = new Users();
        $model_templates = new Templates();

        $request = $this->getRequest();
        $label_template = $request->getParam('template');

        $user = $model_users->findByUrl($this->user->url);
        $session = new Zend_Session_Namespace('yachay');

        $this->context('user', $user);
        $template = $model_templates->findByLabel($label_template);
        if (!empty($template)) {
            $user->template = $template->label;

            if ($user->isValid()) {
                $user->save();
                $session->user = $user;
                $this->_helper->flashMessenger->addMessage('Tu has cambiado tu plantilla correctamente');
            }
        } else {
            $this->_helper->flashMessenger->addMessage(ucfirst($label_template) . ' no se encuentra registrada como plantilla');
        }

        $url = new Zend_View_Helper_Url();
        $this->_redirect($url->url(array(), 'templates_list'));
    }
}
