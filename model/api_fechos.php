<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-fechos.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-fecho'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $codmaterial = $inf->{'cod-material'};
     $codfecho = $inf->{'cod-fecho'};
     $tipofecho = $inf->{'tipo-fecho'};


    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_fecho) AS qtd FROM fechos WHERE codigo_fecho = :codigo_fecho";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_fecho', $codfecho);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO fechos(codigo_fecho,tipo_fecho ,id_material)
                                          VALUES (:codigo_fecho,:tipo_fecho ,:codigo_material) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_fecho', $codfecho);
        $statement->bindParam(':tipo_fecho', $tipofecho);
        $statement->bindParam(':codigo_material', $codmaterial);

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


        $sql_update = "UPDATE fechos SET tipo_fecho = :tipo_fecho ,id_material = :codigo_material
                                                WHERE codigo_fecho=:codigo_fecho";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_fecho', $codfecho);
        $statement->bindParam(':tipo_fecho', $tipofecho);
        $statement->bindParam(':codigo_material', $codmaterial);
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

