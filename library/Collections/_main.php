<?php

include ('Tree.php');
include ('Tree/Structurable.php');
include ('Tree/Node.php');
include ('Tree/Node/Default.php');

$_list = array(
    array('b', '9'),
    array('4', '1'),
    array('a', '8'),
    array('7', '5'),
    array('3', null),
    
    array('6', '2'),
    array('5', '2'),
    array('8', '7'),
    array('1', null),
    array('9', '5'),
    
    array('0', '4'),
    array('2', null),
);

$tree = new Structures_Tree();
foreach ($_list as $elements) {
    $node = new Structures_Tree_Node_Default($elements[0], $elements[1]);
    $tree->addNode($node);
}

$tree->indexAll();

foreach ($tree as $node) {
    echo str_repeat('---> ', $node['level']) . $node['node']->ident . ',' . $node['node']->parent . PHP_EOL;
}
echo 'Orphans: ' . count($tree->getOrphans());

echo PHP_EOL;
