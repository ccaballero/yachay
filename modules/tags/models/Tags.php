<?php

class Tags extends Yeah_Model_Table
{
    protected $_name            = 'tag';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Tags_Tag';
    protected $_dependentTables = array('Tags_Resources', 'Tags_Communities', 'Tags_Users', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Etiqueta',
        'url'                   => 'Identificador',
        'weight'                => 'Peso',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    public function findMaxWeight() {
        $stmt = $this->fetchRow($this->select()->from($this, array('MAX(weight) as max')));
        return $stmt->max;
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function tagging_user($old_tags, $_new_tags, $user) {
        $this->tagging($old_tags, $_new_tags, $user, new Tags_Users(), 'findByTagAndUser', 'user');
    }

    public function tagging_community($old_tags, $_new_tags, $community) {
        $this->tagging($old_tags, $_new_tags, $community, new Tags_Communities(), 'findByTagAndCommunity', 'community');
    }

    public function tagging_resource($old_tags, $_new_tags, $resource) {
        $this->tagging($old_tags, $_new_tags, $resource, new Tags_Resources(), 'findByTagAndResource', 'resource');
    }

    // re-tagging
    private function tagging($old_tags, $_new_tags, $resource, $model, $method, $field) {
        $new_tags = explode(',', $_new_tags);
        $saved_tags = array();

        // removing duplicates tags
        foreach ($new_tags as $new_tag) {
            $new_tag = trim(strtolower($new_tag));
            if (!in_array($new_tag, $saved_tags)) {
                $saved_tags[] = $new_tag;
            }
        }

        // remove old tags
        for ($i = 0; $i < count($saved_tags); $i++) {
            for ($j = 0; $j < count($old_tags); $j++) {
                if (isset($saved_tags[$i]) && isset($old_tags[$j])) {
                    if ($saved_tags[$i] == $old_tags[$j]) {
                        $saved_tags[$i] = NULL;
                        $old_tags[$j] = NULL;
                    }
                }
            }
        }

        // add new tags
        foreach ($saved_tags as $tag_label) {
            if ($tag_label <> NULL) {
                $tag_label = trim(strtolower($tag_label));
                $tag = $this->findByLabel($tag_label);

                if ($tag == NULL) {
                    $tag = $this->createRow();
                    $tag->label = $tag_label;

                    $tag->url = convert($tag->label);
                    $count = 1;
                    while ($count <> 0) {
                        $_tag = $this->findByUrl($tag->url);
                        if (empty($_tag)) {
                            $count = 0;
                        } else {
                            $tag->url = convert($tag->label . $count);
                            $count++;
                        }
                    }

                    $tag->weight = 1;
                    if ($tag->isValid()) {
                        $tag->tsregister = time();
                        $tag->save();
                    }
                } else {
                    $tag->weight = $tag->weight + 1;
                    $tag->save();
                }

                if ($tag->ident <> 0) {
                    $assign = $model->createRow();
                    $assign->tag = $tag->ident;
                    $assign->{$field} = $resource->ident;
                    $assign->save();
                }
            }
        }

        // remove old tags
        foreach ($old_tags as $tag_label) {
            if ($tag_label <> NULL) {
                $tag = $this->findByLabel($tag_label);
                $tag->weight = $tag->weight - 1;
                $tag->save();

                $assign = $model->{$method}($tag->ident, $resource->ident);
                $assign->delete();

                if ($tag->weight == 0) {
                    $tag->delete();
                }
            }
        }
    }
}
