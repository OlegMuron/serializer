<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;
/**
 * @Serializer\Exclude("NONE")
 */
class SimpleInternalObject extends \Exception
{
    private $bar;

    protected $camelCase = 'boo';

    public function __construct($foo, $bar)
    {
        parent::__construct($foo);
        $this->bar = $bar;
    }
}
