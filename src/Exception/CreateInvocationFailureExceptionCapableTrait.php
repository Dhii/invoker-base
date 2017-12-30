<?php

namespace Dhii\Invocation\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

trait CreateInvocationFailureExceptionCapableTrait
{
    /**
     * Creates a new Invocation Failure Exception.
     *
     * @since [*next-version*]
     *
     * @param null|string|Stringable       $message  The error message, if any.
     * @param null|int|string|Stringable   $code     The numeric error code, if any.
     * @param RootException|null           $previous The inner exception, if any.
     * @param CommandInvokerInterface|null $invoker  The problematic invoker, if any.
     * @param string|Stringable|null       $command  The command that failed, if any.
     * @param array|null                   $args     The command arguments, if any.
     *
     * @throws InvalidArgumentException If an argument does not match the type spec, or cannot be normalized to it.
     *
     * @return CommandInvokerException The new exception.
     */
    protected function _createInvocationFailureException(
            $message = null,
            $code = null,
            RootException $previous = null,
            CommandInvokerInterface $invoker = null,
            $command = null,
            $args = null
    ) {
        return new InvocationFailureException($message, $code, $previous, $invoker, $command, $args);
    }
}
