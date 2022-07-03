<?php

namespace SignNow\Serializer\Construction;

use Doctrine\Instantiator\Instantiator;
use SignNow\Serializer\DeserializationContext;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\VisitorInterface;

class UnserializeObjectConstructor implements ObjectConstructorInterface
{
    /** @var Instantiator */
    private $instantiator;

    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type, DeserializationContext $context)
    {
        return $this->getInstantiator()->instantiate($metadata->name);
    }

    /**
     * @return Instantiator
     */
    private function getInstantiator()
    {
        if (null == $this->instantiator) {
            $this->instantiator = new Instantiator();
        }

        return $this->instantiator;
    }
}
