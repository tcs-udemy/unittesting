<?php
namespace Acme\Tests;

/**
 * Class ApplicationTest
 * @package Acme\Tests
 */
class ApplicationTest extends AcmeBaseTest {

    /**
     * Test writing warning to log
     */
    public function testLogWarning()
    {
        $this->app->logWarning('Warning');
    }

    /**
     * Test writing error to log
     */
    public function testLogError()
    {
        $this->app->logError('Error');
    }
}
