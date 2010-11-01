<?= $this->doctype() ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Language" content="es-BO" />
        <?= $this->headLink()->appendStylesheet($this->theme->htmlbase . 'css/style.css'); ?>
        <link rel="icon" type="image/x-icon" href="<?= $this->config->media_base . '../' ?>/favicon.ico" />
        <title><?= $this->title->toString() ?></title>
    </head>
    <body>
        <div id="header">
            <div class="tools">
                <?= $this->render('webarte/toolbar.php'); ?>
            </div>
            <div class="menu">
                <?= $this->render('webarte/menubar.php'); ?>
            </div>
        </div>
        <div id="content">
            <div id="primary">
                <?= $this->layout()->content ?>
            </div>
            <div id="widgets">
                <?= $this->render('webarte/widgets.php') ?>
            </div>
        </div>
        <div id="footer">
            <?= $this->render('webarte/footer.php'); ?>
        </div>
    </body>
</html>
