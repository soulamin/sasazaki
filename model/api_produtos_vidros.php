<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-prod-vidro.r";
$dados = array();
$json = json_encode($dados);
$ch = curl_init($urlaut);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Authorization: Basic ' . base64_encode("$username:$password"),
        'Content-Type: application/json',
        'Accept: application/json',
        'Content-Length: ' . strlen($json),
        'charset=utf-8',
    )
);
$Resultado  = curl_exec($ch);
$j          = json_decode($Resultado, false);
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-prod-vidro'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $codvidro = $inf->{'cod-vidro'};
     $codproduto = $inf->{'cod-produto'};
     $largura = $inf->{'largura'};
     $quantidade = $inf->{'qtde'};
     $altura = $inf->{'altura'};
     $espessura = $inf->{'espessura'};


    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_produto) AS qtd FROM produtos_vidros WHERE codigo_produto = :codigo_produto ";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_produto', $codproduto);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO produtos_vidros (codigo_produto,codigo_vidro,altura,largura,quantidade,espessura)
                                          VALUES (:codigo_produto,:codigo_vidro,:altura,:largura,:quantidade,:espessura) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_produto', $codproduto);
        $statement->bindParam(':codigo_vidro', $codvidro);
        $statement->bindParam(':altura', $altura);
        $statement->bindParam(':quantidade', $quantidade);
        $statement->bindParam(':espessura', $espessura);
        $statement->bindParam(':largura', $largura);

        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
             $msg = "Cadastro Realizado com Sucesso!";
        } else {
            $cod_error = 1;
             $msg = " Usuário já Cadastro!";
        }

    } else {


        $sql_update = "UPDATE produtos_vidros SET codigo_vidro = :codigo_vidro ,altura=:altura,
                                                    largura=:largura,quantidade=:quantidade,espessura=:espessura
                                                WHERE codigo_produto=:codigo_produto";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_produto', $codproduto);
        $statement->bindParam(':codigo_vidro', $codvidro);
        $statement->bindParam(':altura', $altura);
        $statement->bindParam(':quantidade', $quantidade);
        $statement->bindParam(':espessura', $espessura);
        $statement->bindParam(':largura', $largura);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
            $msg = "Cadastro Atualizado com Sucesso!";
        } else {
            $cod_error = 1;
            $msg = " Usuário já Cadastro!";
        }
    }
}
echo $msg;
