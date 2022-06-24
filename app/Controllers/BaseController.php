<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	public $totem_id = 1;
	protected $totem;
	protected $totem_sql = '';
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];


	protected $data = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		$this->totem_id = intval(file_get_contents(__DIR__."\..\..\id.txt", true));
		parent::initController($request, $response, $logger);
		//DEFINE DE ONDE PEGAR IMAGENS
		$this->data['locale'] = $this->request->getLocale();
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('baners');
        $this->data['footer_baner'] = $builder->where('posicao','rodapé')->orderBy('ordem')->where('posicao','cabeçalho')->join('totem_tem_baners','fk_baner_id  = id','left')->where('fk_totem_id',$this->totem_id)->groupStart()->where('data_expiracao IS NULL' , null)->orWhere('data_expiracao <=' , 'CURDATE()')->groupEnd()->get()->getResult();
        $this->data['baners'] = $builder->where('posicao','cabeçalho')->orderBy('ordem')->where('posicao','cabeçalho')->join('totem_tem_baners','fk_baner_id  = id','left')->where('fk_totem_id',$this->totem_id)->groupStart()->where('data_expiracao IS NULL' , null)->orWhere('data_expiracao <=' , 'CURDATE()')->groupEnd()->get()->getResult();
        $builder = $db->table('lojas');
        $this->totem = $builder->where('totem_id',$this->totem_id)->limit(1)->get()->getRow();
        $this->data['cronometro']  = $this->totem->segundos_away;
        $this->data['totem_tipo']  = $this->totem->tipo;

        if($this->data['totem_tipo'] == 'website')
        	$this->data['url_fonte_imgs'] = 'http://www.portobello.com.br';
    	else
        	$this->data['url_fonte_imgs'] = base_url('uploads');

        $this->data['totem_id']  = $this->totem_id;
        $totem_sql = [];
		if($this->totem->cv_revenda == 'Y')
			$totem_sql[] = "cv_revenda = 'Y'";
		if($this->totem->cv_pbshop == 'Y')
			$totem_sql[] = "cv_portobello_shop = 'Y'";
		if($this->totem->cv_engenharia == 'Y')
			$totem_sql[] = "cv_engenharia = 'Y'";
		if($this->totem->cv_exportacao == 'Y')
			$totem_sql[] = "cv_exportacao = 'Y'";
		if(sizeof($totem_sql)>0){
			$this->totem_sql = '('.implode(' OR ', $totem_sql).')';
		}

		$item = $db->query("SELECT DATE_FORMAT(dataatualizacao, '%d/%m/%Y') dataatualizacao from atualizacao order by dataatualizacao desc")->getRow();

		$this->data['dataatualizacao'] = $item->dataatualizacao == null ? date('d/m/Y') : $item->dataatualizacao;
	}
}
