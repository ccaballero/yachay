<h1><?= $this->PAGE->label ?></h1>

<p>
    <span class="mark">Tema:</span> <?= $this->template->label ?><br />
    <span class="mark">Descripción:</span> <?= $this->template->description ?><br />
    <span class="mark">Doctype:</span> <?= $this->template->doctype ?><br />
</p>

<h2>Esquema de colores</h2>
<p>Usted puede cambiar el esquema de colores de este tema, seleccione el que mas le agrade:</p>


<form method="post" action="" accept-charset="utf-8">
    Verde
    <input type="hidden" name="_color1" value="#6D852A" />
    <input type="hidden" name="_color2" value="#DDE6C5" />
    <input type="hidden" name="_color3" value="#666666" />
    <input type="hidden" name="_color4" value="#FFFFFF" />
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/colors/test.png' ?>" alt="" title="" />
    <input type="submit" name="choice" value="Seleccionar" />
</form>
