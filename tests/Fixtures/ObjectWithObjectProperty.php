<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;


class ObjectWithObjectProperty
{
    /**
     * @Type("string")
     */
    private $foo;

    /**
     * @Type("SignNow\Serializer\Tests\Fixtures\Author")
     */
    private $author;

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @return \SignNow\Serializer\Tests\Fixtures\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }


}
