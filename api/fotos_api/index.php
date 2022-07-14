<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM fotos');
        $executa = $stmt->execute();
        $fotos = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($fotos, $linha);
        }

        $Resultado['fotos'] = $fotos;
        echo json_encode($Resultado);
