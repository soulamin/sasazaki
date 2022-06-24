<div class="slider-minis container-fluid">
	<div class="row">
		<div class="10">
			<div class="float-start pe-5">
				<h3><?=lang('Pb.select_your_ambient');?></h3>
			</div>
			<form>
				<div class="float-start pb-2">
					<select class="form-select" aria-label="Default select example" id="usoSelect" name="uso">
					  <option value="Residencial"><?=lang('Pb.residential');?></option>
					  <option value="Comercial"><?=lang('Pb.commercial');?></option>
					  <option value="Fachada"><?=lang('Pb.facade');?></option>
					  <option value="Hotelaria"><?=lang('Pb.hotel');?></option>
					  <option value="Industrial"><?=lang('Pb.industrial');?></option>
					  <option value="Obra_Urbana"><?=lang('Pb.urban_work');?></option>
					  <option value="Saude"><?=lang('Pb.health');?></option>
					</select>
				</div>
				<div class="float-start pb-2 ps-2">
					<select class="form-select" aria-label="Piso ou Parede" id="N1Select" name="n1">
					  <option value="Piso"><?=lang('Pb.floor');?></option>
					  <option value="Parede"><?=lang('Pb.wall');?></option>
					</select>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
		<div class="col-sm-2 text-end">
			<a href="<?=previous_url($locale)?>" style="color:white; text-decoration: none;"><h5 class="text-transform: capitalize;"><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5></a>
		</div>
	</div>
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
	    <li class="breadcrumb-item">
	    	<a href="<?=base_url($locale.'/ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambientes[0]->USO)).'/'.convert_accented_characters($ambientes[0]->N1))?>"><?=$ambientes[0]->USO?> > <?=$ambientes[0]->N1?></a>
	    </li>
	    <li class="breadcrumb-item active" aria-current="page"><?=$ambientes[0]->N2?></li>
	  </ol>
	</nav>
	<div class="splide" id="splide-ambiente">
		<div class="splide__track">
			<ul class="splide__list">
				<?php 
				foreach ($ambientes as $ambiente) : 
					$ende='semimagem.jpg'; if(!empty($ambiente->imagem)) $ende = $ambiente->imagem;
					$tooltip = '';
					$tooltip .= 'coef. atrito molhado: ';
					if(!empty($ambiente->coeficiente_atrito_molhado)) 
						$tooltip .= $ambiente->coeficiente_atrito_molhado; 
					$tooltip .= '<br>local de uso: ';
					if(!empty($ambiente->local_uso)) 
						$tooltip .= $ambiente->local_uso; 
					/*
					$tooltip .= '<br>pei: ';
					if(!empty($ambiente->pei)) 
						$tooltip .= $ambiente->pei; 
					*/
					$tooltip .= '<br>absorcao de água: ';
					if(!empty($ambiente->absorcao_agua)) 
						$tooltip .= $ambiente->absorcao_agua; 
					$tooltip .= '<br>resistência à manchas: ';
					if(!empty($ambiente->resistencia_manchas)) 
						$tooltip .= $ambiente->resistencia_manchas; 
					$tooltip .= '<br>res. ataq. quim. alta: ';
					if(!empty($ambiente->res_ata_quimico_alta)) 
						$tooltip .= $ambiente->res_ata_quimico_alta; 
					$tooltip .= '<br>res. ataq. quim. baixa: ';
					if(!empty($ambiente->res_ata_quimico_baixa)) 
						$tooltip .= $ambiente->res_ata_quimico_baixa; 
					$tooltip .= '<br>expansão por umidade: ';
					if(!empty($ambiente->expansao_por_umidade)) 
						$tooltip .= $ambiente->expansao_por_umidade; 
				?>
					<li class="splide__slide">
						<a href="<?=base_url($locale.'/ambientes/id/'.$ambiente->ambiente_id)?>" style="text-decoration: none;">
			    			<div class="rect-img-container">
							  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
							</div>
							<h6><?=$ambiente->N3?>
						</a> 
							<i class="fas fa-info-circle" style="color:white;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<?=$tooltip?>"></i></h6>
					</li>					
				<?php endforeach; ?>
				<li class="splide__slide">
					<a href="<?=base_url($locale.'ambientes/pesquisa/'. str_replace(' ', '_',convert_accented_characters($ambiente->USO)).'/'.convert_accented_characters($ambiente->N1).'/'.convert_accented_characters($ambiente->N2_id).'/todos')?>" style="text-decoration: none;">
			    	<div class="rect-img-container">
						<img  class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/semimagem.jpg')?>" />
					</div>
					<h6 class="text-transform: capitalize;"><?=lang('Pb.see_all');?></h6>
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
	    	var urlAmbiente = '<?=base_url($locale)?>?uso=' + $('#usoSelect').val() + '&n1=' + $('#N1Select').val();
	    	location.href = urlAmbiente;
	    });
	    $('#usoSelect').change(function(){
	    	var urlAmbiente = '<?=base_url($locale)?>?uso=' + $('#usoSelect').val() + '&n1=' + $('#N1Select').val();
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
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	});
</script>