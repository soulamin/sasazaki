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

    case 'Salva_GrupoTotens':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Nome = $_POST['txt_nomegrupototens'];
        $Totens = $_POST['txt_listatotem'];
        $Status = "a"; //ativo
        $idusuario = $_SESSION['ID_USUARIO'];
      

        if (!empty($Nome)) {

            $sql_insert = "INSERT INTO  grupototens (nomegrupo,criadopor,status)
                                                                                VALUES
                                                    (:nomegrupo,:criadopor,:status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':nomegrupo', $Nome);
            $statement->bindParam(':criadopor', $idusuario);
            $statement->bindParam(':status', $Status);


            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                $idgrupototem = $pdo->lastInsertId();
                foreach ($Totens as $idtotem) {
                   
                    $sql_insert2 = "INSERT INTO  grupoxtotens (id_grupo,id_totens)
                                                        VALUES
                                                             (:id_grupo,:id_totens)";
                    // Prepara uma senten�a para ser executada                                               
                    $st = $pdo->prepare($sql_insert2);
                    $st->bindParam(':id_grupo', $idgrupototem);
                    $st->bindParam(':id_totens', $idtotem);
                    $st->execute();
                }
                // Definimos a mensagem de sucesso
                $cod_error = 0;
                $msg = "Cadastro Realizado com Sucesso!";
            } else {
                $cod_error = 1;
                $msg = " Usuário já Cadastro!";
            }
        } else {

            $cod_error = 1;
            $msg = "Existe(m) Campo(s) Vazio(s). Por favor preencher!";
        }

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;


    case 'Altera_GrupoTotens':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idToten = $_POST['atxt_idToten'];
        $email = $_POST['atxt_email'];
        $login = $_POST['atxt_login'];
        $senha = password_hash($_POST['atxt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['atxt_tipo'];


        if ((!empty($login)) && (!empty($email)) && (!empty($email))) {

            $sql_update = "UPDATE  Totens SET login = :login ,email = :email , WHERE id = :idToten";

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

    case 'Busca_GrupoToten':

        $stmt = $pdo->prepare('SELECT * FROM grupototens');
        $executa = $stmt->execute();
        $Totens = array();

        while ($linha = $stmt->fetch()) {

            //verifica status
            if ($linha['status'] == 'a') {

                $status = '<span class="badge badge-success">Ativo</span>';
               

                //botao editar
                $botaodesativar = '<a class="dropdown-item" id="btnDesativar"  codigo ="' . $linha['idgrupototens'] . '"  href="#">
                    <i class="fa fa-trash"> Desativar </i> 
                    </a>';
            } else {

                $status = '<span class="badge badge-danger">Desativado</span>';
                //botao Desativar
                $botaodesativar = '';
            }

         //botao Editar
         $botaoeditar = '<a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['idgrupototens'] . '"  href="#">
         <i class="fa fa-pencil"> Editar </i> 
         </a>';
           
            $idgrupototens = $linha['idgrupototens'];

            $stmtmu = $pdo->prepare('SELECT nome_da_loja  FROM grupoxtotens g
                                                   INNER JOIN lojas l ON l.totem_id=g.id_totens WHERE g.id_grupo =:idgrupototens');
            $stmtmu->bindParam(":idgrupototens", $idgrupototens);
            $stmtmu->execute();
            $totens ="";
            while($l = $stmtmu->fetch()) {
             $totens .='<span class="badge badge-dark">'.$l["nome_da_loja"].'</span>'; 
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



            $t = array(
                'NomeGrupo' => $linha['nomegrupo'], 'Totens' => $totens,
                       'Status' => $status, 'Html_Acao' => $botao
            );
            array_push($Totens, $t);
        }

        $Resultado['Html'] = $Totens;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Toten':

        $Toten = $_POST['txt_codigo'];
        $stmt = $pdo->prepare('SELECT * FROM lojas  WHERE totem_id = :Toten');
        $stmt->bindParam(':Toten', $Toten);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Toten = array(
                'Codigo' => $linha['idgrupototens'], 'Nome' => $linha['nomegrupo']
            );
        }
        $Resultado['Html'] = $Toten;
        echo json_encode($Resultado);
        break;

    case 'Desativa_GrupoToten':

        $idgrupototen = $_POST['idgrupototen'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE grupototens SET status = :status  WHERE idgrupototens = :idgrupototens";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idgrupototens', $idgrupototen);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;

    case 'Combobox_Municipio':

        $statement = $pdo->prepare('SELECT * FROM municipio');
        $statement->execute();
        $Municipio = array();
        $m = '';
        array_push($Municipio, $m);
        while ($linhas = $statement->fetch()) {

            $m = '<option value="' . $linhas['id'] . '" >' . $linhas['nome'] . '-' . $linhas['uf'] . '</option>';
            array_push($Municipio, $m);
        }
        $resultado['Html'] = $Municipio;
        echo json_encode($resultado);

        break;
        
        case 'Combobox_GrupoTotens':

            $statement = $pdo->prepare('SELECT * FROM grupototens WHERE status ="a"');
            $statement->execute();
            $GrupoTotens = array();
            $t ="";
            while ($linhas = $statement->fetch()) {
    
                $t = '<option value="' . $linhas['idgrupototens'] . '" >' . $linhas['nomegrupo']. '</option>';
                array_push($GrupoTotens, $t);
            }
            $resultado['Html'] = $GrupoTotens;
            echo json_encode($resultado);
    
            break;

    case 'Combobox_Totem':

        $statement = $pdo->prepare('SELECT * FROM lojas WHERE status ="a"');
        $statement->execute();
        $Totem = array();
        $t = '';
        while ($linhas = $statement->fetch()) {

            $t = '<option value="' . $linhas['totem_id'] . '" >' . $linhas['nome_da_loja'] . '</option>';
            array_push($Totem, $t);
        }
        $resultado['Html'] = $Totem;
        echo json_encode($resultado);

        break;
}