<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\HandlerCallback;
use SignNow\Serializer\Annotation\Type;

class ObjectWithHandlerCallbacks
{
    /**
     * @Type("string")
     */
    public $name;

    /**
     * @HandlerCallback(direction="serialization", format="json")
     */
    public function toJson()
    {
        return $this->name;
    }

    /**
     * @HandlerCallback(direction="serialization", format="xml")
     */
    public function toXml()
    {
        return $this->name;
    }
}
