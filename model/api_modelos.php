<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-modelos.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-modelo'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

      $nomemodelo = $inf->{'nome-modelo'};
      $codmodelo = $inf->{'cod-modelo'};
      $descmodelo = $inf->{'desc-modelo'};
      $coddiferencial = $inf->{'cod-diferencial'};
      $codcategoria = $inf->{'cod-categoria'};
      $caminho = $inf->{'caminho'};
      $extensao = substr($caminho, -3)=='peg'?'jpeg':substr($caminho, -3);


      
      /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(descricao_modelo) AS qtd FROM modelos WHERE codigo_modelo = :codigo_modelo";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_modelo', $codmodelo);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {

        $sql_insert = "INSERT INTO modelos(codigo_modelo,nome_modelo, descricao_modelo, codigo_diferencial, codigo_categoria,caminho) 
                         VALUES (:codigo_modelo,:nome_modelo, :descricao_modelo, :codigo_diferencial, :codigo_categoria,:caminho) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);

        $statement->bindParam(':codigo_modelo', $codmodelo);
        $statement->bindParam(':nome_modelo', $nomemodelo);
        $statement->bindParam(':descricao_modelo', $descmodelo);
        $statement->bindParam(':codigo_diferencial', $coddiferencial);
        $statement->bindParam(':codigo_categoria', $codcategoria);
        $statement->bindParam(':caminho', $caminho);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
            $msg = "Cadastro Realizado com Sucesso!";
            if(!@copy($caminho,'../public/imagens/modelos'.$codmodelo.".".$extensao))
            {
                   $errors= error_get_last();
                    "COPY ERROR: ".$errors['type'];
                    "<br />\n".$errors['message'];
               } else {
                    "File copied from remote!";
               }
        } else {
            $cod_error = 1;
            $msg ="erro no cadastro";
        }

    } else {
    

    $sql_update = "UPDATE modelos SET nome_modelo=:nome_modelo, descricao_modelo=:descricao_modelo,
                        codigo_diferencial= :codigo_diferencial, codigo_categoria=:codigo_categoria ,
                        caminho=:caminho      WHERE codigo_modelo=:codigo_modelo";

    // Prepara uma senten�a para ser executada                                               
    $statement = $pdo->prepare($sql_update);

    $statement->bindParam(':codigo_modelo', $codmodelo);
    $statement->bindParam(':nome_modelo', $nomemodelo);
    $statement->bindParam(':descricao_modelo', $descmodelo);
    $statement->bindParam(':codigo_diferencial', $coddiferencial);
    $statement->bindParam(':codigo_categoria', $codcategoria);
    $statement->bindParam(':caminho', $caminho);
    // Executa a senten�a j� com os valores
    if ($statement->execute()) {
        // Definimos a mensagem de sucesso
        $cod_error = 0;
        $msg = "Atualização Realizado com Sucesso!";
        if(!@copy($caminho,'../public/imagens/modelos/'.$codmodelo.".".$extensao))
        {
            $errors= error_get_last();
             "COPY ERROR: ".$errors['type'];
             "<br />\n".$errors['message'];
        } else {
             "File copied from remote!";
        }
    } else {
        $cod_error = 1;
        $msg ="erro no cadastro";
    }
}
}

