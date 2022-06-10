<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Exclude;
use Signnow\Serializer\Annotation\PostDeserialize;
use Signnow\Serializer\Annotation\PostSerialize;
use Signnow\Serializer\Annotation\PreSerialize;
use Signnow\Serializer\Annotation\Type;

class ObjectWithLifecycleCallbacks
{
    /**
     * @Exclude
     */
    private $firstname;

    /**
     * @Exclude
     */
    private $lastname;

    /**
     * @Type("string")
     */
    private $name;

    public function __construct($firstname = 'Foo', $lastname = 'Bar')
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    /**
     * @PreSerialize
     */
    private function prepareForSerialization()
    {
        $this->name = $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @PostSerialize
     */
    private function cleanUpAfterSerialization()
    {
        $this->name = null;
    }

    /**
     * @PostDeserialize
     */
    private function afterDeserialization()
    {
        list($this->firstname, $this->lastname) = explode(' ', $this->name);
        $this->name = null;
    }
}
