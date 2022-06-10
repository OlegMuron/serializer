<?php

namespace Signnow\Serializer\Tests\Fixtures\Discriminator;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "post": "Signnow\Serializer\Tests\Fixtures\Discriminator\Post",
 *    "image_post": "Signnow\Serializer\Tests\Fixtures\Discriminator\ImagePost",
 * })
 */
class Post
{
    /** @Serializer\Type("string") */
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }
}
