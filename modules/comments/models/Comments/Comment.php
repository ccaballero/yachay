<?php

class modules_comments_models_Comments_Comment extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'comment' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getResource() {
        $resources = Yeah_Adapter::getModel('resources');
        return $resources->findByIdent($this->resource);
    }

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }

    public function amAuthor() {
        global $USER;
        return ($USER->ident == $this->author);
    }
}
