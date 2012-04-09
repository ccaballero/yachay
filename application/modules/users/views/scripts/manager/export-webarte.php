<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="export_extension">Formato de archivo (*): </label><select id="export_extension" name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></p>
    <p><label>Atributos que desea exportar: </label>&nbsp;</p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="code" /></span> <span class="form"><?php echo $this->model_users->_mapping['code'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="formalname" /></span> <span class="form"><?php echo $this->model_users->_mapping['formalname'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="role" /></span> <span class="form"><?php echo $this->model_users->_mapping['role'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="label" /></span> <span class="form"><?php echo $this->model_users->_mapping['label'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="email" /></span> <span class="form"><?php echo $this->model_users->_mapping['email'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="surname" /></span> <span class="form"><?php echo $this->model_users->_mapping['surname'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="name" /></span> <span class="form"><?php echo $this->model_users->_mapping['name'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="career" /></span> <span class="form"><?php echo $this->model_users->_mapping['career'] ?></span></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Exportar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
