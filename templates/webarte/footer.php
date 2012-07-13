<?php
$count = 0;
$container = array();

foreach ($this->FOOTER->items as $item) {
    $container[(int)($count / 9)][$count % 9] = '<li><a href="' . $item['link'] . '">' . $item['label'] . '</a></li>';
    $count++;
}

foreach ($container as $row) { 
    echo '<ul class="menu">' . implode('', $row) . '</ul>';
}

?>

<span><?php echo $this->FOOTER->copyright ?></span>
