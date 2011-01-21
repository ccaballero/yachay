<h2>Insertar nuevo comentario</h2>

<form method="post" action="<?= $this->url(array('resource' => $this->resource->ident), $this->route) ?>" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
    <div class="resource">
        <div class="avatar">
            <img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $this->USER->getAvatar() ?>" alt="<?= $this->USER->getFullName() ?>" title="<?= $this->USER->getFullName() ?>" />
        </div>
        <div class="message"><textarea cols="100" rows="2" name="comment"></textarea></div>
        <span class="addon"><span class="viewall"><input type="submit" value="Comentar" /></span></span>
    </div>
</form>
