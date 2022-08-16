<?php

require '../../fontes/conexao.php';

$itempai             = isset($_GET['itempai'])   ? ' p.item_pai = "'.$_GET['itempai'].'"' : "";
$codproduto          = isset($_GET['codproduto'])? ' codigo_produto = "'.$_GET['codproduto'].'"':"";

$stmt_opc = $pdo->prepare("SELECT codigo_produto, codigo_opcional FROM produtos_opcionais
                           WHERE ".$codproduto);

$executa = $stmt_opc->execute();


$produtos = array();


while ($linha = $stmt_opc->fetch(PDO::FETCH_ASSOC)) {
    
    $stmt = $pdo->prepare("SELECT p.*,l.nome_linha, v.tipo_vidro , o.nome_opcional ,m.nome_modelo,i.nome_material,
                         d.descricao_diferencial ,c.nome_cor FROM produtos p
                         INNER JOIN produtos_vidros pv ON pv.codigo_produto=p.codigo_produto
                         INNER JOIN produtos_opcionais po ON po.codigo_produto=p.codigo_produto
                         INNER JOIN produtos_diferenciais pd ON pd.codigo_produto=p.codigo_produto
                         INNER JOIN vidros v ON pv.codigo_vidro=v.codigo_vidro
                         INNER JOIN linhas l ON l.codigo_linha=p.id_linha
                         INNER JOIN modelos m ON m.codigo_modelo=p.codigo_modelo
                         INNER JOIN materiais i ON i.codigo_material=p.codigo_material
                         INNER JOIN cores c ON c.codigo_cor=p.codigo_cor
                         INNER JOIN opcionais o ON po.codigo_opcional=o.codigo_opcional
                         INNER JOIN diferenciais d ON pd.codigo_diferencial=d.codigo_diferencial
                         WHERE ".$itempai);
     
     $stmt->bindParam(':codigo_produto', $linha['codigo_produto']);
     $stmt->execute();         
       
    }
    array_push($produtos, $linha);
  
}

$Resultado['produtos'] = $produtos;
echo json_encode($Resultado);
