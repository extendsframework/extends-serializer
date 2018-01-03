<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper;

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
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::getMapping()
     */
    public function testToClassName(): void
    {
        $mapper = (new Mapper())
            ->addMapping(QuxQuux::class, 'QuxQuux');

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
     * @covers \ExtendsFramework\Serializer\Mapper\Mapper::getMapping()
     */
    public function testFromClassName(): void
    {
        $mapper = (new Mapper())
            ->addMapping(QuxQuux::class, 'QuxQuux');

        $this->assertSame('QuxQuux', $mapper->fromClassName(QuxQuux::class));
        $this->assertNull($mapper->fromClassName(FooBar::class));
    }

    /**
     * Class not exists.
     *
     * Test that an exception will be thrown when class not exists.
     *
     * @covers                   \ExtendsFramework\Serializer\Mapper\Mapper::addMapping()
     * @covers                   \ExtendsFramework\Serializer\Mapper\Exception\ClassNotExists::__construct()
     * @expectedException        \ExtendsFramework\Serializer\Mapper\Exception\ClassNotExists
     * @expectedExceptionMessage Class with name "BarBaz" does not exist and can not be added to the mapper.
     */
    public function testClassNotExists(): void
    {
        (new Mapper())->addMapping('BarBaz', 'BarBaz');
    }
}

class QuxQuux
{
}

class FooBar
{
}
