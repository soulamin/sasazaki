<!doctype html>
  <html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rodrigo Furtado">
    <meta name="generator" content="BeeID">
    <meta name="keywords" content="porcelanato, cerâmica, piso, parede, revestimento, ceramica, ceramicos, revestimentos, retificados, peças especiais, portobello, arquiteto">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('assets/img/icons')?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('assets/img/icons')?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/img/icons')?>/favicon-16x16.png">
    <title>Portobello</title>

    <link rel="stylesheet" href="<?=base_url('assets')?>/css/jquery-ui.css">
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('assets')?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets')?>/css/splide.min.css" rel="stylesheet">
    <link href="<?=base_url('assets')?>/css/all.css" rel="stylesheet">  
    <link href="<?=base_url('assets')?>/css/bootstrap-multiselect.css" rel="stylesheet"> 

    <link href="<?=base_url('assets')?>/css/portobello.css?v=<?=time()?>" rel="stylesheet">  
    <!-- LayerSlider stylesheet -->
    <link rel="stylesheet" href="<?=base_url('assets')?>/js/layerslider/css/layerslider.css" type="text/css">
    <!-- External libraries: jQuery & GreenSock 
    <script src="<?=base_url('assets')?>/js/jquery-2.2.4.min.js"></script>-->
    <script src="<?=base_url('assets')?>/js/layerslider/js/jquery.js" type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/js/layerslider/js/layerslider.utils.js" type="text/javascript"></script>
    <!-- LayerSlider script files -->
    <script src="<?=base_url('assets')?>/js/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/js/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
    <!-- QRCODE js -->
    <script src="<?=base_url('assets')?>/js/jquery-ui.js"></script>
    <script src="<?=base_url('assets')?>/js/bootstrap.bundle-4.5.2.min.js"></script>
    <script src="<?=base_url('assets')?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url('assets')?>/js/all.js"></script>
    <script src="<?=base_url('assets')?>/js/splide.min.js"></script>
    <script src="<?=base_url('assets')?>/js/tinysort.min.js"></script>
    <script src="<?=base_url('assets')?>/js/bootstrap-multiselect.js"></script>
    <script src="<?=base_url('assets')?>/js/qrcode.min.js" type="text/javascript"></script>
    <?php if($totem_tipo == 'totem'):?>
    <link href="<?=base_url('assets')?>/css/kioskboard-1.4.0.min.css" rel="stylesheet">  
    <script src="<?=base_url('assets')?>/js/kioskboard-1.4.0.min.js" type="text/javascript"></script>
    <?php endif?>

    <script type="text/javascript" src="https://cdn.roomvo.com/static/scripts/b2b/portobellocombr.js" async></script>

    <!-- Favicons 
    <link rel="apple-touch-icon" href="assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="assets/img/favicons/favicon.ico">
  -->
  <style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }
  /* The side navigation menu */
.sidenav {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1; /* Stay on top */
  top: 0; /* Stay at the top */
  left: 0;
  background-color: #111; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}

/* The navigation menu links */
.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover {
  color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
  transition: margin-left .5s;
  padding: 20px;
}

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  @media (max-width: 1200px) {
    #idiomaDrop {
      /*display: none;*/
    }
  }
  .fa-bars {
    font-size: 2.5rem;
  }
</style>

<script>
  $(function(){
    criarSessao()
  })  

  function criarSessao() {
    var url_atual = window.location.pathname;
    var sessao = '<?= md5(date('Y-m-d H:i:s'));?>'
    
    if (url_atual === "/" || url_atual === '/pt-br' || url_atual === '/en' || url_atual === '/es' || url_atual === '/index.php/home') {
      var sessao = JSON.parse(localStorage.getItem("@PortoBeloSessao"));
			
			sessao['datatermino'] = '<?= date('Y-m-d H:i:s')?>'
			$.ajax({
				method: "POST",
				url: "/api/setarsessao",
				data:sessao,
				success: function() {
					localStorage.removeItem('@PortoBeloSessao')
				}
			})
      return;
    }
    
    var sessaoIniciada = localStorage.getItem("@PortoBeloSessao");
    
    if (sessaoIniciada !== undefined && sessaoIniciada !== null)
      return;

    var objSessao = {
      sessao: sessao,
      datainicio: '<?= date('Y-m-d H:i:s');?>',
      totem_id: '<?= $totem_id;?>'
    }
    localStorage.setItem("@PortoBeloSessao", JSON.stringify(objSessao))
  }
</script>
<!-- Custom styles-->
<link href="<?=base_url('assets')?>/css/carousel.css" rel="stylesheet">
</head>
<body>  
  <?php if($totem_tipo == 'totem'): ?>
  <div id="mydiv" class="btn-group dropend mt-4" style="padding: <?php if($totem_tipo == 'totem') echo '1';?>8px; background-color: transparent">
    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-bars"  style="color:white"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="fakemenu">
      <ul class="list-group list-group-horizontal" id="submenu">
        <li class="list-group-item text-center">
          <a class="dropdown-item " href="<?=base_url($locale)?>"><i class="fas fa-home"></i> <br/><?= lang('Pb.home');?></a>
        </li>
        <li class="list-group-item text-center">
          <a class="dropdown-item" href="<?=base_url($locale.'/caracteristicas')?>"><i class="fas fa-search"></i> <br/><?= lang('Pb.advanced_search');?></a>
        </li>
        <li class="list-group-item text-center">
          <a class="dropdown-item" href="<?=base_url($locale.'/ambientes')?>"><i class="fal fa-file-search"></i> <br/><?= lang('Pb.tech_search');?></a>
        </li>
        <li class="list-group-item text-center">
          <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalTechLib" href="javascript:void(0)"><i class="fas fa-book"></i><br/><?= lang('Pb.tech_lib');?></a>
        </li>
      </ul>
    </ul>
  </div>
  <?php endif ?>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <div class="col-xs-4 col-4">
          <?php if($totem_tipo != 'totem'): ?>
          <button class="btn" id="botaoMenu" type="button" onclick="openNav()" style="margin-top: 0.8rem;float:left;">
            <i class="fas fa-bars" style="color:white"></i>
          </button>
            <div id="mySidenav" class="sidenav">
              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
              <a href="<?=base_url($locale)?>"><i class="fas fa-home"></i> <?= lang('Pb.home');?></a>
              <a href="<?=base_url($locale.'/caracteristicas')?>"><i class="fas fa-search"></i> <?= lang('Pb.advanced_search');?></a>
              <a href="<?=base_url($locale.'/ambientes')?>"><i class="fal fa-file-search"></i> <?= lang('Pb.tech_search');?></a>
              <a href="https://especificadorvirtual.portobello.com.br/area_tecnica/index"><i class="fas fa-book"></i> <?= lang('Pb.tech_lib');?></a>
            </div>
          <?php endif ?>
          <div class="mt-3<?php if($totem_tipo == 'totem'): ?>  text-center" style="float:left; margin-left: 90px;"<?php else: ?>" style="float:left; margin-left: 10px;"<?php endif ?>>
            <div class="dropdown" id="idiomaDrop">
              <a class="btn" type="button" id="dropdownFlags" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; padding: 0;">
                <i class="far fa-globe" style="font-size: 3.5rem; color:white;"></i>
                <h6 id="idioma" style="font-size:0.8rem"><?=lang('Pb.language');?></h6>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownFlags" style="min-width:2.3rem; float: right; top: 0; margin-top: -0.6rem; background-color: transparent; border: none; margin-left: 4rem; position:absolute;">
                <li>
                  <a class="dropdown-item" href="<?=base_url('pt-br')?>" style="padding:0; margin-bottom: 5px;">
                    <img src="<?=base_url('assets/img/flags/flag-brazil.png')?>" class="img-fluid" style="width:2.5rem">
                  </a>
                  </li>
                <li>
                  <a class="dropdown-item" href="<?=base_url('es')?>" style="padding:0; margin-bottom: 5px;">
                    <img src="<?=base_url('assets/img/flags/flag-spain.png')?>" class="img-fluid" style="width:2.5rem">
                  </a>
                  </li>
                <li>
                  <a class="dropdown-item" href="<?=base_url('en')?>" style="padding:0; margin-bottom: 5px;">
                    <img src="<?=base_url('assets/img/flags/flag-uk.png')?>" class="img-fluid" style="width:2.5rem">
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xs-4 col-4 text-center">
          <a href="<?=base_url($locale)?>">
            <img class="img-fluid" src="<?=base_url('assets')?>/img/logo_provisorio.png">
          </a>
        </div>
        <div class="col-xs-4 col-4 text-end">
          <a href="<?=base_url($locale.'/favoritos')?>">
            <span class="fa-layers fa-fw" style="font-size: 3.5rem; color:white;">
              <i class="fas fa-heart" ></i>
              <?php if (isset($_SESSION['favoritos'])): ?>
              <span class="fa-layers-counter" style="background-color:#df3d42"><?=sizeof($_SESSION['favoritos'])?></span>
              <?php endif ?>
            </span>
          </a>
        </div>
      </div>
    </nav>
  </header>
  <script type="text/javascript">
    $(window).load(function(){  
      $("#dropdownMenuButton1").click( 'click', function() {
        $( "#submenu" ).css({'min-height': $( "#mydiv" ).outerHeight()});
        $( "#submenu" ).css({'max-height': $( "#mydiv" ).outerHeight()});
        $( "#submenu" ).css({'height': $( "#mydiv" ).outerHeight()});
        $( "#submenu" ).css({'margin-top': "-"+$.trim($('#fakemenu').css('-webkit-transform').split(/[()]/)[1].split(',')[5]) + "px"});
        
        //$("#fakemenu").css('-webkit-transform',  "translateY(0)");
        //var espaco = $( "#mydiv" ).outerWidth() - 10;
        //$("#fakemenu").css('-webkit-transform',  "translateX("+ espaco +"px)");
      });
    });
    /* Set the width of the side navigation to 250px */
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
  </script>
  <div id="super-wrapper" <?php if($totem_tipo == 'totem') echo 'style="padding-top:0px;"';?>>

  <div class="modal fade" id="modalTechLib" tabindex="-1" aria-labelledby="modalTechLib" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?=lang('Pb.access_tec_lib');?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div id="qrcodelib" class="text-center"></div>
        <script type="text/javascript">
          var qrcodelib = new QRCode("qrcodelib", {
              text: "https://especificadorvirtual.portobello.com.br/area_tecnica/index",
              width: 240,
              height: 240,
              colorDark : "#000000",
              colorLight : "#ffffff",
              correctLevel : QRCode.CorrectLevel.H
          });
        </script>
        </div>
        <div class="modal-footer">
          <h6 class="text-center" ><?=lang('Pb.access_link_qrcode');?></h6>
        </div>
      </div>
    </div>
  </div>