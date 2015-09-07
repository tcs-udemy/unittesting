<?php
namespace Acme\Tests;

use Acme\Models\Testimonial;

class TestimonialTest extends AcmeBaseTest {

    public function testGetUserForTestimonial()
    {
        $testimonial = Testimonial::find(1);
        $user_id = $testimonial->user->id;
        $this->assertEquals(1, $user_id);
    }
}
