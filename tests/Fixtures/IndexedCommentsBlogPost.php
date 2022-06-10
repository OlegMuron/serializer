<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Accessor;
use Signnow\Serializer\Annotation\XmlAttribute;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlMap;
use Signnow\Serializer\Annotation\XmlRoot;

/** @XmlRoot("post") */
class IndexedCommentsBlogPost
{
    /**
     * @XmlMap(keyAttribute="author-name", inline=true, entry="comments")
     * @Accessor(getter="getCommentsIndexedByAuthor")
     */
    private $comments = array();

    public function __construct()
    {
        $author = new Author('Foo');
        $this->comments[] = new Comment($author, 'foo');
        $this->comments[] = new Comment($author, 'bar');
    }

    public function getCommentsIndexedByAuthor()
    {
        $indexedComments = array();
        foreach ($this->comments as $comment) {
            $authorName = $comment->getAuthor()->getName();

            if (!isset($indexedComments[$authorName])) {
                $indexedComments[$authorName] = new IndexedCommentsList();
            }

            $indexedComments[$authorName]->addComment($comment);
        }

        return $indexedComments;
    }
}

class IndexedCommentsList
{
    /** @XmlList(inline=true, entry="comment") */
    private $comments = array();

    /** @XmlAttribute */
    private $count = 0;

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $this->count += 1;
    }
}
