<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper;

use ExtendsFramework\Serializer\Mapper\Exception\ClassNotExists;
use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    /**
     * To class name.
     *
     * Test that correct values will be returned for identifier.
     *
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::addMapping()
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::toClassName()
     */
    public function testToClassName(): void
    {
        $mapper = (new Mapper())->addMapping(QuxQuux::class, 'QuxQuux');

        $this->assertSame(QuxQuux::class, $mapper->toClassName('QuxQuux'));
        $this->assertNull($mapper->toClassName('FooBar'));
    }

    /**
     * From class name.
     *
     * Test that correct values will be returned for class names.
     *
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::addMapping()
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::fromClassName()
     */
    public function testFromClassName(): void
    {
        $mapper = (new Mapper())->addMapping(QuxQuux::class, 'QuxQuux');

        $this->assertSame('QuxQuux', $mapper->fromClassName(QuxQuux::class));
        $this->assertNull($mapper->fromClassName(FooBar::class));
    }

    /**
     * Class not exists.
     *
     * Test that an exception will be thrown when class not exists.
     *
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::addMapping()
     * @covers \ExtendsFramework\Serializer\Mapper\Exception\ClassNotExists::__construct()
     */
    public function testClassNotExists(): void
    {
        $this->expectException(ClassNotExists::class);
        $this->expectExceptionMessage('Class with name "BarBaz" does not exist and can not be added to the mapper.');

        (new Mapper())->addMapping('BarBaz', 'BarBaz');
    }
}
