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

    case 'Salva_Banner':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $titulo = $_POST['txt_titulo'];
        $texto = $_POST['txt_texto'];
        $posicao = $_POST['txt_posicao'];
        $ordem = $_POST['txt_ordem'];
        $foto = $_FILES['txt_foto'];
        $dataexp = $_POST['txt_dataexpiracao'];
        $totens = $_POST['txt_totem'];
        $status = "a";
        $ext= explode("/",$foto['type']);
         $extensao = $ext[1];
      
        if ((!empty($titulo)) && (!empty($totens)) && (!empty($texto))) {


            $imagem = "public/banners/" . $titulo . "." . $extensao;


            if (!@copy($foto['tmp_name'],  '../'.$imagem)) {
                $errors = error_get_last();
                "COPY ERROR: " . $errors['type'];
                "<br />\n" . $errors['message'];
            } else {
            


            $sql_insert = "INSERT INTO banners(titulo, texto, posicao, imagem, ordem, data_expiracao, status)
                                       VALUES (:titulo, :texto, :posicao, :imagem, :ordem, :data_expiracao, :status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);

            $statement->bindParam(':titulo', $titulo);
            $statement->bindParam(':texto', $texto);
            $statement->bindParam(':posicao', $posicao);
            $statement->bindParam(':imagem', $imagem);
            $statement->bindParam(':ordem', $ordem);
            $statement->bindParam(':data_expiracao', $dataexp);
            $statement->bindParam(':status', $status);
            // Executa a senten�a j� com os valores
            if ($statement->execute()) {

               $idbanner = $pdo->lastInsertId();

                foreach ($totens as $idtotem) {
                    
                    $sql_ins= "INSERT INTO banner_grupototens (id_banner, id_grupototens)
                                                      VALUES  (:id_banner, :id_grupototens)";
                    // Prepara uma senten�a para ser executada                                               
                    $st = $pdo->prepare($sql_ins);

                    $st->bindParam(':id_grupototens', $idtotem);
                    $st->bindParam(':id_banner', $idbanner);
                    $st->execute();
                }
                $cod_error = 0;
                $msg = "Cadastro Realizado com Sucesso!";
            } else {
                $cod_error = 1;
                $msg ="erro no cadastro";
            }
        }
        } else {

            $cod_error = 1;
            $Html = "Existe(m) Campo(s) Vazio(s). Por favor preencher!";
        }

        $resultado['cod_error'] = $cod_error;
        $resultado['msg'] = $msg;
        echo json_encode($resultado);

        break;


    case 'Altera_Banner':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idBanner = $_POST['atxt_idBanner'];
        $email = $_POST['atxt_email'];
        $login = $_POST['atxt_login'];
        $senha = password_hash($_POST['atxt_senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['atxt_tipo'];


        if ((!empty($login)) && (!empty($email)) && (!empty($email))) {

            $sql_update = "UPDATE  Banners SET login = :login ,email = :email , WHERE id = :idBanner";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idBanner', $idBanner);
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

    case 'Busca_Banner':

        $stmt = $pdo->prepare('SELECT * FROM banners');
        $executa = $stmt->execute();
        $Banners = array();

        while ($linha = $stmt->fetch()) {

            //verifica status
            if ($linha['status'] == 'a') {

                $status = '<span class="badge badge-success">Ativo</span>';
                //botao Desativar


                //botao editar
                $botaodesativar = '<a class="dropdown-item" id="btnDesativar"  codigo ="' . $linha['id'] . '"  href="#">
                    <i class="fa fa-trash"> Desativar </i> 
                    </a>';
            } else {

                $status = '<span class="badge badge-danger">Desativado</span>';
                //botao Desativar
                $botaodesativar = '';
            }
            //botao editar
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


            $U = array(
                'Titulo' => $linha['titulo'], 'Texto' => $linha['texto'], 'Posicao' => $linha['posicao'],
                'Imagem' => $linha['imagem'], 'Status' => $status, 'Html_Acao' => $botao
            );
            array_push($Banners, $U);
        }

        $Resultado['Html'] = $Banners;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Banner':


        $stmt = $pdo->prepare('SELECT U.* FROM Banners U  WHERE idBanner LIKE :Banner');
        $stmt->bindParam(':Banner', $Banner);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Banner = array(
                'Nome' => $linha['nome'], 'Email' => $linha['email'], 'Login' => $linha['login'],
                'Codigo' => $linha['idBanner']
            );
        }
        $Resultado['Html'] = $Banner;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Banner':

        $idbanner = $_POST['idbanner'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE banners SET status = :status  WHERE id = :idbanner";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idbanner', $idbanner);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;
}
