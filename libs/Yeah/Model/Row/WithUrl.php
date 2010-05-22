<?php

class Yeah_Model_Row_WithUrl extends Yeah_Model_Row_Validation
{
    public function save() {
        // FIXME -> UNIQUE INDEX (`url`);
        $this->url = convert($this->label);
        parent::save();
    }
}
