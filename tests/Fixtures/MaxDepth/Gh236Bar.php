<?php

namespace SignNow\Serializer\Tests\Fixtures\MaxDepth;

use SignNow\Serializer\Annotation as Serializer;

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
