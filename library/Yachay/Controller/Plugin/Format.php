<?php

class Yachay_Controller_Plugin_Format extends Zend_Controller_Plugin_Abstract
{
    protected $request;

    public function  preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        $this->request = $request;
    }

    public function dispatchLoopShutdown() {
        $view = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer')->view;

        $format = $this->request->getParam('_format', 'html');
        $xml = new Yachay_View_Helper_Xml();

        switch($format) {
            case 'xml':
                $this->_response->setHeader('Content-Type', 'application/xml; charset=utf-8');
                $this->_response->setBody($xml->xml($view));
                break;
            case 'json':
                $this->_response->setHeader('Content-Type', 'application/json; charset=utf-8');
                $this->_response->setBody(@Zend_Json::fromXml($xml->xml($view), true));
                break;
        }
    }
}
