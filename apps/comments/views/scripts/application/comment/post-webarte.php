<h2>Insertar nuevo comentario</h2>

<form method="post" action="<?php echo $this->url(array('resource' => $this->resource->ident), $this->comment_route) ?>" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />
    <div class="resource">
        <div class="avatar">
            <img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_small/' . $this->user->getAvatar() ?>" alt="<?php echo $this->user->getFullName() ?>" title="<?php echo $this->user->getFullName() ?>" />
        </div>
        <div class="message"><textarea cols="100" rows="2" name="comment"></textarea></div>
        <span class="addon"><span class="viewall"><input type="submit" value="Comentar" /></span></span>
    </div>
</form>
