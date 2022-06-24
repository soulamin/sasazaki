
<style type="text/css">
  @media only screen and (max-width: 1200px) {
    #layerslider {
      height: 40vh !important;
    }
  }

  @media only screen and (min-width: 1200px) {
    #layerslider {
      height: 600px !important;
    }
  }
</style>
<!-- Initializing the slider -->
  <div id="slider-wrapper">
  <?php 
  if(!empty($env_images) && sizeof($env_images)>0): 
  ?>
    <!-- LayerSlider início -->
    <div id="layerslider" style="width:100%;">
      <!-- inicio do slide 1 -->
      <?php foreach($env_images as $baner): ?>
      <div class="ls-slide" data-ls="slidedelay: 5500; transition2d: 12;">
        <!-- slide imagem de background -->
        <img src="<?=$url_fonte_imgs?><?= $baner["environmentImage"] ?>" class="ls-bg" alt="Slide background"/>
        <!-- layer 1 -->
        <h2 class="ls-layer" style="top: 12%; left: 100%; font-size: 3rem; font-weight: 600; color: white; background-color: rgba(0,0,0,0.25); text-shadow:/*1px 0 0 white,0 1px 0 white,-1px 0 0 white,0 -1px 0 white,*/1px 2px 7px rgba(0,0,0,0.8);" data-ls="
          offsetxin: right;
          offsetxout: right;
          offsetyin: 0;
          offsetyout: 0;
          durationin: 2000;
          durationout: 1000;
          delayin: 1000;
          rotateyin: 0;
        ">&nbsp;<?php if(!empty($produto)) 
                  echo $produto[0]['desc_produto']; 
                elseif(!empty($materiais))  
                  echo $materiais[0]['linha']?>&nbsp;&nbsp;&nbsp;</h2>
        <!-- layer 2 -->
      </div>
    <?php endforeach ?>
      <!-- fim do slide 1 -->
    </div>
    <!-- LayerSlider Fim -->
  <script>
    jQuery("#layerslider").layerSlider({
      skin: 'outline',
      hoverPrevNext: false,
      allowFullscreen: false,
      skinsPath: '<?=base_url('assets')?>/js/layerslider/skins/'
    });
  </script>
  <?php endif; ?>
  </div>