<?php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Testimonial extends Eloquent
{
    public function user()
    {
        return $this->belongsTo('Acme\Models\User');
    }
}
