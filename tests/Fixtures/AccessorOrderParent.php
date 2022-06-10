<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

/** @Serializer\AccessorOrder("alphabetical") */
class AccessorOrderParent
{
    private $b = 'b', $a = 'a';
}
