<?php
namespace Acme\Tests;

use Acme\Controllers\AdminController;
use Acme\Models\User;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class AdminControllerTest
 * @package Acme\Tests
 */
class AdminControllerTest extends AcmeBaseTest {

    use WebTrait;

    /**
     * Test adding a page when not logged in
     */
    public function testAddingPageForUserNotLoggedIn()
    {
        $response_code = $this->crawl('http://localhost/admin/page/add');
        $this->assertEquals(404, $response_code);
    }

    /**
     * Test adding a page when loggedin, but not admin
     */
    public function testAddingPageForLoggedInUserNotAdmin()
    {
        $user = $this->getUser(false);
        $this->app->di['session']->put('user', $user);
        $response_code = $this->crawl('http://localhost/admin/page/add');
        $this->assertEquals(404, $response_code);
    }

    /**
     * Test adding a page in controller
     * @runInSeparateProcess
     */
    public function testAddPage()
    {
        $controller = new AdminController("text/html", $this->app);
        $controller->getAddPage();
        $out = ob_get_contents();
        $dom = HtmlDomParser::str_get_html($out);
        $this->assertEquals(1, sizeof(($dom->find('nav'))));

    }


    /**
     * Test saving a page in controller
     */
    public function testPostSavePage()
    {
        $this->app->di['request']->addRequestItem("page_id", "0");
        $this->app->di['request']->addRequestItem("broswer_title", "Title");
        $this->app->di['request']->addRequestItem("thedata", "Test Data");
        $controller = new AdminController("text/html", $this->app);
        $controller->postSavePage();
    }


    /**
     * test auth functions
     */
    public function testAuth()
    {
        $user = $this->getUser(false);
        $this->app->di['session']->put('user', $user);
        $controller = new AdminController("text/html", $this->app);
        $actual = $controller->auth();
        $this->assertTrue($actual);
        $this->app->di['session']->forget('user');
        $actual = $controller->auth();
        $this->assertFalse($actual);

    }


    /**
     * test access level function
     */
    public function testAccessLevel()
    {
        $controller = new AdminController("text/html", $this->app);
        $shd_be_false = $controller->accessLevel();
        $user = $this->getUser(false);
        $this->app->di['session']->put('user', $user);
        $shd_be_greater_than_zero = $controller->accessLevel();

        $this->assertGreaterThan(0, $shd_be_greater_than_zero);
        $this->assertFalse($shd_be_false);
    }


    /**
     * Util to return user object
     *
     * @param bool|true $is_admin
     * @return User
     */
    function getUser($is_admin = true)
    {
        $user = new User;
        $user->id = 1;
        $user->first_name = "";
        $user->last_name = "";
        $user->email = "me@here.com";
        $user->password = "abc123";
        if ($is_admin)
            $user->access_level = 1;
        else
            $user->access_level = 2;

        return $user;
    }
}
