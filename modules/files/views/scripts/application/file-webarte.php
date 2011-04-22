<?php if (!empty($this->file->description)) { ?>
    <p><?= $this->specialEscape($this->escape($this->file->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/attach.png' ?>" alt="" title="" />
    <a href="<?= $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?= $this->file->filename . ' (' . $this->size($this->file->size) . ')' ?></a>
</p>
