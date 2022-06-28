<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-modelos.r";
$dados = array(
  
);
$json = json_encode($dados);
$ch = curl_init( $urlaut );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Authorization: Basic '. base64_encode("$username:$password"),
        'Content-Type: application/json',
        'Accept: application/json',
        'Content-Length: ' . strlen($json),
        'charset=utf-8',
    )
);
$Resultado  = curl_exec( $ch );
$j          = json_decode($Resultado,false);
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-produto'};

foreach ( $dd as $dados ){
    $inf = $dados;
   json_encode($inf);

  echo  $nomemodelo = $inf->{'nome-modelo'};
  echo  $codmodelo = $inf->{'cod-modelo'};
  echo  $descmodelo = $inf->{'desc-modelo'};
  echo  $coddiferencial = $inf->{'cod-diferencial'};
  echo  $codcategoria = $inf->{'codcategoria'};
  echo '<hr>';

  $sql_insert = "INSERT INTO modelos(codigo_modelo, descricao_modelo, codigo_diferencial, codigo_categoria) 
  VALUES (:codigo_modelo, :descricao_modelo, :codigo_diferencial, :codigo_categoria) ";

 // Prepara uma senten�a para ser executada                                               
 $statement = $pdo->prepare($sql_insert);

 $statement->bindParam(':codigo_modelo', $idlinha);
 $statement->bindParam(':descricao_modelo', $qtdefolhas);
 $statement->bindParam(':codigo_diferencial', $batenteincluso);
 $statement->bindParam(':codigo_categoria', $codproduto);

 // Executa a senten�a j� com os valores
 if ($statement->execute()) {
     // Definimos a mensagem de sucesso
     $cod_error = 0;
    $msg = "Cadastro Realizado com Sucesso!";
 } else {
     $cod_error = 1;
     $msg = " Usuário já Cadastro!";
 }

 echo $msg.'<br>';



}
/* var_dump($dd); */
