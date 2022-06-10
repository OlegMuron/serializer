<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class ObjectWithNullProperty extends SimpleObject
{
    /**
     * @var null
     * @Type("string")
     */
    private $nullProperty = null;

    /**
     * @return null
     */
    public function getNullProperty()
    {
        return $this->nullProperty;
    }
}
