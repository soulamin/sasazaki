<?php

namespace App\Controllers;

class Favoritos extends BaseController
{ 
	public function index()
	{
        //$session = \Config\Services::session();
		helper('text');
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        $builder2 = $db->table('ambientes_n3');
        helper(['form', 'url']);
        $cont = 0;
        $contAmbiente = 0;
        //var_dump($_SESSION['favoritos']);
        if (!empty($_SESSION['favoritos'])) {
			$builder->select("`produtos`.*, `related_images_landscape`.relatedImageLandscape")
				->join('related_images_landscape', "produtos.cod_produto = related_images_landscape.cod_produto", 'left');
			$builder2->select("N3_id, N1_Uso_N2, N2_id, N3, coeficiente_atrito_molhado, local_uso, pei, absorcao_agua, resistencia_manchas, res_ata_quimico_alta, res_ata_quimico_baixa, expansao_por_umidade");
			foreach ($_SESSION['favoritos'] as $favorito) {
				//var_dump($favorito);
				if($cont++){
					if(strlen($favorito["sufixo"]) > 0 && strlen($favorito["sufixo"]) < 4){
						$builder->orGroupStart()
						->where("`produtos`.cod_produto" , $favorito["cod_produto"])
						->where("`produtos`.sufixo" , $favorito["sufixo"])
						->groupEnd();
					}
					else
						$builder->orWhere("`produtos`.cod_produto" , $favorito["cod_produto"]);
				}
				else{
					if(strlen($favorito["sufixo"]) > 0 && strlen($favorito["sufixo"]) < 4){
						$builder->groupStart()
						->where("`produtos`.cod_produto" , $favorito["cod_produto"])
						->where("`produtos`.sufixo" , $favorito["sufixo"])
						->groupEnd();
					}
					else
						$builder->where("`produtos`.cod_produto" , $favorito["cod_produto"]);
				}
				if(strlen($favorito["jornada"]) > 0 && is_numeric($favorito["jornada"]))
				{
					if($contAmbiente++)
						$builder2->orWhere('N3_id' , $favorito["jornada"]);
					else
						$builder2->where('N3_id' , $favorito["jornada"]);
				}
				
			}
			if($contAmbiente) {
				$query2 = $builder2->get();
				$this->data['ambientes'] =  $query2->getResultArray();
			}
			
			$query = $builder->get();
			//var_dump($db->getLastQuery());
			//var_dump('--------------------');
	 		$this->data['materiais'] = $query->getResultArray();
			//var_dump($this->data['materiais']);	
        }	
	    echo view('header', $this->data);
	    echo view('favoritos', $this->data);
	    echo view('footer', $this->data);
	}
	public function adicionar($cod_produto = '', $sufixo = '')
	{
        //$session = \Config\Services::session();
		$ja_inserido = false;
		$ambiente_id = '';
        if(!empty($_GET['ambiente']) && is_numeric($_GET['ambiente'])) {
        	$ambiente_id = $_GET['ambiente'];
        }
 		if(!empty($_SESSION['favoritos'])) {
	          foreach ($_SESSION['favoritos'] as $key => $value) {
	            if($_SESSION['favoritos'][$key]['cod_produto'] == $cod_produto)
	            if($_SESSION['favoritos'][$key]['sufixo'] == $sufixo) {
	              if(!empty($ambiente_id) && ($_SESSION['favoritos'][$key]['jornada'] == $ambiente_id)) {   
	                $ja_inserido = true;
	                $this->index();
	              }
	              elseif(empty($ambiente_id) && $_SESSION['favoritos'][$key]['jornada'] == '') {
	                $ja_inserido = true;
	                $this->index();
	              }
	            }
	          }
		}
		if(!$ja_inserido) {			
	        $db = \Config\Database::connect();
	        $builder = $db->table('produtos');
			$builder->select("cod_produto");
				if(is_numeric($cod_produto))
					$builder->where("`produtos`.cod_produto" , $cod_produto);
				if(is_string($sufixo) && (strlen($sufixo) > 0 && strlen($sufixo) <= 3))
					$builder->where("`produtos`.sufixo" , $sufixo);
			$query = $builder->countAllResults();
			//var_dump($db->getLastQuery());
	 		//var_dump($query);
	 		if($query == 1) {
	 			//echo 'entrou';
	 			$arrayFav = [
		 			"cod_produto" => $cod_produto,
		 			"sufixo" => $sufixo,
		 			"jornada" => $ambiente_id
		 		];
		 		//unset($_SESSION['favoritos']);
	 			if(!empty($_SESSION['favoritos'])) {
	 				//echo 'aqui';
			 		$this->session->push('favoritos', [$arrayFav]);
	 			}
			 	else {
	 				//echo 'aqui2';
			 		$_SESSION['favoritos'] = [$arrayFav];
	 				//$this->session->push('favoritos', $arrayFav);
			 	}
		 	}
		    $this->index();
		}
	}
	public function remover($cod_produto = '', $sufixo = '') {
        //$session = \Config\Services::session();
		if(is_numeric($cod_produto)) {
			if(sizeof($_SESSION['favoritos']) == 1)
				$this->session->remove('favoritos');
			else {
				$ambiente_id = '';
		        if(!empty($_GET['ambiente']) && is_numeric($_GET['ambiente'])) {
		        	$ambiente_id = $_GET['ambiente'];
		        }
				$keys = array_keys(array_column($_SESSION['favoritos'], 'cod_produto'), $cod_produto);
				//var_dump($keys);
				foreach ($keys as $key) {
		 			if($_SESSION['favoritos'][$key]['sufixo'] == $sufixo) {
		               	if(!empty($ambiente_id) && $_SESSION['favoritos'][$key]['jornada'] == $ambiente_id)
		               	{
							$ja_inserido = true;
							unset($_SESSION['favoritos'][$key]);
							$_SESSION['favoritos'] = array_values($_SESSION['favoritos']);
							$this->index();
		                }
		                elseif(empty($ambiente_id) && $_SESSION['favoritos'][$key]['jornada'] == '') {
		                    $ja_inserido = true;
							unset($_SESSION['favoritos'][$key]);
							$_SESSION['favoritos'] = array_values($_SESSION['favoritos']);
		                    $this->index();
		                }
		            }
				}
			}
		}
		else
			$this->session->remove('favoritos');
		$this->index();
	}
}
