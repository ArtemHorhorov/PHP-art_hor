<?php

namespace myclasses;

use PDO;
use PDOException;

class Db
{
    private $db;

    public function __construct()
    {
        $this->dbConnect();
    }

    public function getDbConnect()
    {
        $this->dbConnect();
        return $this->db;
    }

    private function dbConnect()
    {
        if ($this->db === null) {
            try {
                $this->db = new PDO('mysql:host=localhost;dbname=tmp', 'root', '', array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ));
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
            }
        }
    }
}