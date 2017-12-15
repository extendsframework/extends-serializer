<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

use ExtendsFramework\Serializer\SerializedObjectInterface;
use PHPUnit\Framework\TestCase;

class ReflectionSerializerTest extends TestCase
{
    /**
     * Serialize.
     *
     * Test that object will be serialized to correct serialized object.
     *
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::serialize()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getObjectValues()
     */
    public function testSerialize(): void
    {
        $object = new Foo(
            'foo',
            new Bar(
                'qux',
                new Baz()
            ),
            33,
            null
        );

        $serializer = new ReflectionSerializer();
        $serialized = $serializer->serialize($object);

        $this->assertSame(Foo::class, $serialized->getClass());
        $this->assertEquals([
            'foo' => 'foo',
            'bar' => [
                'qux' => 'qux',
                'quux' => [],
            ],
            'baz' => 33,
            'qux' => true,
            'quux' => [],
        ], $serialized->getData());
    }

    /**
     * Unserialize.
     *
     * Test that serialized object will be unserialized to correct object.
     *
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::unserialize()
     * @covers \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getConstructParameters()
     */
    public function testUnserialize(): void
    {
        $serialized = $this->createMock(SerializedObjectInterface::class);
        $serialized
            ->method('getClass')
            ->willReturn(Foo::class);

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
         */
        $serializer = new ReflectionSerializer();
        $object = $serializer->unserialize($serialized);

        $this->assertEquals(new Foo(
            'foo',
            new Bar(
                'qux',
                new Baz()
            ),
            33,
            null
        ), $object);
    }

    /**
     * Construct parameter missing.
     *
     * Test that ...
     *
     * @covers                   \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::serialize()
     * @covers                   \ExtendsFramework\Serializer\Reflection\ReflectionSerializer::getConstructParameters()
     * @covers                   \ExtendsFramework\Serializer\Reflection\Exception\MissingConstructParameter::__construct()
     * @expectedException        \ExtendsFramework\Serializer\Reflection\Exception\MissingConstructParameter
     * @expectedExceptionMessage Parameter "foo" is missing, no default value is available and is not nullable.
     */
    public function testConstructParameterMissing(): void
    {
        $serialized = $this->createMock(SerializedObjectInterface::class);
        $serialized
            ->method('getClass')
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

class Foo
{
    /**
     * @var string
     */
    protected $foo;

    /**
     * @var Bar
     */
    protected $bar;

    /**
     * @var int
     */
    protected $baz;

    /**
     * @var bool|null
     */
    protected $qux;

    /**
     * @var array|null
     */
    protected $quux;

    /**
     * @param string     $foo
     * @param Bar        $bar
     * @param int|null   $baz
     * @param bool|null  $qux
     * @param array|null $quux
     */
    public function __construct(string $foo, Bar $bar, int $baz = null, ?bool $qux, array $quux = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->baz = $baz ?? 33;
        $this->qux = $qux ?? true;
        $this->quux = $quux ?? [];
    }
}

class Bar
{
    /**
     * @var string
     */
    protected $qux;

    /**
     * @var Baz
     */
    protected $quux;

    /**
     * @param string $qux
     * @param Baz    $quux
     */
    public function __construct(string $qux, Baz $quux)
    {
        $this->qux = $qux;
        $this->quux = $quux;
    }
}

class Baz
{
}
