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
            <td>Color de fondo</td>
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
            <td class="center" style="background-color: #3C3C3C;"><input type="radio" name="_background_headers" value="#3C3C3C" <?= $this->properties['background_headers'] == '#3C3C3C' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #9A3A3A;"><input type="radio" name="_background_headers" value="#9A3A3A" <?= $this->properties['background_headers'] == '#9A3A3A' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3B5998;"><input type="radio" name="_background_headers" value="#3B5998" <?= $this->properties['background_headers'] == '#3B5998' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #33A332;"><input type="radio" name="_background_headers" value="#33A332" <?= $this->properties['background_headers'] == '#33A332' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #988E3D;"><input type="radio" name="_background_headers" value="#988E3D" <?= $this->properties['background_headers'] == '#988E3D' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #9D3780;"><input type="radio" name="_background_headers" value="#9D3780" <?= $this->properties['background_headers'] == '#9D3780' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #9D6A37;"><input type="radio" name="_background_headers" value="#9D6A37" <?= $this->properties['background_headers'] == '#9D6A37' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3D8698;"><input type="radio" name="_background_headers" value="#3D8698" <?= $this->properties['background_headers'] == '#3D8698' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #41379D;"><input type="radio" name="_background_headers" value="#41379D" <?= $this->properties['background_headers'] == '#41379D' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background_headers" value="#FFFFFF" <?= $this->properties['background_headers'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Segundo color de fondo en la parte superior</td>
            <td class="center" style="background-color: #555555;"><input type="radio" name="_background_headers2" value="#555555" <?= $this->properties['background_headers2'] == '#555555' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #AC6464;"><input type="radio" name="_background_headers2" value="#AC6464" <?= $this->properties['background_headers2'] == '#AC6464' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #627AAD;"><input type="radio" name="_background_headers2" value="#627AAD" <?= $this->properties['background_headers2'] == '#627AAD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #5AB65A;"><input type="radio" name="_background_headers2" value="#5AB65A" <?= $this->properties['background_headers2'] == '#5AB65A' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B4B35C;"><input type="radio" name="_background_headers2" value="#B4B35C" <?= $this->properties['background_headers2'] == '#B4B35C' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B15F99;"><input type="radio" name="_background_headers2" value="#B15F99" <?= $this->properties['background_headers2'] == '#B15F99' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #AF8F61;"><input type="radio" name="_background_headers2" value="#AF8F61" <?= $this->properties['background_headers2'] == '#AF8F61' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #5F99B1;"><input type="radio" name="_background_headers2" value="#5F99B1" <?= $this->properties['background_headers2'] == '#5F99B1' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #6258B8;"><input type="radio" name="_background_headers2" value="#6258B8" <?= $this->properties['background_headers2'] == '#6258B8' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #DDDDDD;"><input type="radio" name="_background_headers2" value="#DDDDDD" <?= $this->properties['background_headers2'] == '#DDDDDD' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de fondo de los avisos</td>
            <td class="center" style="background-color: #000000;"><input type="radio" name="_background_messages" value="#000000" <?= $this->properties['background_messages'] == '#000000' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_background_messages" value="#F9D4D0" <?= $this->properties['background_messages'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_background_messages" value="#B6C4E3" <?= $this->properties['background_messages'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_background_messages" value="#C4E3B6" <?= $this->properties['background_messages'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_background_messages" value="#FEFFDD" <?= $this->properties['background_messages'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_background_messages" value="#E3B6C3" <?= $this->properties['background_messages'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_background_messages" value="#EEE6D5" <?= $this->properties['background_messages'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_background_messages" value="#D4EEE6" <?= $this->properties['background_messages'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_background_messages" value="#E6D4EE" <?= $this->properties['background_messages'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_background_messages" value="#FFFFFF" <?= $this->properties['background_messages'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de las letras en la parte superior</td>
            <td class="center" style="background-color: #666666;"><input type="radio" name="_color_headers" value="#666666" <?= $this->properties['color_headers'] == '#666666' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_color_headers" value="#F9D4D0" <?= $this->properties['color_headers'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_color_headers" value="#B6C4E3" <?= $this->properties['color_headers'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_color_headers" value="#C4E3B6" <?= $this->properties['color_headers'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_color_headers" value="#FEFFDD" <?= $this->properties['color_headers'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_color_headers" value="#E3B6C3" <?= $this->properties['color_headers'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_color_headers" value="#EEE6D5" <?= $this->properties['color_headers'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_color_headers" value="#D4EEE6" <?= $this->properties['color_headers'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_color_headers" value="#E6D4EE" <?= $this->properties['color_headers'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_color_headers" value="#FFFFFF" <?= $this->properties['color_headers'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de los bordes</td>
            <td class="center" style="background-color: #E2E2E2;"><input type="radio" name="_color_borders" value="#E2E2E2" <?= $this->properties['color_borders'] == '#E2E2E2' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #F9D4D0;"><input type="radio" name="_color_borders" value="#F9D4D0" <?= $this->properties['color_borders'] == '#F9D4D0' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #B6C4E3;"><input type="radio" name="_color_borders" value="#B6C4E3" <?= $this->properties['color_borders'] == '#B6C4E3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #C4E3B6;"><input type="radio" name="_color_borders" value="#C4E3B6" <?= $this->properties['color_borders'] == '#C4E3B6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FEFFDD;"><input type="radio" name="_color_borders" value="#FEFFDD" <?= $this->properties['color_borders'] == '#FEFFDD' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E3B6C3;"><input type="radio" name="_color_borders" value="#E3B6C3" <?= $this->properties['color_borders'] == '#E3B6C3' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #EEE6D5;"><input type="radio" name="_color_borders" value="#EEE6D5" <?= $this->properties['color_borders'] == '#EEE6D5' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #D4EEE6;"><input type="radio" name="_color_borders" value="#D4EEE6" <?= $this->properties['color_borders'] == '#D4EEE6' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #E6D4EE;"><input type="radio" name="_color_borders" value="#E6D4EE" <?= $this->properties['color_borders'] == '#E6D4EE' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #666666;"><input type="radio" name="_color_borders" value="#666666" <?= $this->properties['color_borders'] == '#666666' ? 'checked="checked"':'' ?>/></td>
        </tr>
        <tr>
            <td>Color de las letras</td>
            <td class="center" style="background-color: #333333;"><input type="radio" name="_color_letters" value="#333333" <?= $this->properties['color_letters'] == '#333333' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #8A1C0F;"><input type="radio" name="_color_letters" value="#8A1C0F" <?= $this->properties['color_letters'] == '#8A1C0F' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3B5998;"><input type="radio" name="_color_letters" value="#3B5998" <?= $this->properties['color_letters'] == '#3B5998' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #3A984B;"><input type="radio" name="_color_letters" value="#3A984B" <?= $this->properties['color_letters'] == '#3A984B' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #A6AA00;"><input type="radio" name="_color_letters" value="#A6AA00" <?= $this->properties['color_letters'] == '#A6AA00' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #983A87;"><input type="radio" name="_color_letters" value="#983A87" <?= $this->properties['color_letters'] == '#983A87' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #695428;"><input type="radio" name="_color_letters" value="#695428" <?= $this->properties['color_letters'] == '#695428' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #296754;"><input type="radio" name="_color_letters" value="#296754" <?= $this->properties['color_letters'] == '#296754' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #542967;"><input type="radio" name="_color_letters" value="#542967" <?= $this->properties['color_letters'] == '#542967' ? 'checked="checked"':'' ?>/></td>
            <td class="center" style="background-color: #FFFFFF;"><input type="radio" name="_color_letters" value="#FFFFFF" <?= $this->properties['color_letters'] == '#FFFFFF' ? 'checked="checked"':'' ?>/></td>
        </tr>
    </table>
    <input type="submit" value="Cambiar esquema de colores" />
</form>
