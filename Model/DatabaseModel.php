<?php

namespace Model;

use Config\Connect;

class DatabaseModel {
    protected $pdo;

    public function __construct ($pdo)
    {
        $this->pdo = Connect::connection();
    }
}