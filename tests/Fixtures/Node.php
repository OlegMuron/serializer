<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

class Node
{
    /**
     * @Serializer\MaxDepth(2)
     */
    public $children;

    public $foo = 'bar';

    public function __construct($children = array())
    {
        $this->children = $children;
    }
}
