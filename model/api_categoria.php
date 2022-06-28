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

  echo  $idlinha = $inf->{'cod-linha'};
  echo  $qtdefolhas = $inf->{'qtde-folhas'};
  echo  $batenteincluso = $inf->{'batente-incluso'};
  echo  $codproduto = $inf->{'cod-produto'};
  echo  $itempai = $inf->{'item-pai'};
  echo  $tipoabertura = $inf->{'tipo-abertura'};
  echo  $largura = $inf->{'largura'};
  echo  $larguralivre = $inf->{'largura-livre'};
  echo  $qtdebascula = $inf->{'qtde-bascula'};
  echo  $descproduto = $inf->{'desc-produto'};
  echo  $garantia = $inf->{'garantia'};
  echo  $possuitrinco = $inf->{'possui-trinco'};
  echo  $codgrade = $inf->{'cod-grade'};
  echo  $alturalivre = $inf->{'altura-livre'};
  echo  $altura = $inf->{'altura'};
  echo  $batente = $inf->{'batente'};
  echo  $voltagem = $inf->{'voltagem'};
  echo  $itcodigo = $inf->{'it-codigo'};
  echo  $codmodelo = $inf->{'cod-modelo'};
  echo  $codcor = $inf->{'cod-cor'}; 
  echo  $qtdefolhasfixas = $inf->{'qtde-folhas-fixas'};
  echo  $codfechadura = $inf->{'cod-fechadura'};
  echo  $codmaterial = $inf->{'cod-material'};
  echo  $qtdefolhasmoveis = $inf->{'qtde-folhas-moveis'};

  echo '<hr>';

  $sql_insert = "INSERT INTO produtos( id_linha, quantidade_folhas, batente_incluso, codigo_produto, item_pai, 
  tipo_abertura, largura, largura_livre, quantidade_bascula, descricao_produto, garantia, possui_trinco,
   altura_livre, altura, batente, voltagem, it_codigo, codigo_modelo, codigo_cor, quantidade_folhas_fixas,
   id_fechadura) VALUES (:id_linha,:quantidade_folhas, :batente_incluso, :codigo_produto, :item_pai, 
  :tipo_abertura, :largura, :largura_livre, :quantidade_bascula, :descricao_produto, :garantia, :possui_trinco,
   :altura_livre, :altura, :batente, :voltagem, :it_codigo, :codigo_modelo, :codigo_cor, :quantidade_folhas_fixas,
   :id_fechadura)";

 // Prepara uma senten�a para ser executada                                               
 $statement = $pdo->prepare($sql_insert);

 $statement->bindParam(':id_linha', $idlinha);
 $statement->bindParam(':quantidade_folhas', $qtdefolhas);
 $statement->bindParam(':batente_incluso', $batenteincluso);
 $statement->bindParam(':codigo_produto', $codproduto);
 $statement->bindParam(':item_pai', $itempai);
 $statement->bindParam(':tipo_abertura', $tipoabertura);
 $statement->bindParam(':largura', $largura);
 $statement->bindParam(':largura_livre', $larguralivre);
 $statement->bindParam(':quantidade_bascula', $qtdebascula);
 $statement->bindParam(':descricao_produto', $descproduto);
 $statement->bindParam(':garantia', $garantia);
 $statement->bindParam(':possui_trinco', $possuitrinco);
 $statement->bindParam(':altura_livre', $alturalivre);
 $statement->bindParam(':altura', $altura);
 $statement->bindParam(':batente', $batente);
 $statement->bindParam(':voltagem', $voltagem);
 $statement->bindParam(':it_codigo', $itcodigo);
 $statement->bindParam(':codigo_modelo', $codmodelo);
 $statement->bindParam(':codigo_cor', $codcor);
 $statement->bindParam(':quantidade_folhas_fixas', $qtdefolhasfixas);
 $statement->bindParam(':id_fechadura', $codfechadura);
 

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
