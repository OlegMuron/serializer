<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;
use Signnow\Serializer\Annotation\Type;

/** @Serializer\AccessorOrder("alphabetical") */
class InlineParent
{
    /**
     * @Type("string")
     */
    private $c = 'c';

    /**
     * @Type("string")
     */
    private $d = 'd';

    /**
     * @Serializer\Inline
     */
    private $child;

    public function __construct($child = null)
    {
        $this->child = $child ?: new InlineChild();
    }
}
