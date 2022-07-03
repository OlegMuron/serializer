<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;

class ParentSkipWithEmptyChild
{
    private $c = 'c';

    private $d = 'd';

    /**
     * @Serializer\SkipWhenEmpty()
     * @var InlineChild
     */
    private $child;

    public function __construct($child = null)
    {
        $this->child = $child ?: new InlineChild();
    }
}
