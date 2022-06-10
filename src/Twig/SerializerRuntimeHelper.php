<?php

namespace Signnow\Serializer\Twig;

use Signnow\Serializer\SerializationContext;
use Signnow\Serializer\SerializerInterface;

/**
 * @author Asmir Mustafic <goetas@gmail.com>
 */
final class SerializerRuntimeHelper
{
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $object
     * @param string $type
     * @param SerializationContext|null $context
     * @return string
     */
    public function serialize($object, $type = 'json', SerializationContext $context = null)
    {
        return $this->serializer->serialize($object, $type, $context);
    }
}
