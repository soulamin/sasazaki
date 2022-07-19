<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../fontes/conexao.php';
session_start();
$acao = $_POST['acao'];

switch ($acao) {

    case 'Salva_Toten':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Loja = $_POST['txt_nomeloja'];
        $Responsavel = $_POST['txt_nomeresponsavel'];
        $Endereco = $_POST['txt_endereco'];
        $Municipio = $_POST['txt_municipio'];
        $Consultor = $_POST['txt_consultor'];
        $Segundo = $_POST['txt_segundos'];
        $Tipo = $_POST['txt_tipo'];
        $Revenda = $_POST['txt_revenda'];
        $Pbshop = $_POST['txt_pbshop'];
        $Engenharia = $_POST['txt_engenharia'];
        $Exportacao = $_POST['txt_exportacao'];
        $Status = "a";//ativo
    


        if ((!empty($Responsavel)) && (!empty($Endereco)) && (!empty($Loja))) {

            $sql_insert = "INSERT INTO  totens (nome_da_loja,nome_responsavel,endereco,fk_municipio_id,status)
                                                                                VALUES
                                               (:nome_da_loja,:nome_responsavel,:endereco,:fk_municipio_id,:status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':nome_da_loja', $Loja);
            $statement->bindParam(':nome_responsavel', $Responsavel);
            $statement->bindParam(':endereco', $Endereco);
            $statement->bindParam(':fk_municipio_id', $Municipio);
            $statement->bindParam(':fk_consultor_id', $Consultor);
            $statement->bindParam(':status', $Status);
           

            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                // Definimos a mensagem de sucesso
                $cod_error = 0;
                $msg = "Cadastro Realizado com Sucesso!";
            } else {
                $cod_error = 1;
                $msg ="erro no cadastro";
            }
        } else {

            $cod_error = 1;
            $msg = "Existe(m) Campo(s) Vazio(s). Por favor preencher!";
        }

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;


    case 'Altera_Toten':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idToten = $_POST['atxt_idToten'];
        $email = $_POST['atxt_email'];
        $login = $_POST['atxt_login'];
        $senha = password_hash($_POST['atxt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['atxt_tipo'];


        if ((!empty($login)) && (!empty($email)) && (!empty($email))) {

            $sql_update = "UPDATE  totens SET login = :login ,email = :email , WHERE id = :idToten";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idToten', $idToten);
            $statement->bindParam(':nome', $Nome);
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':celular',  $Celular);
            $statement->bindParam(':email',  $email);


            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                // Definimos a mensagem de sucesso
                $cod_error = 0;
                $msg = 'Cadastro Realizado com Sucesso!';
            } else {
                $cod_error = '1';
                $msg = 'Falha ao Realizar Cadastro';
            }
        } else {

            $cod_error = '1';
            $msg = 'Existe(m) Campo(s) Vazio(s). Por favor preencher!';
        }

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;

    case 'Busca_Toten':

        $stmt = $pdo->prepare('SELECT * FROM totens');
        $executa = $stmt->execute();
        $Totens = array();

        while ($linha = $stmt->fetch()) {

               //verifica status
                if ($linha['status'] == 'a') {

                    $status = '<span class="badge badge-success">Ativo</span>';
                    //botao Desativar
                    $botaoeditar = '<a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['totem_id'] . '"  href="#">
                    <i class="fa fa-pencil"> Editar </i> 
                    </a>';

                    //botao editar
                      $botaodesativar = '<a class="dropdown-item" id="btnDesativar"  codigo ="' . $linha['totem_id'] . '"  href="#">
                    <i class="fa fa-trash"> Desativar </i> 
                    </a>';

                } else {

                    $status = '<span class="badge badge-danger">Desativado</span>';
                    //botao Desativar
                    $botaodesativar = '';

                     //botao Desativar
                     $botaoeditar = '<a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['totem_id'] . '"  href="#">
                     <i class="fa fa-pencil"> Editar </i> 
                     </a>';
                }
                
          $idmunicipio = $linha['fk_municipio_id'];
           

            $stmtmu = $pdo->prepare('SELECT *  FROM municipio WHERE id =:id');
            $stmtmu->bindParam(":id", $idmunicipio );
            $stmtmu->execute();
            if($l = $stmtmu->fetch()){
                $municipio = $l['nome'].'-'.$l['uf'];
            }else{
                $municipio = "";
            }
            $botao =   '<div class="btn-group">
                            <button type="button" class="btn btn-warning btn-sm">Ação</button>
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                            ' . $botaoeditar . '
                            ' . $botaodesativar . '
                            </div>
                        </div>';

         

            $t = array('Id' => $linha['totem_id'],'Loja' => $linha['nome_da_loja'], 'Responsavel' => $linha['nome_responsavel'], 
                       'Endereco' => $linha['endereco'], 'Municipio' => $municipio,'Status' => $status, 'Html_Acao' => $botao);
            array_push($Totens, $t);
        }

        $Resultado['Html'] = $Totens;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Toten':

        $Toten = $_POST['txt_codigo'];
        $stmt = $pdo->prepare('SELECT * FROM totens  WHERE totem_id = :Toten');
        $stmt->bindParam(':Toten', $Toten);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Toten = array(
                'Codigo' => $linha['totem_id'], 'Loja' => $linha['nome_da_loja'], 'Responsavel' => $linha['nome_responsavel'],
                'Endereco' => $linha['endereco'], 'Municipio' => $linha['fk_municipio_id'], 'Consultor' => $linha['fk_consultor_id'],
                'Segundos' => $linha['segundos_away'],'Revenda' => $linha['cv_revenda'],'Shop' => $linha['cvpbshop'],
                'Engenharia' => $linha['cv_engenharia'],'Exportacao' => $linha['cv_exportacao']
            );
        }
        $Resultado['Html'] = $Toten;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Toten':

        $idToten = $_POST['idToten'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE totens SET status = :status  WHERE totem_id = :idToten";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idToten', $idToten);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;

    case 'Combobox_Municipio' :

            $statement = $pdo->prepare('SELECT * FROM municipio');
            $statement->execute();
            $Municipio = array();
            $m = '';
            array_push($Municipio, $m);
            while ($linhas = $statement->fetch()) {
    
                $m = '<option value="' . $linhas['id']. '" >'.$linhas['nome'].'-'.$linhas['uf'].'</option>';
                array_push($Municipio, $m);
            }
            $resultado['Html'] = $Municipio;
            echo json_encode($resultado);
    
        break ;

        case 'Combobox_Totem' :

            $statement = $pdo->prepare('SELECT * FROM totens WHERE status ="a"');
            $statement->execute();
            $Totem = array();
            $t = '';
            while ($linhas = $statement->fetch()) {
    
                $t = '<option value="' . $linhas['totem_id']. '" >'.$linhas['nome_da_loja'].'</option>';
                array_push($Totem, $t);
            }
            $resultado['Html'] = $Totem;
            echo json_encode($resultado);
    
        break ;
    
}
