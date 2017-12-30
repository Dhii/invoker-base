<?php

namespace Dhii\Invocation\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

trait CreateCommandInvokerExceptionCapableTrait
{
    /**
     * Creates a new Command Invoker Exception.
     *
     * @since [*next-version*]
     *
     * @param null|string|Stringable       $message  The error message, if any.
     * @param null|int|string|Stringable   $code     The error code, if any.
     * @param RootException|null           $previous The inner exception, if any.
     * @param CommandInvokerInterface|null $invoker  The problematic invoker, if any.
     *
     * @throws InvalidArgumentException If an argument does not match the type spec, or cannot be normalized to it.
     *
     * @return CommandInvokerException The new exception.
     */
    protected function _createCommandInvokerException(
        $message = null,
        $code = null,
        RootException $previous = null,
        CommandInvokerInterface $invoker = null
    ) {
        return new CommandInvokerException($message, $code, $previous, $invoker);
    }
}
