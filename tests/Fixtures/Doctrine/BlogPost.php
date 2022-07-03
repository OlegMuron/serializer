<?php

namespace SignNow\Serializer\Tests\Fixtures\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SignNow\Serializer\Annotation as Serializer;
use SignNow\Serializer\Annotation\Groups;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlAttribute;
use SignNow\Serializer\Annotation\XmlList;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @ORM\Entity
 * @XmlRoot("blog-post")
 */
class BlogPost
{
    /**
     * @ORM\Id @ORM\Column(type="guid") @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"comments","post"})
     */
    private $title;

    /**
     * @ORM\Column(type="some_custom_type")
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime")
     * @XmlAttribute
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Type("integer")
     * This boolean to integer conversion is one of the few changes between this
     * and the standard BlogPost class. It's used to test the override behavior
     * of the DoctrineTypeDriver so notice it, but please don't change it.
     *
     * @SerializedName("is_published")
     * @Groups({"post"})
     * @XmlAttribute
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blogPost")
     * @XmlList(inline=true, entry="comment")
     * @Groups({"comments"})
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity="Author")
     * @Groups({"post"})
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Exclude()
     */
    private $ref;

    public function __construct($title, Author $author, \DateTime $createdAt)
    {
        $this->title = $title;
        $this->author = $author;
        $this->published = false;
        $this->comments = new ArrayCollection();
        $this->createdAt = $createdAt;
    }

    public function setPublished()
    {
        $this->published = true;
    }

    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getRef()
    {
        return $this->ref;
    }
}
