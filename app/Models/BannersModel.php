<?php 

    namespace App\Models;

use CodeIgniter\Model;

    class BannersModel extends Model 
    {

        protected $db;

        protected $table = 'baners';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $DBgroup = 'default';
        
        public function __construct($group = 'default')
        {
            $this->db = \Config\Database::connect($group);
        }

        public $allowedFields = [
            "titulo", "texto", "posicao", "imagem", "ordem", "data_expiracao"
        ];

        public function querySql($sql, $bindins) {
            return $this->db->query($sql, $bindins)->getResult();
        }
    }