<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

interface SerializedObjectInterface
{
    /**
     * Get class name for serialized object.
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * Get data for serialized object.
     *
     * @return array
     */
    public function getData(): array;
}
