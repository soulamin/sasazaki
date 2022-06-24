<?php

/**
 * Created by PhpStorm.
 * User: ALAN
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';

session_start();
$acao = $_POST['acao'];

switch ($acao) {

    case 'Salva_Pessoa':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $cnpjcpf = $_POST['txt_cnpjcpf'];
        $apelido = $_POST['txt_apelido'];
        $razaosocial = $_POST['txt_razaosocial'];
        $inscestadual = $_POST['txt_inscestadual'];
        $inscmunicipal = $_POST['txt_inscmunicipal'];
        $cep = str_replace('-',"",$_POST['txt_cep']);
        $endereco = $_POST['txt_endereco'];
        $numero = $_POST['txt_numero'];
        $compl = $_POST['txt_complemento'];
        $cidade = $_POST['txt_cidade'];
        $bairro = $_POST['txt_bairro'];
        $uf = $_POST['txt_uf'];
        $wpp = $_POST['txt_wpp'];
        $celular = $_POST['txt_celular'];
        $email = $_POST['txt_email'];
        $obs = $_POST['txt_obs'];
        $Status = 1;
        $tiposervico =  $_POST['tiposervico'];


        if ((!empty($apelido)) && (!empty($razaosocial))) {

            //Caso queira altera a senha do usuario

           
            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('INSERT INTO  pessoa (apelido,razaosocial,endereco,numero,compl,bairro,cidade,
                                                             uf,cep,cnpj_cpf,inscestadual,inscmunicipal,telefone,
                                                             email,wpp,obs,status)
                                                             VALUES
                                                             (:apelido,:razaosocial,:endereco,:numero,:compl,:bairro,:cidade,
                                                             :uf,:cep,:cnpj_cpf,:inscestadual,:inscmunicipal,:telefone,
                                                             :email,:wpp,:obs,:status)');
            $statement->bindParam(':apelido', $apelido);
            $statement->bindParam(':razaosocial', $razaosocial);
            $statement->bindParam(':endereco', $endereco);
            $statement->bindParam(':numero', $numero);
            $statement->bindParam(':compl', $compl);
            $statement->bindParam(':bairro', $bairro);
            $statement->bindParam(':cidade', $cidade);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':uf', $uf);
            $statement->bindParam(':cep', $cep);
            $statement->bindParam(':cnpj_cpf', $cnpjcpf);
            $statement->bindParam(':inscestadual', $inscestadual);
            $statement->bindParam(':inscmunicipal', $inscmunicipal);
            $statement->bindParam(':telefone', $celular);
            $statement->bindParam(':wpp', $wpp);
            $statement->bindParam(':obs', $obs);
            $statement->bindParam(':status', $Status);
         


            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                $idpessoa = $pdo->lastInsertId();
                foreach($tiposervico as $tp){
                    // Prepara uma senten�a para ser executada
                   $st = $pdo->prepare('INSERT INTO  tipopessoa_pessoa (id_tipopessoa,id_pessoa) 
                                                                      VALUES
                                                                         (:id_tipopessoa,:id_pessoa)');
                    $st->bindParam(':id_tipopessoa', $tp);
                    $st->bindParam(':id_pessoa', $idpessoa);
                    $st->execute();

                }

                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                       <h4><i class='icon fa fa-check'></i>
                            Cadastro Realizado com Sucesso! </h4></div>";
            } else {
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                   <h4><i class='icon fa fa-ban'></i> Usuário já Cadastro!  </h4>
                   </div>";
            }
        } else {

            $Cod_Error = '1';
            $Html = "<div class='alert alert-danger disable alert-dismissable'>
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                   <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
                   </div>";
        }

        $resultado['Cod_Error'] = $Cod_Error;
        $resultado['Html'] = $Html;
        echo json_encode($resultado);

        break;

        case 'Altera_Pessoa':

            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $idpessoa = $_POST['atxt_idpessoa'];
            $cnpjcpf = $_POST['atxt_cnpjcpf'];
            $apelido = $_POST['atxt_apelido'];
            $razaosocial = $_POST['atxt_razaosocial'];
            $inscestadual = $_POST['atxt_inscestadual'];
            $inscmunicipal = $_POST['atxt_inscmunicipal'];
            $cep = str_replace('-',"",$_POST['atxt_cep']);
            $endereco = $_POST['atxt_endereco'];
            $numero = $_POST['atxt_numero'];
            $compl = $_POST['atxt_complemento'];
            $cidade = $_POST['atxt_cidade'];
            $bairro = $_POST['atxt_bairro'];
            $uf = $_POST['atxt_uf'];
            $wpp = $_POST['atxt_wpp'];
            $celular = $_POST['atxt_celular'];
            $email = $_POST['atxt_email'];
            $obs = $_POST['atxt_obs'];
            $tiposervico =  $_POST['atiposervico'];
    
    
            if ((!empty($apelido)) && (!empty($razaosocial))) {
    
                //Caso queira altera a senha do usuario
    
               
                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('UPDATE  pessoa SET apelido=:apelido,razaosocial=:razaosocial,endereco=:endereco,
                                                                 numero=:numero,compl=:compl,bairro=:bairro,cidade=:cidade,
                                                                 uf=:uf,cep=:cep,cnpj_cpf=:cnpj_cpf,inscestadual=:inscestadual,
                                                                 inscmunicipal=:inscmunicipal,telefone=:telefone,
                                                                 email=:email,wpp=:wpp,obs=:obs WHERE idpessoa =:idpessoa ' );
                $statement->bindParam(':apelido', $apelido);
                $statement->bindParam(':razaosocial', $razaosocial);
                $statement->bindParam(':endereco', $endereco);
                $statement->bindParam(':numero', $numero);
                $statement->bindParam(':compl', $compl);
                $statement->bindParam(':bairro', $bairro);
                $statement->bindParam(':cidade', $cidade);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':uf', $uf);
                $statement->bindParam(':cep', $cep);
                $statement->bindParam(':cnpj_cpf', $cnpjcpf);
                $statement->bindParam(':inscestadual', $inscestadual);
                $statement->bindParam(':inscmunicipal', $inscmunicipal);
                $statement->bindParam(':telefone', $celular);
                $statement->bindParam(':wpp', $wpp);
                $statement->bindParam(':obs', $obs);
                $statement->bindParam(':idpessoa', $idpessoa);
             
    
    
                // Executa a senten�a j� com os valores
                if ($statement->execute()) {
                  
                    foreach($tiposervico as $tp){
                        // Prepara uma senten�a para ser executada
                       $st = $pdo->prepare('INSERT INTO  tipopessoa_pessoa (id_tipopessoa,id_pessoa) 
                                                                          VALUES
                                                                             (:id_tipopessoa,:id_pessoa)');
                        $st->bindParam(':id_tipopessoa', $tp);
                        $st->bindParam(':id_pessoa', $idpessoa);
                        $st->execute();
    
                    }
    
                    // Definimos a mensagem de sucesso
                    $Cod_Error = 0;
                    $Html = "<div class='alert alert-success'>
                           <h4><i class='icon fa fa-check'></i>
                                Cadastro Realizado com Sucesso! </h4></div>";
                } else {
                    $Cod_Error = '1';
                    $Html = "<div class='alert alert-danger disable alert-dismissable'>
                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                       <h4><i class='icon fa fa-ban'></i> Usuário já Cadastro!  </h4>
                       </div>";
                }
            } else {
    
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                       <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
                       </div>";
            }
    
            $resultado['Cod_Error'] = $Cod_Error;
            $resultado['Html'] = $Html;
            echo json_encode($resultado);
    
            break;
   

    
         
    case 'Busca_Pessoas_Tabela':


        $stmt = $pdo->prepare('SELECT *  FROM pessoa ');
        $executa = $stmt->execute();
        $Usuarios = array();

        while ($linha = $stmt->fetch()) {

            $botao =   '<div class="btn-group">
                    <button type="button" class="btn btn-warning">Ação</button>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" id="btnExcluir"  codigo ="' . $linha['idpessoa'] . '"  href="#">
                      <i class="fa fa-trash"> Excluir </i> </a>
                      <a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['idpessoa'] . '"  href="#">
                      <i class="fa fa-pencil"> Editar </i> </a>
                    </div>
                  </div>';


          

            if ($linha['status'] == '1') {
                $Status = '<span class="badge badge-success">Ativo</span>';
            } else {

                $Status = '<span class="badge badge-danger">Desativado</span>';
            }

            $st = $pdo->prepare('SELECT b.nome as Tipo FROM tipopessoa_pessoa a
                                      INNER JOIN tipopessoa b on b.idtipopessoa = a.id_tipopessoa 
                                      WHERE a.id_pessoa = :idpessoa ');
            $st->bindParam(':idpessoa',$linha['idpessoa']);
            $st->execute();
            $tiposervico="";
             while($l=$st->fetch()){
                $tiposervico .= '<p class="btn btn-sm btn-warning">'.$l['Tipo'].'</p> ';
             }

            $U = array('Apelido' => $linha['apelido'], 'Razao' => $linha['razaosocial'],  'Tipo' => $tiposervico, 'Status' => $Status, 'Html_Acao' => $botao);
            array_push($Usuarios, $U);
        }

        $Resultado['Html'] = $Usuarios;
        echo json_encode($Resultado);

        break;

    case 'Busca_Pessoa_Formulario':
        $idpessoa = $_POST['Cod_Pessoa'];
        $stmt = $pdo->prepare('SELECT * FROM pessoa  WHERE idpessoa LIKE :idpessoa');
        $stmt->bindParam(':idpessoa', $idpessoa);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $usuario = array(
                 'Apelido' => $linha['apelido'], 'RazaoSocial' => $linha['razaosocial'], 'Endereco' => $linha['endereco'],
                 'Numero' => $linha['numero'], 'Compl' => $linha['compl'], 'Bairro' => $linha['bairro'], 'Email' => $linha['email'],
                 'Cidade' => $linha['cidade'], 'Inscestadual' => $linha['inscestadual'], 'Inscmunicipal' => $linha['inscmunicipal'],
                 'Uf' => $linha['uf'], 'Codigo' => $linha['idpessoa'], 'Telefone' => $linha['telefone'],'Wpp' => $linha['wpp'],
                 'Obs' => $linha['obs'], 'cnpj_cpf' => $linha['cnpj_cpf'], 'cep' => $linha['cep'],
            );
        }
        $Resultado['Html'] = $usuario;
        echo json_encode($Resultado);
        break;

    case 'Exclui_Usuario':

        $Cod_Usuario = $_POST['Cod_Usuario'];
        $stmt = $pdo->prepare('UPDATE usuarios SET STATUS = 0  WHERE IDUSUARIO= :Cod_Usuario');
        $stmt->bindParam(':Cod_Usuario', $Cod_Usuario);
        if ($stmt->execute()) {

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

    case 'Exclui_PlacaUsuario':

        $Cod_PlacaUsuario = $_POST['Cod_PlacaUsuario'];
        $stmt = $pdo->prepare('UPDATE placausuario SET STATUS = 0  WHERE IDPLACAUSUARIO= :Cod_PlacaUsuario');
        $stmt->bindParam(':Cod_PlacaUsuario', $Cod_PlacaUsuario);
        if ($stmt->execute()) {

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;


    case 'Salva_PlacaUsuario':

        $IdUsuario = $_POST['Id_Usuario'];
        $Placa = $_POST['Placa'];
        $Status = 1;

        $sts = $pdo->prepare('SELECT COUNT(ID_USUARIO) AS QTD FROM placausuario WHERE PLACA=:placa AND ID_USUARIO=:idusuario');
        $sts->bindParam(':idusuario', $IdUsuario);
        $sts->bindParam(':placa', $Placa);
        $sts->execute();
        $linhas = $sts->fetch();

        if ($linhas['QTD'] == 0) {
            $st = $pdo->prepare('INSERT INTO placausuario (PLACA,ID_USUARIO,STATUS) VALUES (:placa,:idusuario ,:status)');
            $st->bindParam(':idusuario', $IdUsuario);
            $st->bindParam(':placa', $Placa);
            $st->bindParam(':status', $Status);
            // Definimos a mensagem de sucesso
            if ($st->execute()) {
                $Cod_Error = 0;
            }
        } else {
            $Cod_Error = 1;
        }

        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

        case 'UsuarioToken':

        $IdUsuario = $_SESSION['ID_USUARIO'];
        $Status = 1;
        $sts = $pdo->prepare('SELECT  * FROM token WHERE STATUS=:status AND ID_USUARIO=:idusuario');
        $sts->bindParam(':idusuario', $IdUsuario);
        $sts->bindParam(':status', $Status);
        $sts->execute();
        $Token ='';
        if($sts->rowCount()>=1){
            while($linhas = $sts->fetch()){
            $Token .= '<option value="'.$linhas["IDTOKEN"].'">CARTÃO FINAL '.$linhas["CARTAO"].'- VAL.'.$linhas["VAL"].' </option>';
            }
            $Cod_Error = 0;
        }
        else {
            $Cod_Error = 1;
        }
        $Token .= '<option value="#">Novo Cartão </option>';

        $Resultado['Html'] = $Token;
        echo json_encode($Resultado);

        break;


    case 'Resetar_Senha':

        $Cod_Usuario = $_POST['Cod_Usuario'];
        $Senha = md5(12345);
        $stmt = $pdo->prepare('UPDATE usuarios SET SENHA =:senha  WHERE IDUSUARIO= :Cod_Usuario');
        $stmt->bindParam(':Cod_Usuario', $Cod_Usuario);
        $stmt->bindParam(':senha', $Senha);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

    case 'Combobox_Fiscal':

        $statement = $pdo->prepare('SELECT * FROM usuarios WHERE STATUS = 1 AND NIVEL IN("G" ,"F") ORDER BY NOME ASC');
        $statement->execute();

        $r = '<option value="0" >SELECIONE GUARDADOR</option>';
        while ($linhas = $statement->fetch()) {

            $r .= '<option value="' . $linhas['IDUSUARIO'] . '" >' . $linhas['NOME'] . '</option>';
        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;

    case 'MinhasPlacas':
        $Id_Usuario = $_SESSION['ID_USUARIO'];
        $statement = $pdo->prepare('SELECT P.PLACA ,P.IDPLACAUSUARIO FROM   placausuario P WHERE P.ID_USUARIO =:idusuario AND P.STATUS = 1');
        $statement->bindParam(':idusuario', $Id_Usuario);
        $statement->execute();

        $r = '';

        while ($linhas = $statement->fetch()) {

            $r .= '<div class="col-md-3 col-sm-6">
                     <div class="small-box bg-gray">
                            <div class="inner text-center">
                            <h3>' . $linhas['PLACA'] . '</h3>
                            </div>
                           <a href="#" class="small-box-footer btnExcluirPlacaUsuario text-danger" codigo ="' . $linhas['IDPLACAUSUARIO'] . '">Excluir <i class="fa fa-trash "></i></a>
                       </div>
                    </div>';
        }

        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;


    case 'Combobox_Operador':
        
        $statement = $pdo->prepare("SELECT p.* FROM pessoa p
                                      INNER JOIN tipopessoa_pessoa tp ON tp.id_pessoa=p.idpessoa 
                                      INNER JOIN tipopessoa t ON tp.id_tipopessoa=t.idtipopessoa
                                      WHERE t.sigla like 'op'");
        $statement->execute();

        $r = '<option value="#" >SELECIONE OPERADOR...</option>';

        while ($linhas = $statement->fetch()) {
          
            $r .= '<option value="' . $linhas['idpessoa'] . '" >' . $linhas['apelido'] . '</option>';
        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;
        case 'Combobox_Vendedor':
        
            $statement = $pdo->prepare("SELECT p.* FROM pessoa p
                                          INNER JOIN tipopessoa_pessoa tp ON tp.id_pessoa=p.idpessoa 
                                          INNER JOIN tipopessoa t ON tp.id_tipopessoa=t.idtipopessoa
                                          WHERE t.sigla like 'vd' ");
            $statement->execute();
    
            $r = '<option value="#" >SELECIONE VENDEDOR...</option>';
    
            while ($linhas = $statement->fetch()) {
              
                $r .= '<option value="' . $linhas['idpessoa'] . '" >' . $linhas['apelido'] . '</option>';
            }
            $resultado['Html'] = $r;
            echo json_encode($resultado);
    
            break;
    /* 
/* 
    case 'EsqueciaSenha':

        $NovaSenha = substr(md5(date('YdHis')),0,5);
        $Email = trim($_POST['Email']);
        $statement = $pdo->prepare('SELECT  IDUSUARIO,NOME , LOGIN FROM usuarios WHERE EMAIL =:email AND NIVEL = "U" AND STATUS = 1');
        $statement->bindParam(':email', $Email);
        $statement->execute();
        if($statement->rowCount() >= 1){
           $LinhaEmail= $statement->fetch();
           
             $Nome =   $LinhaEmail['NOME'];
             $Login =  $LinhaEmail['LOGIN'];
                $st1 = $pdo->prepare('UPDATE usuarios SET SENHA = :senha WHERE NIVEL = "U" AND EMAIL = :email');
                $st1->bindParam(':email', $Email);
                $st1->bindParam(':senha', md5($NovaSenha));
                $st1->execute();
                EnviaEmail($Nome,$Email,$Login,$NovaSenha) ;
                $Cod_Error='0'; 
                $Html = "<div class='alert alert-warning disable alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-exclamation'></i> 'Foi enviado um Email com seu Usuário e Senha Cadastrado'  </h4>
                </div>";
        }else{
                $Cod_Error='1';
                $Html = "<div class='alert alert-info disable alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-exclamation'></i> Não Encontramos esse Email cadastrado.  </h4>
                </div>";
        }
        $resultado['Html'] =  $Html;
        $resultado['Cod_Error'] =  $Cod_Error;
        echo json_encode($resultado);

        break; */
}
