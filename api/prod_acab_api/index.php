<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM produtos_acabamentos');
        $executa = $stmt->execute();
        $produtos = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($produtos, $linha);
        }

        $Resultado['produtos_acabamentos'] = $produtos;
        echo json_encode($Resultado);
