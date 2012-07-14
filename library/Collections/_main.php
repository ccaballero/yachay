<?php

include ('Tree/Nodeable.php');
include ('Tree/Node.php');
include ('Tree/Node/Default.php');
include ('Tree.php');

$_list = array(
    array( 1, null),
    array( 2, 1),
    array( 3, 1),
    array( 4, 2),
    array( 5, 2),
    array( 6, 3),
    array( 7, 3),
    array( 8, 4),
    array( 9, 4),
    array(10, 5),
    array(11, 5),
    array(12, 6),
    array(13, 6),
    array(14, 7),
    array(15, 7),
);

$tree = new Collections_Tree();
foreach ($_list as $elements) {
    $node = new Collections_Tree_Node_Default($elements[0], $elements[1]);
    $tree->addNode($node);
}

echo 'TREE VISUALIZATION' . PHP_EOL;

$tree->indexAll();
foreach ($tree as $node) {
    echo str_repeat(' ', $node->level() * 2) . str_pad($node->ident(), 2, ' ', STR_PAD_LEFT) . ' -> ' . $node->parent() . PHP_EOL;
}

echo PHP_EOL . 'PATH EXAMPLE' . PHP_EOL;
foreach (array_reverse($tree->path(11)) as $dir) {
    echo '/' . $dir->ident();
}
echo PHP_EOL;
