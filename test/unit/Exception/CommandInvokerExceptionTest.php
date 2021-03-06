<?php

namespace Dhii\Invocation\UnitTest\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Xpmock\TestCase;
use Dhii\Invocation\Exception\CommandInvokerException as TestSubject;
use Exception as RootException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CommandInvokerExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Invocation\Exception\CommandInvokerException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param string[] $methods The names of methods to make mockable.
     *
     * @return TestSubject
     */
    public function createInstance($methods = [], $disableOriginalConstructor = true)
    {
        $methods = $this->mergeValues($methods, [
            '_normalizeString',
            '_normalizeInt',
            '__',
        ]);
        $builder = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods);
        $disableOriginalConstructor && $builder->disableOriginalConstructor();
        $mock = $builder->getMock();

        $mock->method('_normalizeString')
            ->will($this->returnCallback(function ($string) {
                return (string) $string;
            }));
        $mock->method('_normalizeInt')
            ->will($this->returnCallback(function ($int) {
                return intval($int);
            }));
        $mock->method('_normalizeArray')
            ->will($this->returnCallback(function ($array) {
                return $array;
            }));
        $mock->method('__')
            ->will($this->returnCallback(function ($message) {
                return $message;
            }));

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
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created.'
        );
        $this->assertInstanceOf('Exception', $subject, 'Subject is not a valid exception');
        $this->assertInstanceOf('Dhii\Invocation\Exception\CommandInvokerExceptionInterface', $subject, 'Subject is not a valid command invoker exception.');
    }

    /**
     * Tests that the parameter-less constructor doesn't fail.
     *
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = $this->createInstance(['_construct', '_normalizeString', '_normalizeInt', '_setCommandInvoker']);
        $_subject = $this->reflect($subject);
        $message = uniqid('message-');
        $code = rand(1, 99);
        $previous = $this->createException('inner-message-');
        $invoker = $this->createCommandInvoker();

        $subject->expects($this->exactly(1))
            ->method('_normalizeString')
            ->with($message);
        $subject->expects($this->exactly(1))
            ->method('_normalizeInt')
            ->with($code);
        $subject->expects($this->exactly(1))
            ->method('_setCommandInvoker')
            ->with($invoker);
        $subject->expects($this->exactly(1))
            ->method('_construct');

        $subject->__construct($message, $code, $previous, $invoker);
    }
}
