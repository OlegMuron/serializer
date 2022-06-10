<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\ExclusionPolicy;
use Signnow\Serializer\Annotation\VirtualProperty;

/**
 * @VirtualProperty(
 *     "virtualValue",
 *     exp="object.getVirtualValue()"
 * )
 * @ExclusionPolicy("all")
 */
class ObjectWithExpressionVirtualPropertiesAndExcludeAll
{

    public function getVirtualValue()
    {
        return 'value';
    }
}
