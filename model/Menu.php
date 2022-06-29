<?php

/**
 * Created by PhpStorm.
 * User: ALAN Lamin
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';

$acao = $_POST['acao'];

switch ($acao) {

  case 'Sair':

    session_start();
    session_destroy();
    $Resultado['Cod_Error'] = 1;
    echo json_encode($Resultado);

    break;

  case 'Validar':

    session_start();
    if (!isset($_SESSION['LOGIN'])) {
      session_destroy();
      $Resultado['Cod_Error'] = 1;
      $html = 1;
    } else {

      $TipoPerfil = $_SESSION['NIVEL'];

      $Saudacao = '<b class="text-primary ">BEM VINDO, ' . strtoupper($_SESSION['LOGIN']) .
        ' <i class="fa fa-sort-desc"> </i>  </b>';

      switch ($TipoPerfil) {

          // Tipo de Perfil ADMINISTRADOR
        case '2':
          $MenuLateral = '<li class="nav-item">
          <a href="#" class="nav-link">
          <i class="nav-icon fa fa-shopping-cart"></i>
            <p>Lojas<i class="fa fa-angle-left right"></i>
          </p>
          </a>
        <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item btnGrupoToten" >
            <a href="#" class="nav-link ">
            <i class="fa  fa-columns nav-icon"></i>
            <p>Grupo Totens</p>
            </a>
            </li>

            <li class="nav-item btnTotens">
            <a href="#" class="nav-link">
            <i class="fa fa-tablet nav-icon "></i>
            <p>Totens</p>
            </a>
            </li>

            <li class="nav-item  btnBanners">
            <a href="#" class="nav-link">
            <i class="fa fa-tag nav-icon"></i>
            <p>Banners</p>
            </a>
            </li>
        </ul>
      </li>

      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class="nav-icon fa fa-ticket"></i>
        <p>Produtos<i class="fa fa-angle-left right"></i>
      </p>
      </a>
    <ul class="nav nav-treeview" style="display: none;">

        <li class="nav-item btnProdutos">
        <a href="#" class="nav-link ">
        <i class="fa  fa-columns nav-icon"></i>
        <p>Lista Produtos</p>
        </a>
        </li>

        <li class="nav-item btnAmbientes">
        <a href="#" class="nav-link">
        <i class="fa fa-archive nav-icon "></i>
        <p>Ambientes </p>
        </a>
        </li>


        <li class="nav-item btnModelos">
        <a href="#" class="nav-link">
        <i class="fa fa-book nav-icon "></i>
        <p>Modelos</p>
        </a>
        </li>

    </ul>
  </li>
  
  
  <li class="nav-item">
  <a href="#" class="nav-link">
  <i class="nav-icon fa fa-users"></i>
    <p>Usuários<i class="fa fa-angle-left right"></i>
  </p>
  </a>
<ul class="nav nav-treeview" style="display: none;">
    <li class="nav-item">
    <a href="#" class="nav-link btnUsuarios">
    <i class="fa  fa-user"></i>
    <p>Cadastro</p>
    </a>
    </li>

    <li class="nav-item btnPapeis">
    <a href="#" class="nav-link">
    <i class="fa fa-clone nav-icon "></i>
    <p>Papéis</p>
    </a>
    </li>

    <li class="nav-item btnFuncionalidades">
    <a href="#" class="nav-link">
    <i class="fa fa-cogs nav-icon "></i>
    <p>Funcionalidades</p>
    </a>
    </li>
</ul>
</li>

<li class="nav-item">
<a href="#" class="nav-link">
<i class="nav-icon fa fa-spinner"></i>
<p>Atualizações<i class="fa fa-angle-left right"></i>
</p>
</a>
<ul class="nav nav-treeview" style="display: none;">
<li class="nav-item">
<a href="#" class="nav-link btnImportProd">
<i class="fa fa-exchange"></i>
<p>Importar Produtos</p>
</a>
</li>

    <li class="nav-item">
    <a href="#" class="nav-link">
    <i class="fa fa-calendar nav-icon btnAgendaAtualizacao"></i>
    <p>Agendar Atualização</p>
    </a>
    </li>
  </ul>
</li>
<li class="nav-item">
<a href="#" class="nav-link">
<i class="fa fa-bar-chart nav-icon btnAnalytics"></i>
<p>Analytics</p>
</a>
</li>';

          $Tipo = $TipoPerfil;

          break;

          //Fiscalizador
        case '4':

          $MenuLateral = '<li class="nav-item">
          <a href="#" class="nav-link">
          <i class="nav-icon fa fa-shopping-cart"></i>
            <p>Lojas<i class="fa fa-angle-left right"></i>
          </p>
          </a>
        <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item btnGrupoToten" >
            <a href="#" class="nav-link ">
            <i class="fa  fa-columns nav-icon"></i>
            <p>Grupo Totens</p>
            </a>
            </li>

            <li class="nav-item btnTotens">
            <a href="#" class="nav-link">
            <i class="fa fa-tablet nav-icon "></i>
            <p>Totens</p>
            </a>
            </li>

            <li class="nav-item  btnBanners">
            <a href="#" class="nav-link">
            <i class="fa fa-tag nav-icon"></i>
            <p>Banners</p>
            </a>
            </li>
        </ul>
      </li>

      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class="nav-icon fa fa-ticket"></i>
        <p>Produtos<i class="fa fa-angle-left right"></i>
      </p>
      </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item btnProdutos">
        <a href="#" class="nav-link ">
        <i class="fa  fa-tags nav-icon"></i>
        <p>Lista Produtos</p>
        </a>
        </li>

        <li class="nav-item btnCategorias">
        <a href="#" class="nav-link">
        <i class="fa fa-archive nav-icon "></i>
        <p>Categorias </p>
        </a>
        </li>

        <li class="nav-item btnAmbientes">
        <a href="#" class="nav-link">
        <i class="fa fa-archive nav-icon "></i>
        <p>Ambientes </p>
        </a>
        </li>

        <li class="nav-item btnLinhas">
        <a href="#" class="nav-link">
        <i class="fa fa-archive nav-icon "></i>
        <p>Linhas </p>
        </a>
        </li>

        <li class="nav-item btnModelos">
        <a href="#" class="nav-link">
        <i class="fa fa-archive nav-icon "></i>
        <p>Modelos</p>
        </a>
        </li>

    </ul>
  </li>
  
  
  <li class="nav-item">
  <a href="#" class="nav-link">
  <i class="nav-icon fa fa-users"></i>
    <p>Usuários<i class="fa fa-angle-left right"></i>
  </p>
  </a>
<ul class="nav nav-treeview" style="display: none;">
    <li class="nav-item">
    <a href="#" class="nav-link btnUsuarios">
    <i class="fa  fa-user"></i>
    <p>Cadastro</p>
    </a>
    </li>

    <li class="nav-item btnPapeis">
    <a href="#" class="nav-link">
    <i class="fa fa-clone nav-icon "></i>
    <p>Papéis</p>
    </a>
    </li>

    <li class="nav-item btnFuncionalidades">
    <a href="#" class="nav-link">
    <i class="fa fa-cogs nav-icon "></i>
    <p>Funcionalidades</p>
    </a>
    </li>
</ul>
</li>

<li class="nav-item">
<a href="#" class="nav-link">
<i class="nav-icon fa fa-spinner"></i>
<p>Atualizações<i class="fa fa-angle-left right"></i>
</p>
</a>
<ul class="nav nav-treeview" style="display: none;">
<li class="nav-item">
<a href="#" class="nav-link btnImportProd">
<i class="fa fa-exchange"></i>
<p>Importar Produtos</p>
</a>
</li>

    <li class="nav-item">
    <a href="#" class="nav-link">
    <i class="fa fa-calendar nav-icon btnAgendaAtualizacao"></i>
    <p>Agendar Atualização</p>
    </a>
    </li>
  </ul>
</li>
<li class="nav-item">
<a href="#" class="nav-link">
<i class="fa fa-bar-chart nav-icon btnAnalytics"></i>
<p>Analytics</p>
</a>
</li>';

          $Tipo = $TipoPerfil;

          break;
      }
      $MenuTopo = '<li class=" text-white nav-item dropdown ">
                                    <a class="nav-link text-white" data-toggle="dropdown" href="#" >
                                      ' . $Saudacao . '
                                     <i class="nav-icon fa fa-caret-down"> </i>
                                     </a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <a href="#"> <span class="dropdown-item dropdown-header btnAlteraSenha text-center ">ALTERAR SENHA</span></a>
                                    <a href="#"> <span   id="btnSair" class="dropdown-item dropdown-header  text-center ">SAIR </span></a>
                                     
                          </li>';

      /*  $MenuLateral .= '<li class="nav-item ">
                                   <a href="#"  class="nav-link btnAjudaSuporte">
                                       <i class="nav-icon fa fa-question-circle"></i>
                                        <p>Ajuda/Suporte</p>
                                    </a>
                                 </li>';   */
      // Tipo de Perfil Visualizador
      $Resultado['Cod_Error'] = 0;
      $Resultado['MenuTopo'] = $MenuTopo;
      $Resultado['MenuLateral'] = $MenuLateral;
      $Resultado['Tipo'] = $Tipo;
    }
    echo json_encode($Resultado);

    break;
}
