<h1>Editar Evento</h1>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
	        <tr>
                <td><b>Nombre (*):</b></td>
                <td><input type="text" name="name" value="<?= $this->utf2html($this->event->label) ?>"/></td>
            </tr>
            <tr>
                <td><b>Lugar :</b></td>
                <td><input type="text" name="place" value="<?= $this->utf2html($this->event->place) ?>"/></td>
            </tr>
            <tr>
                <td><b>Fecha (*):</b></td>
                <td><?= $this->time('event', $this->event->event) ?></td>
            </tr>
            <tr>
                <td><b>Duraci&oacute;n :</b></td>
                <td>
                	<?= $this->interval('duration', 'interval', $this->event->duration) ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Mensaje :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="message" cols="50" rows="5"><?= $this->utf2html($this->event->message) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Guardar" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>

