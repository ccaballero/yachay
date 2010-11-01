<?php

echo $this->doctype();
echo '<html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
echo '<title>' . $this->title->toString() . '</title>';
echo '</head><body>';
echo renderToolbar($this->toolbar);
echo renderMenubar($this->menubar);
echo '<br/><hr/><table width="100%" cellspacing="10"><tr><td valign="top" width="15%">';
echo renderWidget($this->widgets[1]);
echo !empty($this->widgets[1]) ? '<hr />' : '';
echo renderWidget($this->widgets[3]);
echo !empty($this->widgets[3]) ? '<hr />' : '';
echo '</td><td valign="top">';
echo renderBreadcrumb($this->breadcrumb);
echo renderMessage();
echo $this->layout()->content;
echo '</td><td valign="top" width="15%">';
echo renderWidget($this->widgets[2]);
echo !empty($this->widgets[2]) ? '<hr />' : '';
echo renderWidget($this->widgets[4]);
echo !empty($this->widgets[4]) ? '<hr />' : '';
echo '</td></tr></table><hr /><center>';
echo renderFooter($this->footer);
echo '</center></body></html>';

function renderToolbar($toolbar) {
    return '<table align="right"><tr><td>[' . implode(']</td><td>[', $toolbar->items) . ']</td></tr></table>';
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
        return "$title{$widget['content']}";
    } else {
        return '';
    }
}
