<?php

namespace SignNow\Serializer\EventDispatcher;

use SignNow\Serializer\Context;

class ObjectEvent extends Event
{
    private $object;

    public function __construct(Context $context, $object, array $type)
    {
        parent::__construct($context, $type);

        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;
    }
}
