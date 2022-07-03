<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlKeyValuePairs;

class ObjectWithXmlKeyValuePairsWithObjectType
{
    /**
     * @var array
     * @Type("array<string,SignNow\Serializer\Tests\Fixtures\ObjectWithXmlKeyValuePairsWithType>")
     * @XmlKeyValuePairs
     */
    private $list;

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public static function create1()
    {
        return new self(
            [
                'key_first' => ObjectWithXmlKeyValuePairsWithType::create1(),
                'key_second' => ObjectWithXmlKeyValuePairsWithType::create2(),
            ]
        );
    }
}
