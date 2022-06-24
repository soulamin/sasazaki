<div class="container-fluid pt-5">
	<div class="row">
		<div class="col-sm-10">
			<div class="float-start pe-5">
				<h3><?=lang('Pb.select_your_ambient');?></h3>
			</div>
			<form>
				<div class="float-start pb-2">
					<select class="form-select" aria-label="Tipo de uso" id="usoSelect" name="uso">
					<?php 
						foreach ($usos as $uso): 
						?>
					  <option value="<?=str_replace(' ', '_',convert_accented_characters($uso->Uso_nome))?>"><?=$uso->Uso_nome?></option>
					<?php endforeach; ?>
					</select>
				</div>
				<div class="float-start pb-2 ps-2">
					<select class="form-select" aria-label="Piso ou Parede" id="N1Select" name="n1">
					<?php 
						foreach ($n1s as $n1): 
						?>
					  <option value="<?=str_replace(' ', '_',convert_accented_characters($n1->N1_nome))?>"><?=$n1->N1_nome?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
    	<?php 
    		if(!empty($ambientes)):
				$crumbs = explode(' - ', $ambientes[0]->N1_Uso_N2);
				$voltar = base_url('?uso='.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'&n1='.str_replace(' ', '_',convert_accented_characters($crumbs[0])));
			else:
				$voltar = previous_url();
				$crumbs[] = $uri['n1'];
				$crumbs[] = $uri['uso'];
			endif;
		?>
		<div class="col-sm-2 text-end">
			<a href="<?=$voltar?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5></a>
		</div>
	</div>
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?=base_url($locale)?>">Home</a></li>
	    <li class="breadcrumb-item">
		    <a href="<?=$voltar?>"><?=$crumbs[1]?> > <?=$crumbs[0]?></a>
	    </li>
	    	<?php if(!empty($ambientes)):?>
	    <li class="breadcrumb-item active" aria-current="page"><?=$ambientes[0]->N2_nome?></li>
	    	<?php endif;?>
	  </ol>
	</nav>
	<div class="row">
		<?php 
		if(empty($ambientes)):?>
		<div class="alert alert-danger" role="alert">
		   <h5><?=lang('Pb.product_not_found');?></h5>
		</div>
	    <?php endif;?>
		<?php 
		foreach ($ambientes as $ambiente) : 
			$ende = 'semimagem.jpg'; if(!empty($ambiente->imagem)) $ende = $ambiente->imagem;
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
			$tooltip .= '<br>absorção de água: ';
			if(!empty($ambiente->absorcao_agua)) 
				$tooltip .= $ambiente->absorcao_agua; 
			$tooltip .= '<br>resist. à manchas: ';
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
			if($totem_tipo == 'totem')
				$tooltip .= '" style="font-size:1.5rem; margin-top:3px;"';
		?>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<a href="<?=base_url($locale.'/ambientes/id/'.$ambiente->N3_id)?>" style="text-decoration: none;">
    			<div class="rect-img-container">
				  <img class="rect-img" width="100%" src="<?=base_url('uploads/ambientes/'.$ende)?>" />
				</div>
				<h6><?=$ambiente->N3?>
			</a> 
				<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<?=$tooltip?>"></i></h6>
		</div>					
		<?php endforeach; ?>
	</div>
	<?php
		$url = '?uso=' . $uri['uso'] . '&n1=' . $uri['n1'] . '&n2=' . $uri['n2'];
	?>
	<div class="row text-center mt-3">
		<a href="<?=base_url($locale.'/ambientes/'.$url)?>" id="vertodos" style="color:white; text-decoration: none;"><h5 style="text-transform: capitalize;"><i class="fas fa-sort me-3"></i><?=lang('Pb.see_all');?></h5></a>
	</div>
</div>
<script>
	$(window).load(function(){  
		if($('#N1Select').val() == 'Piso')
			$('#usoSelect option[value="Fachada"]').hide();
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