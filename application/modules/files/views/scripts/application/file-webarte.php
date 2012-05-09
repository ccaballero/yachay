<?php if (!empty($this->file->description)) { ?>
    <p><?php echo $this->specialEscape($this->escape($this->file->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?php echo $this->template->htmlbase . 'images/attach.png' ?>" alt="" title="" />
    <a href="<?php echo $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?php echo $this->file->filename . ' (' . $this->size($this->file->size) . ')' ?></a>
</p>
