<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

        $stmt = $pdo->prepare('SELECT * FROM Ambientes');
        $executa = $stmt->execute();
        $Ambientes = array();

        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($Ambientes, $linha);
        }

        $Resultado['ambientes'] = $Ambientes;
        echo json_encode($Resultado);

      