<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Request;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Analytics extends ResourceController
{
    use ResponseTrait;
    protected $format    = 'json';   
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function setSession() {
        try {
            $request = \Config\Services::request();
            
            $newSession = [
                "sessao" => $request->getVar("sessao"),
                "datainicio" => $request->getVar("datainicio"),
                "datatermino" => $request->getVar("datatermino"),
                "totem_id" => $request->getVar("totem_id"),
                "qrcode" => $request->getVar("qrcode")
            ];
            $builder = $this->db->table('sessao');
            $builder->insert((array)$newSession);
            
        } catch (Exception $e){
            throw $e->getMessage();
        }
    }

    public function setAnalyticsProdutos() {
        try {
            $request = \Config\Services::request();
            
            $newSession = [
                "totem_id" => $request->getVar("totem_id"),
                "codigoproduto" => $request->getVar("codigoproduto"),
                "sessao" => $request->getVar("sessao"),
                "nome" => $request->getVar("nome"),
                "imagem" => $request->getVar("imagem"),
                "datacadastro" => $request->getVar("datacadastro")
            ];
            $builder = $this->db->table('analytics_produto');
            $builder->insert((array)$newSession);
            
        } catch (Exception $e){
            throw $e->getMessage();
        }
    }
   
    public function getTotalizadores() {
        $db = \Config\Database::connect();
        $builder = $db->table('analytcsprodutoview');
        
        $itemsProdutos = $builder->getWhere()->getResult();
        return $this->respond($itemsProdutos);
    }
   
    public function getSessaoDash() {
        $db = \Config\Database::connect();
        $builder = $db->table('sessaoview');
        
        $itemsSessao = $builder->getWhere()->getResult();
        return $this->respond($itemsSessao);
    }
}