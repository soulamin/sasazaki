<?php

require '../../fontes/conexao.php';

$codproduto = isset($_GET['codproduto'])? ' codigo_produto = "'.$_GET['codproduto'].'"':"";

$stmt_opc = $pdo->prepare("SELECT codigo_opcional FROM produtos_opcionais WHERE ".$codproduto);

$executa = $stmt_opc->execute();

$produtos = array();


while ($linha = $stmt_opc->fetch(PDO::FETCH_ASSOC)) {

    //print_r($linha);
    //print_r($linha['codigo_opcional']);

    $stmt_opc_pai = $pdo->prepare("SELECT p.it_codigo from produtos p WHERE p.codigo_produto ='".$linha['codigo_opcional']."'"); 

    $executa = $stmt_opc_pai->execute();

    while ($linha_opc = $stmt_opc_pai->fetch(PDO::FETCH_ASSOC)) {
        
        $stmt = $pdo->prepare("SELECT p.*,l.nome_linha, m.nome_modelo,i.nome_material,c.nome_cor 
        FROM produtos p
        INNER JOIN linhas l ON l.codigo_linha=p.id_linha
        INNER JOIN modelos m ON m.codigo_modelo=p.codigo_modelo
        INNER JOIN materiais i ON i.codigo_material=p.codigo_material
        INNER JOIN cores c ON c.codigo_cor=p.codigo_cor
        WHERE p.it_codigo ='".$linha_opc['it_codigo']."'");

        $executa = $stmt->execute();

        while($linha_final = $stmt->fetch(PDO::FETCH_ASSOC))
        {                       
            array_push($produtos, $linha_final);
        }
       
        //$stmt->bindParam(':it_codigo', $linha_opc['it_codigo']);
        //$stmt->execute();       
      
        }
      
    }
     

$Resultado['produtos'] = $produtos;
echo json_encode($Resultado);
