<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-linhas.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-linha'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $nomelinha = $inf->{'nome-linha'};
     $codlinha = $inf->{'cod-linha'};
     $conceito = $inf->{'conceito'};


    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_linha) AS qtd FROM linhas WHERE codigo_linha = :codigo_linha";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_linha', $codlinha);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO linhas(codigo_linha,nome_linha,conceito)
                                          VALUES (:codigo_linha,:nome_linha,:conceito) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_linha', $codlinha);
        $statement->bindParam(':nome_linha', $nomelinha);
        $statement->bindParam(':conceito', $conceito);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
             $msg = "Cadastro Realizado com Sucesso!";
        } else {
            $cod_error = 1;
             $msg ="erro no cadastro";
        }

    } else {


        $sql_update = "UPDATE linhas SET nome_linha = :nome_linha ,conceito = :conceito
                                                WHERE codigo_linha=:codigo_linha";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_linha', $codlinha);
        $statement->bindParam(':nome_linha', $nomelinha);
        $statement->bindParam(':conceito', $conceito);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
            $msg = "Cadastro Atualizado com Sucesso!";
        } else {
            $cod_error = 1;
            $msg ="erro no cadastro";
        }
    }
}
 echo json_encode( $cod_error);
