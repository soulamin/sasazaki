<!-- Initializing the slider -->
  <div id="slider-wrapper" <?php if($totem_tipo == 'totem') echo 'class="" style="margin-top:0px"';?>>
    <!-- LayerSlider início -->
    <style type="text/css">
      @media only screen and (max-width: 1200px) {
        #layerslider {
          height: 31vh !important;
        }
      }

      @media only screen and (min-width: 1200px) {
        #layerslider {
          height: 600px !important;
        }
      }
    </style>
    <div id="layerslider" style="width:100%;">
      <!-- inicio do slide 1 -->
      <?php foreach($baners as $baner): ?>
      <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 12;">
        <!-- slide imagem de background -->
        <img src="<?=base_url('uploads/baners/'.$baner->imagem)?>" class="ls-bg" alt="Slide background"/>
        <!-- layer 1 -->
        <?php if(!empty($baner->titulo)): ?>
        <h2 class="ls-layer" style="top: 12%; left: 100%; font-size: 3rem; font-weight: 500; color: white; background-color: rgba(0,0,0,0.25); text-shadow:/*1px 0 0 white,0 1px 0 white,-1px 0 0 white,0 -1px 0 white,*/1px 2px 7px rgba(0,0,0,0.8);" data-ls="
          offsetxin: right;
          offsetxout: right;
          offsetyin: 0;
          offsetyout: 0;
          durationin: 2000;
          durationout: 1000;
          delayin: 1000;
          rotateyin: 0;
        ">&nbsp;<?= $baner->titulo ?>&nbsp;&nbsp;&nbsp;</h2>
        <?php endif; ?>
        <?php if(!empty($baner->texto)): ?>
        <div class="ls-layer" style="top: 100%; left: 0%; font-size: 1rem; font-weight: 400; width: 40%; color: white; text-shadow: 2px 2px 8px rgba(0,0,0,1);" data-ls="
          offsetxin: left;
          offsetxout: left;
          offsetyin: 0;
          offsetyout: 0;
          durationin: 1000;
          durationout: 1000;
          delayin: 2000;
          rotateyin: 0;
        "><p style="margin-left: 2rem; margin-bottom: 3.5rem;"><?=wordwrap($baner->texto, 60,"<br>")?></p></div>
        <?php endif; ?>
      </div>
    <?php endforeach ?>
      <!-- fim do slide 1 -->
    </div>
    <!-- LayerSlider Fim -->
  </div>
  <script>
    jQuery("#layerslider").layerSlider({
      skin: 'outline',
      hoverPrevNext: false,
      allowFullscreen: false,
      skinsPath: '<?=base_url('assets')?>/js/layerslider/skins/'
    });
  </script>