<?php global $USER; ?>
<h1><?= $this->utf2html($this->evaluation->label) ?></h1>

<h2>Nueva calificacion</h2>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre de la calificacion (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->test->label ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Codigo a utilizar (*):</b></td>
                <td><input type="text" name="key" value="<?= $this->test->key ?>" maxlength="4" /></td>
            </tr>
            <tr>
                <td><b>Nota minima :</b></td>
                <td><input type="text" name="minimum" value="<?= $this->test->minimumnote ?>" maxlength="3" /></td>
            </tr>
            <tr>
                <td><b>Nota por omision :</b></td>
                <td><input type="text" name="default" value="<?= $this->test->defaultnote ?>" maxlength="3" /></td>
            </tr>
            <tr>
                <td><b>Nota maxima :</b></td>
                <td><input type="text" name="maximum" value="<?= $this->test->maximumnote ?>" maxlength="3" /></td>
            </tr>
            <tr>
                <td><b>Formula de calculo :</b></td>
                <td><input type="text" name="formula" value="<?= $this->test->formula ?>" maxlength="512" /></td>
            </tr>
            <tr>
                <td><b>Orden de precedencia :</b></td>
                <td><input type="text" name="order" value="<?= $this->test->order ?>" maxlength="3" /></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Agregar calificaci&oacute;n" />
                    <a href="<?= $this->lastPage() ?>">Volver</a>
                </td>
            </tr>
        </table>
    </form>
</center>

<h2>Calificaciones registradas</h2>

<?php if (count($this->tests)) { ?>
<dl>
<?php foreach ($this->tests as $test) { ?>
    <dt>
        <b>[<?= $test->key ?>]&nbsp;<a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') ?>"><?= $this->utf2html($test->label) ?></a></b>
        <?php if ($test->formula) { ?>
        	: <?= $test->formula ?>
        <?php } ?>
        <?php if ($this->evaluation->author == $USER->ident && count($this->groups) == 0) { ?>
        	[<i><a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') ?>">Eliminar</a></i>]
        <?php } ?>
    </dt>
    <dd>
    	<b>Nota minima: </b><?= $test->minimumnote ?><br />
    	<b>Nota por omision: </b><?= $test->defaultnote ?><br />
    	<b>Nota maxima: </b><?= $test->maximumnote ?><br />
    </dd>
<?php } ?>
</dl>
<?php } else { ?>
<p>No se registraron calificaciones previstas.</p>
<?php } ?>
