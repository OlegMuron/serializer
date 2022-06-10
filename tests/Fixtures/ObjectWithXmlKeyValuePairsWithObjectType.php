<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlKeyValuePairs;

class ObjectWithXmlKeyValuePairsWithObjectType
{
    /**
     * @var array
     * @Type("array<string,Signnow\Serializer\Tests\Fixtures\ObjectWithXmlKeyValuePairsWithType>")
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
