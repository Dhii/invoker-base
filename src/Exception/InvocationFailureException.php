<?php

namespace Dhii\Invocation\Exception;

use Exception as RootException;
use Dhii\Invocation\CommandInvokerInterface;
use Dhii\Invocation\ArgsAwareTrait;
use Dhii\Invocation\CommandAwareTrait;
use Dhii\Util\Normalization\NormalizeArrayCapableTrait;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Dhii\Util\Normalization\NormalizeIntCapableTrait;
use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * An exception that occurs in relation to a command invoker.
 *
 * @since [*next-version*]
 */
class InvocationFailureException extends AbstractBaseCommandInvokerException implements InvocationFailureExceptionInterface
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

    /*
     * Adds internal command awareness.
     *
     * @since [*next-version*]
     */
    use CommandAwareTrait;

    /*
     * Adds internal args awareness.
     *
     * @since [*next-version*]
     */
    use ArgsAwareTrait;

    /*
     * Adds array normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeArrayCapableTrait;

    /**
     * @since [*next-version*]
     *
     * @param string|Stringable|null       $message  The error message, if any.
     * @param int|string|Stringable|null   $code     The numeric error code, if any.
     * @param RootException|null           $previous The previous exception, if any.
     * @param CommandInvokerInterface|null $invoker  The problematic invoker, if any.
     * @param string|Stringable|null       $command  The command that failed, if any.
     * @param array|null                   $args     The command arguments, if any.
     *
     * @throws InvalidArgumentException If an argument does not match the type spec, or cannot be normalized to it.
     */
    public function __construct($message = null, $code = null, RootException $previous = null, CommandInvokerInterface $invoker = null, $command = null, $args = null)
    {
        $message = is_null($message)
                ? ''
                : $this->_normalizeString($message);
        $code = is_null($code)
                ? 0
                : $this->_normalizeInt($code);
        $args = is_null($args)
                ? []
                : $this->_normalizeArray($args);

        parent::__construct($message, $code, $previous);

        $this->_setCommandInvoker($invoker);
        $this->_setCommand($command);
        $this->_setArgs($args);

        $this->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getCommand()
    {
        return $this->_getCommand();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getArgs()
    {
        return $this->_getArgs();
    }
}
