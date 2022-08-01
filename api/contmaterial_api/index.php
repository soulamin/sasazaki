<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';



 $stmt = $pdo->prepare("SELECT COUNT(m.id) as quantidade , m.codigo_material ,
                                                                m.nome_material FROM materiais m 
                                                               INNER JOIN produtos p ON p.codigo_material = m.codigo_material 
                                                               GROUP BY m.codigo_material");

$executa = $stmt->execute();
$material = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

    array_push($material, $linha);
}

$Resultado['contmaterial'] = $material;
echo json_encode($Resultado);
