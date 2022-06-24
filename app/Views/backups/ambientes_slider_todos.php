<div class="container-fluid">
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
		<div class="col-sm-2 text-end">
			<a href="<?=previous_url()?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> Voltar</h5></a>
		</div>
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
	<div class="row">
		<?php 
		foreach ($ambientes as $ambiente) : 
			$ende='semimagem.jpg'; if(!empty($ambiente->N2_imagem)) $ende = $ambiente->N2_imagem;
		?>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<a href="<?=site_url('ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->USO)).'/'.convert_accented_characters($ambiente->N1).'/'.$ambiente->N2_id)?>" style="text-decoration: none;">
				<div class="rect-img-container">
				  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
				</div>
				<h6><?=$ambiente->N2?></h6>
			</a>
		</div>					
		<?php endforeach; ?>
	</div>
</div>
<script>
	$(window).load(function(){  
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