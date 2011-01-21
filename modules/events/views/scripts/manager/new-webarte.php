<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="event_publish">Publicar en (*): </label><?= $this->context('publish') ?></p>
    <p><label for="event_name">Nombre (*): </label><input type="text" name="name" value="<?= $this->event->label ?>" maxlength="64" /></p>
    <p><label for="event_place">Lugar: </label><input type="text" name="place" value="<?= $this->event->place ?>" maxlength="256" /></p>
    <p><label for="event_date">Fecha: </label><?= $this->time('event', $this->event->event) ?></p>
    <p><label for="event_duration">Duración: </label><?= $this->interval('duration', 'interval', $this->event->duration) ?></p>
    <p><label for="event_message">Mensaje: </label><textarea id="event_message" name="message" cols="50" rows="5"><?= $this->event->message ?></textarea></p>
    <p><label for="event_tags">Etiquetas (**): </label><input name="tags" value="<?= $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Publicar evento" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
