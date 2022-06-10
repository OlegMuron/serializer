<?php

namespace Signnow\Serializer\Tests\Fixtures\MaxDepth;

use Signnow\Serializer\Annotation as Serializer;

class Gh236Bar
{
    /**
     * @Serializer\Expose()
     */
    public $xxx = 'yyy';

    /**
     * @Serializer\Expose()
     * @Serializer\SkipWhenEmpty()
     */
    public $inner;
}
