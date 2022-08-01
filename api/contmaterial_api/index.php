<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$codmodelo       = isset($_GET['mod'])? ' AND p.codigo_modelo = "'.$_GET['mod'].'"':"";
$codambiente     = " pa.codigo_ambiente = '".$_GET['amb']."'";


$stmt = $pdo->prepare("SELECT COUNT(m.id) as quantidade , m.codigo_material ,
                                                                m.nome_material FROM materiais m 
                                                               INNER JOIN produtos p ON p.codigo_material = m.codigo_material 
                                                               INNER JOIN produtos_ambientes pa ON p.codigo_produto =  pa.codigo_produto
                                                               INNER JOIN ambientes a ON a.codigo_ambiente =  pa.codigo_ambiente
                                                               WHERE ".$codambiente.$codmodelo."
                                                               GROUP BY m.codigo_material");
var_dump($stmt);
$executa = $stmt->execute();
$material = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

    array_push($material, $linha);
}

$Resultado['contmaterial'] = $material;
echo json_encode($Resultado);
