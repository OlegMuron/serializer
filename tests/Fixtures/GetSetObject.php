<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\AccessType;
use SignNow\Serializer\Annotation\Exclude;
use SignNow\Serializer\Annotation\ReadOnlyProperty;
use SignNow\Serializer\Annotation\Type;

/** @AccessType("public_method") */
class GetSetObject
{
    /** @AccessType("property") @Type("integer") */
    private $id = 1;

    /** @Type("string") */
    private $name = 'Foo';

    /**
     * @ReadOnlyProperty
     */
    private $readOnlyProperty = 42;

    /**
     * This property should be exlcluded
     * @Exclude()
     */
    private $excludedProperty;

    public function getId()
    {
        throw new \RuntimeException('This should not be called.');
    }

    public function getName()
    {
        return 'Johannes';
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getReadOnlyProperty()
    {
        return $this->readOnlyProperty;
    }
}
