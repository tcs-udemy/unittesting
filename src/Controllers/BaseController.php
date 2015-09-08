<?php
namespace Acme\Controllers;

use Acme\App\Application;
use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Interfaces\ControllerInterface;
use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;

/**
 * Class BaseController
 * @package Acme\Controllers
 */
abstract class BaseController implements ControllerInterface {

    /**
     * @var BladeInstance
     */
    protected $blade;

    /**
     * @var SignatureGenerator
     */
    protected $signer;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Request
     */
    public $request;


    /**
     * @var Application
     */
    public $app;

    public $session;

    public $log;

    public $auth;

    /**
     * @param string $type
     */
    public function __construct($type = "text/html", Application $app)
    {
        $this->signer = new SignatureGenerator(getenv('CSRF_SECRET'));
        $this->blade = new BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));
        $this->request = $app->di['request'];
        $this->response = $app->di['response'];
        $this->session = $app->di['session'];
        $this->log = $app->di['log'];
        $this->app = $app;
    }


    /**
     * @return bool
     */
    public function auth()
    {
        if ($this->session->has('user'))
            return true;
        else
            return false;
    }


    /**
     * @return bool
     */
    public function accessLevel()
    {
        if ($this->session->has('user')){
            $user = $this->session->get('user');
            return $user->access_level;
        } else {
            return false;
        }
    }

}
