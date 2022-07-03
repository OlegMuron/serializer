<?php

namespace SignNow\Serializer\Accessor;

use SignNow\Serializer\Metadata\PropertyMetadata;

/**
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class DefaultAccessorStrategy implements AccessorStrategyInterface
{

    public function getValue($object, PropertyMetadata $metadata)
    {
        return $metadata->getValue($object);
    }

    public function setValue($object, $value, PropertyMetadata $metadata)
    {
        $metadata->setValue($object, $value);
    }
}
