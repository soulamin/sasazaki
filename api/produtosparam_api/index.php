<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$codproduto  = 'p.codigo_produto = "'.$_GET['codproduto'].'"';
$itempai     = isset($_GET['itempai'])? ' AND p.item_pai = '.$_GET['itempai'].' ' : "";
$itcodigo    = isset($_GET['itcodigo'])? ' AND p.item_codigo = '.$_GET['itcodigo'] : ""; 


 $stmt = $pdo->prepare("SELECT p.*, v.tipo_vidro , o.nome_opcional ,m.nome_modelo,f.tipo_foto,f.caminho,
                                            d.descricao_diferencial ,c.nome_cor FROM produtos p
                                            INNER JOIN produtos_vidros pv ON pv.codigo_produto=p.codigo_produto
                                            INNER JOIN produtos_opcionais po ON po.codigo_produto=p.codigo_produto
                                            INNER JOIN produtos_diferenciais pd ON pd.codigo_produto=p.codigo_produto
                                            INNER JOIN produtos_fotos pf ON pf.codigo_produto=p.codigo_produto
                                            INNER JOIN vidros v ON pv.codigo_vidro=v.codigo_vidro
                                            INNER JOIN  fotos f ON f.codigo_foto=pf.codigo_foto
                                            INNER JOIN modelos m ON m.codigo_modelo=p.codigo_modelo
                                            INNER JOIN cores c ON c.codigo_cor=p.codigo_cor
                                            INNER JOIN opcionais o ON po.codigo_opcional=o.codigo_opcional
                                            INNER JOIN diferenciais d ON pd.codigo_diferencial=d.codigo_diferencial
                                            WHERE ".$codproduto.$itempai.$itcodigo);

/* $stmt->bindParam(':itempai', $itempai);.'$codproduto'.
$stmt->bindParam(':codigoproduto', $codproduto);
$stmt->bindParam(':itcodigo', $itcodigo); */
$executa = $stmt->execute();
$produtos = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

    array_push($produtos, $linha);
}

$Resultado['produtos'] = $produtos;
echo json_encode($Resultado);
