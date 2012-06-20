<div>
<?php if ($this->acl('packages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'packages_list') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'packages_new') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
</div>