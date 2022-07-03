<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Construction\UnserializeObjectConstructor;
use SignNow\Serializer\DeserializationContext;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\VisitorInterface;

class InitializedBlogPostConstructor extends UnserializeObjectConstructor
{
    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type, DeserializationContext $context)
    {
        if ($type['name'] !== 'SignNow\Serializer\Tests\Fixtures\BlogPost') {
            return parent::construct($visitor, $metadata, $data, $type);
        }

        return new BlogPost('This is a nice title.', new Author('Foo Bar'), new \DateTime('2011-07-30 00:00', new \DateTimeZone('UTC')), new Publisher('Bar Foo'));
    }
}
