<?php 

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\LogModel;
use App\Models\ProdutosModel;
use App\Models\ProdutosTotemModel;
use Exception;

$GLOBALS['campoImg'] = 'imagem';
$GLOBALS['subpasta'] = '';
//$GLOBALS['upload_folder'] = WRITEPATH . '..\\public\\uploads\\';
$GLOBALS['upload_folder'] = WRITEPATH . '../uploads/';

//^(\s\s\s\s"en)[\s\S]+?(?=("simulatedProduct"))
class Admin extends AdminController
{
    public function requestGetData($request) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $request,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function index() {
       
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        else {
            // header('Location: '.base_url('admin/produtos'));
            header('Location: '.base_url('admin/inicio'));
            exit;
        }
    }
    

    public function inicio($mensagem = null) {        
            
        $db = \Config\Database::connect();
        $builder = $db->query("SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(datatermino, datainicio))) / COUNT(id)),'%H:%i:%s') diferenca,  
                                COUNT(id) total FROM sessao")->getRow();

        $permissoes = ["permissoes" => $this->getPermissoes($this->session->idpermissao), 
            'mensagem' => $mensagem, 
            'title' => 'Tela Inicial',
            'usuario' => $this->session->email,
            'tempoMedio' => $builder->diferenca,
            'total' => $builder->total
        ]; 

        return view('telainicial', $permissoes);
    }

    private function _templateOutput($output = null) {
        
        $permissoes = ["permissoes" => $this->getPermissoes($this->session->idpermissao), 
            'output' => $output,
            'usuario' => $this->session->email
        ];
        
        return view('admin', $permissoes);
    }
    public function login()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        helper(['form', 'url']);
        
        $validation->setRules([
            'email' => 'required|valid_email',
            'senha' => 'required'
        ]);
        if($validation->withRequest($request)->run()){
            $senha = $request->getVar('senha', FILTER_SANITIZE_STRING);
            $email = $request->getVar('email', FILTER_SANITIZE_EMAIL);
            
            $db = \Config\Database::connect();
            $builder = $db->table('usuarios');
            $row = $builder->getWhere([
                'email' => $email
            ])->getRow();

            if(isset($row) && password_verify($senha, $row->senha)) {
                $permissoes = $this->getPermissoes($row->idpermissao);
                $sessao = [
                    'usuario_id'  => $row->id,
                    'login'  => $row->login,
                    'email'     => $row->email,
                    'role'     => $row->role,
                    'idpermissao' => $row->idpermissao,
                    'permissoes' => $permissoes,
                    'logged_in' => true
                ];
                $this->session->set($sessao);
                // header('Location: '.base_url('admin/produtos'));
                header('Location: '.base_url('admin/inicio'));
                exit;
            }
            else {
                $dados = [
                    'email' => $request->getVar('email'),
                    'senha' =>  $request->getVar('senha'),
                    'validation' => $validation,
                    'dadosNaoBatem' => true
                ];
                echo view('login', $dados);
            }
        }
        else {            
            $dados = [
                'email' => $request->getVar('email'),
                'senha' =>  $request->getVar('senha'),
                'validation' => $validation,
                'dadosNaoBatem' => false
            ];
            echo view('login', $dados);
        }
    }
    public function getPermissoes($idPermissao) {
        $db = \Config\Database::connect();
        $builder = $db->table('permissaoxfuncao');
        $permissoes = $builder->getWhere([
            'idpermissao' => $idPermissao
        ])->getResult();
        
        $arrayPermissao = [];

        foreach($permissoes as $permissao) {
            $tableFuncao = $db->table('funcao');
            $funcao = $tableFuncao->getWhere(['id' => $permissao->idfuncao])->getRow();
            
            array_push($arrayPermissao, $funcao);
        }
        
        return $arrayPermissao;
    }

    public function validaPermissao($funcao) {
        $permissoes = $this->getPermissoes($this->session->idpermissao);
        $arrayPermissions = [];

        foreach($permissoes as $permissao) {
            array_push($arrayPermissions, $permissao->funcao);
        }
        
        if (in_array($funcao, $arrayPermissions)) {
            return true;
        }
        return false;
    }

    public function logoff() {
        $this->session->destroy();
        return redirect()->to('admin/login');
    }
    public function ambientes_aplicacoes() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('ambientes_aplicacoes');
        $crud->setSubject('Ambiente Aplicação');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function ambientes_usos() {
        if (!$this->validaPermissao('FN_CADAMBIENTEUSO')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADAMBIENTEUSO'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('ambientes_uso');
        $crud->setSubject('Ambiente Uso');
        $crud->setRelation('N1_id','ambientes_n1','N1_nome');
        $crud->unsetFields(['N1','N1_Uso']);
        //$crud = $this->_uploadField($crud,'ambientes');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function ambientes_n1() {
        if (!$this->validaPermissao('FN_CADAMBIENTEN1')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADAMBIENTEN1'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('ambientes_n1');
        $crud->setSubject('Ambiente N1');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function ambientes_n2() {
        if (!$this->validaPermissao('FN_CADAMBIENTEN2')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADAMBIENTEN2'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('ambientes_n2');
        $crud->setSubject('Ambiente N2');
        $crud = $this->_uploadField($crud,'ambientes','N2_imagem');
        $crud->setRelation('Uso_id','ambientes_uso','N1_Uso');
        // $crud->setRelation('N1_id','ambientes_n1','N1_nome');
        $crud->unsetFields(['N1_Uso_N2','N1_Uso']);
        $crud->fieldType('N2_Aparece_Totem', 'dropdown', [
            'SIM' => 'SIM',
            'NÃO' => 'NÃO'
        ]);
        //$crud = $this->_uploadField($crud,'ambientes');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function ambientes_n3() {
        if (!$this->validaPermissao('FN_CADAMBIENTEN3')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADAMBIENTEN3'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('ambientes_n3');
        $crud->setSubject('Ambiente N3');
        $crud->setRelation('N2_id','ambientes_n2','N1_Uso_N2');
        $crud->setRelation('Uso_id','ambientes_uso','N1_Uso');
        $crud->setRelation('N1_id','ambientes_n1','N1_nome');
        $crud->fieldType('PisoTotem', 'dropdown', [
            'SIM' => 'SIM',
            'NÃO' => 'NÃO'
        ]);
        $crud->fieldType('ParedeTotem', 'dropdown', [
            'SIM' => 'SIM',
            'NÃO' => 'NÃO'
        ]);
        $crud = $this->_uploadField($crud,'ambientes');
        $crud->unsetFields(['N1_Uso_N2']);
        $output = $crud->render();

        return $this->_templateOutput($output);
    }

    public function getBannersTotem() {
        $db = \Config\Database::connect();
        $items = [];
        if ($this->session->role == 'admin') {
            return '';

        } else {

            $builder = $db->table('usuarioxlojas');
            $itemsUsuarios = $builder->getWhere([
                'idusuario' => $this->session->usuario_id
                ])->getResult();
            
            foreach($itemsUsuarios as $item) {
                array_push($items, $item->totem_id);
            }
        }
        $arr = [];
        foreach($items as $item) { 
            array_push($arr, "id = ".$item);
        }
        $query = implode(" OR ", $arr);

        return "(".$query.")";
    }

    public function baners() {
        if (!$this->validaPermissao('FN_CADBANNER')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADBANNER'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();        
        $crud->setTable('baners');
        $crud->setSubject('Baner');     
        $query = $this->getBannersTotem();
        if ($query != '')
            $crud->where($query);
        $crud->unsetDelete();
        $crud = $this->_uploadField($crud,'baners');
        $query = $this->getTotensUsuario("lojas.totem_id");
        $crud->setRelation('totem_id', 'lojas', '{totem_id} - {nome_da_loja}', $query);
        
        $output = $crud->render();
        return $this->_templateOutput($output);
    }
    public function consultor() {
        if (!$this->validaPermissao('FN_CADCONSULTOR')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADCONSULTOR'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('consultor');
        $crud->setSubject('Consultor');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function group_images() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('group_images');
        $crud->setSubject('Group Image');
        $crud->columns(['id','mainImage','environmentImages']);
        $output = $crud->render();

        return $this->_templateOutput($output);
    }  


    public function totens() {
        if (!$this->validaPermissao('FN_CADTOTEN')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $query = $this->getTotensUsuario("lojas.totem_id");
        if ($this->session->role != 'admin') {
            $crud->unsetAdd();
        }

        $crud->setTable('lojas');
        $crud->setSubject('Totem');
        $crud->where("(".$query.")");
        $crud->columns(['totem_id','nome_da_loja','nome_responsavel','endereco','fk_municipio_id','fk_consultor_id']);
        $crud->displayAs('fk_municipio_id', 'Município');
        $crud->displayAs('fk_consultor_id', 'Consultor(a)');
        $crud->requiredFields(['nome_da_loja','nome_responsavel','endereco','fk_municipio_id','fk_consultor_id']);
        //$crud->setPrimaryKey('cod_produto', 'produtos');
                            //nome label, tabelaNtoN, tabela_N2, tabela_N1_id, tabela_N2_id, nomes bonitos);
       // $crud->setRelationNtoN('fora_de_estoque', 'estoque', 'produtos', 'loja_id', 'cod_produto', '{produtos.cod_produto}{sufixo} - {linha} {desc_produto}');
        $crud->setRelation('fk_municipio_id','municipio','{nome} - {uf}');
        $crud->setRelation('fk_consultor_id','consultor','{consultor_nome} - {consultor_telefone} - {consultor_email}');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function estoque() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('estoque');
        $crud->setSubject('Estoque');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function materiais() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('materiais');
        $crud->setSubject('Material');
        $crud->setRule('slug', 'Slug', 'alpha_dash');
        if($this->request->getFile($GLOBALS['campoImg'])) 
            $crud->setRule('imagem', 'Imagem', 'uploaded[imagem]|max_size[imagem,4096]|is_image[imagem]');
        //$subpasta = 'materiais';
       //$campo = 'imagem';
        
        $crud = $this->_uploadField($crud,'materiais');

        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function adicionarProdutoTotem($totem) {
        $db = \Config\Database::connect();
        $builder = $db->table('produtos');
        
        $produtos = $builder->getWhere()->getResult();

        $prodTotem = new ProdutosTotemModel();
        $prodTotem->where('totem_id', $totem)->delete();
        
        foreach($produtos as $produto) {
            $prodTotem->insert(["idproduto" => $produto->id, "totem_id" => $totem, "prioridade" => 0, "situacao" => 1]);
        }
    }
    public function getTotensUsuario($column) {
        $db = \Config\Database::connect();
        $items = [];
        if ($this->session->role == 'admin') {
            
            $builder = $db->table('lojas');
            $items = $builder->getWhere()->getResult();
        } else {

            $builder = $db->table('usuarioxlojas');
            $items = $builder->getWhere([
                'idusuario' => $this->session->usuario_id
                ])->getResult();
        }
        $arr = [];
        foreach($items as $usr) { 
            array_push($arr, $column." = ".$usr->totem_id);
        }
        $query = implode(" OR ", $arr);

        return "(".$query.")";
    }
    public function importar_agora() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        
        $query = $this->getTotensUsuario("lojas.totem_id");
        
        $crud = new GroceryCrud();
        $crud->setTable('atualizacao_totem');    
        
        $crud->setSubject('Atualização de Totem');
        $crud->setRelation('totem_id', "lojas", "nome_da_loja", "(".$query.")");
        $crud->displayAs("totem_id", "Atualizar os Totens");
        $crud->unsetFields(['data_cadastro', 'data_atualizacao', "id"]);
        $crud->fieldType('situacao', 'hidden');
        
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data['situacao'] = 0;
            
            return $stateParameters;
        });

        $crud->callbackAfterInsert(function ($stateParameters) {
            $this->adicionarProdutoTotem($stateParameters->data['totem_id']);
            return $stateParameters;
        });

        $output = $crud->render();

        return $this->_templateOutput($output);
    }

    public function importar_produtos() {
        $return = json_decode($this->requestGetData("http://34.203.87.184:3000/products"));

        $db = \Config\Database::connect();
        $builder = $db->table('produtos');

        foreach($return as $item) {

            $produto = $builder->getWhere([
                    'cod_produto' => $item->cod_produto
                ])->getRow();

            if ($produto == null) {
                $this->insertProduct($item);
            } else {
                $this->updateProduct($item, $produto);
            }
        }
        $builderAtualizacao = $db->table('atualizacao');
        $newAtualizacao = [
            "dataatualizacao" => date('Y-m-d H:i:s')
        ];

        $builderAtualizacao->insert((array)$newAtualizacao);
        return redirect()->to('admin/importar_agora');
    }

    public function insertProduct($produto) {
        try {

            $crud = new ProdutosModel();
            $return = $crud->insert((array)$produto);
            
            echo "Produto Cadastrado ";
        }
        catch (Exception $e) {
            $log = new LogModel();
            $erro = ["message" => $e->getMessage(), "item" => $produto];
            $data = [
                "tipo" => 1,
                "descricao" => json_encode($erro)
            ];

            $log->insert($data);
        }
    }
    public function updateProduct($item, $produto) {
        try {

            $crud = new ProdutosModel();
            $produto->last_update_date = date('Y-m-d');

            $return = $crud->update($produto->cod_produto, (array)$item);
            
            echo "Produto Atualizado";
        }
        catch (Exception $e) {
            $log = new LogModel();
            $erro = ["message" => $e->getMessage(), "item" => $produto];
            $data = [
                "tipo" => 1,
                "descricao" => json_encode($erro)
            ];

            $log->insert($data);
        }
    }

    public function inativarItem() {
        $permissoes = [
            "permissoes" => $this->getPermissoes($this->session->idpermissao), 
            'mensagem' => 'Aguarde enquanto inativamos o item.', 
            'title' => 'Ativar/Desativar'];

        $request = \Config\Services::request();
        $builder = new ProdutosTotemModel();
        $prod = $builder->getWhere([
                "id" => $request->getVar('produtototem', FILTER_SANITIZE_STRING) 
            ])->getRow();
        if ($prod->situacao == 1) {
            $prod->situacao = 0;
            $builder->update($prod->id, $prod);
        } else {
            $prod->situacao = 1;
            $builder->update($prod->id, $prod);
        }

        echo view('telainicial', $permissoes);
        header('Location: '.base_url('admin/produtos'));
        exit;
    }
    public function produtos($request = '') {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        
        // if ($this->session->role == 'admin') {
        //     $crud->setTable('produtos');
        // } else {
        $crud->unsetEdit();
        $crud->unsetAdd();
        $crud->setTable('produtoview');
        
        $query = $this->getTotensUsuario("totem_id");
            
        $crud->where("(".$query.")");
        $crud->setPrimaryKey('id');
        $crud->unsetColumns(['totem_id']);
        $crud->unsetFields(["loja", 'totem_id', 'Situacao', 'id']); 
        // }

        $crud->setSubject('Produto');
        $crud->unsetDelete();               

        $crud->setActionButton('Ativar/Ina.', 'fa fa-eye', function($row, $item) {
            if (!isset($item->idprodutototem))
                return ;
            
            return "inativarItem?produtototem=".$item->idprodutototem;
        }, false);
        
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function related() {        
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('related_images');
        $crud->setSubject('Imagem Related');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function usuarios() {
        if (!$this->validaPermissao('FN_CADUSUARIO')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADUSUARIO'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('usuarios');
        $crud->setSubject('Usuário');
        $crud->fieldType('senha', 'password');
        $crud->unsetFields(['role']);
        $crud->unsetColumns(['role', 'senha']);
        $crud->setRelationNtoN('lojas', 'usuarioxlojas', 'lojas', 'idusuario', 'totem_id', '{nome_da_loja}');
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data['senha'] = password_hash($stateParameters->data['senha'], PASSWORD_DEFAULT);
            return $stateParameters;
        });
        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $stateParameters->data['senha'] = password_hash($stateParameters->data['senha'], PASSWORD_DEFAULT);
            return $stateParameters;
        });
        $crud->setRelation('idpermissao','permissoes','nome');
        $crud->displayAs('idpermissao', 'Papel');
        

        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    public function papeis() {
        if (!$this->validaPermissao('FN_CADPAPEL')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADPAPEL'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('permissoes');
        $crud->setSubject('Papéis');
        $crud->setRelationNtoN('funções', 'permissaoxfuncao', 'funcao', 'idpermissao', 'idfuncao', '{id} - {nome}');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    
    public function funcionalidades() {
        if (!$this->validaPermissao('FN_CADFUNCIONALIDADE')) {
            return $this->inicio('Você não tem permissão para acessar esta funcionalidade.');
        }
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true && $this->validaPermissao('FN_CADFUNCIONALIDADE'))
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('funcao');
        $crud->setSubject('Funcionalidades');
        
        $output = $crud->render();

        return $this->_templateOutput($output);
    }
    
    public function related_landscape() {
        if(!isset($this->session->logged_in) && !$this->session->logged_in == true)
            return redirect()->to('admin/login');
        $crud = new GroceryCrud();
        $crud->setTable('related-images-landscapes');
        $crud->setSubject('Imagem Landscape');
        $output = $crud->render();

        return $this->_templateOutput($output);
    }

    private function _uploadField($crud,$subpasta = '',$campo = 'imagem') {
        if ($campo) $GLOBALS['campoImg'] = $campo;
        if ($subpasta) $GLOBALS['subpasta'] = $subpasta;
        //var_dump($GLOBALS['upload_folder'] . $GLOBALS['subpasta']);
        // Oerride the default upload field ...
        $crud->callbackAddField (
          $GLOBALS['campoImg'],
          function () {
            return '<input id="field-'.$GLOBALS['campoImg'].'" type="file" class="form-control" name="'.$GLOBALS['campoImg'].'" value="">';
          }
        );
        $crud->callbackEditField(
          $GLOBALS['campoImg'],
          function ($fieldValue, $primaryKeyValue, $rowData) {
            return '<input id="field-'.$GLOBALS['campoImg'].'" type="file" class="form-control" name="'.$GLOBALS['campoImg'].'" value=""><br><img height="250" src="'.base_url('uploads/' . $GLOBALS['subpasta']) .'/'. $fieldValue.'">';
          }
        );
        $crud->callbackBeforeInsert (function ($uploadData) {
            $toUpload = $this->request->getFile($GLOBALS['campoImg']);
            $toUpload->move($GLOBALS['upload_folder'] . $GLOBALS['subpasta'] );
            $uploadData->data[$GLOBALS['campoImg']] = $toUpload->getName();
            return $uploadData;
        });
        $crud->callbackBeforeUpdate (function ($uploadData) {
            if($this->request->getFile($GLOBALS['campoImg'])) {
                $toUpload = $this->request->getFile($GLOBALS['campoImg']);
                $toUpload->move($GLOBALS['upload_folder'] . $GLOBALS['subpasta'] );
                $uploadData->data[$GLOBALS['campoImg']] = $toUpload->getName();
            } else {
                unset($uploadData->data[$GLOBALS['campoImg']]);
            }
            return $uploadData;
        });

        return $crud;
    }
}
