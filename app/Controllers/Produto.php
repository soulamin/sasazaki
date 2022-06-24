<?php

namespace App\Controllers;

class Produto extends BaseController
{ 
	public function index()
	{
	}
	public function linha($tipo = '')
	{
        $db = \Config\Database::connect();
        helper('text');
        if(!empty($_GET['ambiente']) && is_numeric($_GET['ambiente'])) {
        	$builder = $db->table('ambientes_n3');
			$query = $builder->select("N3_id, N1_Uso_N2, N2_id, N3, coeficiente_atrito_molhado, local_uso, pei, absorcao_agua, resistencia_manchas, res_ata_quimico_alta, res_ata_quimico_baixa, expansao_por_umidade")
				->where('N3_id' , $_GET['ambiente'])
				->get();
			$ambiente =	$query->getRow();
			if(!empty($ambiente)) {
				$this->data['ambiente'] = $ambiente;
				$crumbs = explode(' - ', $ambiente->N1_Uso_N2);
				$builder = $db->table('produtos');
        		$builder->where($this->totem_sql,null);
				$builder->select('*, REPLACE(lancamento, "N", 0) as lancamento_ord')
						->join('group_images', 'produtos.groupColor = group_images.id', 'left')
						->where('groupColor' , $tipo);
				$coeficiente_atrito_molhado = $ambiente->coeficiente_atrito_molhado;

				if(strlen($coeficiente_atrito_molhado) > 0){
					$builder->groupStart();
					$builder->where('atrito_molhado_iso >=' , $coeficiente_atrito_molhado);
					if($crumbs[0]=='Parede')
						$builder->orWhere('atrito_molhado_iso is NULL');
					$builder->groupEnd();
				}

				//if(strlen($ambiente->local_uso) > 0){
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
					else if($ambiente->res_ata_quimico_alta == 'HB'){
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
							$builder->orWhere('ataque_qui_alta_conc' , NULL);
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
							$builder->orWhere('ataque_qui_baixa_conc' , NULL);
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
				
				$builder->where('enableforrevenda=true');
							
        	}
        }
        else {
	        $builder = $db->table('produtos');
        	$builder->where($this->totem_sql,null);
			$builder->select('*, REPLACE(lancamento, "N", 0) as lancamento_ord')
					->where('groupColor' , $tipo)
					->where('enableforrevenda=true')
					->join('group_images', 'produtos.groupColor = group_images.id', 'left');
        }
		$query = $builder
					->orderBy('lancamento_ord', 'desc')
					->orderBy('desc_produto')
					->get();
			//var_dump($db->getLastQuery());die;
 		$this->data['materiais'] = $query->getResultArray();
 		$this->data['env_images'] = [];
 		foreach ($this->data['materiais'] as $value) {
 			$this->data['env_images'] = array_merge($this->data['env_images'], $this->_environmentImages($value['cod_produto'], $value['sufixo']));
 			if(sizeof($this->data['env_images']) > 4)
 				break;
 		}
 			//var_dump($this->data['env_images']);

	    echo view('header', $this->data);
 		if (!empty($this->data['env_images'])) 
	    	echo view('sliderProduto', $this->data);
 		else
	    	echo view('slider', $this->data);
	    echo view('groupcolors_todos', $this->data);
		echo view('footer', $this->data);
	}
	public function codigo($cod_produto, $sufixo)
	{
        $db = \Config\Database::connect();
        helper('text');
        if(!empty($_GET['ambiente']) && is_numeric($_GET['ambiente'])) {
        	$builder = $db->table('ambientes_n3');
			$query = $builder->select("N3_id, N1_Uso_N2, N2_id, N3, coeficiente_atrito_molhado, local_uso, pei, absorcao_agua, resistencia_manchas, res_ata_quimico_alta, res_ata_quimico_baixa, expansao_por_umidade")
				->where('N3_id' , $_GET['ambiente'])
				->get();
			//var_dump($db->getLastQuery());
			$ambiente =	$query->getRow();
			if(!empty($ambiente)) 
				$this->data['ambiente'] = $ambiente;
		}
        $builder = $db->table('produtos');
        $builder->where($this->totem_sql,null);
		$builder->where("cod_produto" , $cod_produto)->limit(1);
		if(!empty($sufixo))
			$builder->where("sufixo" , $sufixo);
        /*
		$builder->select("`produtos`.*, `related_images`.*")
				->join('related_images', "produtos.cod_produto = related_images.cod_produto", 'left')
				->where("`produtos`.cod_produto" , $cod_produto)
				->limit(1);
		if(!empty($sufixo))
			$builder->where("`produtos`.sufixo" , $sufixo);
		*/
		$query = $builder->get();
		//var_dump($db->getLastQuery());
		
 		$this->data['produto'] = $query->getResultArray();
 		$this->data['env_images'] = $this->_environmentImages($cod_produto, $sufixo);
 		$this->data['rel_images'] = $this->_related_images_landscape($cod_produto, $sufixo);
 		//var_dump($this->data['env_images']);
	    echo view('header', $this->data);
	    echo view('sliderProduto', $this->data);
	    echo view('produto', $this->data);
	    echo view('footer', $this->data);
	}
	private function _environmentImages($cod_produto, $sufixo = '')
	{
        $db = \Config\Database::connect();
        $builder = $db->table('environment_images')
        	->where("cod_produto" , $cod_produto)
        	->where("sufixo" , $sufixo)
        	->get();
        return $builder->getResultArray();
	}
	private function _related_images_landscape($cod_produto, $sufixo = '')
	{
        $db = \Config\Database::connect();
        $builder = $db->table('related_images_landscape')
        	->where("cod_produto" , $cod_produto)
        	->where("sufixo" , $sufixo)
        	->get();
        return $builder->getResultArray();
	}
	public function ajaxSearch()
	{
		if(!empty($_GET['term'])) {
        	$db = \Config\Database::connect();
			$array = [];
			if($_GET['term'] == 'atualizarbd' OR $_GET['term'] == 'ATUALIZARBD') {
				$sql = base_url('portobello.sql');
				$templine = '';
			    // Read in entire file
			    $lines = file($sql);
			    foreach($lines as $line) {
			        // Skip it if it's a comment
			        if (substr($line, 0, 2) == '--' || $line == '')
			            continue;

			        // Add this line to the current templine we are creating
			        $templine.=$line;

			        // If it has a semicolon at the end, it's the end of the query so can process this templine
			        if (substr(trim($line), -1, 1) == ';') {
			            // Perform the query
			            $db->query($templine);
			            // Reset temp variable to empty
			            $templine = '';
			        }
			    }
				$array[] = [
					'value' => 'oi',
					'label' => base_url('portobello.sql')
				];	

			}
			if(is_numeric(substr($_GET['term'],0,5))) {
		        $builder = $db->table('produtos');
		        $builder->where($this->totem_sql,null);
				$query = $builder->select(['id','groupColor','cod_produto','linha','desc_produto','sufixo'])->like("cod_produto" , $_GET['term'])->orlike("linha" , $_GET['term'])->limit(10)->where('enableforrevenda=true')->groupBy('desc_produto')->orderBy('cod_produto')->get()->getResultArray();
			}
			else {
		        $builder = $db->table('produtos');
		        $builder->where($this->totem_sql,null);
				$query = $builder->select(['id','groupColor','cod_produto','linha','desc_produto','sufixo'])->like("desc_produto" , $_GET['term'])->orlike("linha" , $_GET['term'])->where('enableforrevenda=true')->limit(10)->groupBy('desc_produto')->orderBy('desc_produto')->get()->getResultArray();
			}
			//var_dump($db->getLastQuery());
			if(!empty($query)){
				foreach ($query as $prod) {
					$array[] = [
						'value' => $prod['groupColor'],
						'label' => $prod['cod_produto'].' '.$prod['sufixo'].' / '.$prod['linha'].' - '.$prod['desc_produto']
					];					
				}
			}
			//var_dump($array);
			if(isset ($_GET['callback']))
			{
			    header("Content-Type: application/json");
			    echo $_GET['callback']."(".json_encode($array).")";
			}
		}
	}
}
