<h1><?= $this->PAGE->label ?></h1>

<p>
    <span class="mark">Tema:</span> <?= $this->template->label ?><br />
    <span class="mark">Descripción:</span> <?= $this->template->description ?><br />
    <span class="mark">Doctype:</span> <?= $this->template->doctype ?><br />
</p>

<h2>Esquema de colores</h2>
<p>Usted puede cambiar el esquema de colores de este tema, seleccione el que mas le agrade:</p>


<form method="post" action="" accept-charset="utf-8">
    <table>
        <tr>
            <th>Descripción</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
            <th style="width: 2.75em;">&nbsp;</th>
        </tr>
        <tr>
            <td>Color de fondo en la parte superior</td>
            <td class="center" style="background-color: #000000;"><input type="radio" name="_background" value="#000000" <?= $this->properties['background'] == '#000000' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #8A1C0F;"><input type="radio" name="_background" value="#8A1C0F" <?= $this->properties['background'] == '#8A1C0F' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3B5998;"><input type="radio" name="_background" value="#3B5998" <?= $this->properties['background'] == '#3B5998' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3A984B;"><input type="radio" name="_background" value="#3A984B" <?= $this->properties['background'] == '#3A984B' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A6AA00;"><input type="radio" name="_background" value="#A6AA00" <?= $this->properties['background'] == '#A6AA00' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #983A87;"><input type="radio" name="_background" value="#983A87" <?= $this->properties['background'] == '#983A87' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #695428;"><input type="radio" name="_background" value="#695428" <?= $this->properties['background'] == '#695428' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #296754;"><input type="radio" name="_background" value="#296754" <?= $this->properties['background'] == '#296754' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #542967;"><input type="radio" name="_background" value="#542967" <?= $this->properties['background'] == '#542967' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background" value="#FFFFFF" <?= $this->properties['background'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de fondo en la parte superior</td>
            <td class="center" style="background-color: #000000;"><input type="radio" name="_background-headers" value="#000000" <?= $this->properties['background-headers'] == '#000000' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #8A1C0F;"><input type="radio" name="_background-headers" value="#8A1C0F" <?= $this->properties['background-headers'] == '#8A1C0F' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3B5998;"><input type="radio" name="_background-headers" value="#3B5998" <?= $this->properties['background-headers'] == '#3B5998' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3A984B;"><input type="radio" name="_background-headers" value="#3A984B" <?= $this->properties['background-headers'] == '#3A984B' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A6AA00;"><input type="radio" name="_background-headers" value="#A6AA00" <?= $this->properties['background-headers'] == '#A6AA00' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #983A87;"><input type="radio" name="_background-headers" value="#983A87" <?= $this->properties['background-headers'] == '#983A87' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #695428;"><input type="radio" name="_background-headers" value="#695428" <?= $this->properties['background-headers'] == '#695428' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #296754;"><input type="radio" name="_background-headers" value="#296754" <?= $this->properties['background-headers'] == '#296754' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #542967;"><input type="radio" name="_background-headers" value="#542967" <?= $this->properties['background-headers'] == '#542967' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background-headers" value="#FFFFFF" <?= $this->properties['background-headers'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Segundo color de fondo en la parte superior</td>
            <td class="center" style="background-color: #959595;"><input type="radio" name="_background-headers2" value="#959595" <?= $this->properties['background-headers2'] == '#959595' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EA5847;"><input type="radio" name="_background-headers2" value="#EA5847" <?= $this->properties['background-headers2'] == '#EA5847' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #627AAD;"><input type="radio" name="_background-headers2" value="#627AAD" <?= $this->properties['background-headers2'] == '#627AAD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A6D590;"><input type="radio" name="_background-headers2" value="#A6D590" <?= $this->properties['background-headers2'] == '#A6D590' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FBFF44;"><input type="radio" name="_background-headers2" value="#FBFF44" <?= $this->properties['background-headers2'] == '#FBFF44' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D590A6;"><input type="radio" name="_background-headers2" value="#D590A6" <?= $this->properties['background-headers2'] == '#D590A6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4A667;"><input type="radio" name="_background-headers2" value="#C4A667" <?= $this->properties['background-headers2'] == '#C4A667' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #67C3A6;"><input type="radio" name="_background-headers2" value="#67C3A6" <?= $this->properties['background-headers2'] == '#67C3A6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A667C3;"><input type="radio" name="_background-headers2" value="#A667C3" <?= $this->properties['background-headers2'] == '#A667C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background-headers2" value="#FFFFFF" <?= $this->properties['background-headers2'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de fondo de los avisos</td>
            <td class="center" style="background-color: #000000;"><input type="radio" name="_background-messages" value="#000000" <?= $this->properties['background-messages'] == '#000000' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_background-messages" value="#F9D4D0" <?= $this->properties['background-messages'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_background-messages" value="#B6C4E3" <?= $this->properties['background-messages'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_background-messages" value="#C4E3B6" <?= $this->properties['background-messages'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_background-messages" value="#FEFFDD" <?= $this->properties['background-messages'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_background-messages" value="#E3B6C3" <?= $this->properties['background-messages'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_background-messages" value="#EEE6D5" <?= $this->properties['background-messages'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_background-messages" value="#D4EEE6" <?= $this->properties['background-messages'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_background-messages" value="#E6D4EE" <?= $this->properties['background-messages'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background-messages" value="#FFFFFF" <?= $this->properties['background-messages'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de las letras en la parte superior</td>
            <td class="center" style="background-color: #E2E2E2;"><input type="radio" name="_color-headers" value="#E2E2E2" <?= $this->properties['color-headers'] == '#E2E2E2' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_color-headers" value="#F9D4D0" <?= $this->properties['color-headers'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_color-headers" value="#B6C4E3" <?= $this->properties['color-headers'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_color-headers" value="#C4E3B6" <?= $this->properties['color-headers'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_color-headers" value="#FEFFDD" <?= $this->properties['color-headers'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_color-headers" value="#E3B6C3" <?= $this->properties['color-headers'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_color-headers" value="#EEE6D5" <?= $this->properties['color-headers'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_color-headers" value="#D4EEE6" <?= $this->properties['color-headers'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_color-headers" value="#E6D4EE" <?= $this->properties['color-headers'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_color-headers" value="#FFFFFF" <?= $this->properties['color-headers'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de los bordes</td>
            <td class="center" style="background-color: #E2E2E2;"><input type="radio" name="_color-borders" value="#E2E2E2" <?= $this->properties['color-borders'] == '#E2E2E2' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_color-borders" value="#F9D4D0" <?= $this->properties['color-borders'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_color-borders" value="#B6C4E3" <?= $this->properties['color-borders'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_color-borders" value="#C4E3B6" <?= $this->properties['color-borders'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_color-borders" value="#FEFFDD" <?= $this->properties['color-borders'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_color-borders" value="#E3B6C3" <?= $this->properties['color-borders'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_color-borders" value="#EEE6D5" <?= $this->properties['color-borders'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_color-borders" value="#D4EEE6" <?= $this->properties['color-borders'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_color-borders" value="#E6D4EE" <?= $this->properties['color-borders'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_color-borders" value="#FFFFFF" <?= $this->properties['color-borders'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de las letras</td>
            <td class="center" style="background-color: #333333;"><input type="radio" name="_color-letters" value="#333333" <?= $this->properties['color-letters'] == '#333333' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #8A1C0F;"><input type="radio" name="_color-letters" value="#8A1C0F" <?= $this->properties['color-letters'] == '#8A1C0F' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3B5998;"><input type="radio" name="_color-letters" value="#3B5998" <?= $this->properties['color-letters'] == '#3B5998' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3A984B;"><input type="radio" name="_color-letters" value="#3A984B" <?= $this->properties['color-letters'] == '#3A984B' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A6AA00;"><input type="radio" name="_color-letters" value="#A6AA00" <?= $this->properties['color-letters'] == '#A6AA00' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #983A87;"><input type="radio" name="_color-letters" value="#983A87" <?= $this->properties['color-letters'] == '#983A87' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #695428;"><input type="radio" name="_color-letters" value="#695428" <?= $this->properties['color-letters'] == '#695428' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #296754;"><input type="radio" name="_color-letters" value="#296754" <?= $this->properties['color-letters'] == '#296754' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #542967;"><input type="radio" name="_color-letters" value="#542967" <?= $this->properties['color-letters'] == '#542967' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_color-letters" value="#FFFFFF" <?= $this->properties['color-letters'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
    </table>
    <input type="submit" value="Cambiar esquema de colores" />
</form>
