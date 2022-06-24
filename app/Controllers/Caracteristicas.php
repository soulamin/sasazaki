<?php

namespace App\Controllers;

class Caracteristicas extends BaseController
{ 
	public function index()
	{
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $db = \Config\Database::connect();
        helper(['form', 'url']);
        $tipologias = $db->table('produtos')->select("tipologia_comercial")->distinct()->get()->getResult();
        $acabamentos = $db->table('produtos')->select("caracteristica_acabamento")->where('caracteristica_acabamento !=' , 'N/A')->distinct()->get()->getResult();
        $bordas = $db->table('produtos')->select("acabamento_de_borda")->where('acabamento_de_borda !=' , 'N/A')->distinct()->get()->getResult();
        $limpezas = $db->table('produtos')->select("resultado_minimo_limpeza")->distinct()->get()->getResult();        
	    $this->data['tipologias'] = $tipologias;
	    $this->data['acabamentos'] = $acabamentos;
	    $this->data['bordas'] = $bordas;
	    $this->data['limpezas'] = $limpezas;

	    //var_dump($tipologias);
	    echo view('header', $this->data);
	    //echo view('slider', $this->data);
	    echo view('caracteristicas', $this->data);
	    echo view('footer', $this->data);
	}
	public function pesquisa()
	{
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $session = \Config\Services::session();
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        $builder->where($this->totem_sql,null);
		$builder->select('*, REPLACE(lancamento, "N", 0) as lancamento_ord')
				->groupBy('desc_produto')
				->join('group_images', 'produtos.groupColor = group_images.id', 'left');

		//$coeficiente_atrito_molhado = $request->getVar('coeficiente_atrito_molhado');
		//if(strlen($coeficiente_atrito_molhado) > 0)
		//	$builder->where('atrito_molhado_iso >=' , $coeficiente_atrito_molhado);

		if(!empty($request->getVar('coeficiente_atrito_molhado'))){
			$builder->groupStart();
			foreach ($request->getVar('coeficiente_atrito_molhado') as $key => $value) {
			    if ($key === array_key_first($request->getVar('coeficiente_atrito_molhado'))) {
					$builder->where('atrito_molhado_iso' , $value);
			    }
			    else
					$builder->orWhere('atrito_molhado_iso' , $value);
			}
			$builder->groupEnd();
		}

		if(!empty($request->getVar('local_uso'))){
			$builder->groupStart();
			foreach ($request->getVar('local_uso') as $key => $value) {
			    if ($key === array_key_first($request->getVar('local_uso'))) {
					$builder->like('USO' , $value);
			    }
			    else
					$builder->orLike('USO' , $value);
			}
			$builder->groupEnd();
		}

		//if(strlen($request->getVar('pei')) > 0)
			//$builder->where('res_abra_superficial >=' , $request->getVar('pei'));

		if(strlen($request->getVar('absorcao_dagua')) > 0){
			$absorcao = $request->getVar('absorcao_dagua');
			switch ($absorcao) {
				case '0.5':
					$builder->where('absorcao_dagua <' , 0.5);
					break;
				case '3':
					$builder->where('absorcao_dagua <' , 3);
					$builder->where('absorcao_dagua >=' , 0.5);
					break;
				case '6':
					$builder->where('absorcao_dagua <' , 6);
					$builder->where('absorcao_dagua >=' , 3);
					break;
				case '10':
					$builder->where('absorcao_dagua <' , 10);
					$builder->where('absorcao_dagua >=' , 6);
					break;
				case '10+':
					$builder->where('absorcao_dagua >=' , 10);
					break;
			}
		}

		if(strlen($request->getVar('resistencia_manchas')) > 0)
			$builder->where('resultado_minimo_manchantes >=' , $request->getVar('resistencia_manchas'));

		if(strlen($request->getVar('res_ata_quimico_alta')) > 0)
			if($request->getVar('res_ata_quimico_alta') == 'HC')
					$builder->groupStart()
					->where('ataque_qui_alta_conc' , 'HA')
					->orWhere('ataque_qui_alta_conc' , 'HB')
					->orWhere('ataque_qui_alta_conc' , 'HC')
					->groupEnd();
			else if($request->getVar('res_ata_quimico_alta') == 'HB')
					$builder->groupStart()
					->where('ataque_qui_alta_conc' , 'HB')
					->orWhere('ataque_qui_alta_conc' , 'HA')
					->groupEnd();
			else if($request->getVar('res_ata_quimico_alta') == 'HA')
				$builder->where('ataque_qui_alta_conc', 'HA');

		if(strlen($request->getVar('res_ata_quimico_baixa')) > 0)
			if($request->getVar('res_ata_quimico_baixa') == 'LC')
					$builder->groupStart()
					->where('ataque_qui_alta_conc' , 'LA')
					->orWhere('ataque_qui_alta_conc' , 'LB')
					->orWhere('ataque_qui_alta_conc' , 'LC')
					->groupEnd();
			else if($request->getVar('res_ata_quimico_baixa') == 'LB')
					$builder->groupStart()
					->where('ataque_qui_alta_conc' , 'LB')
					->orWhere('ataque_qui_alta_conc' , 'LA')
					->groupEnd();
			else if($request->getVar('res_ata_quimico_baixa') == 'LA')
				$builder->where('ataque_qui_alta_conc', 'LA');

		if(!empty($request->getVar('resultado_minimo_limpeza'))){
			$builder->groupStart();
			foreach ($request->getVar('resultado_minimo_limpeza') as $key => $value) {
			    if ($key === array_key_first($request->getVar('resultado_minimo_limpeza'))) {
					$builder->like('resultado_minimo_limpeza' , $value);
			    }
			    else
					$builder->orLike('resultado_minimo_limpeza' , $value);
			}
			$builder->groupEnd();
		}

		if(strlen($request->getVar('expansao_por_umidade')) > 0)
			$builder->where('expansao_por_umidade <=' , $request->getVar('expansao_por_umidade'));

		if(!empty($request->getVar('tipologia_comercial'))){
			$builder->groupStart();
			foreach ($request->getVar('tipologia_comercial') as $key => $value) {
			    if ($key === array_key_first($request->getVar('tipologia_comercial'))) {
					$builder->where('tipologia_comercial' , $value);
			    }
			    else
					$builder->orWhere('tipologia_comercial' , $value);
			}
			$builder->groupEnd();
		}

		if(!empty($request->getVar('caracteristica_acabamento'))){
			$builder->groupStart();
			foreach ($request->getVar('caracteristica_acabamento') as $key => $value) {
			    if ($key === array_key_first($request->getVar('caracteristica_acabamento'))) {
					$builder->where('caracteristica_acabamento' , $value);
			    }
			    else
					$builder->orWhere('caracteristica_acabamento' , $value);
			}
			$builder->groupEnd();
		}

		if(!empty($request->getVar('acabamento_de_borda'))){
			$builder->groupStart();
			foreach ($request->getVar('acabamento_de_borda') as $key => $value) {
			    if ($key === array_key_first($request->getVar('acabamento_de_borda'))) {
					$builder->where('acabamento_de_borda' , $value);
			    }
			    else
					$builder->orWhere('acabamento_de_borda' , $value);
			}
			$builder->groupEnd();
		}

		$query = $builder
					->orderBy('lancamento_ord', 'desc')
					->orderBy('linha')
					->orderBy('desc_produto')
					->orderBy('material')
					->get();
		//var_dump($db->getLastQuery());
		$this->data['lastQuery'] = $db->getLastQuery();
 		$this->data['materiais'] = $query->getResultArray();
 		if(empty($this->data['materiais'])) {
	        $this->data['pesquisa_feita'] = $_POST;
			$_SESSION['aviso'] = 'NoResult';
			$session->markAsFlashdata('aviso');
			$this->index();
 		}
 		else {
		    echo view('header', $this->data);
	        $this->data['pesquisa_feita'] = $_POST;
		    echo view('slider', $this->data);
		    //echo view('groupcolors_todos', $this->data);
		    echo view('materiais_todos', $this->data);
		   	echo view('footer', $this->data);
 		}
	}
}
