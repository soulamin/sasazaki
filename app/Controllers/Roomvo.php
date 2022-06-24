<?php

namespace App\Controllers;

class Roomvo extends BaseController
{ 
	public function index()
	{
        //CARREGA VIEWS
	    echo view('header', $this->data);
        echo view('roomvo', $this->data);
	    echo view('footer', $this->data);
	}
}