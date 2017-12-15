<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

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
     * @inheritDoc
     */
    public function serialize(object $object): SerializedObjectInterface
    {
        return new SerializedObject(
            get_class($object),
            $this->getObjectValues($object)
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize(SerializedObjectInterface $serializedObject): object
    {
        $class = new ReflectionClass($serializedObject->getClass());
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
                    $parameters = $this->getConstructParameters($class, $data[$name] ?? []);
                    $value = $class->newInstanceArgs($parameters);
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
}
