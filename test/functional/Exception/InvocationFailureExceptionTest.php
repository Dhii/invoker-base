<?php

namespace Dhii\Invocation\FuncTest\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Dhii\Invocation\Exception\CommandInvokerExceptionInterface;
use Xpmock\TestCase;
use Dhii\Invocation\Exception\InvocationFailureException as TestSubject;
use Exception as RootException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class InvocationFailureExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Invocation\Exception\InvocationFailureException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param string[] $methods The names of methods to make mockable.
     *
     * @return TestSubject
     */
    public function createInstance($methods = [], $constructorArgs = [], $disableOriginalConstructor = true)
    {
        $methods = is_array($methods)
            ? $this->mergeValues($methods, [])
            : $methods;
        $builder = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->setConstructorArgs($constructorArgs);
        $disableOriginalConstructor && $builder->disableOriginalConstructor();
        $mock = $builder->getMock();

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
     * Creates a new stringable object.
     *
     * @since [*next-version*]
     *
     * @param string $string The string to wrap.
     *
     * @return Stringable The new stringable.
     */
    public function createStringable($string = '')
    {
        $mock = $this->mock('Dhii\Util\String\StringableInterface')
            ->__toString($string)
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
        $command = $this->createStringable(uniqid('command-'));
        $args = array_map(function () { return rand(1, 99); }, array_fill(0, rand(1, 10), null));
        $subject = $this->createInstance(null, [$message, $code, $previous, $invoker, $command, $args], false);
        $_subject = $this->reflect($subject);

        try {
            throw $subject;
        } catch (CommandInvokerExceptionInterface $e) {
            $this->assertEquals($message, $e->getMessage(), 'Wrong message retrieved from subject');
            $this->assertEquals($code, $e->getCode(), 'Wrong code retrieved from subject');
            $this->assertEquals($previous, $e->getPrevious(), 'Wrong inner exception retrieved from subject');
            $this->assertEquals($invoker, $e->getCommandInvoker(), 'Wrong invoker retrieved from subject');
            $this->assertEquals($command, $e->getCommand(), 'Wrong command retrieved from subject');
            $this->assertEquals($args, $e->getArgs(), 'Wrong args retrieved from subject');
        }
    }
}
