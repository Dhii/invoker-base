<?php

namespace Dhii\Invocation\UnitTest\Exception;

use Dhii\Invocation\CommandInvokerInterface;
use Xpmock\TestCase;
use Dhii\Invocation\Exception\AbstractBaseCommandInvokerException as TestSubject;
use Exception as RootException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseCommandInvokerExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Invocation\Exception\AbstractBaseCommandInvokerException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param string[] $methods The names of methods to make mockable.
     *
     * @return TestSubject
     */
    public function createInstance($methods = [])
    {
        $methods = $this->mergeValues($methods, []);
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForAbstractClass();

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
    }

    /**
     * Tests that the subject can have a command invoker retrieved correctly.
     *
     * @since [*next-version*]
     */
    public function testGetCommandInvoker()
    {
        $subject = $this->createInstance(['_getCommandInvoker']);
        $_subject = $this->reflect($subject);
        $invoker = $this->createCommandInvoker();

        $subject->method('_getCommandInvoker')
            ->will($this->returnValue($invoker));

        $result = $subject->getCommandInvoker();
        $this->assertSame($invoker, $result, 'The retrieved invoker is wrong.');
    }

    /**
     * Tests that the parameter-less constructor doesn't fail.
     *
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_construct();
    }
}
