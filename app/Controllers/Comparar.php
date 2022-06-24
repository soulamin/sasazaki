<?php

namespace App\Controllers;

class Comparar extends BaseController
{ 
	public function index()
	{
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        $cont = 0;
        if (!empty($_POST['produtos'])) {
			$builder->select("`produtos`.*");
			foreach ($_POST['produtos'] as $favorito) {
				$codigo = explode('/', $favorito);
				$sufixo = '';
				if(sizeof($codigo) > 1)
					$sufixo = $codigo[1];
				$codigo = $codigo[0];
				if($cont++){
					$builder->orGroupStart()
					->where("`produtos`.cod_produto" , $codigo)
					->where("`produtos`.sufixo" , $sufixo)
					->groupEnd();
				}
				else{
					$builder->groupStart()
					->where("`produtos`.cod_produto" , $codigo)
					->where("`produtos`.sufixo" , $sufixo)
					->groupEnd();
				}
			}	
			$query = $builder->get();
	 		$this->data['produtos'] = $query->getResultArray();
        }	
	    echo view('header', $this->data);
	    echo view('comparar', $this->data);
	    echo view('footer', $this->data);
	}
}
