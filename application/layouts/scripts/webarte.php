<?php echo $this->doctype() ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Language" content="es-BO" />
        <link href="<?php echo $this->TEMPLATE->htmlbase . 'css/style.css' ?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->CONFIG->wwwroot . 'templates/css/properties.css' ?>" media="screen" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/x-icon" href="<?php echo $this->CONFIG->media_base ?>favicon.jpg" />
        <title><?php echo $this->TITLE->toString() ?></title>
    </head>
    <body>
        <div id="header">
            <div class="tools">
                <?php echo $this->render('webarte/toolbar.php'); ?>
            </div>
            <div class="menu">
                <?php echo $this->render('webarte/menubar.php'); ?>
            </div>
        </div>
        <div id="content">
            <div id="primary">
                <?php echo $this->render('webarte/breadcrumb.php') ?>
                <?php echo $this->render('webarte/messages.php') ?>
                <div id="main">
                    <?php echo $this->layout()->content ?>
                </div>
            </div>
            <div id="secondary">
                <?php echo $this->render('webarte/widgets.php') ?>
            </div>
        </div>
        <div id="footer">
            <?php echo $this->render('webarte/footer.php'); ?>
        </div>
    </body>
</html>
