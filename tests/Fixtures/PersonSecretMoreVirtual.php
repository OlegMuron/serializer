<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\AccessorOrder("custom",custom = {"name", "gender"})
 */
class PersonSecretMoreVirtual
{
    /**
     * @Serializer\Type("string")
     * @Serializer\Expose()
     */
    public $name;

    public $gender;

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\Type("string")
     * @Serializer\Expose(if="show_data('gender')")
     */
    public function getGender()
    {
        return $this->gender;
    }
}
