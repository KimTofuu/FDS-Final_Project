<?php
require_once __DIR__ . '/../composerDep/vlucas/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

class ConnectionFinProj{
    protected $con_string;
    protected $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function  __construct(){
        $this->con_string = "mysql:host=" . $_ENV['SERVER'] . ";dbname=" . $_ENV['DBASE'] . ";charset=utf8mb4";
    }
    public function connect()
    {
        try {
            return new \PDO($this->con_string, $_ENV['USER'], $_ENV['PASSWORD'], $this->options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
