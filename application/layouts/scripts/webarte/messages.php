<?php $session = new Zend_Session_Namespace(); $messages = $session->messages->getMessages(); ?>
<div id="messages">
<?php foreach ($messages as $message) { ?>
    <span class="message"><?php echo $message ?></span>
<?php } ?>
</div>
<?php $session->messages->clean(); ?>
