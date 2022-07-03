<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Exclude;
use SignNow\Serializer\Annotation\PostDeserialize;
use SignNow\Serializer\Annotation\PostSerialize;
use SignNow\Serializer\Annotation\PreSerialize;
use SignNow\Serializer\Annotation\Type;

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
