<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Accessor;
use SignNow\Serializer\Annotation\ReadOnlyProperty;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("author")
 * @ReadOnlyProperty
 */
class AuthorReadOnlyPerClass
{
    /**
     * @ReadOnlyProperty
     * @SerializedName("id")
     */
    private $id;

    /**
     * @Type("string")
     * @SerializedName("full_name")
     * @Accessor("getName")
     * @ReadOnlyProperty(false)
     */
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
