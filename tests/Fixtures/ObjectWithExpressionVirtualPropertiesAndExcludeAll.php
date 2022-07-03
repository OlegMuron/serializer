<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\ExclusionPolicy;
use SignNow\Serializer\Annotation\VirtualProperty;

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
