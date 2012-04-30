<?php

class Templates_ManagerController extends Yachay_Action
{
    public function cssAction() {
        global $TEMPLATE;
        global $USER;

        $model_templates = new Templates();
        $model_templates_users = new Templates_Users();

        $template = $model_templates->findByLabel($TEMPLATE->label);

        $json_properties = $template->css_properties;
        $custom_properties = $model_templates_users->findByTemplateAndUser($template->ident, $USER->ident);
        if ($custom_properties != NULL) {
            $json_properties = $custom_properties->css_properties;
        }

        $properties = json_decode($json_properties, true);

        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . '/modules/templates/views/scripts/manager/');

        $view->config = Zend_Registry::get('config');

        foreach ($properties as $property => $value) {
            $view->{$property} = $value;
        }

        $css = $view->render($this->view->template('templates', 'css', 'manager/', TRUE));

        header("HTTP/1.1 200 OK"); //mandamos código de OK
        header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
        header('Content-Type: text/css');
        header('Content-Length: '. strlen($css));
        echo $css;
        die();
    }
}
