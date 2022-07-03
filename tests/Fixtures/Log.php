<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlList;
use SignNow\Serializer\Annotation\XmlMap;
use SignNow\Serializer\Annotation\XmlRoot;

/** @XmlRoot("log") */
class Log
{
    /**
     * @SerializedName("author_list")
     * @XmlMap
     * @Type("AuthorList")
     */
    private $authors;

    /**
     * @XmlList(inline=true, entry = "comment")
     * @Type("array<SignNow\Serializer\Tests\Fixtures\Comment>")
     */
    private $comments;

    public function __construct()
    {
        $this->authors = new AuthorList();
        $this->authors->add(new Author('Johannes Schmitt'));
        $this->authors->add(new Author('John Doe'));

        $author = new Author('Foo Bar');
        $this->comments = array();
        $this->comments[] = new Comment($author, 'foo');
        $this->comments[] = new Comment($author, 'bar');
        $this->comments[] = new Comment($author, 'baz');
    }
}
