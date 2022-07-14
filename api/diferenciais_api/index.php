<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM diferenciais');
        $executa = $stmt->execute();
        $diferenciais = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($diferenciais, $linha);
        }

        $Resultado['diferenciais'] = $diferenciais;
        echo json_encode($Resultado);
