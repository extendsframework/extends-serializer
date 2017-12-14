<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

class SerializedObject implements SerializedObjectInterface
{
    /**
     * Serialized object class.
     *
     * @var string
     */
    protected $class;

    /**
     * Serialized object data.
     *
     * @var array
     */
    protected $data;

    /**
     * SerializedObject constructor.
     *
     * @param string $class
     * @param array  $data
     */
    public function __construct(string $class, array $data)
    {
        $this->class = $class;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
