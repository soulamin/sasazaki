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

    case 'Salva_Modelo':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $email = $_POST['txt_email'];
        $login = $_POST['txt_login'];
        $senha = password_hash($_POST['txt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['txt_tipo'];
        $status = "a"; //ativo
        $role = "admin";


        if ((!empty($email)) && (!empty($login)) && (!empty($senha))) {

            $sql_insert = "INSERT INTO  Modelos (login,senha,email,role,idpermissao,status)
                                                                                VALUES
                                                                                (:login ,:senha,:email,:role,:tipo,:status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':senha', $senha);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':tipo', $tipo);
            $statement->bindParam(':role', $role);
            $statement->bindParam(':login', $login);
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
            $Html = "Existe(m) Campo(s) Vazio(s). Por favor preencher!";
        }

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;


    case 'Altera_Modelo':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idModelo = $_POST['atxt_idModelo'];
        $email = $_POST['atxt_email'];
        $login = $_POST['atxt_login'];
        $senha = password_hash($_POST['atxt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['atxt_tipo'];


        if ((!empty($login)) && (!empty($email)) && (!empty($email))) {

            $sql_update = "UPDATE  Modelos SET login = :login ,email = :email , WHERE id = :idModelo";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idModelo', $idModelo);
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

    case 'Busca_Modelo':

        $stmt = $pdo->prepare('SELECT * FROM modelos');
        $executa = $stmt->execute();
        $Modelos = array();

        while ($linha = $stmt->fetch()) {
          
           
            $m = array('Nome' => $linha['nome_modelo'], 'Codigo' => $linha['codigo_modelo'], 'Descricao' => $linha['descricao_modelo'],
                     'Diferencial' => $linha['codigo_diferencial'] ,'Categoria' => $linha['codigo_categoria']);
            array_push($Modelos, $m);
        }

        $Resultado['Html'] = $Modelos;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Modelo':


        $stmt = $pdo->prepare('SELECT U.* FROM Modelos U  WHERE idModelo LIKE :Modelo');
        $stmt->bindParam(':Modelo', $Modelo);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Modelo = array(
                'Nome' => $linha['nome'], 'Email' => $linha['email'], 'Login' => $linha['login'],
                'Codigo' => $linha['idModelo']
            );
        }
        $Resultado['Html'] = $Modelo;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Modelo':

        $idModelo = $_POST['idModelo'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE banners SET status = :status  WHERE id = :idModelo";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idModelo', $idModelo);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;
}
