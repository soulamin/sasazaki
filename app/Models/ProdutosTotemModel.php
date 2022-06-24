<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutosTotemModel extends Model 
{ 
    protected $db;

    protected $table = 'produtoxtotem';
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    protected $allowedFields = ["idproduto", "totem_id", "prioridade", "situacao"];
}