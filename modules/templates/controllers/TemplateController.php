<?php

class Templates_TemplateController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('templates', 'configure');

        $request = $this->getRequest();
        $label_template = $request->getParam('template');

        $model_templates = new Templates();
        $model_templates_users = new Templates_Users();

        $template = $model_templates->findByLabel($label_template);

        $this->requireExistence($template, 'template', 'template_template_view', 'frontpage_user');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $class = new StdClass();
            foreach ($request->getParams() as $param => $value) {
                if (strcasecmp(substr($param, 0, strlen('_')), '_') === 0) {
                    $param = substr($param, 1);
                    $class->{$param} = $value;
                }
            }

            $template_user = $model_templates_users->findByTemplateAndUser($template->ident, $USER->ident);
            if (empty($template_user)) {
                $template_user = $model_templates_users->createRow();
                $template_user->template = $template->ident;
                $template_user->user = $USER->ident;
            }

            $template_user->css_properties = json_encode($class);
            $template_user->save();

            $session->messages->addMessage('Tu plantilla se configuró correctamente');
            $this->_redirect($this->view->url(array('template' => $template->label), 'templates_template_view'));
        }

        $this->view->template = $template;

        history('templates/view/' . $template->label);
        $breadcrumb = array();
        $breadcrumb['Temas'] = $this->view->url(array(), 'templates_list');
        breadcrumb($breadcrumb);
    }

    public function switchAction() {
        global $USER;

        $this->requirePermission('templates', 'switch');

        $model_users = new Users();
        $model_templates = new Templates();

        $request = $this->getRequest();
        $label_template = $request->getParam('template');

        $user = $model_users->findByUrl($USER->url);
        $session = new Zend_Session_Namespace();

        context('user', $user);
        $template = $model_templates->findByLabel($label_template);
        if (!empty($template)) {
            $user->template = $template->label;

            if ($user->isValid()) {
                $user->save();
                $session->user = $user;
                $session->messages->addMessage('Tu has cambiado tu plantilla correctamente');
            }
        } else {
            $session->messages->addMessage(ucfirst($label_template) . ' no se encuentra registrada como plantilla');
        }

        $url = new Zend_View_Helper_Url();
        $this->_redirect($url->url(array(), 'templates_list'));
    }
}
