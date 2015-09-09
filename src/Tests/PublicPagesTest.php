<?php
namespace Acme\Tests;

/**
 * Class PublicPagesTest
 * @package Acme\Tests
 */
class PublicPagesTest extends AcmeBaseTest
{
    use WebTrait;

    /**
     * Test showing home page
     */
    function testHomePage()
    {
        $response_code = $this->crawl('http://localhost/');
        $this->assertEquals(200, $response_code);
    }

    /**
     * Test showing login page
     */
    function testLoginPage()
    {
        $response_code = $this->crawl('http://localhost/login');
        $this->assertEquals(200, $response_code);
    }

    /**
     * Test page not found
     */
    function testPageNotFound()
    {
        $response_code = $this->crawl('http://localhost/asdf');
        $this->assertEquals(404, $response_code);
    }


    /**
     * Test showing about page
     */
    function testShowAboutPage()
    {
        $response_code = $this->crawl('http://localhost/about-acme');
        $this->assertEquals(200, $response_code);
    }

}
