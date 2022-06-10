<?php

namespace Signnow\Serializer\ContextFactory;

use Signnow\Serializer\SerializationContext;

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
