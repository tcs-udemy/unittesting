<?php
namespace Acme\Tests;

use Acme\Http\Session;
use Acme\App\Application;
use PDO;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv;

/**
 * Class AcmeBaseTest
 * @package Acme\Tests
 */
abstract class AcmeBaseTest extends \PHPUnit_Extensions_Database_TestCase {

    /**
     * @var
     */
    public $bootstrapResources;
    /**
     * @var
     */
    public $dbAdapter;
    /**
     * @var
     */
    public $bootstrap;
    /**
     * @var
     */
    public $conn;
    /**
     * @var
     */
    public $session;
    /**
     * @var
     */
    public $app;

    /**
     * Set up test database connnection
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    public function getConnection()
    {
        $db = new PDO(
            "mysql:host=localhost;dbname=acme_test",
            "vagrant", "secret");

        return $this->createDefaultDBConnection($db, "acme_test");
    }

    /**
     * Load data into schema
     * @return \PHPUnit_Extensions_Database_DataSet_MysqlXmlDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . "/acme_db.xml");
    }

    /**
     * Set up app
     */
    public function setUp()
    {
        require __DIR__ . '/../../vendor/autoload.php';
        require __DIR__ . '/../../bootstrap/functions.php';
        Dotenv::load(__DIR__ . '/../../');

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acme_test',
            'username'  => 'vagrant',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        include __DIR__ . "/../../bootstrap/functions.php";
        $this->app = new Application();
    }

}
