<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM linhas');
        $executa = $stmt->execute();
        $linhas = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($linhas, $linha);
        }

        $Resultado['linhas'] = $linhas;
        echo json_encode($Resultado);
