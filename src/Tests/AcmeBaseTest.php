<?php
namespace Acme\Tests;

use Acme\Http\Session;
use PDO;


abstract class AcmeBaseTest extends \PHPUnit_Extensions_Database_TestCase {

    protected $bootstrapResources;
    protected $dbAdapter;
    protected $bootstrap;
    protected $conn;

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
        $conn = $this->getConnection();
        $conn->getConnection()->query("set foreign_key_checks=0");
        parent::setUp();
        $conn->getConnection()->query("set foreign_key_checks=1");
    }
}
