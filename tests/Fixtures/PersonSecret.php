<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("NONE")
 * @Serializer\AccessorOrder("custom",custom = {"name", "gender" ,"age"})
 */
class PersonSecret
{
    /**
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\Type("string")
     * @Serializer\Exclude(if="show_data('gender')")
     */
    public $gender;

    /**
     * @Serializer\Type("string")
     * @Serializer\Expose(if="show_data('age')")
     */
    public $age;
}
