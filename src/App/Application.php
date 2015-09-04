<?php
namespace Acme\App;

use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Http\Session;
use Pimple\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Application {

    public $di;
    private static $instance;


    public function __construct()
    {
        $this->setUpDi(self::$instance);
        $this->setUpLogging();
    }

    public function run()
    {

    }

    private function setUpLogging()
    {
        $this->di['log']->pushHandler(new StreamHandler(base_path()
            . '/Logs/app.log', Logger::WARNING));
    }

    public function logWarning($message)
    {
        $this->di['log']->addWarning($message);
    }

    public function logError($message)
    {
        $this->di['log']->addError($message);
    }

    private function setUpDi($app)
    {
        $container = new Container();

        $container['response'] = function() use ($app) {
            return new Response($this);
        };

        $container['request'] = function() {
            return new Request($_REQUEST, $_GET, $_POST, $_SERVER);
        };

        $container['session'] = function() {
            return new Session();
        };

        $container['log'] = function() {
            return new Logger('log');
        };

        $this->di = $container;
    }
}
