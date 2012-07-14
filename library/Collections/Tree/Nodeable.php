<?php

interface Collections_Tree_Nodeable
{
    public function ident();
    public function parent();
    public function children();
    public function add(Collections_Tree_Nodeable $child);
    public function remove($ident);
}
