<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

use PHPUnit\Framework\TestCase;

class ClassMapperTest extends TestCase
{
    /**
     * To class name.
     *
     * Test that correct values will be returned for identifier.
     *
     * @covers \ExtendsFramework\Serializer\ClassMapper::addMapping()
     * @covers \ExtendsFramework\Serializer\ClassMapper::toClassName()
     */
    public function testToClassName(): void
    {
        $classMapper = (new ClassMapper())
            ->addMapping(QuxQuux::class, 'QuxQuux');

        $this->assertSame(QuxQuux::class, $classMapper->toClassName('QuxQuux'));
        $this->assertNull($classMapper->toClassName('FooBar'));
    }

    /**
     * From class name.
     *
     * Test that correct values will be returned for class names.
     *
     * @covers \ExtendsFramework\Serializer\ClassMapper::addMapping()
     * @covers \ExtendsFramework\Serializer\ClassMapper::fromClassName()
     */
    public function testFromClassName(): void
    {
        $classMapper = (new ClassMapper())
            ->addMapping(QuxQuux::class, 'QuxQuux');

        $this->assertSame('QuxQuux', $classMapper->fromClassName(QuxQuux::class));
        $this->assertNull($classMapper->fromClassName(FooBar::class));
    }
}

class QuxQuux
{
}

class FooBar
{
}
