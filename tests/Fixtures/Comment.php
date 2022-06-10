<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class Comment
{
    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\Author")
     */
    private $author;

    /**
     * @Type("string")
     */
    private $text;

    public function __construct(Author $author = null, $text)
    {
        $this->author = $author;
        $this->text = $text;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}
