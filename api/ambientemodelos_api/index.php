<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

 $codambiente = $_GET['ca'] ;
 $codmodelo = $_GET['cm'] ;
// Prepara uma senten�a para ser executada                                               

        $st = $pdo->prepare('SELECT * FROM ambiente_modelo am
                                        INNER JOIN  ambientes a ON am.codigo_ambiente=a.codigo_ambiente
                                        INNER JOIN  modelos m ON am.codigo_modelo=m.codigo_modelo
                                        WHERE am.codigo_ambiente = :codigo_ambiente AND 
                                        am.codigo_modelo = :codigo_modelo');
        $st->bindParam(':codigo_ambiente', $codambiente);
        $st->bindParam(':codigo_modelo', $codmodelo);
        
        $executa = $st->execute();
        $Ambientes = array();

        while ($linha = $st->fetch(PDO::FETCH_ASSOC)) {
          
            array_push($Ambientes, $linha);
        }

        $Resultado['ambientes'] = $Ambientes;
        echo json_encode($Resultado);

      