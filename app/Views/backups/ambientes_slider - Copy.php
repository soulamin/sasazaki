<div class="slider-minis" class="container-fluid">
	<div class="float-start"><h3>Selecione seu Ambiente</h3></div>
	<form>
	<div class="float-start" style="padding:9px;margin-left:28px;">
		<select class="form-select" aria-label="Default select example" id="usoSelect" name="uso">
		  <option value="residencial" selected>Residencial</option>
		  <option value="comercial">Comercial</option>
		  <option value="fachada">Fachada</option>
		  <option value="hotelaria">Hotelaria</option>
		  <option value="industrial">Industrial</option>
		  <option value="obra_urbana">Obra Urbana</option>
		  <option value="saude">Saúde</option>
		</select>
	</div>
	<div class="float-start" style="padding:9px; margin-left:2px;">
		<select class="form-select" aria-label="Piso ou Parede" id="N1Select" name="n1">
		  <option selected value="Piso">Piso</option>
		  <option value="Parede">Parede</option>
		</select>
	</div>
	<!--
	<button type="submit" class="btn  btn-light" style="height: 38px; margin-top:9px;margin-left:12px;">Escolher!</button> -->
	</form>
	<div class="clearfix"></div>
	<div class="splide" id="splide-piso">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ($pisos as $piso) : ?>
					<li class="splide__slide" style="position:relative; cursor: pointer;" onclick="location.href = '<?=site_url('ambientes/id/'.$piso->ambiente_id)?>'">
						<?php $ende='semimagem.jpg'; if($piso->N2_imagem) $ende = $piso->N2_imagem;?>
		    			<div class="rect-img-container">
						  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
						</div>
						<h6 style="font-size: 1.1em;"><?=$piso->N2?></h6>
					</li>					
				<?php endforeach; ?>
				<li class="splide__slide" style="position:relative; cursor: pointer;" onclick="location.href = '<?=site_url('ambientes/piso/residencial/todos')?>'">
					<img width="100%" src="<?=base_url('uploads/ambientes/semimagem.jpg')?>" />
					<div style="background-color:#111016;position:absolute;bottom:0;margin-bottom: 0;width: 100%;">
						<h6 style="font-size: 1.1em;">Ver todos</h6>
					</div>
				</li>
				<?php /* BACKUP DO VER TODOS DO AMBIENTES SLIDER
				<li class="splide__slide">
					<a href="<?=site_url('ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->USO)).'/'.convert_accented_characters($ambiente->N1).'/todos')?>" style="text-decoration: none;">
			    	<div class="rect-img-container">
						<img  class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/semimagem.jpg')?>" />
					</div>
					<h6>Ver todos</h6>
					</a>
				</li>

				*/ ?>
			</ul>
		</div>
	</div>
	<div class="splide" id="splide-parede" style="display:none">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ($paredes as $parede) : ?>
					<li class="splide__slide" style="position:relative; cursor: pointer;" onclick="location.href = '<?=site_url('ambientes/id/'.$parede->ambiente_id)?>'">
						<?php $ende='semimagem.jpg'; if($parede->N2_imagem) $ende = $parede->N2_imagem;?>
		    			<div class="rect-img-container">
						  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
						</div>
						<h6 style="font-size: 1.1em;"><?=$parede->N2?></h6>
					</li>					
			<?php endforeach; ?>
				<li class="splide__slide" style="position:relative; cursor: pointer;" onclick="location.href = '<?=site_url('ambientes/parede/residencial/todos')?>'">
					<img width="100%" src="<?=base_url('uploads/ambientes/semimagem.jpg')?>" />
					<div style="background-color:#111016;position:absolute;bottom:0;margin-bottom: 0;width: 100%;">
						<h6 style="font-size: 1.1em;">Ver todos2</h6>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
	$(function() { 
 		new Splide( '#splide-piso', {
			gap: '2em',
			perPage: 4,
			rewind : true,
			pagination: false,
			heightRatio: 0.25,
			cover: true
		} ).mount();
	    $('#N1Select').change(function(){
	        if($('#N1Select').val() == 'Piso') {
	    		$('#splide-parede').hide(); 
	    		$('#splide-piso').show(); 
	        }
	        if($('#N1Select').val() == 'Parede') {
	    		$('#splide-piso').hide(); 
	    		$('#splide-parede').show(); 
				new Splide( '#splide-parede', {
					gap: '2em',
					perPage: 4,
					rewind : true,
					pagination: false,
					cover: true
				} ).mount();
	        }
	    });
	    $('#usoSelect').change(function(){
	    	var urlAmbiente = '<?=site_url('ambientes/pesquisa/')?>' + $('#usoSelect').val() + '/' + $('#N1Select').val();
	    	location.href = urlAmbiente;
	    });
	});
</script>

