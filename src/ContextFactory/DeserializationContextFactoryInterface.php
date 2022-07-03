<?php

namespace SignNow\Serializer\ContextFactory;

use SignNow\Serializer\DeserializationContext;

/**
 * Deserialization Context Factory Interface.
 */
interface DeserializationContextFactoryInterface
{
    /**
     * @return DeserializationContext
     */
    public function createDeserializationContext();
}
