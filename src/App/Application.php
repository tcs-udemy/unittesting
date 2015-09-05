<?php
namespace Acme\App;

use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Http\Session;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\Container;

class Application {

    public $di;
    private static $instance;


    /**
     * contructor
     */
    public function __construct()
    {
        $this->setUpDi(self::$instance);
        $this->setUpLogging();
    }

    /**
     * Set up logging config
     */
    private function setUpLogging()
    {
        $this->di['log']->pushHandler(new StreamHandler(base_path()
            . '/Logs/app.log', Logger::WARNING));
    }

    /**
     * Log warning messages
     *
     * @param $message
     */
    public function logWarning($message)
    {
        $this->di['log']->addWarning($message);
    }

    /**
     * Log errors
     *
     * @param $message
     */
    public function logError($message)
    {
        $this->di['log']->addError($message);
    }

    /**
     * Set up Dependency Injection container
     *
     * @param $app
     */
    private function setUpDi($app)
    {
        $container = new Container();

        $container['response'] = function () use ($app) {
            return new Response($this);
        };

        $container['request'] = function () {
            return new Request($_REQUEST, $_GET, $_POST, $_SERVER);
        };

        $container['session'] = function () {
            return new Session();
        };

        $container['log'] = function () {
            return new Logger('log');
        };

        $container['auth'] = function () {

        };

        $this->di = $container;
    }
}
