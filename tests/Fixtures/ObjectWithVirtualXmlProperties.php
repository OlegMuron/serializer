<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Groups;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Since;
use Signnow\Serializer\Annotation\Until;
use Signnow\Serializer\Annotation\VirtualProperty;
use Signnow\Serializer\Annotation\XmlAttribute;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlMap;
use Signnow\Serializer\Annotation\XmlValue;

class ObjectWithVirtualXmlProperties
{

    /**
     *
     * @VirtualProperty
     * @SerializedName("foo")
     * @Groups({"attributes"})
     * @XmlAttribute
     */
    public function getVirualXmlAttributeValue()
    {
        return 'bar';
    }

    /**
     *
     * @VirtualProperty
     * @SerializedName("xml-value")
     * @Groups({"values"})
     * @XmlValue
     */
    public function getVirualXmlValue()
    {
        return 'xml-value';
    }

    /**
     *
     * @VirtualProperty
     * @SerializedName("list")
     * @Groups({"list"})
     * @XmlList(inline = true, entry = "val")
     */
    public function getVirualXmlList()
    {
        return array('One', 'Two');
    }

    /**
     *
     * @VirtualProperty
     * @SerializedName("map")
     * @Groups({"map"})
     * @XmlMap(keyAttribute = "key")
     */
    public function getVirualXmlMap()
    {
        return array(
            'key-one' => 'One',
            'key-two' => 'Two'
        );
    }

    /**
     *
     * @VirtualProperty
     * @SerializedName("low")
     * @Groups({"versions"})
     * @Until("8")
     */
    public function getVirualLowValue()
    {
        return 1;
    }

    /**
     * @VirtualProperty
     * @SerializedName("hight")
     * @Groups({"versions"})
     * @Since("8")
     */
    public function getVirualHighValue()
    {
        return 8;
    }

}
