<?php
namespace Acme\Tests;

use Acme\Http\Session;
use Acme\App\Application;
use PDO;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv;

abstract class AcmeBaseTest extends \PHPUnit_Extensions_Database_TestCase {

    public $bootstrapResources;
    public $dbAdapter;
    public $bootstrap;
    public $conn;
    public $session;
    public $app;

    public function getConnection() {
        $db = new PDO(
            "mysql:host=localhost;dbname=acme_test",
            "vagrant", "secret");
        return $this->createDefaultDBConnection($db, "acme_test");
    }

    public function getDataSet() {
        return $this->createMySQLXMLDataSet( __DIR__ . "/acme_db.xml");
    }

    public function setUp()
    {
        require __DIR__.'/../../vendor/autoload.php';
        require __DIR__.'/../../bootstrap/functions.php';
        Dotenv::load(__DIR__.'/../../');

//        $this->conn = $this->getConnection();
//        parent::setUp();

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'acme_test',
            'username' => 'vagrant',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        include __DIR__ . "/../../bootstrap/functions.php";
        $this->app = new Application();

    }
}
