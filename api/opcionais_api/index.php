<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM opcionais');
        $executa = $stmt->execute();
        $opcionais = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($opcionais, $linha);
        }

        $Resultado['opcionais'] = $opcionais;
        echo json_encode($Resultado);
