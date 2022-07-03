<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\ExclusionPolicy;
use SignNow\Serializer\Annotation\VirtualProperty;

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
