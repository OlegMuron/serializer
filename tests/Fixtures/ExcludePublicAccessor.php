<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\AccessType;
use SignNow\Serializer\Annotation\Exclude;
use SignNow\Serializer\Annotation\ReadOnlyProperty;

/**
 */

/**
 * @AccessType("public_method")
 * @ReadOnlyProperty
 */
class ExcludePublicAccessor
{
    /**
     * @Exclude
     *
     * @var mixed
     */
    private $iShallNotBeAccessed;

    /**
     * @var int
     */
    private $id = 1;

    public function getId()
    {
        return $this->id;
    }
}
