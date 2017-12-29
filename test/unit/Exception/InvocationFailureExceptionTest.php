<?php

namespace Dhii\Invocation\UnitTest\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Dhii\Util\String\StringableInterface as Stringable;
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
    public function createInstance($methods = [], $disableOriginalConstructor = true)
    {
        $methods = $this->mergeValues($methods, [
            '_normalizeString',
            '_normalizeInt',
            '_normalizeArray',
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
        $this->assertInstanceOf('Dhii\Invocation\Exception\InvocationFailureExceptionInterface', $subject, 'Subject is not a valid invocation failure exception.');
    }

    /**
     * Tests that the parameter-less constructor doesn't fail.
     *
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = $this->createInstance([
            '_construct',
            '_setCommandInvoker',
            '_setCommand',
        ]);
        $_subject = $this->reflect($subject);
        $message = uniqid('message-');
        $code = rand(1, 99);
        $previous = $this->createException('inner-message-');
        $invoker = $this->createCommandInvoker();
        $command = $this->createStringable(uniqid('command-'));
        $args = array_map(function () { return rand(1, 99); }, array_fill(0, rand(1, 10), null));

        $subject->expects($this->exactly(1))
            ->method('_normalizeString')
            ->with($message);
        $subject->expects($this->exactly(1))
            ->method('_normalizeInt')
            ->with($code);
        $subject->expects($this->exactly(1))
            ->method('_normalizeArray')
            ->with($args);
        $subject->expects($this->exactly(1))
            ->method('_setCommandInvoker')
            ->with($invoker);
        $subject->expects($this->exactly(1))
            ->method('_setCommand')
            ->with($command);
        $subject->expects($this->exactly(1))
            ->method('_construct');

        $subject->__construct($message, $code, $previous, $invoker, $command, $args);
    }

    /**
     * Tests that the command is retrieved correctly.
     *
     * @since [*next-version*]
     */
    public function testGetCommand()
    {
        $subject = $this->createInstance(['_getCommand']);
        $command = $this->createStringable(uniqid('command-'));

        $subject->expects($this->exactly(1))
            ->method('_getCommand')
            ->will($this->returnValue($command));

        $result = $subject->getCommand();
        $this->assertSame($command, $result, 'Wrong command retrieved from subject');
    }

    /**
     * Tests that the arguments are retrieved correctly.
     *
     * @since [*next-version*]
     */
    public function testGetArgs()
    {
        $subject = $this->createInstance(['_getArgs']);
        $args = array_map(function () { return rand(1, 99); }, array_fill(0, rand(1, 10), null));

        $subject->expects($this->exactly(1))
            ->method('_getArgs')
            ->will($this->returnValue($args));

        $result = $subject->getArgs();
        $this->assertSame($args, $result, 'Wrong args retrieved from subject');
    }
}
