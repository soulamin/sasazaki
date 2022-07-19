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

    case 'Salva_Papel':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $nome = $_POST['txt_nome'];
        $funcao = $_POST['txt_funcao'];
        $status = "a"; //ativo

        if ((!empty($nome)) && (!empty($funcao))) {

            $sql_insert = "INSERT INTO  permissoes (nome,status)
                                                                    VALUES
                                                                          (:nome,:status)";
            // Prepara uma senten�a para ser executada                                               
            $statement = $pdo->prepare($sql_insert);
            $statement->bindParam(':nome', $nome);
            $statement->bindParam(':status', $status);

            // Executa a senten�a j� com os valores
            if ($statement->execute()) {

                $idpermissao = $pdo->lastInsertId();

                foreach($funcao as $fn){
                    $prioridade = 0 ;
                    $sql_ins = "INSERT INTO  permissao_funcao (idpermissao,idfuncao,prioridade)
                                                  VALUES
                                                              (:idpermissao,:idfuncao,:prioridade)";
                    // Prepara uma senten�a para ser executada                                               
                    $st = $pdo->prepare($sql_ins);
                    $st->bindParam(':idpermissao', $idpermissao);
                    $st->bindParam(':idfuncao', $fn);
                    $st->bindParam(':prioridade', $prioridade);
                    $st->execute();

                }


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


    case 'Altera_Papel':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $idPapel = $_POST['atxt_codigo'];
        $nome = $_POST['atxt_nome'];
        $funcao = $_POST['atxt_funcao'];
       
        if ((!empty($nome)) && (!empty($funcao))) {

            $sql_update = "UPDATE funcao SET  nome= :nome ,funcao = :funcao WHERE id = :idPapel";

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare($sql_update);

            $statement->bindParam(':idPapel', $idPapel);
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

    case 'Busca_Papel':

        $stmt = $pdo->prepare('SELECT *  FROM permissoes');
        $executa = $stmt->execute();
        $Papeis = array();
        
        while ($linha = $stmt->fetch()) {
               $funcao ="";
               $idpermissao = $linha['id'];

               $st = $pdo->prepare('SELECT *  FROM funcao f
                                              INNER JOIN  permissao_funcao p ON f.id=p.idfuncao WHERE 
                                             p.idpermissao = :idpermissao');
                $st->bindParam(":idpermissao",$idpermissao);
                $st->execute();

                 while($l=$st->fetch()){
                        $funcao .='<span class="badge badge-dark">'.$l["nome"].'</span>';
                 }


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


            $p = array('Nome' => $linha['nome'], 'Funcao' => $funcao, 'Status' => $status, 'Html_Acao' => $botao);
            array_push($Papeis, $p);
        }

        $Resultado['Html'] = $Papeis;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Papel':

        $idPapel = $_POST['idPapel'];
        $stmt = $pdo->prepare('SELECT * FROM funcao   WHERE id =:idPapel');
        $stmt->bindParam(':idPapel', $idPapel);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $Papel = array(
                'Nome' => $linha['nome'], 'Funcao' => $linha['funcao'],
                'Codigo' => $linha['id']
            );
        }
        $Resultado['Html'] = $Papel;
        echo json_encode($Resultado);
        break;

    case 'Desativa_Papel':

        $idPapel = $_POST['idPapel'];
        $status = "d"; //desativado
        $sql_desativa = "UPDATE permissoes SET status = :status  WHERE id = :idPapel";
        $stmt = $pdo->prepare($sql_desativa);
        $stmt->bindParam(':idPapel', $idPapel);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            $cod_error = 0;
        }
        $Resultado['cod_error'] = $cod_error;
        echo json_encode($Resultado);

        break;
}
