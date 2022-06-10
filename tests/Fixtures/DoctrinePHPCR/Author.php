<?php

namespace Signnow\Serializer\Tests\Fixtures\DoctrinePHPCR;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Signnow\Serializer\Annotation\SerializedName;

/** @PHPCRODM\Document */
class Author
{
    /**
     * @PHPCRODM\Id()
     */
    protected $id;

    /**
     * @PHPCRODM\Field(type="string")
     * @SerializedName("full_name")
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
