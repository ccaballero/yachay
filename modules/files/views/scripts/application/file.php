<b>ARCHIVO:</b>
<br />
<?= $this->utf2html($this->wrapper($this->file->description)) ?>
<br />
<?= $this->mime($this->file->mime) ?>&nbsp;
<a href="<?= $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?= $this->utf2html($this->file->filename) ?></a>
&nbsp;<?= $this->size($this->file->size) ?>
