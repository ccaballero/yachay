<h2>Insertar nuevo comentario</h2>

<form method="post" action="<?= $this->url(array('resource' => $this->resource->ident), $this->route) ?>" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
    <textarea cols="100" rows="3" name="comment"></textarea>
    <br />
    <input type="submit" value="Comentar" />
</form>
