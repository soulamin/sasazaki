<style type="text/css">
  #detalhe {
    font-size: 2em; 
    padding-left:40px;
    padding-top:40px;
    padding-bottom:40px;
    padding-right:20px;
    color:white
  }
  #detalhe h2 {
    font-size:2em;
  }
  #tabelaPai {
     border-radius: 15px; 
     overflow:hidden; 
     margin: 20px;
  }
  #tabelaPai .table{
   text-indent: 30px;
  }
  @media (max-width: 1200px) {
    #detalhe {
      font-size: 1.2em; 
      padding-left:5px;
      padding-top:10px;
      padding-bottom:10px;
      padding-right:5px;
      color:white
    }
    #detalhe h2 {
      font-size:1.4em;
    }
    #tabelaPai {
       margin: 5px;
    }
    #tabelaPai .table{
     text-indent: 10px;
    }
  }
  [data-roomvo-vendor-code] {
    display:none !important
  }
</style>

<div class="container-fluid">
  <div id="detalhe" class="container-fluid">
    <div class="row">
      <div class="col-8">
        <h2><?=lang('Pb.product_detail');?></h2>    
        <?php if(!empty($ambiente)): 
          $crumbs = explode(' - ', $ambiente->N1_Uso_N2);
          $voltar2 = base_url($locale.'/ambientes/pesquisa/'.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'/'.str_replace(' ', '_',convert_accented_characters($crumbs[0])).'/'.$ambiente->N2_id);
          $voltar = base_url($locale.'/produto/linha/' . $produto[0]['groupColor'].'/?ambiente='.$ambiente->N3_id);
        ?>    
        <?php endif; ?>
      </div>
      <div class="col-4 text-end">
        <a href="<?php if(!empty($voltar)) echo $voltar; else echo previous_url()?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5></a>
      </div>
      <?php if(!empty($ambiente)): ?>
      <div class="col-12">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url($locale)?>"><?=lang('Pb.home');?></a></li>
            <li class="breadcrumb-item"><a href="<?=base_url($locale.'?uso='.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'&n1='.str_replace(' ', '_',convert_accented_characters($crumbs[0])))?>"><?=$crumbs[1]?> > <?=$crumbs[0]?></a></li>
            <li class="breadcrumb-item"><a href="<?=$voltar2?>">
              <?=$crumbs[2]?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <a href="<?=$voltar?>"><?=$ambiente->N3?></a>
            </li>
          </ol>
        </nav>
      </div>
      <?php endif ?>
      <?php 
        $favorito_url = $locale.'/favoritos/adicionar/'.$produto[0]['cod_produto'];
        if($produto[0]['sufixo']) 
          $favorito_url = $favorito_url.'/'.$produto[0]['sufixo'];
        if(!empty($ambiente))
          $favorito_url .= '?ambiente='.$ambiente->N3_id;
        $ja_inserido = false;
        $ja_em_outro = false;
        if(!empty($_SESSION['favoritos'])) {
          foreach ($_SESSION['favoritos'] as $key => $value) {
            if($_SESSION['favoritos'][$key]['cod_produto'] == $produto[0]['cod_produto'])
            if($_SESSION['favoritos'][$key]['sufixo'] == $produto[0]['sufixo']) {
              $ja_em_outro = true; 
              if(!empty($ambiente) && ($_SESSION['favoritos'][$key]['jornada'] == $ambiente->N3_id)) {   
                $ja_inserido = true;
              }
              elseif(empty($ambiente) && $_SESSION['favoritos'][$key]['jornada'] == '') {
                $ja_inserido = true;
              }
            }
          }
        }
      ?>
      <div class="col-xl-2 col-lg-3 col-md-8 col-8">
        <div class="splide" id="splide-produto">
          <div class="splide__track">
            <ul class="splide__list">
              <li class="splide__slide">
                <div class="rect-img-container">
                  <img class="rect-img" src="<?=$url_fonte_imgs?><?=$produto[0]['zoomImage'];?>" alt="">
                </div>
              </li>
              <?php 
              foreach ($rel_images as $rel_image) : ?>
                <li class="splide__slide">
                    <div class="rect-img-container">
                      <img class="rect-img" src="<?=$url_fonte_imgs?><?=$rel_image['relatedImageLandscape']?>" />
                    </div>
                </li>         
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="<?=base_url($favorito_url)?>">
            <?php if(!$ja_inserido):?>
            <i class="far fa-heart" style="color:white; position: absolute; top: 3%; right: 3%; font-size: 2rem"></i></a>
            <?php else:?>
            <i class="fas fa-heart" style="color:white; position: absolute; top: 3%; right: 3%; font-size: 2rem"></i></a>
            <?php endif?>  
        </div>
        <div class="d-grid gap-1">
          <?php if(!$ja_inserido):?>
          <a href="<?=base_url($favorito_url)?>" class="">
            <button type="button" class="btn-lg btn-primary mt-3" style="background-color:white; color: black; border-radius: 0.3rem; width: 100%;"><i class="fas fa-paper-plane" style="font-size:0.7em; margin-right: 8px;"></i> <?= lang('Pb.want_to_receive');?></button>
          </a>
          <?php if($ja_em_outro):?><p><small>* Esse produto já foi favoritado em outro ambiente / jornada</small></p>
            <?php endif; endif;?>  
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-4">
        <h4><?=$produto[0]['linha']?> </h4>
        <h4><span style="font-weight:100"><?=$produto[0]['desc_produto']?></span></h4>
        <h5 style="margin-top:30px; font-size: 1em"><?= lang('Pb.material');?></h5>
        <div class="row">
        <?php $locais_de_uso = explode(" ", $produto[0]['uso']);
          foreach ($locais_de_uso as $value):?>
          <div class="col-6 col-xs-6 col-md-6 col-lg-4">
            <div class="rect-img-container">
              <img class="rect-img" src="<?=base_url('assets/img/icons/'.$value.'.png')?>" style="border-radius:0.3rem; border: 2px solid #111016; background-color:black;">
              <?php switch ($value) {
                  case 'RE':
                    $tooltip = 'Residencial';
                    break;
                  case 'FA':
                    $tooltip = 'Fachada';
                    break;
                  case 'CL':
                    $tooltip = 'Comercial Leve';
                    break;
                  case 'RI':
                    $tooltip = 'Revestimento Interno';
                    break;
                  case 'IU':
                    $tooltip = 'Industrial e Urbano';
                    break;
                  case 'CP':
                    $tooltip = 'Comercial Pesado';
                    break;
                  case 'PE':
                    $tooltip = 'Parede Externa';
                    break;
                  default:
                    $tooltip = 'Local de uso';
                    break;
              }?>
            </div>  
              <h6 style="font-size:1rem"><?=$value?> <i class="fas fa-info-circle" style="color:white;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<?=$tooltip?>"></i></h6>        
          </div>
        <?php endforeach; ?>
        </div>
      </div>
      <div class="col-xl-8 col-lg-6 col-md-12 col-xs-12">
        <div class="container-fluid">
          <h4 id="caracteristicas"><?= lang('Pb.tech_features');?></h4>
          <dl class="row">
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?=lang('Pb.code')?></dt>
              <dd><?=$produto[0]['cod_produto']?> <?=$produto[0]['sufixo']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt>Acabamento</dt>
              <dd><?=$produto[0]['caracteristica_acabamento']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.piece_per_box');?></dt>
              <dd><?=$produto[0]['qt_pc_caixa']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.m2_per_box');?></dt>
              <dd><?=$produto[0]['qt_m2_caixa']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.type');?></dt>
              <dd><?=$produto[0]['tipologia_comercial']?></dd>
            </div>  
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.format');?></dt>
              <dd><?=$produto[0]['desc_formato_nominal']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.num_faces');?></dt>
              <dd><?=$produto[0]['nr_faces']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt>Var. de Tonalidade</dt>
              <dd><?=$produto[0]['cod_variacao_tonalidade']?></dd>
            </div>  
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.edge');?></dt>
              <dd><?=$produto[0]['acabamento_de_borda']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.application');?></dt>
              <dd><?=$produto[0]['aplicacao_tecnica']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.thickness');?></dt>
              <dd><?php if(!empty($produto[0]['espessura'])) echo $produto[0]['espessura'].' mm'?> </dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt>Junta de assent.</dt>
              <dd><?=$produto[0]['junta_de_assentamento']?><?php
          if(!empty($produto[0]['junta_de_assentamento'])) {
            $tooltip = lang('Pb.junta_assentamento_p').': '.$produto[0]['junta_assentamento_p'].'<br>';
            $tooltip .= lang('Pb.junta_assentamento_ef').': '.$produto[0]['junta_assentamento_ef'].'<br>';
            $tooltip .= lang('Pb.junta_assentamento_im').': '.$produto[0]['junta_assentamento_im'].'<br>';
            $tooltip .= lang('Pb.junta_assentamento_is').': '.$produto[0]['junta_assentamento_is'];
            echo ' <i class="fas fa-info-circle" style="color:white;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="'.$tooltip.'"></i>';
          }
            ?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.reproduction');?></dt>
              <dd><?=$produto[0]['material']?></dd>
            </div>
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt><?= lang('Pb.color_body');?></dt>
              <dd>
                <?php 
                  if($produto[0]['color_body'] == 'Y'){
                    echo "Sim";
                  }elseif($produto[0]['color_body'] == 'N'){
                    echo "Não";
                  }else{
                    echo "N/D";
                  }
                ?>
              </dd>
            </div>  
            <div class="col-3 col-xl-3 col-lg-4 col-md-4 ">
              <dt>Cor Rejunte</dt>
              <dd><?=$produto[0]['rejunte'] !== null ? $produto[0]['rejunte'] : "-"; ?></dd>
            </div>  
          </dl>
        </div>
      </div>
    </div>
  </div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div id="tabelaPai">
      <table class="table table-hover table-striped" style="border:1px;">
        <thead style="border:1px;  font-size: 2em; padding-top:20px; padding-bottom:20px;">
          <tr style="border:1px;  padding-top:20px; padding-bottom:20px;">
            <th scope="col">Tabela</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody style="border:1px;">
          <tr>
            <th scope="row"><?=lang('Pb.water_absorption')?></th>
            <td><?=$produto[0]['absorcao_dagua']?></td>
          </tr>
          <tr>
            <th scope="row"><?=lang('Pb.wet_friction_coef')?></th>
            <td><?=$produto[0]['atrito_molhado_iso']?></td>
          </tr>
          <tr>
            <th scope="row">Indicação de Uso</th>
            <td><?=$produto[0]['uso']?></td>
          </tr>
          <tr>
            <th scope="row">Resistência à Manchas</th>
            <td><?=$produto[0]['resultado_minimo_manchantes']?></td>
          </tr>
         <!-- <tr>
            <th scope="row">Resistência à produtos de limpeza</th>
            <td><?= $produto[0]['resultado_minimo_limpeza'] ?></td>
          </tr> -->
          <tr>
            <th scope="row"><?=lang('Pb.min_staining_low')?></th>
            <td><?=$produto[0]['ataque_qui_baixa_conc']?></td>
          </tr>
          <!-- <tr>
            <th scope="row"><?=lang('Pb.min_staining_high')?></th>
            <td><?=$produto[0]['ataque_qui_alta_conc']?></td>
          </tr> -->
          <tr>
            <th scope="row"><?=lang('Pb.expansion_humidity')?></th>
            <td><?=$produto[0]['expansao_por_umidade']?></td>
          </tr>
         <!-- <tr>
            <th scope="row">Carga de Ruptura (N)</th>
            <td><?=$produto[0]['carga_ruptura']?></td>
          </tr>
          <tr>
            <th scope="row">Resistência ao Gretamento</th>
            <td><?=$produto[0]['gretagem_port']?></td>
          </tr>
          <tr>
            <th scope="row">Resistência ao Congelamento</th>
            <td><?=$produto[0]['congelamento_port']?></td>
          </tr>
          <tr>
            <th scope="row">Resistência ao Choque Térmico</th>
            <td><?=$produto[0]['choque_termico_port']?></td>
          </tr> -->
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(window).load(function(){  
    new Splide( '#splide-produto', {
      rewind : true,
      loop : true,
      pagination: true,
      arrows: false,
      cover: true
    } ).mount();
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
  
	$(function() {
    adicionarDadosProdutos()
	})

  function adicionarDadosProdutos() {
    
    var produto = {
      "totem_id": '<?= $totem_id; ?>',
      "codigoproduto": '<?=$produto[0]['cod_produto']?>',
      "sessao": '<?= md5(date('Y-m-d H:i:s'))?>',
      "nome": "<?=$produto[0]['desc_produto']?>",
      "imagem": "<?=$produto[0]['zoomImage'];?>",
      "datacadastro": '<?= date('Y-m-d H:i:s')?>'
    }
			$.ajax({
				method: "POST",
				url: "/api/setarnalyticsprodutos",
				data:produto
			})
  }
</script>