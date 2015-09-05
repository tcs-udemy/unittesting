<?php
namespace Acme\Tests;

class ApplicationTest extends AcmeBaseTest {

    public function testLogWarning()
    {
        $this->app->logWarning('Warning');
    }

    public function testLogError()
    {
        $this->app->logError('Warning');
    }
}
