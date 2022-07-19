<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";



$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-diferenciais.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-diferencial'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $descdiferencial = $inf->{'desc-diferencial'};
     $coddiferencial = $inf->{'cod-diferencial'};
  

    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_diferencial) AS qtd FROM diferenciais WHERE codigo_diferencial = :codigo_diferencial";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_diferencial', $coddiferencial);
    $stverifica->execute();
    $diferencial =  $stverifica->fetch();

    if ($diferencial['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO diferenciais(codigo_diferencial,descricao_diferencial)
                                          VALUES (:codigo_diferencial,:descricao_diferencial) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_diferencial', $coddiferencial);
        $statement->bindParam(':descricao_diferencial', $descdiferencial);
      
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


        $sql_update = "UPDATE diferenciais SET descricao_diferencial = :descricao_diferencial 
                                                WHERE codigo_diferencial=:codigo_diferencial";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_diferencial', $coddiferencial);
        $statement->bindParam(':descricao_diferencial', $descdiferencial);
       
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
