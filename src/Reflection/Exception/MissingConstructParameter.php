<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection\Exception;

use ExtendsFramework\Serializer\SerializerException;
use LogicException;
use ReflectionParameter;

class MissingConstructParameter extends LogicException implements SerializerException
{
    /**
     * ParameterIsMissing constructor.
     *
     * @param ReflectionParameter $parameter
     */
    public function __construct(ReflectionParameter $parameter)
    {
        parent::__construct(sprintf(
            'Parameter "%s" is missing, no default value is available and is not nullable.',
            $parameter->getName()
        ));
    }
}
