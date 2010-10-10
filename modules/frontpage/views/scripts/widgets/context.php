<?php $spaces = $this->context('asdf', TRUE); ?>

<?php foreach ($spaces as $space) { ?>
    <br />[<a><?= $this->recipient($space) ?></a>]
<?php } ?>
<br />
