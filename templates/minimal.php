<?php 

    global $TITLE;
    global $TOOLBAR;
    global $SEARCH;
    global $MENUBAR;
    global $BREADCRUMB;
    global $WIDGETS;
    global $FOOTER;
    
    function renderToolbar($toolbar) {
        $session = new Zend_Session_Namespace();
        return '<table align="right"><tr><td>' . implode('</td><td>', $toolbar->items) . '</td></tr></table>';
    }
    
    function renderSearch($search) {
        return '<table><tr><td><form method="' . $search->method . '" action="' . 
                $search->action . '">' . $search->search . '</form></td></tr></table>';
    }
    
    function renderMenubar($menubar) {
        $menu = array();
        foreach($menubar->items as $item) {
            $menu[] = '<a href="' . $item['link'] . '">[' . $item['label'] . ']</a>';
        }
        return '<table align="left"><tr><td>' . implode('</td><td>', $menu) . '</td></tr></table>';
    }

    function renderMessage() {
        $session = new Zend_Session_Namespace();
        $messages = $session->messages->getMessages();
        $ret = implode('<br />', $messages);

        $utf = new Yeah_Helpers_Utf2html;
        $ret = $utf->utf2html($ret);

        $session->messages->clean();
        return "<center>$ret</center>";
    }

    function renderBreadcrumb($breadcrumb) {
        $bread = array();
        foreach($breadcrumb->items as $item) {
            $bread[] = '<a href="' . $item['link'] . '">[' . $item['label'] . ']</a>';
        }
        $ret = implode('&nbsp;::', $bread);
        if (!empty($ret)) {
            return '::' . $ret;
        }
    }
    
    function renderFooter($footer) {
        $foot = array();
        foreach($footer->items as $item) {
            $foot[] = '<a href="' . $item['link'] . '">[' . $item['label'] . ']</a>';
        }
        return '<center>' . implode('&nbsp;', $foot) . '<br/>' . $footer->copyright . '</center>';
    }

    function renderWidget($widget) {
        if (!empty($widget)) {
            $title = '';
            if (!empty($widget['title'])) {
                $title = "[{$widget['title']}]";
            }
            return "$title {$widget['content']}";
        } else {
            return '';
        }
    }
?>

<html>
    <head>
        <!-- REGION: icon --><!-- END REGION -->
        <!-- REGION: title -->
        <title><?= $TITLE->toString() ?></title>
        <!-- END REGION -->
    </head>
    <body>
        <!-- REGION: toolbar -->
            <?= renderToolbar($TOOLBAR) ?><!-- END REGION -->
        <!-- REGION: search -->
            <?= renderSearch($SEARCH) ?><!-- END REGION -->
        <!-- REGION: primary -->
            <?= renderMenubar($MENUBAR) ?><!-- END REGION -->
        <!-- REGION: banner --><!-- END REGION -->
        <!-- REGION: secondary --><!-- END REGION -->
        <br/>
        <hr/>
        <table width="100%">
            <tr>
                <td valign="top" width="20%">
                    <!-- REGION: widget 1 -->
                       <?= renderWidget($WIDGETS[1]) ?><!-- END REGION -->
                    <br />
                    <!-- REGION: widget 2 -->
                       <?= renderWidget($WIDGETS[3]) ?><!-- END REGION -->
                </td>
                <td valign="top">
                    <!-- REGION: breadcrumb -->
                       <?= renderBreadcrumb($BREADCRUMB) ?><!-- END REGION -->
                    <!-- REGION: message -->
                       <?= renderMessage() ?><!-- END REGION -->
                    <!-- REGION: content -->
                       <?= $this->layout()->content ?><!-- END REGION -->
                </td>
                <td valign="top" width="20%">
                    <!-- REGION: widget 3 -->
                       <?= renderWidget($WIDGETS[2]) ?><!-- END REGION -->
                    <br />
                    <!-- REGION: widget 4 -->
                       <?= renderWidget($WIDGETS[4]) ?><!-- END REGION -->
                </td>
            </tr>
        </table>
        <hr />
        <center>
            <!-- REGION: footer -->
                <?= renderFooter($FOOTER) ?><!-- END REGION -->
        </center>
    </body>
</html>
