<?php

namespace App\Controllers;

use App\Models\BannersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class ImportarBanner extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';
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
        try {

            $result = $this->validatePermission();

            if (!$result["success"]) {
                return $this->failUnauthorized('Unauthorized', 401, $result["message"]);
            }

            $model = new BannersModel();
            $data = $model->querySql("
            SELECT a.* FROM totem_tem_baners t 
                LEFT JOIN baners a
                    ON  a.id = t.fk_baner_id
                WHERE t.fk_totem_id = :totem:", ["totem" => $totem]);
            
            return $this->respond($data);
        } catch(Exception $e) {
            var_dump($e);
        }
    }
}