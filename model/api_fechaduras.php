<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-fechaduras.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-fechadura'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $codcor = $inf->{'cod-cor'};
     $codfechadura = $inf->{'cod-fechadura'};
     $tipofechadura = $inf->{'tipo-fechadura'};
     $tipochave = $inf->{'tipo-chave'};


    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_fechadura) AS qtd FROM fechaduras WHERE codigo_fechadura = :codigo_fechadura";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_fechadura', $codfechadura);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO fechaduras(codigo_fechadura,tipo_fechadura ,codigo_cor,tipo_chave)
                                          VALUES (:codigo_fechadura,:tipo_fechadura ,:codigo_cor,:tipo_chave) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_fechadura', $codfechadura);
        $statement->bindParam(':tipo_fechadura', $tipofechadura);
        $statement->bindParam(':tipo_chave', $tipochave);
        $statement->bindParam(':codigo_cor', $codcor);

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


        $sql_update = "UPDATE fechaduras SET tipo_fechadura = :tipo_fechadura , codigo_cor = :codigo_cor,tipo_chave=:tipo_chave
                                                WHERE codigo_fechadura=:codigo_fechadura";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_fechadura', $codfechadura);
        $statement->bindParam(':tipo_fechadura', $tipofechadura);
        $statement->bindParam(':tipo_chave', $tipochave);
        $statement->bindParam(':codigo_cor', $codcor);
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
