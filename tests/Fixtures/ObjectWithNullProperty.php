<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

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
