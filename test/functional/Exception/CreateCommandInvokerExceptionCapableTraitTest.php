<?php

namespace Dhii\Invocation\FuncTest\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Dhii\Invocation\Exception\CommandInvokerExceptionInterface;
use Xpmock\TestCase;
use Dhii\Invocation\Exception\CreateCommandInvokerExceptionCapableTrait as TestSubject;
use Exception as RootException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateCommandInvokerExceptionCapableTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Invocation\Exception\CreateCommandInvokerExceptionCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param string[] $methods The names of methods to make mockable.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function createInstance($methods = [])
    {
        $methods = is_array($methods)
                ? $this->mergeValues($methods, [])
                : $methods;
        $builder = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods);
        $mock = $builder->getMockForTrait();

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The error message, if any.
     *
     * @return RootException
     */
    public function createException($message = '')
    {
        $mock = $this->mock('Exception')
            ->new($message);

        return $mock;
    }

    /**
     * Creates a new command invoker.
     *
     * @since [*next-version*]
     *
     * @return CommandInvokerInterface The new command invoker.
     */
    public function createCommandInvoker()
    {
        $mock = $this->mock('Dhii\Invocation\CommandInvokerInterface')
            ->invoke()
            ->new();

        return $mock;
    }

    /**
     * Tests that the parameter-less constructor doesn't fail.
     *
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $message = uniqid('message-');
        $code = rand(1, 99);
        $previous = $this->createException('inner-message-');
        $invoker = $this->createCommandInvoker();
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $result = $_subject->_createCommandInvokerException($message, $code, $previous, $invoker);

        try {
            throw $result;
        } catch (CommandInvokerExceptionInterface $e) {
            $this->assertEquals($message, $e->getMessage(), 'Wrong message retrieved from subject');
            $this->assertEquals($code, $e->getCode(), 'Wrong code retrieved from subject');
            $this->assertEquals($previous, $e->getPrevious(), 'Wrong inner exception retrieved from subject');
            $this->assertEquals($invoker, $e->getCommandInvoker(), 'Wrong invoker retrieved from subject');
        }
    }
}
