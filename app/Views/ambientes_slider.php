<div class="slider-minis container-fluid pt-5">
	<div class="row">
		<?php if($totem_tipo == 'totem'):?>
			<div class="col-2"></div>
			<div class="col-10 pb-3">
		<?php else: ?>
			<div class="col-12 pb-3">
		<?php endif?>
				<div class="input-group input-group-lg mb-3 ui-widget">
					<input type="text" class="form-control js-kioskboard-input" aria-label="pesquisar" placeholder="Buscar" aria-describedby="pesquisa" id="pesquisa_field" data-kioskboard-type="all" data-kioskboard-specialcharacters="true">
					<span class="input-group-text" id="pesquisa"><i class="fas fa-search"></i></span>
				</div>
			</div>
	</div>
>	<div class="row">
		<div class="col-sm-10">
			<div class="float-start pe-5">
		    <style type="text/css">
		      @media only screen and (max-width: 1200px) {
		        h3 {
		          font-size: 1.7rem;
		        }
		        .ls-nav-prev {
		        	display: none;
		        }
		        .ls-nav-next {
		        	display: none;
		        }
		      }
	        #vertodos {
	        	position: absolute;
				    bottom: 0;
				    right: 0;
				    margin-right: 1rem;
	        }
		    </style>
				<h3><?=lang('Pb.choose_environment');?></h3>
			</div>
			<form>
				<div class="float-start pb-2">
					<select class="form-select" aria-label="Tipo de uso" id="usoSelect" name="uso">
					<?php 
						foreach ($usos as $uso): 
						?>
					  <option value="<?=str_replace(' ', '_',convert_accented_characters($uso->Uso_nome))?>" <?php if (!empty($uri['uso']) && str_replace(' ', '_',convert_accented_characters($uso->Uso_nome)) == $uri['uso']) echo 'selected'?>><?=$uso->Uso_nome?></option>
					<?php endforeach; ?>
					</select>
				</div>
				<div class="float-start pb-2 ps-2">
					<select class="form-select" aria-label="Piso ou Parede" id="N1Select" name="n1">
					<?php 
						foreach ($n1s as $n1): 
						?>
					  <option value="<?=str_replace(' ', '_',convert_accented_characters($n1->N1_nome))?>" <?php if (!empty($uri['n1']) && str_replace(' ', '_',convert_accented_characters($n1->N1_nome)) == $uri['n1']) echo 'selected'?>><?=$n1->N1_nome?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</form>
			<div class="clearfix"></div>
			<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?=base_url($locale)?>"><?=lang('Pb.home');?></a></li>
			    <li class="breadcrumb-item active" aria-current="page">
			    	<?=$uri['uso']?> > <?=$uri['n1']?>
			    </li>
			  </ol>
			</nav>
		</div>
		<?php if (!empty($uri['home']) && !$uri['home']):?>
		<div class="col-sm-2 text-end" style="position:relative;">
			<a href="<?=previous_url()?>" style="color:white; text-decoration: none;"><h5 style="text-transform: lowercase;"><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5></a>
		</div>

		<?php else:?>
		<div class="2 text-end" style="position:relative;">
			<a href="<?=base_url($locale.'/ambientes')?>" id="vertodos" style="color:white; text-decoration: none;"><h5><i class="fas fa-sort me-3"></i> <?=lang('Pb.see_all');?></h5></a>
		</div>
		<?php endif; ?>
	</div>
	<?php 
	$uso = $ambientes[0]->Uso_nome;
	$n1 = $ambientes[0]->N1_nome;
	$idsplide = str_replace(' ', '_',convert_accented_characters($uso)).'-'.convert_accented_characters($n1);
	$splides[] = $idsplide;
	?>
	<div class="splide" id="<?=$idsplide?>">
		<div class="splide__track">
			<ul class="splide__list">
	<?php 
	foreach ($ambientes as $ambiente) : 
		$ende='semimagem.jpg'; if(!empty($ambiente->N2_imagem)) $ende = $ambiente->N2_imagem;
		if($n1 !== $ambiente->N1_nome || $uso !== $ambiente->Uso_nome ):
			$idsplide =  str_replace(' ', '_',convert_accented_characters($ambiente->Uso_nome)).'-'.convert_accented_characters($ambiente->N1_nome);
			$splides[] = $idsplide;
			$uso = $ambiente->Uso_nome;
			$n1 = $ambiente->N1_nome;
		?>
			</ul>
		</div>
	</div>	
	<div class="splide" id="<?=$idsplide?>">
		<div class="splide__track">
			<ul class="splide__list">
		<?php endif; ?>
				<li class="splide__slide">
					<a href="<?=base_url($locale.'/ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->Uso_nome)).'/'.convert_accented_characters($ambiente->N1_nome).'/'.$ambiente->N2_id)?>" style="text-decoration: none;">
		    			<div class="rect-img-container">
						  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
						</div>
						<h6><?=$ambiente->N2_nome?></h6>
					</a>
				</li>	
	<?php endforeach; ?>
			</ul>
		</div>
	</div>	
</div>
<script>
  $(document).ready(function() {
		$('#usoSelect option[value="Fachada"]').hide();
		$( "#pesquisa_field" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax( {
          url: "<?=base_url('produto/ajaxSearch')?>",
          dataType: "jsonp",
  		  headers: {'X-Requested-With': 'XMLHttpRequest'},
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        location.href = '<?=base_url($locale.'/produto/linha/')?>/' + ui.item.value;
      }
    } );
		<?php if($totem_tipo == 'totem'):?>
		KioskBoard.Run('.js-kioskboard-input', {
		  keysArrayOfObjects: null,
		  keysJsonUrl: '<?=base_url('assets/js/kioskboard-keys-spanish.json')?>',
		  specialCharactersObject: null,
		  language: 'es',
		  theme: 'dark',
		  capsLockActive: true,
		  allowRealKeyboard: true,
		  allowMobileKeyboard: true,
		  cssAnimations: true,
		  cssAnimationsDuration: 360,
		  cssAnimationsStyle: 'slide',
		  keysAllowSpacebar: true,
		  keysSpacebarText: 'Espaço',
		  keysFontFamily: 'Roboto',
		  keysFontSize: '22px',
		  keysFontWeight: 'normal',
		  keysIconSize: '25px',
		  autoScroll: false,
		});
		$( "#pesquisa_field" ).change(function() {
			$( "#pesquisa_field" ).autocomplete("search");
		});
	<?php endif ?>
	});

	$(window).load(function(){  
		<?php foreach ($splides as $splide): ?>
 		new Splide( '#<?=$splide?>', {
			gap: '2em',
			perPage: 4,
			breakpoints: {
				720: {
					perPage: 2,
				},
				960: {
					perPage: 3,
				},
			},
			rewind : true,
			pagination: false,
			cover: true
		} ).mount();
		<?php endforeach; ?>
		$('.splide').hide();
		var uson1 = '#<?=$uri['uso']?>-<?=$uri['n1']?>';
		$(uson1).show();
		$('#splide-material').show();
	  $('#N1Select').change(function(){
	    	$(uson1).hide();
	    	if($('#N1Select').val() == 'Piso')
	    		 $('#usoSelect option[value="Fachada"]').hide();
	    	else
	    		$('#usoSelect option[value="Fachada"]').show();
	    	$('.active').text($('#usoSelect option[value="'+$('#usoSelect').val()+'"]').text() + ' > ' + $('#N1Select option[value="'+$('#N1Select').val()+'"]').text());
		 	uson1 = '#'+$('#usoSelect').val() + '-' + $('#N1Select').val();
	    	$(uson1).show();
	  });
	  $('#usoSelect').change(function(){
	   	$(uson1).hide();
    	$('.active').text($('#usoSelect option[value="'+$('#usoSelect').val()+'"]').text() + ' > ' + $('#N1Select option[value="'+$('#N1Select').val()+'"]').text());
		 	uson1 = '#'+$('#usoSelect').val() + '-' + $('#N1Select').val();
    	$(uson1).show();
    });
  	$("#usoSelect > option").each(function() {
		  if (this.value == "<?=$uri['uso']?>")
		    $(this).attr("selected","selected");
		});	    	
  	$("#N1Select > option").each(function() {
		  if (this.value == "<?=$uri['n1']?>")
		    $(this).attr("selected","selected");
		});
    $("#vertodos").click( 'click', function verTodos(evt) {
      	evt.preventDefault();
	    	var urlAmbiente = '<?=base_url($locale.'/ambientes')?>' + '?uso=' + $('#usoSelect').val() + '&n1=' + $('#N1Select').val();
	    	location.href = urlAmbiente;
	    });	  
	});
</script>

