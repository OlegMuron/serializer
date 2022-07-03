<?php

namespace SignNow\Serializer\Tests\Fixtures\Discriminator;

use SignNow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "post": "SignNow\Serializer\Tests\Fixtures\Discriminator\Post",
 *    "image_post": "SignNow\Serializer\Tests\Fixtures\Discriminator\ImagePost",
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
