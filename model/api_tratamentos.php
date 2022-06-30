<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-tratamentos.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-tratamento'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $desctratamento = $inf->{'desc-tratamento'};
     $codtratamento = $inf->{'cod-tratamento'};
  

    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_tratamento) AS qtd FROM tratamentos WHERE codigo_tratamento = :codigo_tratamento";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_tratamento', $codtratamento);
    $stverifica->execute();
    $tratamento =  $stverifica->fetch();

    if ($tratamento['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO tratamentos(codigo_tratamento,descricao_tratamento)
                                          VALUES (:codigo_tratamento,:descricao_tratamento) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_tratamento', $codtratamento);
        $statement->bindParam(':descricao_tratamento', $desctratamento);
      
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


        $sql_update = "UPDATE tratamentos SET descricao_tratamento = :descricao_tratamento 
                                                WHERE codigo_tratamento=:codigo_tratamento";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_tratamento', $codtratamento);
        $statement->bindParam(':descricao_tratamento', $desctratamento);
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
