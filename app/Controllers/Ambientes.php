<?php

namespace App\Controllers;

class Ambientes extends BaseController
{ 
	public function index()
	{
		helper('text');
        $db = \Config\Database::connect();
        if(!empty($_GET['uso']) && !empty($_GET['n1'])) {
			$this->data['uri'] = array(
				'uso' => $_GET['uso'],
				'n1' => $_GET['n1'],
				'home' => false
			);
	        if(!empty($_GET['n2']))
	        	$this->data['uri']['n2'] = $_GET['n2'];
	        else
	        	$this->data['uri']['n2'] = '';
        }
        $builder = $db->table('ambientes_n3');
		$query = $builder->select("ambientes_n3.N2_id, N3_id, Uso_nome, N1, N2_nome, N3, ambiente_3_descricao")
				->where('ambientes_uso.N1' , 'Piso')
				->join('ambientes_uso', 'ambientes_uso.Uso_id = ambientes_n3.Uso_id', 'left')
				->join('ambientes_n2', 'ambientes_n2.N2_id = ambientes_n3.N2_id', 'left')
				->orderBy('ambientes_n3.uso_id, ambientes_n3.N2_id, N3')
				->get();
 		$this->data['pisos'] = $query->getResultArray();
		$query2 = $builder->select("N3_id, Uso_nome, N1, N2_nome, N3, ambiente_3_descricao")
				->where('ambientes_uso.N1' , 'Parede')
				->join('ambientes_uso', 'ambientes_uso.Uso_id = ambientes_n3.Uso_id', 'left')
				->join('ambientes_n2', 'ambientes_n2.N2_id = ambientes_n3.N2_id', 'left')
				->orderBy('ambientes_n3.uso_id, ambientes_n3.N2_id, N3')
				->get();
 		$this->data['paredes'] = $query2->getResultArray();
	    echo view('header', $this->data);
	    echo view('ambientes', $this->data);
	    echo view('footer', $this->data);
	}
	public function id($tipo = '')
	{
		helper('text');
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $builder = $db->table('ambientes_n3');
        if(is_numeric($tipo)) {
			$query = $builder->select("N3_id, N1_Uso_N2, N2_id, N3, coeficiente_atrito_molhado, local_uso, pei, absorcao_agua, resistencia_manchas, res_ata_quimico_alta, res_ata_quimico_baixa, expansao_por_umidade")
				->where('N3_id' , $tipo)
				->get();
			$ambiente =	$query->getRow();
			if(!empty($ambiente)) {
				$this->data['ambiente'] = $ambiente;
				$crumbs = explode(' - ', $ambiente->N1_Uso_N2);
				
				$this->data['uri'] = array(
					'uso' => str_replace(' ', '_',convert_accented_characters($crumbs[1])),
					'n1' => str_replace(' ', '_',convert_accented_characters($crumbs[0])),
					'n2' => $ambiente->N2_id,
					'home' => false
				);
				$builder = $db->table('produtos');
        		$builder->where($this->totem_sql,null);
				$builder->select("*")
						->join('group_images', 'produtos.groupColor = group_images.id', 'left');
				$coeficiente_atrito_molhado = $ambiente->coeficiente_atrito_molhado;
				if(strlen($coeficiente_atrito_molhado) > 0){
					$builder->groupStart();
					$builder->where('atrito_molhado_iso >=' , $coeficiente_atrito_molhado);
					if($crumbs[0]=='Parede')
						$builder->orWhere('atrito_molhado_iso is NULL');
					$builder->groupEnd();
				}

				if(strlen($ambiente->local_uso) > 0){
					$builder->groupStart();
					$builder->like('uso' , $ambiente->local_uso);
					if($crumbs[0]=='Parede')
						$builder->orWhere('uso is NULL');
					$builder->groupEnd();
				}
				/*
				if(strlen($ambiente->pei) > 0)
					$builder->where('res_abra_superficial >=' , $ambiente->pei);
				*/
				if(strlen($ambiente->absorcao_agua) > 0){
					$builder->groupStart();
					$builder->where('absorcao_dagua <=' , $ambiente->absorcao_agua);
					if($crumbs[0]=='Parede')
						$builder->orWhere('absorcao_dagua is NULL');
					$builder->groupEnd();
				}

				if(strlen($ambiente->resistencia_manchas) > 0){
					$builder->groupStart();
					$builder->where('resultado_minimo_manchantes >=' , $ambiente->resistencia_manchas);
					if($crumbs[0]=='Parede')
						$builder->orWhere('resultado_minimo_manchantes is NULL');
					$builder->groupEnd();
				}

				if(strlen($ambiente->res_ata_quimico_alta) > 0) {
					if($ambiente->res_ata_quimico_alta == 'HC'){
						$builder->groupStart()
						->where('ataque_qui_alta_conc' , 'HA')
						->orWhere('ataque_qui_alta_conc' , 'HB')
						->orWhere('ataque_qui_alta_conc' , 'HC');
						if($crumbs[0]=='Parede')
							$builder->orWhere('ataque_qui_alta_conc' , NULL);
						$builder->groupEnd();
				}
				else if($ambiente->res_ata_quimico_alta == 'HB') {
						$builder->groupStart()
							->where('ataque_qui_alta_conc' , 'HB')
							->orWhere('ataque_qui_alta_conc' , 'HA');
							if($crumbs[0]=='Parede')
								$builder->orWhere('ataque_qui_alta_conc' , NULL);
							$builder->groupEnd();
					}
					else if($ambiente->res_ata_quimico_alta == 'HA'){
						$builder->groupStart();
						$builder->where('ataque_qui_alta_conc', 'HA');
						if($crumbs[0]=='Parede')
							$builder->orwhere('ataque_qui_alta_conc', NULL);
						$builder->groupEnd();
					}
				}

				if(strlen($ambiente->res_ata_quimico_baixa) > 0) {
					if($ambiente->res_ata_quimico_baixa == 'LC'){
						$builder->groupStart()
						->where('ataque_qui_baixa_conc' , 'LA')
						->orWhere('ataque_qui_baixa_conc' , 'LB')
						->orWhere('ataque_qui_baixa_conc' , 'LC');
						if($crumbs[0]=='Parede')
							$builder->orWhere('ataque_qui_baixa_conc' , NULL);
						$builder->groupEnd();
					}
					else if($ambiente->res_ata_quimico_baixa == 'LB'){
						$builder->groupStart()
						->where('ataque_qui_baixa_conc' , 'LB')
						->orWhere('ataque_qui_baixa_conc' , 'LA');
						if($crumbs[0]=='Parede')
							$builder->orWhere('ataque_qui_baixa_conc' , NULL);
						$builder->groupEnd();
					}
					else if($ambiente->res_ata_quimico_baixa == 'LA'){
						$builder->groupStart();
						$builder->where('ataque_qui_baixa_conc', 'LA');
						if($crumbs[0]=='Parede')
							$builder->orWhere('ataque_qui_baixa_conc', NULL);
						$builder->groupEnd();
					}
				}

				if(strlen($ambiente->expansao_por_umidade) > 0){
					$builder->groupStart();
					$builder->where('expansao_por_umidade <=' , $ambiente->expansao_por_umidade);
					if($crumbs[0]=='Parede')
						$builder->orWhere('expansao_por_umidade is NULL');
					$builder->groupEnd();
				}
				//$query2 = $builder->get();
				$builder->where('enableforrevenda=true');
				
				$query2 = $builder->groupBy('groupColor')->get();
				//var_dump($db->getLastQuery());die;

				

				//var_dump($db->getLastQuery());
				//var_dump('ugabuga');
		 		$this->data['materiais'] = $query2->getResultArray();
		 		//var_dump(sizeof($this->data['materiais']));
		 		$this->data['N3_id'] = $tipo;
		 		if(empty($this->data['materiais'])) {
					$_SESSION['aviso'] = 'No momento, não temos na loja peças para o ambiente escolhido.';
					$session->markAsFlashdata('aviso');
					$this->data['lastQuery'] = $db->getLastQuery();
		        	$this->index();
		 		}
		 		else {
		 			//var_dump($this->data);
				    echo view('header', $this->data);
	    			echo view('slider', $this->data);
				    //echo view('groupcolors_todos', $this->data);
				    echo view('materiais_todos', $this->data);

				    echo view('footer', $this->data);
			    }
		    }
	        else {
				$_SESSION['aviso'] = 'Id de ambiente inválido.';
				$session->markAsFlashdata('aviso');
	        	$this->index();
	        }
        }
        else {
			$_SESSION['aviso'] = 'Id de ambiente inválido.';
			$session->markAsFlashdata('aviso');
        	$this->index();
        }
	}
	public function pesquisa($uso = 'Residencial',$n1 = 'Piso', $n2 = null, $todos = null) 
	{
		helper('text');
	    echo view('header', $this->data);
        //BANERS
        $db = \Config\Database::connect();
        
	    //ADD BANER
	    echo view('slider', $this->data);
        //AMBIENTES
		$ambienteModel = new \App\Models\AmbienteModel();
		$this->data['uri'] = array(
			'uso' => $uso,
			'n1' => $n1,
			'n2' => $n2,
			'home' => false
		);
        $this->data['n1s'] = $ambienteModel->todos_n1();
        $this->data['usos'] = $ambienteModel->todos_uso(true);
		if(!empty($n2)){
			if(is_numeric($n2)){
				if($todos === 'todos' || $todos === 'Todos'){
					$this->data['ambientes'] = $ambienteModel->N2_por_id($n2,$uso,$n1, true);
			    	echo view('ambientes_slider_n3_todos', $this->data);
			    } 
			    else
			    {
					$this->data['ambientes'] = $ambienteModel->N3_por_N2($n2,$n1);
			    	//echo view('ambientes_slider_n3', $this->data);
			    	echo view('ambientes_slider_n3_todos', $this->data);
			    }
			}
			if($n2 === 'todos' || $n2 === 'Todos'){
	        	$this->data['ambientes'] = $ambienteModel->N2_de_usoN1($uso, $n1, true);
		   		echo view('ambientes_slider_todos', $this->data);
			}
		}
		else {
        	$this->data['ambientes'] = $ambienteModel->N2_de_usoN1($uso,$n1);
	   		echo view('ambientes_slider', $this->data);
		}
	    echo view('footer', $this->data);
	}
}
