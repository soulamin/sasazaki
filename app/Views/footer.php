  <!-- FOOTER -->
</div>
  <footer>
    <div>
      <?php if($totem_tipo == 'totem'): ?>
        <div id="slider-wrapper">
          <!-- LayerSlider início -->
          <div id="layerslider_footer" style="width:100%;height:<?php if($totem_tipo == 'totem') echo '330px'; else echo '450px';?>">
            <!-- inicio do slide 1 -->
            <?php 
            if(!empty($footer_baner)):
              foreach($footer_baner as $baner): ?>
            <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 12;">
              <!-- slide imagem de background -->
              <img src="<?=base_url('uploads/baners/'.$baner->imagem)?>" class="ls-bg" alt="Slide background"/>
              <!-- layer 1 -->
              <?php 
              if(!empty($baner->titulo)): ?>
              <h2 class="ls-layer" style="top: 12%; left: 100%; font-size: 3rem; font-weight: 600; color: white; background-color: rgba(0,0,0,0.25); text-shadow:/*1px 0 0 white,0 1px 0 white,-1px 0 0 white,0 -1px 0 white,*/1px 2px 7px rgba(0,0,0,0.8);" data-ls="
                offsetxin: 0;
                offsetxout: 0;
                offsetyin: top;
                offsetyout: top;
                durationin: 2000;
                durationout: 1000;
                delayin: 2000;
                rotateyin: 0;
              "><?= $baner->titulo ?>&nbsp;&nbsp;&nbsp;</h2>
              <?php 
              endif; ?>
              <div class="ls-layer" style="top: 100%; left: 3%; padding: 5px; background-color: rgba(255, 255, 255, 0.9); " data-ls="
                offsetxin: 0;
                offsetxout: 0;
                durationin: 1000;
                durationout: 1000;
                delayin: 0;
                rotateyin: 0;
              ">
                <a id="acessibilidade" href="#" style="color: black">
                    <i style="font-size: 2rem;" class="fas fa-wheelchair"></i>
                </a>
              </div>
            </div>
            <!-- fim do slide 1 -->
            <?php 
            endforeach; 
          else: ?>
            <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 12;">
                <img src="<?=base_url('uploads/baners/BANNER_DIGITAL_SUSTENTABILIDADE.jpg')?>" class="ls-bg" alt="Slide background"/>
            </div>
          <?php 
          endif; ?>
          </div>
          <!-- LayerSlider Fim -->
        </div>
      <?php endif ?>
    </div>
    <div style="text-align: right; padding: 5px; margin: 0">
      <p>Data da última atualização <?= $dataatualizacao?> - versão 1.40.3</p>
    </div>
  </footer>
  <div class="modal " id="timeout" tabindex="-1" aria-labelledby="timeoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timeoutLabel">Oi, você ainda está por aqui?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="font-size:1.2rem;">Parece que faz um tempo desde a sua última interação.</p>
        <p style="font-size:1.2rem;">Deseja continuar a jornada atual?</p>
      </div>
      <div class="modal-footer text-center">
        <button type="button" id="btncontinuar" class="btn btn-secondary" data-bs-dismiss="modal">Continuar Jornada</button>
        <a type="button" id="btnreiniciar" class="btn btn-primary" href="<?=base_url($locale.'/home/reiniciar')?>">Não, recomeçar.</a>
      </div>
    </div>
  </div>
</div>
<div class="modal " id="timeoutFin" tabindex="-1" aria-labelledby="timeoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timeoutLabel">Oi, você ainda está por aqui?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="font-size:1.2rem;">Reiniciando por inatividade em cinco segundos!</p>
    </div>
  </div>
</div>
<script type="text/javascript">
  var modal_open = 0;
  var timeoutHandle;
  document.getElementById('btncontinuar').onclick = function(){clearTimeout(timeoutHandle);modal_open=0;};
  $(document).ready(function() {
    $('img').on('error', function() {
      $(this).attr('src', '<?=base_url('uploads/ambientes/semimagem.jpg')?>');
    });
  });
  $(window).load(function(){  
    $( "body" ).css({'padding-top': $( ".fixed-top" ).outerHeight()});
    $( "#super-wrapper" ).css({'min-height': $(window).height() - $( "footer" ).outerHeight() - $( ".fixed-top" ).outerHeight()});
    $("#acessibilidade").click( 'click', function acessibilidade(evt) {
      evt.preventDefault();
      if($( "body" ).css('padding-top') == "0px" || $( "body" ).css('padding-top') == 0) {
        $( "footer" ).css({'padding-bottom': 0});
        $( ".fixed-top" ).css({top: 0, bottom: 'auto'});
        $( "body" ).css({'padding-top': $( ".fixed-top" ).outerHeight()});
      }
      else {
        $( "footer" ).css({'padding-bottom': $( ".fixed-top" ).outerHeight()});
        $( ".fixed-top" ).css({bottom: 0, top: 'auto'});
        $( "body" ).css({'padding-top': 0});
      }
    });
    $( "#mydiv" ).draggable({ axis: 'y' });
    jQuery("#layerslider_footer").layerSlider({
      skin: 'outline',
      hoverPrevNext: false,
      allowFullscreen: false,
      skinsPath: '<?=base_url('assets')?>/js/layerslider/skins/'
    });

    <?php if($cronometro):?>
    <?php if (isset($_SESSION['favoritos'])){
      $isfavoritos=1;
    }else{
      $isfavoritos=0;
  }?>
    var myModal = new bootstrap.Modal(document.getElementById('timeout'));
    var myModalFin = new bootstrap.Modal(document.getElementById('timeoutFin'));
    reiniciarTimer();
    var myModalEl = document.getElementById('timeout');
    myModalEl.addEventListener('hidden.bs.modal', function (event) {
      reiniciarTimer();
    });
    
    function reiniciarTimer() {
      
      if (modal_open == 0){
        var session = <?php echo $isfavoritos;?>;
        if ((location.href!='http://localhost/portobello/public/' && location.href!='http://localhost/portobello/public/index.php/home') || session){
          timeoutHandle = window.setTimeout(function() { 
            modal_open = 1; reiniciarTimer(); myModal.show();
          }, <?=$cronometro*1000?>);
        }
        
        $(document).on('touchstart mousemove', function() {
          var session = <?php echo $isfavoritos;?>;
          if ((location.href!='http://localhost/portobello/public/' && location.href!='http://localhost/portobello/public/index.php/home') || session){
        
            window.clearTimeout(timeoutHandle);
            timeoutHandle = window.setTimeout(function() { 
              modal_open = 1; reiniciarTimer(); myModal.show();
            }, <?=$cronometro*1000?>);
          }
        });
      }
      else{       
        window.clearTimeout(timeoutHandle);
        timeoutHandle = window.setTimeout(function() { 
          document.getElementById('btncontinuar').click();myModalFin.show();modal_open= 0;timeoutHandle = window.setTimeout(function() { document.getElementById('btnreiniciar').click();},10000);
            }, <?=$cronometro*1000?>);
       
         //click no botão
      }
    };
    <?php endif ?>
  });
  
  </script>
  
</body>
</html>