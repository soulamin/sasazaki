<?php

namespace App\Controllers;

class Home extends BaseController
{ 
	public function index()
	{
		helper('text');
        $db = \Config\Database::connect();
        if(!empty($_GET['uso']) && !empty($_GET['n1'])) {
			$this->data['uri'] = array(
				'uso' => $_GET['uso'],
				'n1' => $_GET['n1'],
				'home' => true
			);
        }
	    else
			$this->data['uri'] = array(
				'uso' => 'Residencial',
				'n1' => 'Piso',
				'home' => true
			);
        //AMBIENTES
		$ambienteModel = new \App\Models\AmbienteModel();
        $this->data['ambientes'] = $ambienteModel->todos_n2();
        $this->data['n1s'] = $ambienteModel->todos_n1();
        $this->data['usos'] = $ambienteModel->todos_uso(true);
        //MATERIAIS
        $builder = $db->table('materiais');
        $this->data['materiais'] = $builder->get()->getResult();
        //CARREGA VIEWS
	    echo view('header', $this->data);
	    echo view('slider', $this->data);
	    echo view('ambientes_slider', $this->data);
	    echo view('material_slider', $this->data);
	    echo view('footer', $this->data);
	}
	public function material($tipo = '')
	{
        $db = \Config\Database::connect();

        
        $builder = $db->table('produtos');
        $builder->where($this->totem_sql,null);
		/*$query = $builder->select("`produtos`.*, `zoom-images`.*")
				->join('zoom-images', "CONCAT(`produtos`.cod_produto,COALESCE(`produtos`.sufixo,'')) = `zoom-images`.code", 'inner')
				->where('material' , $tipo)
				->get();*/

		$builder->select('*, REPLACE(lancamento, "N", 0) as lancamento_ord')
				->where('material' , $tipo)
				->where('enableforrevenda=true')
				->groupBy('desc_produto')
				->join('group_images', 'produtos.groupColor = group_images.id', 'left');
				
		//->groupBy('groupColor')

		$query = $builder
					->orderBy('lancamento_ord', 'desc')
					->orderBy('linha')
					->orderBy('desc_produto')
					->get();

		/*var_dump($db->getLastQuery());*/
					
 		$this->data['materiais'] = $query->getResultArray();
	    echo view('header', $this->data);
	    echo view('slider', $this->data);
	    echo view('materiais_todos', $this->data);
	    echo view('footer', $this->data);
	}
	public function linha($tipo = '')
	{
        $db = \Config\Database::connect();

        
        $builder = $db->table('produtos');
        $builder->where($this->totem_sql,null);
		$query = $builder->select("*")
				->where('groupColor' , $tipo)
				->where('enableforrevenda=true')
				->join('group_images', 'produtos.groupColor = group_images.id', 'left')
				->get();
 		$this->data['materiais'] = $query->getResultArray();
	    echo view('header', $this->data);
	    echo view('slider');
	    echo view('groupcolors_todos', $this->data);
	    echo view('footer', $this->data);
	}
	public function produto($cod_produto = '')
	{
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        $builder->where($this->totem_sql,null);
		$query = $builder->select("`produtos`.*, `zoom-images`.*, `related-images-landscapes`.*")
				->join('zoom-images', "CONCAT(`produtos`.cod_produto,COALESCE(`produtos`.sufixo,'')) = `zoom-images`.code", 'left')
				->join('related-images-landscapes', "produtos.cod_produto = related-images-landscapes.cod_produto", 'left')
				->where("`produtos`.cod_produto" , $cod_produto)
				->where('enableforrevenda=true')
				->get();
				//var_dump($db->getLastQuery());
		
 		$this->data['produto'] = $query->getResultArray();
	    echo view('header', $this->data);
	    echo view('sliderProduto', $this->data);
	    echo view('produto', $this->data);
	    echo view('footer', $this->data);
	    
	}
	public function ambientes($uso = 'Residencial', $n1 = 'Piso')
	{
		helper('text');
        $db = \Config\Database::connect();
		$this->data = [];
		$this->data['uri'] = array(
			'uso' => $uso,
			'n1' => $n1,
			'home' => true
		);
        //AMBIENTES
		$ambienteModel = new \App\Models\AmbienteModel();
        $this->data['ambientes'] = $ambienteModel->todos_n2();
        $this->data['n1s'] = $ambienteModel->todos_n1();
        $this->data['usos'] = $ambienteModel->todos_uso(true);
        //BANERS
        
        //MATERIAIS
        $builder = $db->table('materiais');
        $this->data['materiais'] = $builder->get()->getResult();
        //CARREGA VIEWS
	    echo view('header', $this->data);
	    echo view('slider', $this->data);
	    echo view('ambientes_slider', $this->data);
	    echo view('material_slider', $this->data);
	    echo view('footer', $this->data);
	}
	public function reiniciar($tipo = '')
	{
		$this->session->destroy();
		return redirect()->to('/home');;
	}
	/*
	public function ambiente($tipo = '')
	{
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        $query = $builder->getWhere(['material' => $tipo]);
        $this->data = $query->getResultArray();
	    echo view('header', $this->data);
	    echo view('slider');
	    echo view('ambientes_slider', $this->data);
	    echo view('footer', $this->data);
	}
	*/
}
