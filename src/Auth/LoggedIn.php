<?php
namespace Acme\Auth;

/**
 * Class LoggedIn
 * @package Acme\Auth
 */
class LoggedIn
{


    public function __construct()
    {

    }

    /**
     * @return bool|Acme\Models\User
     */
    public function user()
    {
        //dd($this->app);
//        if ($this->app->session->get('user') != null)
//        {
//            $user = $this->app->session->get('user');
//            return $user;
//        } else {
//            return false;
//        }
    }
}
