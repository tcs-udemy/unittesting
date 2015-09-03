<?php
namespace Acme\Tests;

class PublicPagesTest extends \PHPUnit_Framework_TestCase
{
    use WebTrait;

    function testHomePage()
    {
        $response_code = $this->crawl('http://localhost/');
        $this->assertEquals(200, $response_code);
    }

    function testLoginPage()
    {
        $response_code = $this->crawl('http://localhost/login');
        $this->assertEquals(200, $response_code);
    }

    function testPageNotFound()
    {
        $response_code = $this->crawl('http://localhost/asdf');
        $this->assertEquals(404, $response_code);
    }

}
