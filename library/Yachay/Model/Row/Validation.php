<?php

class Yachay_Model_Row_Validation extends Zend_Db_Table_Row_Abstract
{
    protected $_validationMessages;

    public function isValid() {
        $this->_validationMessages = array();
        foreach ($this->_validationRules as $key => $values) {
            // filtered
            if (isset($values['filters'])) {
                foreach ($values['filters'] as $filter) {
                    $this->$key = @Zend_Filter::get($this->$key, $filter);
                }
            }
            if (isset($values['validators'])) {
                foreach ($values['validators'] as $validator) {
                    if (isset($validator['options'])) {
                        if (isset($validator['namespace'])) {
                            if (isset($this->_foreignkey)) {
                                $result = Zend_Validate::is($this->$key, $validator['validator'], array_merge($validator['options'], array($this->ident, $this->{$this->_foreignkey})), $validator['namespace']);
                            } else {
                                $result = Zend_Validate::is($this->$key, $validator['validator'], array_merge($validator['options'], array($this->ident)), $validator['namespace']);
                            }
                        } else {
                            $result = Zend_Validate::is($this->$key, $validator['validator'], $validator['options']);
                        }
                    } else {
                        $result = Zend_Validate::is($this->$key, $validator['validator']);
                    }
                    if ($result == false) {
                        $this->_validationMessages[] = $validator['message'];
                        break;
                    }
                }
            }
        }
        if (count($this->_validationMessages) == 0) {
            return true;
        }
        return false;
    }

    public function getMessages() {
        return $this->_validationMessages;
    }
}
