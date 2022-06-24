<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use ResourceBundle;

class ImportarMateriais extends ResourceController 
{
    use ResponseTrait;
    
    protected $format = 'json';
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function importarMateriais() {
        $builder = $this->db->table('materiais');

        $materiais = $builder->get()->getResult();

        return $this->respond($materiais);
    }
}