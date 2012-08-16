<?php

echo $this->partial($this->template('resources', 'resource'), array(
    'resources' => $this->resources,
    'pager' => $this->pager,
    'config' => $this->config,
    'template' => $this->template,
    'paginator' => true
));

