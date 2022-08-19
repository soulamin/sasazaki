<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$codmaterial       = isset($_GET['material'])? ' AND p.codigo_material = "'.$_GET['material'].'"':"";
$codmodelo     = " p.codigo_modelo = '".$_GET['modelo']."'";


$sql = 'SELECT p.descricao_produto
        ,p.codigo_produto
        ,p.item_pai
        ,p.id_linha
        ,p.altura
        ,p.largura
        ,p.codigo_cor
        ,p.quantidade_folhas
        ,p.id
        ,p.tipo_abertura
        ,p.batente
        ,v.tipo_vidro 
        ,m.nome_modelo
        ,f.tipo_foto
        ,f.caminholocal as caminho
        ,c.nome_cor
        ,l.nome_linha
        ,m1.nome_material
    FROM produtos p 
    INNER JOIN produtos_vidros pv ON pv.codigo_produto=p.codigo_produto
        INNER JOIN produtos_opcionais po ON po.codigo_produto=p.codigo_produto
        INNER JOIN produtos_fotos pf ON pf.codigo_produto=p.codigo_produto
        INNER JOIN vidros v ON pv.codigo_vidro=v.codigo_vidro
        INNER JOIN fotos f ON f.codigo_foto = pf.codigo_foto
        INNER JOIN modelos m ON m.codigo_modelo=p.codigo_modelo
        INNER JOIN cores c ON c.codigo_cor=p.codigo_cor
        INNER JOIN linhas l ON l.codigo_linha = p.id_linha
        INNER JOIN materiais m1 ON m1.codigo_material = p.codigo_material';

$stmt = $pdo->prepare($sql.' WHERE '.$codmodelo.$codmaterial.' GROUP BY p.item_pai');

$executa = $stmt->execute();
$produtos = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $stft = $pdo->prepare($sql.' WHERE p.item_pai = :codigopai group by codigo_produto');

    $stft->bindParam(':codigopai', $linha['item_pai']);
    $stft->execute();
    $filhos = array();
    while ($lft = $stft->fetch(PDO::FETCH_ASSOC)) {
        array_push($filhos, $lft);    
    }
    $linha['filhos'] = $filhos;
    array_push($produtos, $linha);
}

$Resultado['produtos'] = $produtos;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($Resultado);
