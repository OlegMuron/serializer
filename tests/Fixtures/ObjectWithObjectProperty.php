<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;


class ObjectWithObjectProperty
{
    /**
     * @Type("string")
     */
    private $foo;

    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\Author")
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
     * @return \Signnow\Serializer\Tests\Fixtures\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }


}
