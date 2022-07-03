<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\ExclusionPolicy;
use SignNow\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class AllExcludedObject
{
    private $foo = 'foo';

    /**
     * @Expose
     */
    private $bar = 'bar';
}
