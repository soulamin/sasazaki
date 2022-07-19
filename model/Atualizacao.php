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

    case 'Salva_Atualizacao':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        
        $login = $_SESSION['LOGIN'];
      
            $sql_insert = "INSERT INTO  atualizacao(login)
                                                         VALUES
                                                                (:login)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':login', $login);
        
            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                // Definimos a mensagem de sucesso
                $cod_error = 0;
                $msg = "Cadastro Realizado com Sucesso!";
            } else {
                $cod_error = 1;
                $msg ="erro no cadastro";
            }
        

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;


    case 'Altera_Atualizacao':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idAtualizacao = $_POST['atxt_idAtualizacao'];
        $email = $_POST['atxt_email'];
        $login = $_POST['atxt_login'];
        $senha = password_hash($_POST['atxt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['atxt_tipo'];


        if ((!empty($login)) && (!empty($email)) && (!empty($email))) {

            $sql_update = "UPDATE  Atualizacaos SET login = :login ,email = :email , WHERE id = :idAtualizacao";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idAtualizacao', $idAtualizacao);
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

    case 'Busca_Atualizacao':

        $stmt = $pdo->prepare('SELECT * FROM atualizacao');
        $executa = $stmt->execute();
        $Atualizacaos = array();

        while ($linha = $stmt->fetch()) {
          
           
            $m = array('Login' => $linha['login'], 'DataHora' => date('d/m/Y H:i:s',strtotime($linha['dthr_atualizacao'])) );
            array_push($Atualizacaos, $m);
        }

        $Resultado['Html'] = $Atualizacaos;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Atualizacao':


        $stmt = $pdo->prepare('SELECT U.* FROM Atualizacaos U  WHERE idAtualizacao LIKE :Atualizacao');
        $stmt->bindParam(':Atualizacao', $Atualizacao);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Atualizacao = array(
                'Nome' => $linha['nome'], 'Email' => $linha['email'], 'Login' => $linha['login'],
                'Codigo' => $linha['idAtualizacao']
            );
        }
        $Resultado['Html'] = $Atualizacao;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Atualizacao':

        $idAtualizacao = $_POST['idAtualizacao'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE banners SET status = :status  WHERE id = :idAtualizacao";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idAtualizacao', $idAtualizacao);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;
}
