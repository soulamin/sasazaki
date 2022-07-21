<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-embalagens.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-embalagem'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $descembalagem = $inf->{'desc-embalagem'};
     $codembalagem = $inf->{'cod-embalagem'};
  

    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_embalagem) AS qtd FROM embalagens WHERE codigo_embalagem = :codigo_embalagem";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_embalagem', $codembalagem);
    $stverifica->execute();
    $embalagem =  $stverifica->fetch();

    if ($embalagem['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO embalagens(codigo_embalagem,descricao_embalagem)
                                          VALUES (:codigo_embalagem,:descricao_embalagem) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_embalagem', $codembalagem);
        $statement->bindParam(':descricao_embalagem', $descembalagem);
      
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


        $sql_update = "UPDATE embalagens SET descricao_embalagem = :descricao_embalagem 
                                                WHERE codigo_embalagem=:codigo_embalagem";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_embalagem', $codembalagem);
        $statement->bindParam(':descricao_embalagem', $descembalagem);
      
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

