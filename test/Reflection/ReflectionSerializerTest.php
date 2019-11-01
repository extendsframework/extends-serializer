<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\Serializer\Reflection\Exception\MissingConstructParameter;
use ExtendsFramework\Serializer\SerializedObjectInterface;
use PHPUnit\Framework\TestCase;

class ReflectionSerializerTest extends TestCase
{
    /**
     * Serialize.
     *
     * Test that object will be serialized to correct serialized object.
     *
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::__construct()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::serialize()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getObjectValues()
     */
    public function testSerialize(): void
    {
        $classMapper = $this->createMock(MapperInterface::class);
        $classMapper
            ->method('fromClassName')
            ->with(Foo::class)
            ->willReturn('Foo');

        $object = new Foo(
            'foo',
            new Bar(
                'qux',
                new Baz()
            ),
            null,
            33
        );

        /**
         * @var MapperInterface $classMapper
         */
        $serializer = new ReflectionSerializer($classMapper);
        $serialized = $serializer->serialize($object);

        $this->assertSame('Foo', $serialized->getClassName());
        $this->assertEquals([
            'foo' => 'foo',
            'bar' => [
                'qux' => 'qux',
                'quux' => [],
            ],
            'qux' => true,
            'baz' => 33,
            'quux' => [],
        ], $serialized->getData());
    }

    /**
     * Unserialize.
     *
     * Test that serialized object will be unserialized to correct object.
     *
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::__construct()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::unserialize()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getConstructParameters()
     */
    public function testUnserialize(): void
    {
        $classMapper = $this->createMock(MapperInterface::class);
        $classMapper
            ->method('toClassName')
            ->with('Foo')
            ->willReturn(Foo::class);

        $serialized = $this->createMock(SerializedObjectInterface::class);
        $serialized
            ->method('getClassName')
            ->willReturn('Foo');

        $serialized
            ->method('getData')
            ->willReturn([
                'foo' => 'foo',
                'bar' => [
                    'qux' => 'qux',
                    'quux' => [],
                ],
                'baz' => 33,
            ]);

        /**
         * @var SerializedObjectInterface $serialized
         * @var MapperInterface           $classMapper
         */
        $serializer = new ReflectionSerializer($classMapper);
        $object = $serializer->unserialize($serialized);

        $this->assertEquals(new Foo(
            'foo',
            new Bar(
                'qux',
                new Baz()
            ),
            null,
            33
        ), $object);
    }

    /**
     * Construct parameter missing.
     *
     * Test that exception will be thrown when constructor parameter is missing.
     *
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::__construct()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::serialize()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getConstructParameters()
     * @covers \ExtendsFramework\Serializer\Reflection\Exception\MissingConstructParameter::__construct()
     */
    public function testConstructParameterMissing(): void
    {
        $this->expectException(MissingConstructParameter::class);
        $this->expectExceptionMessage('Parameter "foo" is missing, no default value is available and is not nullable.');

        $serialized = $this->createMock(SerializedObjectInterface::class);
        $serialized
            ->method('getClassName')
            ->willReturn(Foo::class);

        $serialized
            ->method('getData')
            ->willReturn([]);

        /**
         * @var SerializedObjectInterface $serialized
         */
        $serializer = new ReflectionSerializer();
        $serializer->unserialize($serialized);
    }
}
