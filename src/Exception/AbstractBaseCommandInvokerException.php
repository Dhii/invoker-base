<?php

namespace Dhii\Invocation\Exception;

use Exception as RootException;
use Dhii\Invocation\CommandInvokerAwareTrait;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Dhii\Util\Normalization\NormalizeIntCapableTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\I18n\StringTranslatingTrait;

/**
 * Abstract base functionality for command invokers.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseCommandInvokerException extends RootException implements CommandInvokerExceptionInterface
{
    /*
     * Adds internal command invoker awareness.
     *
     * @since [*next-version*]
     */
    use CommandInvokerAwareTrait;

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
     * Adds internal Invalid Argument Exception factory.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /*
     * Adds basic internal i18n functionality.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /**
     * Parameter-less constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getCommandInvoker()
    {
        return $this->_getCommandInvoker();
    }
}
