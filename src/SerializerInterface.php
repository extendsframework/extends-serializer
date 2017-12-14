<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

interface SerializerInterface
{
    /**
     * Serialize object.
     *
     * @param object $object
     * @return SerializedObjectInterface
     * @throws SerializerException
     */
    public function serialize(object $object): SerializedObjectInterface;

    /**
     * Unserialize object.
     *
     * @param SerializedObjectInterface $serializedObject
     * @return object
     * @throws SerializerException
     */
    public function unserialize(SerializedObjectInterface $serializedObject): object;
}
