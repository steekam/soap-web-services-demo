<?php

namespace App;

use PDO;

class Database
{
    private $pdo;
    private static $instance = null;

    private function __constructor() {}

    static function get_instance(): self
    {
        if(self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function connect(): PDO
    {
        if($this->pdo == null) {
            $this->pdo = new PDO("sqlite:".BASE_PATH."/database.sqlite");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }
}
