<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Signnow\Serializer\Annotation\Groups;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlAttribute;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlMap;
use Signnow\Serializer\Annotation\XmlNamespace;
use Signnow\Serializer\Annotation\XmlRoot;
use PhpCollection\Map;
use PhpCollection\Sequence;

/**
 * @XmlRoot("blog-post")
 * @XmlNamespace(uri="http://example.com/namespace")
 * @XmlNamespace(uri="http://schemas.google.com/g/2005", prefix="gd")
 * @XmlNamespace(uri="http://www.w3.org/2005/Atom", prefix="atom")
 * @XmlNamespace(uri="http://purl.org/dc/elements/1.1/", prefix="dc")
 */
class BlogPost
{
    /**
     * @Type("string")
     * @XmlElement(cdata=false)
     * @Groups({"comments","post"})
     */
    private $id = 'what_a_nice_id';

    /**
     * @Type("string")
     * @Groups({"comments","post"})
     * @XmlElement(namespace="http://purl.org/dc/elements/1.1/");
     */
    private $title;

    /**
     * @Type("DateTime")
     * @XmlAttribute
     */
    private $createdAt;

    /**
     * @Type("boolean")
     * @SerializedName("is_published")
     * @XmlAttribute
     * @Groups({"post"})
     */
    private $published;

    /**
     * @Type("bool")
     * @SerializedName("is_reviewed")
     * @XmlAttribute
     * @Groups({"post"})
     */
    private $reviewed;

    /**
     * @Type("string")
     * @XmlAttribute(namespace="http://schemas.google.com/g/2005")
     * @Groups({"post"})
     */
    private $etag;

    /**
     * @Type("ArrayCollection<Signnow\Serializer\Tests\Fixtures\Comment>")
     * @XmlList(inline=true, entry="comment")
     * @Groups({"comments"})
     */
    private $comments;

    /**
     * @Type("PhpCollection\Sequence<Signnow\Serializer\Tests\Fixtures\Comment>")
     * @XmlList(inline=true, entry="comment2")
     * @Groups({"comments"})
     */
    private $comments2;

    /**
     * @Type("PhpCollection\Map<string,string>")
     * @XmlMap(keyAttribute = "key")
     */
    private $metadata;

    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\Author")
     * @Groups({"post"})
     * @XmlElement(namespace="http://www.w3.org/2005/Atom")
     */
    private $author;

    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\Publisher")
     */
    private $publisher;

    /**
     * @Type("array<Signnow\Serializer\Tests\Fixtures\Tag>")
     * @XmlList(inline=true, entry="tag", namespace="http://purl.org/dc/elements/1.1/");
     */
    private $tag;

    public function __construct($title, Author $author, \DateTime $createdAt, Publisher $publisher)
    {
        $this->title = $title;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->published = false;
        $this->reviewed = false;
        $this->comments = new ArrayCollection();
        $this->comments2 = new Sequence();
        $this->metadata = new Map();
        $this->metadata->set('foo', 'bar');
        $this->createdAt = $createdAt;
        $this->etag = sha1($this->createdAt->format(\DateTime::ISO8601));
    }

    public function setPublished()
    {
        $this->published = true;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        $this->comments2->add($comment);
    }

    public function addTag(Tag $tag)
    {
        $this->tag[] = $tag;
    }
}
