<?php

namespace Dhii\Invocation\Exception;

use Exception as RootException;
use Dhii\Invocation\CommandInvokerInterface;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Dhii\Util\Normalization\NormalizeIntCapableTrait;
use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * An exception that occurs in relation to a command invoker.
 *
 * @since [*next-version*]
 */
class CommandInvokerException extends AbstractBaseCommandInvokerException
{
    /*
     * Adds string normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeStringCapableTrait;

    /*
     * Adds integer normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeIntCapableTrait;

    /**
     * @since [*next-version*]
     *
     * @param string|Stringable|null       $message  The error message, if any.
     * @param int|string|Stringable|null   $code     The numeric error code, if any.
     * @param RootException|null           $previous The previous exception, if any.
     * @param CommandInvokerInterface|null $invoker  The problematic invoker, if any.
     *
     * @throws InvalidArgumentException If an argument does not match the type spec, or cannot be normalized to it.
     */
    public function __construct($message = null, $code = null, RootException $previous = null, CommandInvokerInterface $invoker = null)
    {
        $message = is_null($message)
                ? ''
                : $this->_normalizeString($message);
        $code = is_null($code)
                ? 0
                : $this->_normalizeInt($code);

        parent::__construct($message, $code, $previous);

        $this->_setCommandInvoker($invoker);

        $this->_construct();
    }
}
