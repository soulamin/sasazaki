<?php

namespace App\Controllers;

use App\Models\ProdutosModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

class ImportarProduto extends ResourceController
{
    use ResponseTrait;
    protected $format    = 'json';   
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function validatePermission()
    {
        $headers = service('request');
        $auth = $headers->getHeader('Authorization');
        
        if ($auth != "Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c") {
            return ["success" => false, "message" => "Você não tem permissão para atualizar"];
        }

        return ["success" => true, "message" => ""];
    }

    public function getList($totem) {
        $result = $this->validatePermission();

        if (!$result["success"]) {
            return $this->failUnauthorized('Unauthorized', 401, $result["message"]);
        }
        $db = \Config\Database::connect();
        
        $atualTotem = $db->query("Select 
                * 
            from atualizacao_totem 
            where situacao = 0 and totem_id = :totem: order by data_cadastro desc limit 1", ["totem" => $totem])->getRow();
        
        if ($atualTotem == null) {
            return $this->respond(array("lista" => 0, "data" => []));
        }

        $model = new ProdutosModel();
        $data = $model->querySql("
            SELECT p.situacao, a.* FROM produtoxtotem p
                LEFT JOIN produtos a
                ON a.id = p.idproduto
                LEFT JOIN lojas b
                ON b.totem_id = p.totem_id
            WHERE p.situacao = 1 and p.totem_id = :totem:", ["totem" => $totem]);
        $return = array(
            "lista" => $atualTotem->id,
            "data" => $data
        );
        return $this->respond($return);
    }

    public function atualizandoLista($lista) {
        $result = $this->validatePermission();

        if (!$result["success"]) {
            return $this->failUnauthorized('Unauthorized', 401, $result["message"]);
        }
        
        $db = \Config\Database::connect();
        $date = date("Y-m-d H:i:s");
        $db->query("update atualizacao_totem 
                    set situacao = 1, data_atualizacao = :data:
                where id = :lista:", ["lista" => $lista, "data" => $date]);
        return $this->respond("retornando");
    }

    public function importarGroupImages() {
        $builder = $this->db->table('group_images');
        $items = $builder->get()->getResult();

        return $this->respond($items);
    }
   
}