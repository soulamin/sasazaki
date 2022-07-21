<?php
include 'api_acabamentos.php';
 include 'api_ambientes.php';
include 'api_categorias.php';
include 'api_cores.php';
include 'api_diferenciais.php';
include 'api_embalagens.php';
include 'api_fechaduras.php';
include 'api_fechos.php';
include 'api_fotos.php';
include 'api_grades.php';
include 'api_linhas.php';
include 'api_materiais.php';
include 'api_modelos.php';
include 'api_opcionais.php';
include 'api_produtos_acabamentos.php';
include 'api_produtos_ambientes.php';
include 'api_produtos_diferenciais.php';
include 'api_produtos_embalagens.php';
include 'api_produtos_fechos.php';
include 'api_produtos_fotos.php';
include 'api_produtos_opcionais.php';
include 'api_produtos_tratamentos.php';
include 'api_produtos_vidros.php';
include 'api_produtos.php';
include 'api_tratamentos.php';
include 'api_vidros.php'; 

$resultado['cod_error'] = 0;
echo json_encode($resultado);

