<?php

namespace Signnow\Serializer\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Signnow\Serializer\Annotation\Accessor;
use Signnow\Serializer\Annotation\AccessorOrder;
use Signnow\Serializer\Annotation\AccessType;
use Signnow\Serializer\Annotation\Discriminator;
use Signnow\Serializer\Annotation\Exclude;
use Signnow\Serializer\Annotation\ExcludeIf;
use Signnow\Serializer\Annotation\ExclusionPolicy;
use Signnow\Serializer\Annotation\Expose;
use Signnow\Serializer\Annotation\Groups;
use Signnow\Serializer\Annotation\HandlerCallback;
use Signnow\Serializer\Annotation\Inline;
use Signnow\Serializer\Annotation\MaxDepth;
use Signnow\Serializer\Annotation\PostDeserialize;
use Signnow\Serializer\Annotation\PostSerialize;
use Signnow\Serializer\Annotation\PreSerialize;
use Signnow\Serializer\Annotation\ReadOnlyProperty;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Since;
use Signnow\Serializer\Annotation\SkipWhenEmpty;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\Until;
use Signnow\Serializer\Annotation\VirtualProperty;
use Signnow\Serializer\Annotation\XmlAttribute;
use Signnow\Serializer\Annotation\XmlAttributeMap;
use Signnow\Serializer\Annotation\XmlDiscriminator;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlKeyValuePairs;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlMap;
use Signnow\Serializer\Annotation\XmlNamespace;
use Signnow\Serializer\Annotation\XmlRoot;
use Signnow\Serializer\Annotation\XmlValue;
use Signnow\Serializer\Exception\InvalidArgumentException;
use Signnow\Serializer\GraphNavigator;
use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\ExpressionPropertyMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;
use Signnow\Serializer\Metadata\VirtualPropertyMetadata;
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
