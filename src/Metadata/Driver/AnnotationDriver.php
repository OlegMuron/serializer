<?php

namespace SignNow\Serializer\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use SignNow\Serializer\Annotation\Accessor;
use SignNow\Serializer\Annotation\AccessorOrder;
use SignNow\Serializer\Annotation\AccessType;
use SignNow\Serializer\Annotation\Discriminator;
use SignNow\Serializer\Annotation\Exclude;
use SignNow\Serializer\Annotation\ExcludeIf;
use SignNow\Serializer\Annotation\ExclusionPolicy;
use SignNow\Serializer\Annotation\Expose;
use SignNow\Serializer\Annotation\Groups;
use SignNow\Serializer\Annotation\HandlerCallback;
use SignNow\Serializer\Annotation\Inline;
use SignNow\Serializer\Annotation\MaxDepth;
use SignNow\Serializer\Annotation\PostDeserialize;
use SignNow\Serializer\Annotation\PostSerialize;
use SignNow\Serializer\Annotation\PreSerialize;
use SignNow\Serializer\Annotation\ReadOnlyProperty;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Since;
use SignNow\Serializer\Annotation\SkipWhenEmpty;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\Until;
use SignNow\Serializer\Annotation\VirtualProperty;
use SignNow\Serializer\Annotation\XmlAttribute;
use SignNow\Serializer\Annotation\XmlAttributeMap;
use SignNow\Serializer\Annotation\XmlDiscriminator;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlKeyValuePairs;
use SignNow\Serializer\Annotation\XmlList;
use SignNow\Serializer\Annotation\XmlMap;
use SignNow\Serializer\Annotation\XmlNamespace;
use SignNow\Serializer\Annotation\XmlRoot;
use SignNow\Serializer\Annotation\XmlValue;
use SignNow\Serializer\Exception\InvalidArgumentException;
use SignNow\Serializer\GraphNavigator;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\ExpressionPropertyMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\Metadata\VirtualPropertyMetadata;
use Metadata\Driver\DriverInterface;
use Metadata\MethodMetadata;

class AnnotationDriver implements DriverInterface
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class): ?ClassMetadata
    {
        $classMetadata = new ClassMetadata($name = $class->name);
        $classMetadata->fileResources[] = $class->getFilename();

        $propertiesMetadata = array();
        $propertiesAnnotations = array();

        $exclusionPolicy = 'NONE';
        $excludeAll = false;
        $classAccessType = PropertyMetadata::ACCESS_TYPE_PROPERTY;
        $readOnlyClass = false;
        foreach ($this->reader->getClassAnnotations($class) as $annot) {
            if ($annot instanceof ExclusionPolicy) {
                $exclusionPolicy = $annot->policy;
            } elseif ($annot instanceof XmlRoot) {
                $classMetadata->xmlRootName = $annot->name;
                $classMetadata->xmlRootNamespace = $annot->namespace;
            } elseif ($annot instanceof XmlNamespace) {
                $classMetadata->registerNamespace($annot->uri, $annot->prefix);
            } elseif ($annot instanceof Exclude) {
                $excludeAll = true;
            } elseif ($annot instanceof AccessType) {
                $classAccessType = $annot->type;
            } elseif ($annot instanceof ReadOnlyProperty) {
                $readOnlyClass = true;
            } elseif ($annot instanceof AccessorOrder) {
                $classMetadata->setAccessorOrder($annot->order, $annot->custom);
            } elseif ($annot instanceof Discriminator) {
                if ($annot->disabled) {
                    $classMetadata->discriminatorDisabled = true;
                } else {
                    $classMetadata->setDiscriminator($annot->field, $annot->map, $annot->groups);
                }
            } elseif ($annot instanceof XmlDiscriminator) {
                $classMetadata->xmlDiscriminatorAttribute = (bool)$annot->attribute;
                $classMetadata->xmlDiscriminatorCData = (bool)$annot->cdata;
                $classMetadata->xmlDiscriminatorNamespace = $annot->namespace ? (string)$annot->namespace : null;
            } elseif ($annot instanceof VirtualProperty) {
                $virtualPropertyMetadata = new ExpressionPropertyMetadata($name, $annot->name, $annot->exp);
                $propertiesMetadata[] = $virtualPropertyMetadata;
                $propertiesAnnotations[] = $annot->options;
            }
        }

        foreach ($class->getMethods() as $method) {
            if ($method->class !== $name) {
                continue;
            }

            $methodAnnotations = $this->reader->getMethodAnnotations($method);

            foreach ($methodAnnotations as $annot) {
                if ($annot instanceof PreSerialize) {
                    $classMetadata->addPreSerializeMethod(new MethodMetadata($name, $method->name));
                    continue 2;
                } elseif ($annot instanceof PostDeserialize) {
                    $classMetadata->addPostDeserializeMethod(new MethodMetadata($name, $method->name));
                    continue 2;
                } elseif ($annot instanceof PostSerialize) {
                    $classMetadata->addPostSerializeMethod(new MethodMetadata($name, $method->name));
                    continue 2;
                } elseif ($annot instanceof VirtualProperty) {
                    $virtualPropertyMetadata = new VirtualPropertyMetadata($name, $method->name);
                    $propertiesMetadata[] = $virtualPropertyMetadata;
                    $propertiesAnnotations[] = $methodAnnotations;
                    continue 2;
                } elseif ($annot instanceof HandlerCallback) {
                    $classMetadata->addHandlerCallback(GraphNavigator::parseDirection($annot->direction), $annot->format, $method->name);
                    continue 2;
                }
            }
        }

        if (!$excludeAll) {
            foreach ($class->getProperties() as $property) {
                if ($property->class !== $name || (isset($property->info) && $property->info['class'] !== $name)) {
                    continue;
                }
                $propertiesMetadata[] = new PropertyMetadata($name, $property->getName());
                $propertiesAnnotations[] = $this->reader->getPropertyAnnotations($property);
            }

            foreach ($propertiesMetadata as $propertyKey => $propertyMetadata) {
                $isExclude = false;
                $isExpose = $propertyMetadata instanceof VirtualPropertyMetadata
                    || $propertyMetadata instanceof ExpressionPropertyMetadata;
                $propertyMetadata->readOnly = $propertyMetadata->readOnly || $readOnlyClass;
                $accessType = $classAccessType;
                $accessor = array(null, null);

                $propertyAnnotations = $propertiesAnnotations[$propertyKey];

                foreach ($propertyAnnotations as $annot) {
                    if ($annot instanceof Since) {
                        $propertyMetadata->sinceVersion = $annot->version;
                    } elseif ($annot instanceof Until) {
                        $propertyMetadata->untilVersion = $annot->version;
                    } elseif ($annot instanceof SerializedName) {
                        $propertyMetadata->serializedName = $annot->name;
                    } elseif ($annot instanceof SkipWhenEmpty) {
                        $propertyMetadata->skipWhenEmpty = true;
                    } elseif ($annot instanceof Expose) {
                        $isExpose = true;
                        if (null !== $annot->if) {
                            $propertyMetadata->excludeIf = "!(" . $annot->if . ")";
                        }
                    } elseif ($annot instanceof Exclude) {
                        if (null !== $annot->if) {
                            $propertyMetadata->excludeIf = $annot->if;
                        } else {
                            $isExclude = true;
                        }
                    } elseif ($annot instanceof Type) {
                        $propertyMetadata->setType($annot->name);
                    } elseif ($annot instanceof XmlElement) {
                        $propertyMetadata->xmlAttribute = false;
                        $propertyMetadata->xmlElementCData = $annot->cdata;
                        $propertyMetadata->xmlNamespace = $annot->namespace;
                    } elseif ($annot instanceof XmlList) {
                        $propertyMetadata->xmlCollection = true;
                        $propertyMetadata->xmlCollectionInline = $annot->inline;
                        $propertyMetadata->xmlEntryName = $annot->entry;
                        $propertyMetadata->xmlEntryNamespace = $annot->namespace;
                        $propertyMetadata->xmlCollectionSkipWhenEmpty = $annot->skipWhenEmpty;
                    } elseif ($annot instanceof XmlMap) {
                        $propertyMetadata->xmlCollection = true;
                        $propertyMetadata->xmlCollectionInline = $annot->inline;
                        $propertyMetadata->xmlEntryName = $annot->entry;
                        $propertyMetadata->xmlEntryNamespace = $annot->namespace;
                        $propertyMetadata->xmlKeyAttribute = $annot->keyAttribute;
                    } elseif ($annot instanceof XmlKeyValuePairs) {
                        $propertyMetadata->xmlKeyValuePairs = true;
                    } elseif ($annot instanceof XmlAttribute) {
                        $propertyMetadata->xmlAttribute = true;
                        $propertyMetadata->xmlNamespace = $annot->namespace;
                    } elseif ($annot instanceof XmlValue) {
                        $propertyMetadata->xmlValue = true;
                        $propertyMetadata->xmlElementCData = $annot->cdata;
                    } elseif ($annot instanceof XmlElement) {
                        $propertyMetadata->xmlElementCData = $annot->cdata;
                    } elseif ($annot instanceof AccessType) {
                        $accessType = $annot->type;
                    } elseif ($annot instanceof ReadOnlyProperty) {
                        $propertyMetadata->readOnly = $annot->readOnly;
                    } elseif ($annot instanceof Accessor) {
                        $accessor = array($annot->getter, $annot->setter);
                    } elseif ($annot instanceof Groups) {
                        $propertyMetadata->groups = $annot->groups;
                        foreach ((array)$propertyMetadata->groups as $groupName) {
                            if (false !== strpos($groupName, ',')) {
                                throw new InvalidArgumentException(sprintf(
                                    'Invalid group name "%s" on "%s", did you mean to create multiple groups?',
                                    implode(', ', $propertyMetadata->groups),
                                    $propertyMetadata->class . '->' . $propertyMetadata->name
                                ));
                            }
                        }
                    } elseif ($annot instanceof Inline) {
                        $propertyMetadata->inline = true;
                    } elseif ($annot instanceof XmlAttributeMap) {
                        $propertyMetadata->xmlAttributeMap = true;
                    } elseif ($annot instanceof MaxDepth) {
                        $propertyMetadata->maxDepth = $annot->depth;
                    }
                }


                if ((ExclusionPolicy::NONE === $exclusionPolicy && !$isExclude)
                    || (ExclusionPolicy::ALL === $exclusionPolicy && $isExpose)
                ) {
                    $propertyMetadata->setAccessor($accessType, $accessor[0], $accessor[1]);
                    $classMetadata->addPropertyMetadata($propertyMetadata);
                }
            }
        }

        return $classMetadata;
    }
}
