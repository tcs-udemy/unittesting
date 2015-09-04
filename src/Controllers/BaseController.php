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
class BaseController implements ControllerInterface {

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

}
