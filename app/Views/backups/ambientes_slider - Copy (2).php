<div class="slider-minis container-fluid pt-5">
	<div class="row">
		<div class="col-sm-10">
			<div class="float-start pe-5">
				<h3>Selecione seu Ambiente</h3>
			</div>
			<form>
				<div class="float-start pb-2">
					<select class="form-select" aria-label="Default select example" id="usoSelect" name="uso">
					  <option value="Residencial">Residencial</option>
					  <option value="Comercial">Comercial</option>
					  <option value="Fachada">Fachada</option>
					  <option value="Hotelaria">Hotelaria</option>
					  <option value="Industrial">Industrial</option>
					  <option value="Obra_Urbana">Obra Urbana</option>
					  <option value="Saude">Saúde</option>
					</select>
				</div>
				<div class="float-start pb-2 ps-2">
					<select class="form-select" aria-label="Piso ou Parede" id="N1Select" name="n1">
					  <option value="Piso">Piso</option>
					  <option value="Parede">Parede</option>
					</select>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
		<?php if (!$uri['home']):?>
		<div class="col-sm-2 text-end">
			<a href="<?=previous_url()?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> Voltar</h5></a>
		</div>
		<?php endif; ?>
	</div>
	<?php if (!$uri['home']):?>
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
	    <li class="breadcrumb-item active" aria-current="page">
	    	<?=$ambientes[0]->USO?> > <?=$ambientes[0]->N1?>
	    </li>
	  </ol>
	</nav>
	<?php endif; ?>
	<div class="splide" id="splide-ambiente">
		<div class="splide__track">
			<ul class="splide__list">
				<?php 
				foreach ($ambientes as $ambiente) : 
					$ende='semimagem.jpg'; if(!empty($ambiente->N2_imagem)) $ende = $ambiente->N2_imagem;
				?>
					<li class="splide__slide">
						<a href="<?=site_url('ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->USO)).'/'.convert_accented_characters($ambiente->N1).'/'.$ambiente->N2_id)?>" style="text-decoration: none;">
			    			<div class="rect-img-container">
							  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
							</div>
							<h6><?=$ambiente->N2?></h6>
						</a>
					</li>					
				<?php endforeach; ?>
				<li class="splide__slide">
					<a href="<?=site_url('ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->USO)).'/'.convert_accented_characters($ambiente->N1).'/todos')?>" style="text-decoration: none;">
			    	<div class="rect-img-container">
						<img  class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/semimagem.jpg')?>" />
					</div>
					<h6>Ver todos</h6>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
	$(window).load(function(){  
 		new Splide( '#splide-ambiente', {
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
	    $('#N1Select').change(function(){
	    	var urlAmbiente = '<?=site_url('ambientes/pesquisa/')?>' + $('#usoSelect').val() + '/' + $('#N1Select').val();
	    	location.href = urlAmbiente;
	    });
	    $('#usoSelect').change(function(){
	    	var urlAmbiente = '<?=site_url('ambientes/pesquisa/')?>' + $('#usoSelect').val() + '/' + $('#N1Select').val();
	    	location.href = urlAmbiente;
	    });
    	$("#usoSelect > option").each(function() {
		  if (this.value == "<?=$uri['uso']?>")
		    $(this).attr("selected","selected");
		});	    	
    	$("#N1Select > option").each(function() {
		  if (this.value == "<?=$uri['n1']?>")
		    $(this).attr("selected","selected");
		});	  
	});
</script>