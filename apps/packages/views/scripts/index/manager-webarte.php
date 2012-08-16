<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />
    <?php echo $this->partial('index/toolbar-webarte.php') ?>

    <table>
        <tr>
        <?php if ($this->acl('packages', 'lock')) { ?>
            <th>&nbsp;</th>
        <?php } ?>
            <th>Paquete</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Opciones</th>
            <th>Fecha de Registro</th>
        </tr>
    <?php foreach ($this->list as $node) { ?>
        <tr class="<?php echo $this->cycle(array('even', 'odd'))->next() ?>">
        <?php if ($this->acl('packages', 'lock')) { ?>
            <td class="center"><input type="checkbox" name="check[]" value="<?php echo $node->ident ?>" /></td>
        <?php } ?>
            <td><?php echo str_repeat('&nbsp;&nbsp;', $node->level()) . $node->label ?></td>
            <td class="center"><?php echo $node->type ?></td>
            <td class="center">
            <?php if ($node->status == 'active') { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Modulo activo" title="Modulo activo" />
            <?php } else { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Modulo inactivo" title="Modulo inactivo" />
            <?php } ?>
            </td>
            <td class="options">
            <?php if ($this->acl('packages', 'view')) { ?>
                <a href="<?php echo $this->url(array('package' => $node->url), 'packages_package_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->acl('packages', 'lock') && $node->type != 'base') { ?>
                <?php if ($node->status == 'active') { ?>
                <a href="<?php echo $this->url(array('package' => $node->url), 'packages_package_lock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock.png' ?>" alt="Bloquear" title="Bloquear" /></a>
                <?php } else { ?>
                <a href="<?php echo $this->url(array('package' => $node->url), 'packages_package_unlock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock_open.png' ?>" alt="Desbloquear" title="Desbloquear" /></a>
                <?php } ?>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($node->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
    <?php echo $this->partial('index/toolbar-webarte.php') ?>
</form>
