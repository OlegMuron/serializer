<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\HandlerCallback;
use Signnow\Serializer\Annotation\Type;

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
