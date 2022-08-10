<?php

/**
 * 
 * User: ALAN LAMIN
 * Date: 03/06/2022
 * Time: 15:26
 */
require '../../fontes/conexao.php';

$itempai             = isset($_GET['itempai'])   ? ' p.item_pai = "'.$_GET['itempai'].'"' : "";
$codproduto          = isset($_GET['codproduto'])? ' AND p.codigo_produto = "'.$_GET['codproduto'].'"':"";
$quantidade_folhas   = isset($_GET['qtdfolhas'])   ? ' AND p.quantidade_folhas = "'.$_GET['qtdfolhas'].'"' : "";
$batente_incluso     = isset($_GET['bat'])? ' AND p.batente_incluso = "'.$_GET['bat'].'"':"";
$tipo_abertura       = isset($_GET['tpabertura'])   ? ' AND p.tipo_abertura = "'.$_GET['tpabertura'].'"' : "";
$largura             = isset($_GET['largura'])   ? ' AND p.largura = "'.$_GET['largura'].'"' : "";
$largura_livre       = isset($_GET['lglivre'])? ' AND p.largura_livre = "'.$_GET['lglivre'].'"':"";
$quantidade_bascula  = isset($_GET['qtdbasc'])   ? ' AND p.quantidade_bascula = "'.$_GET['qtdbasc'].'"' : "";
$garantia            = isset($_GET['garantia'])   ? ' AND p.garantia = "'.$_GET['garantia'].'"' : "";
$possui_trinco       = isset($_GET['ptrinco'])? ' AND p.possui_trinco = "'.$_GET['ptrinco'].'"':"";
$altura              = isset($_GET['altura'])   ? ' AND p.altura = "'.$_GET['altura'].'"' : "";
$batente             = isset($_GET['batente'])   ? ' AND p.batente = "'.$_GET['batente'].'"' : "";
$altura_livre        = isset($_GET['altlivre'])? ' AND p.altura_livre= "'.$_GET['altlivre'].'"':"";
$codigo_modelo        = isset($_GET['codmodelo'])   ? ' AND p.codigo_modelo = "'.$_GET['codmodelo'].'"' : "";
$codigo_material       = isset($_GET['codmaterial'])   ? ' AND p.codigo_material = "'.$_GET['codmaterial'].'"' : "";
$codigo_cor             = isset($_GET['codcor'])   ? ' AND p.codigo_cor = "'.$_GET['codcor'].'"' : "";
$quantidade_folhas_fixas  = isset($_GET['qtdfolhasfixa'])? ' AND p.quantidade_folhas_fixas = "'.$_GET['qtdfolhasfixa'].'"':"";
$tipo_vidro     = isset($_GET['tpvidro'])   ? ' AND p.tipo_vidro LIKE "'.$_GET['tpvidro'].'"' : "";
$tipo_foto    = isset($_GET['tpfoto'])   ? ' AND p.tipo_foto like  "'.$_GET['tpfoto'].'"' : "";
$nome_cor     = isset($_GET['cor'])   ? ' AND p.nome_cor like  "'.$_GET['cor'].'"' : "";
$itcodigo    = isset($_GET['itcodigo'])   ? ' AND p.it_codigo = "'.$_GET['itcodigo'].'"' : "";




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
                                            WHERE ".$itempai.$codproduto.$itcodigo.$nome_cor.$quantidade_folhas.$batente_incluso
                                            .$tipo_abertura.$largura.$largura_livre.$quantidade_bascula.$garantia.$possui_trinco
                                            .$altura.$batente.$altura_livre.$codigo_modelo.$quantidade_folhas_fixas.$codigo_material.
                                            $codigo_cor.$tipo_vidro.$tipo_foto.$nome_cor);

$executa = $stmt->execute();
$produtos = array();

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $stft = $pdo->prepare("SELECT f.*  FROM fotos f
                                       INNER JOIN produtos_fotos pf  ON f.codigo_foto = pf.codigo_foto
                                        WHERE pf.codigo_produto LIKE :codigo_produto");
    $stft->bindParam(':codigo_produto', $linha['codigo_produto']);
    $stft->execute();
    while ($lft = $stft->fetch(PDO::FETCH_ASSOC)) {
       
        array_push($linha, $lft);
       
    }
    array_push($produtos, $linha);
  
}

$Resultado['produtos'] = $produtos;
echo json_encode($Resultado);
