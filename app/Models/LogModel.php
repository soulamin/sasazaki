<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model 
{
    protected $db;

    protected $table = 'logprocessos';
    protected $primaryKey = "id";

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    protected $allowedFields = ["id", "tipo", "descricao"];
}