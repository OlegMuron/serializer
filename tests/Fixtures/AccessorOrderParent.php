<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;

/** @Serializer\AccessorOrder("alphabetical") */
class AccessorOrderParent
{
    private $b = 'b', $a = 'a';
}
