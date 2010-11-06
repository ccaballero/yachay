<?= $this->wrapper($this->file->description) ?>

<p>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/attach.png' ?>" alt="" title="" />
    <a href="<?= $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?= $this->file->filename . ' (' . $this->size($this->file->size) . ')' ?></a>
</p>
