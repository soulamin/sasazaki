<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class ImportarAmbientes extends ResourceController
{
    use ResponseTrait;
    protected $format    = 'json';   

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function importarAmbienteUso() {
        $builder = $this->db->table('ambientes_uso');
        $ambientes = $builder->get()->getResult();

        return $this->respond($ambientes);
    }

    public function importarAmbienteN1() {
        $builder = $this->db->table('ambientes_n1');
        $ambientes = $builder->get()->getResult();

        return $this->respond($ambientes);
    }

    public function importarAmbienteN2() {
        $builder = $this->db->table('ambientes_n2');
        $ambientes = $builder->get()->getResult();

        return $this->respond($ambientes);
    }

    public function importarAmbienteN3() {
        $builder = $this->db->table('ambientes_n3');
        $ambientes = $builder->get()->getResult();

        return $this->respond($ambientes);
    }
}