<?php

namespace SignNow\Serializer\ContextFactory;

use SignNow\Serializer\SerializationContext;

/**
 * Serialization Context Factory Interface.
 */
interface SerializationContextFactoryInterface
{
    /**
     * @return SerializationContext
     */
    public function createSerializationContext();
}
