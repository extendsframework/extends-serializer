<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

use ExtendsFramework\Serializer\Mapper\Mapper;
use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\Serializer\Reflection\Exception\MissingConstructParameter;
use ExtendsFramework\Serializer\SerializedObject;
use ExtendsFramework\Serializer\SerializedObjectInterface;
use ExtendsFramework\Serializer\SerializerException;
use ExtendsFramework\Serializer\SerializerInterface;
use ReflectionClass;
use ReflectionMethod;

class ReflectionSerializer implements SerializerInterface
{
    /**
     * Class resolver.
     *
     * @var MapperInterface
     */
    protected $classMapper;

    /**
     * ReflectionSerializer constructor.
     *
     * @param MapperInterface|null $classMapper
     */
    public function __construct(MapperInterface $classMapper = null)
    {
        $this->classMapper = $classMapper ?? new Mapper();
    }

    /**
     * @inheritDoc
     */
    public function serialize(object $object): SerializedObjectInterface
    {
        $identifier = $this
                ->getClassMapper()
                ->fromClassName(get_class($object)) ?? get_class($object);

        return new SerializedObject(
            $identifier,
            $this->getObjectValues($object)
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize(SerializedObjectInterface $serializedObject): object
    {
        $className = $this
                ->getClassMapper()
                ->toClassName($serializedObject->getClassName()) ?? $serializedObject->getClassName();

        $class = new ReflectionClass($className);
        $parameters = $this->getConstructParameters(
            $class,
            $serializedObject->getData()
        );

        return $class->newInstanceArgs($parameters);
    }

    /**
     * Get construct parameters.
     *
     * An exception will be thrown when parameter can not be found in data, has no default value and is not nullable.
     *
     * @param ReflectionClass $reflectionClass
     * @param array           $data
     * @return array
     * @throws SerializerException
     */
    protected function getConstructParameters(ReflectionClass $reflectionClass, array $data): array
    {
        $constructor = $reflectionClass->getConstructor();
        if ($constructor instanceof ReflectionMethod) {
            foreach ($constructor->getParameters() as $parameter) {
                $name = $parameter->getName();

                $class = $parameter->getClass();
                if ($class instanceof ReflectionClass) {
                    $value = $class->newInstanceArgs(
                        $this->getConstructParameters($class, $data[$name] ?? [])
                    );
                } elseif (array_key_exists($name, $data) === true) {
                    $value = $data[$name];
                } elseif ($parameter->isDefaultValueAvailable() === true) {
                    $value = $parameter->getDefaultValue();
                } elseif ($parameter->allowsNull() === true) {
                    $value = null;
                } else {
                    throw new MissingConstructParameter($parameter);
                }

                $parameters[$name] = $value;
            }
        }

        return $parameters ?? [];
    }

    /**
     * Get object values.
     *
     * @param object $object
     * @return array
     */
    protected function getObjectValues(object $object): array
    {
        $class = new ReflectionClass(get_class($object));
        $constructor = $class->getConstructor();
        if ($constructor instanceof ReflectionMethod) {
            foreach ($constructor->getParameters() as $parameter) {
                $name = $parameter->getName();

                $property = $class->getProperty($name);
                $property->setAccessible(true);

                $value = $property->getValue($object);
                if (is_object($value) === true) {
                    $value = $this->getObjectValues($value);
                }

                $data[$name] = $value;
            }
        }

        return $data ?? [];
    }

    /**
     * Get class mapper.
     *
     * @return MapperInterface
     */
    protected function getClassMapper(): MapperInterface
    {
        return $this->classMapper;
    }
}
