<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$stmt = $pdo->prepare('SELECT * FROM modelos');
$executa = $stmt->execute();
$Modelos = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    array_push($Modelos, $linha);
}

$Resultado['modelos'] = $Modelos;
echo json_encode($Resultado);
