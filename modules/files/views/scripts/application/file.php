<?php

echo '<b>' . strtoupper($this->file->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->file->description));
echo '<br />';
echo '<center><a href="' . $this->url(array('file' => $this->file->resource), 'files_file_download') . '">' .
     $this->file->filename . ' (' . $this->size($this->file->size) . ')</a> ' . '</center>';
