<!doctype html><?php global $TITLE, $TOOLBAR, $SEARCH, $MENUBAR, $BREADCRUMB, $WIDGETS, $FOOTER; ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title><?= $TITLE->toString() ?></title>
    </head>
    <body>
        <?= renderToolbar($TOOLBAR) ?>
        <?= renderSearch($SEARCH) ?>
        <?= renderMenubar($MENUBAR) ?>
        <br/><hr/>
        <table width="100%" cellspacing="10">
            <tr>
                <td valign="top" width="15%">
                    <?= renderWidget($WIDGETS[1]) ?>
                    <?= !empty($WIDGETS[1]) ? '<hr />' : '' ?>
                    <?= renderWidget($WIDGETS[3]) ?>
                    <?= !empty($WIDGETS[3]) ? '<hr />' : '' ?>
                </td>
                <td valign="top">
                    <?= renderBreadcrumb($BREADCRUMB) ?>
                    <?= renderMessage() ?>
                    <?= $this->layout()->content ?>
                </td>
                <td valign="top" width="15%">
                    <?= renderWidget($WIDGETS[2]) ?>
                    <?= !empty($WIDGETS[2]) ? '<hr />' : '' ?>
                    <?= renderWidget($WIDGETS[4]) ?>
                    <?= !empty($WIDGETS[4]) ? '<hr />' : '' ?>
                </td>
            </tr>
        </table>
        <hr />
        <center><?= renderFooter($FOOTER) ?></center>
    </body>
</html>

<?php
    function renderToolbar($toolbar) {
        $session = new Zend_Session_Namespace();
        return '<table align="right"><tr><td>' . implode('</td><td>', $toolbar->items) . '</td></tr></table>';
    }

    function renderSearch($search) {
        return;
        /*return '<table><tr><td><form method="' . $search->method . '" action="' .
                $search->action . '">' . $search->search . '</form></td></tr></table>';*/
    }

    function renderMenubar($menubar) {
        $menu = array();
        foreach($menubar->items as $item) {
            $menu[] = '[<a href="' . $item['link'] . '">' . $item['label'] . '</a>]';
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
            $bread[] = '[<a href="' . $item['link'] . '">' . $item['label'] . '</a>]';
        }
        $ret = implode('&nbsp;::', $bread);
        if (!empty($ret)) {
            return '::' . $ret;
        }
    }

    function renderFooter($footer) {
        $foot = array();
        foreach($footer->items as $item) {
            $foot[] = '[<a href="' . $item['link'] . '">' . $item['label'] . '</a>]';
        }
        return '<center>' . implode('&nbsp;', $foot) . (count($foot) == 0 ? '':'<br />') . $footer->copyright . '</center>';
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
