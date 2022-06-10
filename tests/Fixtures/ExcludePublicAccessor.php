<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\AccessType;
use Signnow\Serializer\Annotation\Exclude;
use Signnow\Serializer\Annotation\ReadOnlyProperty;

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
