<?php

namespace Signnow\Serializer\Tests\Fixtures\MaxDepth;

use Signnow\Serializer\Annotation as Serializer;

class Gh236Foo
{
    /**
     * @Serializer\MaxDepth(1)
     */
    public $a;

    public function __construct()
    {
        $this->a = new Gh236Bar();
        $this->a->inner = new Gh236Bar();
    }
}
