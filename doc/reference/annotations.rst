Annotations
-----------

@ExclusionPolicy
~~~~~~~~~~~~~~~~
This annotation can be defined on a class to indicate the exclusion strategy
that should be used for the class.

+----------+----------------------------------------------------------------+
| Policy   | Description                                                    |
+==========+================================================================+
| all      | all properties are excluded by default; only properties marked |
|          | with @Expose will be serialized/unserialized                   |
+----------+----------------------------------------------------------------+
| none     | no properties are excluded by default; all properties except   |
|          | those marked with @Exclude will be serialized/unserialized     |
+----------+----------------------------------------------------------------+

@Exclude
~~~~~~~~
This annotation can be defined on a property to indicate that the property should
not be serialized/unserialized. Works only in combination with NoneExclusionPolicy.

If the ``ExpressionLanguageExclusionStrategy`` exclusion strategy is enabled, will
be possible to use ``@Exclude(if="expression")`` to exclude dynamically a property.

@Expose
~~~~~~~
This annotation can be defined on a property to indicate that the property should
be serialized/unserialized. Works only in combination with AllExclusionPolicy.

If the ``ExpressionLanguageExclusionStrategy`` exclusion strategy is enabled, will
be possible to use ``@Expose(if="expression")`` to expose dynamically a property.

@SkipWhenEmpty
~~~~~~~~~~~~~~
This annotation can be defined on a property to indicate that the property should
not be serialized if the result will be "empty".

Works option works only when serializing.

@SerializedName
~~~~~~~~~~~~~~~
This annotation can be defined on a property to define the serialized name for a
property. If this is not defined, the property will be translated from camel-case
to a lower-cased underscored name, e.g. camelCase -> camel_case.

Note that this annotation is not used when you're using any other naming 
stategy than the default configuration (which includes the 
``SerializedNameAnnotationStrategy``). In order to re-enable the annotation, you
will need to wrap your custom strategy with the ``SerializedNameAnnotationStrategy``.

.. code-block :: php

    <?php
    $serializer = \SignNow\Serializer\SerializerBuilder::create()
        ->setPropertyNamingStrategy(
            new \SignNow\Serializer\Naming\SerializedNameAnnotationStrategy(
                new \SignNow\Serializer\Naming\IdenticalPropertyNamingStrategy()
            )
        )
        ->build();

@Since
~~~~~~
This annotation can be defined on a property to specify starting from which
version this property is available. If an earlier version is serialized, then
this property is excluded automatically. The version must be in a format that is
understood by PHP's ``version_compare`` function.

@Until
~~~~~~
This annotation can be defined on a property to specify until which version this
property was available. If a later version is serialized, then this property is
excluded automatically. The version must be in a format that is understood by
PHP's ``version_compare`` function.

@Groups
~~~~~~~
This annotation can be defined on a property to specify if the property
should be serialized when only serializing specific groups (see
:doc:`../cookbook/exclusion_strategies`).

@MaxDepth
~~~~~~~~~
This annotation can be defined on a property to limit the depth to which the
content will be serialized. It is very useful when a property will contain a
large object graph.

@AccessType
~~~~~~~~~~~
This annotation can be defined on a property, or a class to specify in which way
the properties should be accessed. By default, the serializer will retrieve, or
set the value via reflection, but you may change this to use a public method instead:

.. code-block :: php

    <?php
    use SignNow\Serializer\Annotation\AccessType;

    /** @AccessType("public_method") */
    class User
    {
        private $name;

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = trim($name);
        }
    }

@Accessor
~~~~~~~~~
This annotation can be defined on a property to specify which public method should
be called to retrieve, or set the value of the given property:

.. code-block :: php

    <?php
    use SignNow\Serializer\Annotation\Accessor;

    class User
    {
        private $id;

        /** @Accessor(getter="getTrimmedName",setter="setName") */
        private $name;

        // ...
        public function getTrimmedName()
        {
            return trim($this->name);
        }

        public function setName($name)
        {
            $this->name = $name;
        }
    }
    
.. note ::

    If you need only to serialize your data, you can avoid providing a setter by
    setting the property as read-only using the ``@ReadOnly`` annotation.

@AccessorOrder
~~~~~~~~~~~~~~
This annotation can be defined on a class to control the order of properties. By
default the order is undefined, but you may change it to either "alphabetical", or
"custom".

.. code-block :: php

    <?php
    use SignNow\Serializer\Annotation\AccessorOrder;

    /**
     * @AccessorOrder("alphabetical")
     *
     * Resulting Property Order: id, name
     */
    class User
    {
        private $id;
        private $name;
    }

    /**
     * @AccessorOrder("custom", custom = {"name", "id"})
     *
     * Resulting Property Order: name, id
     */
    class User
    {
        private $id;
        private $name;
    }

    /**
     * @AccessorOrder("custom", custom = {"name", "someMethod" ,"id"})
     *
     * Resulting Property Order: name, mood, id
     */
    class User
    {
        private $id;
        private $name;

        /**
         * @Serializer\VirtualProperty
         * @Serializer\SerializedName("mood")
         *
         * @return string
         */
        public function getSomeMethod()
        {
            return 'happy';
        }
    }

@VirtualProperty
~~~~~~~~~~~~~~~~
This annotation can be defined on a method to indicate that the data returned by
the method should appear like a property of the object.

A virtual property can be defined for a method of an object to serialize and can be
also defined at class level exposing data using the Symfony Expression Language.

.. code-block :: php

    /**
     * @Serializer\VirtualProperty(
     *     "firstName",
     *     exp="object.getFirstName()",
     *     options={@Serializer\SerializedName("my_first_name")}
     *  )
     */
    class Author
    {
        /**
         * @Serializer\Expose()
         */
        private $id;

        /**
         * @Serializer\Exclude()
         */
        private $firstName;

        /**
         * @Serializer\Exclude()
         */
        private $lastName;

        /**
         * @Serializer\VirtualProperty()
         */
        public function getLastName()
        {
            return $this->lastName;
        }

        public function getFirstName()
        {
            return $this->firstName;
        }
    }

In this example:

- ``id`` is exposed using the object reflection.
- ``lastName`` is exposed using the ``getLastName`` getter method.
- ``firstName`` is exposed using the ``object.getFirstName()`` expression (``exp`` can contain any valid symfony expression).


.. note ::

    This only works for serialization and is completely ignored during deserialization.

@Inline
~~~~~~~
This annotation can be defined on a property to indicate that the data of the property
should be inlined.

**Note**: This only works for serialization, the serializer will not be able to deserialize
objects with this annotation. Also, AccessorOrder will be using the name of the property
to determine the order.

@ReadOnly
~~~~~~~~~
This annotation can be defined on a property to indicate that the data of the property
is read only and cannot be set during deserialization.

A property can be marked as non read only with ``@ReadOnly(false)`` annotation (useful when a class is marked as read only).

@PreSerialize
~~~~~~~~~~~~~
This annotation can be defined on a method which is supposed to be called before
the serialization of the object starts.

@PostSerialize
~~~~~~~~~~~~~~
This annotation can be defined on a method which is then called directly after the
object has been serialized.

@PostDeserialize
~~~~~~~~~~~~~~~~
This annotation can be defined on a method which is supposed to be called after
the object has been deserialized.

@HandlerCallback
~~~~~~~~~~~~~~~~
This annotation can be defined on a method if serialization/deserialization is handled
by the object itself.

.. code-block :: php

    <?php

    class Article
    {
        /**
         * @HandlerCallback("xml", direction = "serialization")
         */
        public function serializeToXml(XmlSerializationVisitor $visitor)
        {
            // custom logic here
        }
    }

@Discriminator
~~~~~~~~~~~~~~

.. versionadded : 0.12
    @Discriminator was added

This annotation allows serialization/deserialization of relations which are polymorphic, but
where a common base class exists. The ``@Discriminator`` annotation has to be applied
to the least super type::

    /**
     * @Discriminator(field = "type", disabled = false, map = {"car": "Car", "moped": "Moped"}, groups={"foo", "bar"})
     */
    abstract class Vehicle { }
    class Car extends Vehicle { }
    class Moped extends Vehicle { }


.. note ::

    `groups` is optional and is used as exclusion policy.

@Type
~~~~~
This annotation can be defined on a property to specify the type of that property.
For deserialization, this annotation must be defined.
The ``@Type`` annotation can have parameters and parameters can be used by serialization/deserialization
handlers to enhance the serialization or deserialization result; for example, you may want to
force a certain format to be used for serializing DateTime types and specifying at the same time a different format
used when deserializing them.

Available Types:

+----------------------------------------------------------+--------------------------------------------------+
| Type                                                     | Description                                      |
+==========================================================+==================================================+
| boolean or bool                                          | Primitive boolean                                |
+----------------------------------------------------------+--------------------------------------------------+
| integer or int                                           | Primitive integer                                |
+----------------------------------------------------------+--------------------------------------------------+
| double or float                                          | Primitive double                                 |
+----------------------------------------------------------+--------------------------------------------------+
| string                                                   | Primitive string                                 |
+----------------------------------------------------------+--------------------------------------------------+
| array                                                    | An array with arbitrary keys, and values.        |
+----------------------------------------------------------+--------------------------------------------------+
| array<T>                                                 | A list of type T (T can be any available type).  |
|                                                          | Examples:                                        |
|                                                          | array<string>, array<MyNamespace\MyObject>, etc. |
+----------------------------------------------------------+--------------------------------------------------+
| array<K, V>                                              | A map of keys of type K to values of type V.     |
|                                                          | Examples: array<string, string>,                 |
|                                                          | array<string, MyNamespace\MyObject>, etc.        |
+----------------------------------------------------------+--------------------------------------------------+
| DateTime                                                 | PHP's DateTime object (default format*/timezone) |
+----------------------------------------------------------+--------------------------------------------------+
| DateTime<'format'>                                       | PHP's DateTime object (custom format/default     |
|                                                          | timezone)                                        |
+----------------------------------------------------------+--------------------------------------------------+
| DateTime<'format', 'zone'>                               | PHP's DateTime object (custom format/timezone)   |
+----------------------------------------------------------+--------------------------------------------------+
| DateTime<'format', 'zone', 'deserializeFormat'>          | PHP's DateTime object (custom format/timezone,   |
|                                                          | deserialize format). If you do not want to       |
|                                                          | specify a specific timezone, use an empty        |
|                                                          | string ('').                                     |
+----------------------------------------------------------+--------------------------------------------------+
| DateTimeImmutable                                        | PHP's DateTimeImmutable object (default format*/ |
|                                                          | timezone)                                        |
+----------------------------------------------------------+--------------------------------------------------+
| DateTimeImmutable<'format'>                              | PHP's DateTimeImmutable object (custom format/   |
|                                                          | default timezone)                                |
+----------------------------------------------------------+--------------------------------------------------+
| DateTimeImmutable<'format', 'zone'>                      | PHP's DateTimeImmutable object (custom format/   |
|                                                          | timezone)                                        |
+----------------------------------------------------------+--------------------------------------------------+
| DateTimeImmutable<'format', 'zone', 'deserializeFormat'> | PHP's DateTimeImmutable object (custom format/   |
|                                                          | timezone/deserialize format). If you do not want |
|                                                          | to specify a specific timezone, use an empty     |
|                                                          | string ('').                                     |
+----------------------------------------------------------+--------------------------------------------------+
| DateInterval                                             | PHP's DateInterval object using ISO 8601 format  |
+----------------------------------------------------------+--------------------------------------------------+
| T                                                        | Where T is a fully qualified class name.         |
+----------------------------------------------------------+--------------------------------------------------+
| ArrayCollection<T>                                       | Similar to array<T>, but will be deserialized    |
|                                                          | into Doctrine's ArrayCollection class.           |
+----------------------------------------------------------+--------------------------------------------------+
| ArrayCollection<K, V>                                    | Similar to array<K, V>, but will be deserialized |
|                                                          | into Doctrine's ArrayCollection class.           |
+----------------------------------------------------------+--------------------------------------------------+

(*) If the standalone jms/serializer is used then default format is `\DateTime::ISO8601` (which is not compatible with ISO-8601 despite the name). For jms/serializer-bundle the default format is `\DateTime::ATOM` (the real ISO-8601 format) but it can be changed in [configuration](https://jmsyst.com/bundles/JMSSerializerBundle/master/configuration#configuration-block-2-0).

Examples:

.. code-block :: php

    <?php

    namespace MyNamespace;

    use SignNow\Serializer\Annotation\Type;

    class BlogPost
    {
        /**
         * @Type("ArrayCollection<MyNamespace\Comment>")
         */
        private $comments;

        /**
         * @Type("string")
         */
        private $title;

        /**
         * @Type("MyNamespace\Author")
         */
        private $author;

        /**
         * @Type("DateTime")
         */
        private $startAt;

        /**
         * @Type("DateTime<'Y-m-d'>")
         */
        private $endAt;

        /**
         * @Type("DateTimeImmutable")
         */
        private $createdAt;

        /**
         * @Type("DateTimeImmutable<'Y-m-d'>")
         */
        private $updatedAt;

        /**
         * @Type("boolean")
         */
        private $published;

        /**
         * @Type("array<string, string>")
         */
        private $keyValueStore;
    }

@XmlRoot
~~~~~~~~
This allows you to specify the name of the top-level element.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlRoot;

    /** @XmlRoot("user") */
    class User
    {
        private $name = 'Johannes';
    }

Resulting XML:

.. code-block :: xml

    <user>
        <name><![CDATA[Johannes]]></name>
    </user>

.. note ::

    @XmlRoot only applies to the root element, but is for example not taken into
    account for collections. You can define the entry name for collections using
    @XmlList, or @XmlMap.

@XmlAttribute
~~~~~~~~~~~~~
This allows you to mark properties which should be set as attributes,
and not as child elements.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlAttribute;

    class User
    {
        /** @XmlAttribute */
        private $id = 1;
        private $name = 'Johannes';
    }

Resulting XML:

.. code-block :: xml

    <result id="1">
        <name><![CDATA[Johannes]]></name>
    </result>


@XmlDiscriminator
~~~~~~~~~~~~~~~~~
This annotation allows to modify the behaviour of @Discriminator regarding handling of XML.


Available Options:

+-------------------------------------+--------------------------------------------------+
| Type                                | Description                                      |
+=====================================+==================================================+
| attribute                           | use an attribute instead of a child node         |
+-------------------------------------+--------------------------------------------------+
| cdata                               | render child node content with or without cdata  |
+-------------------------------------+--------------------------------------------------+
| namespace                           | render child node using the specified namespace  |
+-------------------------------------+--------------------------------------------------+

Example for "attribute":
.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\Discriminator;
    use SignNow\Serializer\Annotation\XmlDiscriminator;

    /**
     * @Discriminator(field = "type", map = {"car": "Car", "moped": "Moped"}, groups={"foo", "bar"})
     * @XmlDiscriminator(attribute=true)
     */
    abstract class Vehicle { }
    class Car extends Vehicle { }

Resulting XML:

.. code-block :: xml

    <vehicle type="car" />


Example for "cdata":

.. code-block :: php
    <?php

    use SignNow\Serializer\Annotation\Discriminator;
    use SignNow\Serializer\Annotation\XmlDiscriminator;



    /**
     * @Discriminator(field = "type", map = {"car": "Car", "moped": "Moped"}, groups={"foo", "bar"})
     * @XmlDiscriminator(attribute=true)
     */
    abstract class Vehicle { }
    class Car extends Vehicle { }

Resulting XML:

.. code-block :: xml

    <vehicle><type>car</type></vehicle>


@XmlValue
~~~~~~~~~
This allows you to mark properties which should be set as the value of the
current element. Note that this has the limitation that any additional
properties of that object must have the @XmlAttribute annotation.
XMlValue also has property cdata. Which has the same meaning as the one in
XMLElement.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlAttribute;
    use SignNow\Serializer\Annotation\XmlValue;
    use SignNow\Serializer\Annotation\XmlRoot;

    /** @XmlRoot("price") */
    class Price
    {
        /** @XmlAttribute */
        private $currency = 'EUR';

        /** @XmlValue */
        private $amount = 1.23;
    }

Resulting XML:

.. code-block :: xml

    <price currency="EUR">1.23</price>

@XmlList
~~~~~~~~
This allows you to define several properties of how arrays should be
serialized. This is very similar to @XmlMap, and should be used if the
keys of the array are not important.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlList;
    use SignNow\Serializer\Annotation\XmlRoot;

    /** @XmlRoot("post") */
    class Post
    {
        /**
         * @XmlList(inline = true, entry = "comment")
         */
        private $comments = array(
            new Comment('Foo'),
            new Comment('Bar'),
        );
    }

    class Comment
    {
        private $text;

        public function __construct($text)
        {
            $this->text = $text;
        }
    }

Resulting XML:

.. code-block :: xml

    <post>
        <comment>
            <text><![CDATA[Foo]]></text>
        </comment>
        <comment>
            <text><![CDATA[Bar]]></text>
        </comment>
    </post>

You can also specify the entry tag namespace using the ``namespace`` attribute (``@XmlList(inline = true, entry = "comment", namespace="http://www.example.com/ns")``).

@XmlMap
~~~~~~~
Similar to @XmlList, but the keys of the array are meaningful.

@XmlKeyValuePairs
~~~~~~~~~~~~~~~~~
This allows you to use the keys of an array as xml tags.

.. note ::

    When a key is an invalid xml tag name (e.g. 1_foo) the tag name *entry* will be used instead of the key.

@XmlAttributeMap
~~~~~~~~~~~~~~~~

This is similar to the @XmlKeyValuePairs, but instead of creating child elements, it creates attributes.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlAttribute;

    class Input
    {
        /** @XmlAttributeMap */
        private $id = array(
            'name' => 'firstname',
            'value' => 'Adrien',
        );
    }

Resulting XML:

.. code-block :: xml

    <result name="firstname" value="Adrien"/>

@XmlElement
~~~~~~~~~~~
This annotation can be defined on a property to add additional xml serialization/deserialization properties.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlElement;

    /**
     * @XmlNamespace(uri="http://www.w3.org/2005/Atom", prefix="atom")
     */
    class User
    {
        /**
        * @XmlElement(cdata=false, namespace="http://www.w3.org/2005/Atom")
        */
        private $id = 'my_id';
    }

Resulting XML:

.. code-block :: xml

    <atom:id>my_id</atom:id>

@XmlNamespace
~~~~~~~~~~~~~
This annotation allows you to specify Xml namespace/s and prefix used.

.. code-block :: php

    <?php

    use SignNow\Serializer\Annotation\XmlNamespace;

    /**
     * @XmlNamespace(uri="http://example.com/namespace")
     * @XmlNamespace(uri="http://www.w3.org/2005/Atom", prefix="atom")
     */
    class BlogPost
    {
        /**
         * @Type("SignNow\Serializer\Tests\Fixtures\Author")
         * @Groups({"post"})
         * @XmlElement(namespace="http://www.w3.org/2005/Atom")
         */
         private $author;
    }

    class Author
    {
        /**
         * @Type("string")
         * @SerializedName("full_name")
         */
         private $name;
    }

Resulting XML:

.. code-block :: xml

    <?xml version="1.0" encoding="UTF-8"?>
    <blog-post xmlns="http://example.com/namespace" xmlns:atom="http://www.w3.org/2005/Atom">
        <atom:author>
            <full_name><![CDATA[Foo Bar]]></full_name>
        </atom:author>
    </blog>
