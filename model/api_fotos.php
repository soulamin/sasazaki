<?php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 0);   

require '../fontes/conexao.php';
$username = "sistemas";
$password = "sasazaki";

$urlaut = "http://187.92.100.10:8180/api/esp/v1/sszk-fotos.r";
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
$dd = $j->items[0]->{'v-ds-tabelas'}->{'tt-sk-foto'};

foreach ($dd as $dados) {
    $inf = $dados;
    json_encode($inf);

     $sequencia = $inf->{'sequencia'};
     $caminho = $inf->{'caminho'};
     $codfoto = $inf->{'cod-foto'};
     $tipofoto = $inf->{'tipo-foto'};
     $extensao = substr($caminho, -3)=='peg'?'jpeg':substr($caminho, -3);
     $caminholocal = "public/imagens/fotos/".$codfoto.".".$extensao ;
    /* Verifica se ja existe codigo cadastrado */
    $sql_select = "SELECT COUNT(codigo_foto) AS qtd FROM fotos WHERE codigo_foto = :codigo_foto";
    $stverifica = $pdo->prepare($sql_select);
    $stverifica->bindParam(':codigo_foto', $codfoto);
    $stverifica->execute();
    $linha =  $stverifica->fetch();

    if ($linha['qtd'] == 0) {
      
        $sql_insert = "INSERT INTO fotos(codigo_foto,tipo_foto ,caminho,caminholocal, sequencia)
                                 VALUES (:codigo_foto,:tipo_foto ,:caminho,:caminholocal,:sequencia) ";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_insert);
        $statement->bindParam(':codigo_foto', $codfoto);
        $statement->bindParam(':tipo_foto', $tipofoto);
        $statement->bindParam(':caminho', $caminho);
        $statement->bindParam(':sequencia', $sequencia);
        $statement->bindParam(':caminholocal', $caminholocal);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
            $cod_error = 0;
             $msg = "Cadastro Realizado com Sucesso!";

             if(!@copy($caminho,'../public/imagens/'.$codfoto.".".$extensao))
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


        $sql_update = "UPDATE fotos SET tipo_foto=:tipo_foto ,caminho=:caminho, caminholocal=:caminholocal, 
                                               sequencia=:sequencia
                                                WHERE codigo_foto=:codigo_foto";

        // Prepara uma senten�a para ser executada                                               
        $statement = $pdo->prepare($sql_update);
        $statement->bindParam(':codigo_foto', $codfoto);
        $statement->bindParam(':tipo_foto', $tipofoto);
        $statement->bindParam(':caminho', $caminho);
        $statement->bindParam(':caminholocal', $caminholocal);
        $statement->bindParam(':sequencia', $sequencia);
        // Executa a senten�a j� com os valores
        if ($statement->execute()) {
            // Definimos a mensagem de sucesso
         /*    if(file_exists( $caminho,'../public/imagens/'.$codfoto.".".$extensao)){
                unlink($$caminho,'../public/imagens/'.$codfoto.".".$extensao);
              }
 */

            if(!@copy($caminho,'../public/imagens/'.$codfoto.".".$extensao))
            {
                $errors= error_get_last();
                 "COPY ERROR: ".$errors['type'];
                 "<br />\n".$errors['message'];
            } else {
                 "File copied from remote!";
            }

            $cod_error = 0;
            $msg = "Cadastro Atualizado com Sucesso!";
        } else {
            $cod_error = 1;
            $msg ="erro no cadastro";
        }
    }
}

