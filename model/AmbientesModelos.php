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

    case 'Salva_AmbienteModelo':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $ambiente = $_POST['txt_ambiente'];
        $codigomodelo = $_POST['txt_modelo'];
        $Status = "a"; //ativo
        $idusuario = $_SESSION['ID_USUARIO'];


        if (!empty($codigomodelo)) {



            foreach ($codigomodelo as $modelo) {

                $sql_insert = "INSERT INTO  ambiente_modelo (codigo_ambiente,codigo_modelo)
                                                        VALUES
                                                             (:codigo_ambiente,:codigo_modelo)";
                // Prepara uma senten�a para ser executada                                               
                $st = $pdo->prepare($sql_insert);
                $st->bindParam(':codigo_ambiente', $ambiente);
                $st->bindParam(':codigo_modelo', $modelo);
                // Executa a senten�a j� com os valores
                if ($st->execute()) {
                    // Definimos a mensagem de sucesso
                    $cod_error = 0;
                    $msg = "Cadastro Realizado com Sucesso!";
                } else {
                    $cod_error = 1;
                    $msg = "erro no cadastro";
                }
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

    case 'Busca_AmbienteModelo':

        $stmt = $pdo->prepare('SELECT * FROM ambiente_modelo am
                                         INNER JOIN  ambientes a ON am.codigo_ambiente=a.codigo_ambiente
                                         INNER JOIN  modelos m ON am.codigo_modelo=m.codigo_modelo');
        $executa = $stmt->execute();
        $ambientemodelo = array();

        while ($linha = $stmt->fetch()) {

     

            //botao Editar
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
                           
                            </div>
                        </div>';


            $t = array(
                'NomeAmbiente' => $linha['nome_ambiente'], 'NomeModelo' => $linha['nome_modelo'],
                'CodigoAmbiente' => $linha['codigo_ambiente'], 'CodigoModelo' => $linha['codigo_modelo'],
                 'Html_Acao' => $botao
            );
            array_push($ambientemodelo, $t);
        }

        $Resultado['Html'] = $ambientemodelo;
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

    case 'Combobox_Ambiente':

        $statement = $pdo->prepare('SELECT * FROM ambientes');
        $statement->execute();
        $ambiente = array();
        $m = '';
        while ($linhas = $statement->fetch()) {

            $m = '<option value="' . $linhas['codigo_ambiente'] . '" >' . $linhas['nome_ambiente'] . '</option>';
            array_push($ambiente, $m);
        }
        $resultado['Html'] = $ambiente;
        echo json_encode($resultado);

        break;
    case 'Combobox_Modelo':

        $statement = $pdo->prepare('SELECT * FROM modelos');
        $statement->execute();
        $modelo = array();
        $m = '';
        while ($linhas = $statement->fetch()) {

            $m = '<option value="' . $linhas['codigo_modelo'] . '" >' . $linhas['nome_modelo'] . '</option>';
            array_push($modelo, $m);
        }
        $resultado['Html'] = $modelo;
        echo json_encode($resultado);

        break;
}
