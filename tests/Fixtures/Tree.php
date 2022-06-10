<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

class Tree
{
    /**
     * @Serializer\MaxDepth(10)
     */
    public $tree;

    public function __construct($tree)
    {
        $this->tree = $tree;
    }
}
