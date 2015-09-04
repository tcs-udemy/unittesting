<?php
namespace Acme\Tests;

use Acme\Models\Page;
use Acme\Http\Session;
use Acme\Models\User;

class AdminControllerTest extends AcmeBaseTest {

    use WebTrait;

    public function testGetShowPage()
    {
        $test = false;
        $this->assertFalse($test);
    }

    public function testAddingPageForUserNotLoggedIn()
    {
        $response_code = $this->crawl('http://localhost/admin/page/add');
        $this->assertEquals(404, $response_code);
    }

//    public function testAddingPageForLoggedInUserNotAdmin()
//    {
//        $user = new User;
//        $user->id = 1;
//        $user->first_name = "";
//        $user->last_name = "";
//        $user->email = "me@here.com";
//        $user->password = "abc123";
//        $user->access_level = 1;
//
//        $_SESSION['user'] = $user;
//
//        $response_code = $this->crawl('http://localhost/admin/page/add');
//        $this->assertEquals(404, $response_code);
//    }

//    public function testAddPageForAdmin()
//    {
//        $user = new User;
//        $user->id = 1;
//        $user->first_name = "";
//        $user->last_name = "";
//        $user->email = "me@here.com";
//        $user->password = "abc123";
//        $user->access_level = 3;
//
//        $this->session->put('user', $user);
//
//
//    }
}
