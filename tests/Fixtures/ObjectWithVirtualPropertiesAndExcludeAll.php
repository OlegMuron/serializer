<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\ExclusionPolicy;
use Signnow\Serializer\Annotation\VirtualProperty;

/**
 * @ExclusionPolicy("all")
 */
class ObjectWithVirtualPropertiesAndExcludeAll
{
    /**
     * @VirtualProperty
     */
    public function getVirtualValue()
    {
        return 'value';
    }
}
