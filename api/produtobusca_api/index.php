<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

if (!isset($_GET['termo'])) {
    $Resultado['produtos'] = [];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($Resultado);
}
 $stmt = $pdo->prepare("SELECT p.id, p.codigo_produto, p.item_pai, p.descricao_produto, d.descricao_diferencial FROM produtos p
                            JOIN produtos_diferenciais pd ON pd.codigo_produto=p.codigo_produto
                            JOIN diferenciais d ON pd.codigo_diferencial=d.codigo_diferencial
                            WHERE LOWER(p.item_pai) like LOWER('%".$_GET['termo']."%')
                                OR LOWER(p.it_codigo) like LOWER('%".$_GET['termo']."%')
                                OR LOWER(p.descricao_produto) like LOWER('%".$_GET['termo']."%')
                                GROUP BY p.item_pai");

$executa = $stmt->execute();
$stmt->errorInfo();
$produtos = array();
$fotos = [];

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $stft = $pdo->prepare("SELECT f.id, f.tipo_foto, f.sequencia, f.caminholocal, f.codigo_foto FROM fotos f
                                       INNER JOIN produtos_fotos pf  ON f.codigo_foto = pf.codigo_foto
                                        WHERE pf.codigo_produto = :codigo_produto and f.sequencia in (1,3)");
    $stft->bindParam(':codigo_produto', $linha['codigo_produto']);
    $stft->execute();
    while ($lft = $stft->fetch(PDO::FETCH_ASSOC)) {
       
       if($lft['tipo_foto'] == 'Ambientação'){
            $linha['ambientacao'] = $lft;
       }else{
            $linha['foto_produto'] = $lft;
       } 
    }
    array_push($produtos, $linha);  
}

$Resultado['produtos'] = $produtos;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($Resultado);
