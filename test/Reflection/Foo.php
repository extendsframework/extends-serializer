<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

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
     * @param bool|null  $qux
     * @param int|null   $baz
     * @param array|null $quux
     */
    public function __construct(string $foo, Bar $bar, ?bool $qux, int $baz = null, array $quux = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->qux = $qux ?? true;
        $this->baz = $baz ?? 33;
        $this->quux = $quux ?? [];
    }
}
