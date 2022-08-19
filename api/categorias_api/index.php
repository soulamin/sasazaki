<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$stmt = $pdo->prepare('SELECT * FROM Categorias');
$executa = $stmt->execute();
$Categorias = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($Categorias, $linha);
}

$Resultado['categorias'] = $Categorias;
echo json_encode($Resultado);

        

