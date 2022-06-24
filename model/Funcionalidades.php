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

    case 'Salva_Funcionalidade':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $nome = $_POST['txt_nome'];
        $funcao = $_POST['txt_funcao'];
        $status = "a"; //ativo

        if ((!empty($nome)) && (!empty($funcao))) {

            $sql_insert = "INSERT INTO  funcao (nome,funcao,status)
                                                                    VALUES
                                                                          (:nome,:funcao,:status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':nome', $nome);
            $statement->bindParam(':funcao', $funcao);
            $statement->bindParam(':status', $status);

            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
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


    case 'Altera_Funcionalidade':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idfuncionalidade = $_POST['atxt_codigo'];
        $nome = $_POST['atxt_nome'];
        $funcao = $_POST['atxt_funcao'];
       
        if ((!empty($nome)) && (!empty($funcao))) {

            $sql_update = "UPDATE funcao SET  nome= :nome ,funcao = :funcao WHERE id = :idfuncionalidade";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idfuncionalidade', $idfuncionalidade);
            $statement->bindParam(':nome', $nome);
            $statement->bindParam(':funcao', $funcao);
          
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

    case 'Busca_Funcionalidade':

        $stmt = $pdo->prepare('SELECT *  FROM funcao');
        $executa = $stmt->execute();
        $Funcionalidades = array();

        while ($linha = $stmt->fetch()) {

                //verifica status
                if ($linha['status'] == 'a') {

                    $status = '<span class="badge badge-success">Ativo</span>';
                    //botao editar
                    $botaodesativar = '<a class="dropdown-item" id="btnDesativar"  codigo ="' . $linha['id'] . '"  href="#">
                    <i class="fa fa-trash"> Desativar </i> 
                    </a>';

                } else {

                    $status = '<span class="badge badge-danger">Desativado</span>';
                    //botao Desativar
                    $botaodesativar = '';

                }
                    //botao Desativar
                    $botaoeditar = '<a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['id'] . '"  href="#">
                    <i class="fa fa-pencil"> Editar </i> 
                    </a>';

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


            $U = array('Nome' => $linha['nome'], 'Funcao' => $linha['funcao'], 'Status' => $status, 'Html_Acao' => $botao);
            array_push($Funcionalidades, $U);
        }

        $Resultado['Html'] = $Funcionalidades;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Funcionalidade':

        $idfuncionalidade = $_POST['idfuncionalidade'];
        $stmt = $pdo->prepare('SELECT * FROM funcao   WHERE id =:idfuncionalidade');
        $stmt->bindParam(':idfuncionalidade', $idfuncionalidade);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Funcionalidade = array(
                'Nome' => $linha['nome'], 'Funcao' => $linha['funcao'],
                'Codigo' => $linha['id']
            );
        }
        $Resultado['Html'] = $Funcionalidade;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Funcionalidade':

        $idfuncionalidade = $_POST['idFuncionalidade'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE funcao SET status = :status  WHERE id = :idFuncionalidade";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idFuncionalidade', $idfuncionalidade);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;

        case 'Combobox_Funcionalidade' :

            $statement = $pdo->prepare('SELECT * FROM funcao WHERE status ="a"');
            $statement->execute();
            $funcao = array();
            $f = '';
            while ($linhas = $statement->fetch()) {
    
                $f = '<option value="' . $linhas['id']. '" >'.$linhas['nome'].'</option>';
                array_push($funcao, $f);
            }
            $resultado['Html'] = $funcao;
            echo json_encode($resultado);
    
        break ;

}
