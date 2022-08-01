<?php
require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-produtos.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-produto'};

foreach ($dd as $dados) {
    $inf = $dados;
      json_encode($inf);

      $idlinha = $inf->{'cod-linha'};
      $qtdefolhas = $inf->{'qtde-folhas'};
      $batenteincluso = $inf->{'batente-incluso'};
      $codproduto = $inf->{'cod-produto'};
      $itempai = $inf->{'item-pai'};
      $tipoabertura = $inf->{'tipo-abertura'};
      $largura = $inf->{'largura'};
      $larguralivre = $inf->{'largura-livre'};
      $qtdebascula = $inf->{'qtde-bascula'};
      $descproduto = $inf->{'desc-prod-pdv'};
      $garantia = $inf->{'garantia'};
      $possuitrinco = $inf->{'possui-trinco'};
      $codgrade = $inf->{'cod-grade'};
      $alturalivre = $inf->{'altura-livre'};
      $altura = $inf->{'altura'};
      $batente = $inf->{'batente'};
      $voltagem = $inf->{'voltagem'};
      $itcodigo = $inf->{'it-codigo'};
      $codmodelo = $inf->{'cod-modelo'};
      $codcor = $inf->{'cod-cor'};
      $qtdefolhasfixas = $inf->{'qtde-folhas-fixas'};
      $codfechadura = $inf->{'cod-fechadura'};
      $codmaterial = $inf->{'cod-material'};
      $qtdefolhasmoveis = $inf->{'qtde-folhas-moveis'};
      $linkqrcode =$inf->{'link-qrcode'};

    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_produto) AS qtd FROM produtos WHERE codigo_produto = :codigo_produto";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_produto', $codproduto);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {

        $sql_insert = "INSERT INTO  produtos (id_linha,quantidade_folhas, batente_incluso, codigo_produto, item_pai, 
                    tipo_abertura, largura, largura_livre, quantidade_bascula, descricao_produto, garantia, possui_trinco,
                    altura_livre, altura, batente, voltagem, it_codigo, codigo_modelo, codigo_cor, quantidade_folhas_fixas,
                    id_fechadura,codigo_material,linkqrcode)
                     VALUES (:id_linha,:quantidade_folhas, :batente_incluso, :codigo_produto, :item_pai, 
                    :tipo_abertura, :largura, :largura_livre, :quantidade_bascula, :descricao_produto, :garantia, :possui_trinco,
                    :altura_livre, :altura, :batente, :voltagem, :it_codigo, :codigo_modelo, :codigo_cor, :quantidade_folhas_fixas,
                    :id_fechadura, :codigo_material ,:linkqrcode) ";

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
        $statement->bindParam(':codigo_material', $codmaterial);
        $statement->bindParam(':linkqrcode', $linkqrcode);


        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            
            // Definimos a mensagem de sucesso
            $cod_error = 0;
            $msg = "Cadastro Realizado com Sucesso!";
        } else {
            print_r($statement->errorInfo());
            $cod_error = 1;
            $msg ="erro no cadastro";
        }
    } else {
        $sql_update = "UPDATE produtos SET id_linha =:id_linha,quantidade_folhas = :quantidade_folhas, batente_incluso =:batente_incluso, item_pai = :item_pai, 
                                     tipo_abertura = :tipo_abertura, largura=:largura, largura_livre=:largura_livre, 
                                     quantidade_bascula=:quantidade_bascula, 
                                    descricao_produto=:descricao_produto, garantia=:garantia,possui_trinco =:possui_trinco,
                                    altura_livre = :altura_livre, altura=:altura,batente = :batente, voltagem=:voltagem, it_codigo=:it_codigo, 
                                    codigo_modelo = :codigo_modelo, codigo_cor = :codigo_cor, quantidade_folhas_fixas = :quantidade_folhas_fixas,
                                    id_fechadura=:id_fechadura , codigo_material=:codigo_material,  linkqrcode=:linkqrcode WHERE codigo_produto =:codigo_produto";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);

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
        $statement->bindParam(':codigo_material', $codmaterial);
        $statement->bindParam(':linkqrcode', $linkqrcode);


        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
            $msg = "Atualização Realizado com Sucesso!";
        } else {
            $cod_error = 1;
            $msg ="erro no cadastro";
        }
    }
   
}
