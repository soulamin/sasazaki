<!-- Initializing the slider -->

  <div id="slider-wrapper" style="padding-top: 200px;">
    <!-- LayerSlider início -->
    <div id="layerslider" style="width:100%;height:600px">
      <!-- inicio do slide 1 -->
      <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 75,79;">
        <!-- slide imagem de background -->
        <img src="<?=base_url('assets')?>/img/productGroupColor_3598_10pbl_amb_29856_e_quartzites_mont_blanc_120x120_nat_ret_29683_e_quartzites_mont_blanc_60x120_pol_ret_29682_e_quartzites_mont_blanc_120x270_pol_ret_6mmRGB.jpg" class="ls-bg" alt="Slide background"/>
        <!-- layer 1 -->
        <h2 class="ls-l" style="top: 60px; left: 30%; font-size:  4em; font-weight: 700; color: black; -webkit-text-stroke: 1px white;" data-ls="
          offsetxin: 0;
          offsetxout: 0;
          offsetyin: top;
          offsetyout: top;
          durationin: 2000;
          durationout: 1000;
          delayin: 2000;
          rotateyin: 0;
        ">Mont Blanc</h2>
        <!-- layer 2 -->
        <div class="ls-l" style="top: 60%; left: 80%; width: 220px; height: 300px; padding: 30px; background-color: rgba(0,0,0,0.7);border-radius: 20px;" data-ls="
          offsetxin: right;
          offsetxout: right;
          offsetyin: 0;
          offsetyout: 0;
          durationin: 2000;
          durationout: 1000;
          delayin: 3000;
          rotateyin: 0;
        ">
          <div class="text-start" style="font-size:1em; color: white; float: left;height: 70px;margin-left:10px;"><i class="far fa-house fa-3x" style="margin-top:10px;"></i></div>
          <div class="text-start" style="font-size:1em; color: white; float: left; margin-top:15px;margin-left:10px;"><strong>SIMULE</strong> EM <br>SEU <strong>AMBIENTE</strong></div>
          <p class="text-center" style="margin-top:20px;"><img src="<?=base_url('assets')?>/img/qrcode.png" /></p>
        </div>
      </div>
      <!-- fim do slide 1 -->

      <!-- inicio do slide 2 -->
      <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 5; timeshift: -1000;">
        <!-- slide imagem de background -->
        <img src="<?=base_url('assets')?>/img/productGroupColor_3598_40pbl_amb_29682_e_quartzites_mont_blanc_120x270_pol_ret_6mm_29856_e_quartzites_mont_blanc_120x120_nat_ret_29804_e_nord_ris_90x180_nat_ret_9mm_01.jpg" class="ls-bg" alt="Slide background"/>
        <!-- layer 1 -->
        <h2 class="ls-l" style="top: 60px; left: 30%; font-size:  4em; font-weight: 700; color: black; -webkit-text-stroke: 1px white;" data-ls="
          offsetxin: 0;
          offsetxout: 0;
          offsetyin: top;
          offsetyout: top;
          durationin: 2000;
          durationout: 1000;
          delayin: 2000;
          rotateyin: 0;
        ">Mont Blanc</h2>
        <!-- layer 2 -->
        <div class="ls-l" style="top: 60%; left: 80%; width: 220px; height: 300px; padding: 30px; background-color: rgba(0,0,0,0.7);border-radius: 25px;" data-ls="
          offsetxin: right;
          offsetxout: right;
          offsetyin: 0;
          offsetyout: 0;
          durationin: 2000;
          durationout: 1000;
          delayin: 3000;
          rotateyin: 0;
        ">
          <div class="text-start" style="font-size:1em; color: white; float: left;height: 70px;margin-left:10px;"><i class="far fa-house fa-3x" style="margin-top:10px;"></i></div>
          <div class="text-start" style="font-size:1em; color: white; float: left; margin-top:15px;margin-left:10px;"><strong>SIMULE</strong> EM <br>SEU <strong>AMBIENTE</strong></div>
          <p class="text-center" style="margin-top:20px;"><img src="<?=base_url('assets')?>/img/qrcode.png" /></p>
        </div>
      </div>
      <!-- fim do slide 2 -->

    </div>
    <!-- LayerSlider Fim -->
  </div>

  <script>
    jQuery("#layerslider").layerSlider({
      responsive: false,
      responsiveUnder: 1280,
      layersContainer: 1280,
      skin: 'noskin',
      hoverPrevNext: false,
      allowFullscreen: false,
      skinsPath: '<?=base_url('assets')?>/js/layerslider/skins/'
    });
  </script>