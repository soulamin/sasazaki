<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-ambientes.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-ambiente'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $nomeambiente = $inf->{'nome-ambiente'};
     $codambiente = $inf->{'cod-ambiente'};


    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_ambiente) AS qtd FROM ambientes WHERE codigo_ambiente = :codigo_ambiente";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_ambiente', $codambiente);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO ambientes(codigo_ambiente,nome_ambiente)
                                          VALUES (:codigo_ambiente,:nome_ambiente) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_ambiente', $codambiente);
        $statement->bindParam(':nome_ambiente', $nomeambiente);

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


        $sql_update = "UPDATE ambientes SET nome_ambiente = :nome_ambiente
                                                WHERE codigo_ambiente=:codigo_ambiente";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_ambiente', $codambiente);
        $statement->bindParam(':nome_ambiente', $nomeambiente);
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
