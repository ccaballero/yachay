<p><?= str_replace(" ", "&nbsp;", str_replace("\n", "<br/>", $this->escape($this->file->description))) ?></p>
<p>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/attach.png' ?>" alt="" title="" />
    <a href="<?= $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?= $this->file->filename . ' (' . $this->size($this->file->size) . ')' ?></a>
</p>
