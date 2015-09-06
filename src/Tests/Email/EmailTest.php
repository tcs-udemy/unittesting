<?php
namespace Acme\Tests;

use Acme\Email\SendEmail;

/**
 * @backupGlobals disabled
 */
class EmailTest extends AcmeBaseTest {

    public function testSendEmail()
    {
        $email = new SendEmail();

        $result = $email->sendEmail("me@here.ca", "some message", "some message", "from@example.com");
        $this->assertEquals(1, $result);
    }

//    public function testSendEmailWithBadAddress()
//    {
//        $email = new SendEmail();
//
//        $result = $email->sendEmail("me", "some message", "some message", "from@example.com");
//        $this->assertNotEquals(0, $result);
//    }
}
