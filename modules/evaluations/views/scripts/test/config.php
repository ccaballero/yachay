<?php global $USER; ?>
<h1><?= $this->utf2html($this->evaluation->label) ?></h1>

<h2>[<?= $this->utf2html($this->test->key) ?>]&nbsp;<?= $this->utf2html($this->test->label) ?></h2>
<p>
	<?php if ($this->test->formula) { ?>
    	<b>Formula: </b><?= $this->test->formula ?><br />
    <?php } ?>
    <b>Nota minima: </b><?= $this->test->minimumnote ?><br />
    <b>Nota por omision: </b><?= $this->test->defaultnote ?><br />
    <b>Nota maxima: </b><?= $this->test->maximumnote ?>
</p>

<h2>Valores cualitativos</h2>

<?php if (count($this->values)) { ?>
<ul>
<?php foreach ($this->values as $value) { ?>
    <li>
        <b>[<?= $this->utf2html($value->label) ?>]&nbsp;</b><?= $this->utf2html($value->value) ?>
        <?php if ($this->evaluation->author == $USER->ident && count($this->groups) == 0) { ?>
        	[<i><a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $this->test->ident, 'value' => $value->ident), 'evaluations_evaluation_test_value_delete') ?>">Eliminar</a></i>]
        <?php } ?>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se registraron valores cualitativos.</p>
<?php } ?>

<h3>Crear nuevo valor cualitativo</h3>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Valor cualitativo (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->value->label ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Nota que representa (*):</b></td>
                <td><input type="text" name="value" value="<?= $this->value->value ?>" maxlength="3" /></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Agregar valor" />
                </td>
            </tr>
        </table>
    </form>
</center>
