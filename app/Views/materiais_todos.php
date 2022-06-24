<div class="container-fluid pt-4">
	<div class="row">
		<div class="col-9">
			<h3>Escolha Produto Desejado</h3>
		</div>
		<div class="col-3 text-end">    		
  		<?php if(!empty($ambiente)):
  				$crumbs = explode(' - ', $ambiente->N1_Uso_N2);
  				$voltar = base_url($locale.'/ambientes/pesquisa/'.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'/'.str_replace(' ', '_',convert_accented_characters($crumbs[0])).'/'.$ambiente->N2_id);
  			elseif(!empty($pesquisa_feita)):
  				$voltar = base_url($locale.'/caracteristicas');
  			else:
      			$voltar = base_url($locale);
  		 ?>
  		<?php endif ?>
			<a href="<?=$voltar?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> Voltar</h5></a>
		</div>
	</div>
  	<div class="row">
    	<div class="col-xs-12 col-sm-6">
  		<?php if(!empty($ambiente)): ?>
			<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?=base_url($locale)?>"><?=lang('Pb.home');?></a></li>
			    <li class="breadcrumb-item"><a href="<?=base_url($locale.'?uso='.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'&n1='.str_replace(' ', '_',convert_accented_characters($crumbs[0])))?>"><?=$crumbs[1]?> > <?=$crumbs[0]?></a></li>
			    <li class="breadcrumb-item"><a href="<?=$voltar?>">
			    	<?=$crumbs[2]?></a>
			    </li>
			    <li class="breadcrumb-item active" aria-current="page">
			    	<?=$ambiente->N3?>
			    </li>
			  </ol>
			</nav>
  		<?php 
  			endif;
  			$material_tipo = [];  
  			$material_tipo_str = ''; 
  			$material_cor = []; 
  			$material_cor_str = '';
  			//$material_formato = []; 
  			//$material_formato_str = '';
			foreach ($materiais as $mat) {
  				$material_tipo[] = $mat['material']; 
  				$material_cor[] = $mat['cor']; 
  				//$material_formato[] = $mat['desc_formato_nominal']; 
			}
			$material_cor = array_unique($material_cor);
  			sort($material_cor);
			//$material_formato = array_unique($material_formato);
  			//sort($material_formato);
			if(!empty($ambiente) || !empty($pesquisa_feita)) {
				$material_tipo = array_unique($material_tipo);
				sort($material_tipo);
			}
  		?>
	  	<?php 
  		if(!empty($pesquisa_feita)):
  			$pesq_str = '<p style="color: white; font-size: 0.8rem">';
			if(!empty($pesquisa_feita['coeficiente_atrito_molhado'])){
				$pesq_str .=  'Coeficiente Atrito Molhado: ';
				foreach ($pesquisa_feita['coeficiente_atrito_molhado'] as $value) {
				  	$pesq_str .= $value . ' / ';
				}
			}
  			if(!empty($pesquisa_feita['absorcao_dagua']))
  				$pesq_str .= lang('Pb.water_absorption').': ' . $pesquisa_feita['absorcao_dagua'] . ' / ';
			if(!empty($pesquisa_feita['resistencia_manchas']))
				$pesq_str .= lang('Pb.res_to_stains').': ' . $pesquisa_feita['resistencia_manchas'] . ' / ';
			if(!empty($pesquisa_feita['res_ata_quimico_alta']))
				$pesq_str .= lang('Pb.res_chem_low').': ' . $pesquisa_feita['res_ata_quimico_alta'] . ' / ';
			if(!empty($pesquisa_feita['res_ata_quimico_baixa']))
				$pesq_str .= lang('Pb.res_chem_high').': ' . $pesquisa_feita['res_ata_quimico_baixa'] . ' / ';
			if(!empty($pesquisa_feita['expansao_por_umidade']))
				$pesq_str .= lang('Pb.expansion_humidity').': ' . $pesquisa_feita['expansao_por_umidade'] . ' / ';
			if(!empty($pesquisa_feita['tipologia_comercial'])) {
				$pesq_str .= lang('Pb.material').': ';
				foreach ($pesquisa_feita['tipologia_comercial'] as $value) {
				  	$pesq_str .=  $value . ' / ';
				}
			}
			if(!empty($pesquisa_feita['caracteristica_acabamento'])) {
				$pesq_str .= 'Características Acabamento: ';
				foreach ($pesquisa_feita['caracteristica_acabamento'] as $value) {
				  	$pesq_str .=  $value . ' / ';
				}
			}
			if(!empty($pesquisa_feita['acabamento_de_borda'])) {
				$pesq_str .= 'Acabamento de Borda: ';
				foreach ($pesquisa_feita['acabamento_de_borda'] as $value) {
				  	$pesq_str .=  $value . ' / ';
				}
			}
			if(!empty($pesquisa_feita['resultado_minimo_limpeza'])) {
				$pesq_str .= 'Resistência Produto de Limpeza: ';
				foreach ($pesquisa_feita['resultado_minimo_limpeza'] as $value) {
				  	$pesq_str .=  $value . ' / ';
				}
			}
  			$pesq_str = substr($pesq_str, 0, -3).'</p>';
  			echo $pesq_str;
		endif; ?>
	  	</div>
    	<div class="col-xs-12 col-sm-6">
    		<div class="d-flex flex-row-reverse">
    			<div class="p-4">
			        <div class="form-group">
				  		<select class="form-select" aria-label="Ordenar" id="orderAlfa" name="orderAlfa">
				  			<option value="." selected="selected">Ordem</option>
				  			<option value="az">A - Z</option>
				  			<option value="za">Z - A</option>
				  		</select>
			  		</div>
			  	</div>
	  			<div class="p-4">
			        <div class="form-group">
				  		<select class="form-select" aria-label="Cores" id="orderCor" multiple="multiple">
			  				<?php  
				  			foreach ($material_cor as $material):  
				  					if($material_cor_str != $material): 
				  						$material_cor_str = $material;?>
				  				<option value="<?=$material?>" selected="selected"><?=$material?></option>
				  			<?php endif; endforeach; ?>
						</select>
			  		</div>
	  			</div>
	  			<!--
	  			<div class="p-4">
			        <div class="form-group">
				  		<select class="form-select" aria-label="Formato" id="orderFormato" multiple="multiple">
			  				<?php 
			  				/* 
				  			foreach ($material_formato as $material):  
				  					if($material_formato_str != $material): 
				  						$material_formato_str = $material;?>
				  				<option value="<?=$material?>" selected="selected"><?=$material?></option>
				  			<?php endif; endforeach; */?>
						</select>
			  		</div>
	  			</div>
	  			-->
	  			<div class="p-4">
		  			<?php if(!empty($ambiente) || !empty($pesquisa_feita)): ?>
			        <div class="form-group">
				  		<select class="form-select" aria-label="Materiais" id="orderMaterial" name="orderMaterial" multiple="multiple">
			  			<?php
			  				foreach ($material_tipo as $material):  
			  					if($material_tipo_str != $material): 
			  						$material_tipo_str = $material;?>
			  				<option value="<?=$material?>" selected="selected"><?=$material?></option>
			  			<?php endif; endforeach; ?>
			  			</select>
			  		</div>
		  			<?php endif ?>
		  		</div>
			</div>
		</div>
  	</div>
  	<div class="row"  id="materiais">
		<?php if(empty($materiais)):?>
			<div class="alert alert-danger" role="alert">
			    Não temos tal material Portobello nessa revenda.
			</div>
		<?php endif ?>
  		<?php foreach ($materiais as $material): 
  				if($material['zoomImage']):
  					$getn3 = '';
	    			if(!empty($N3_id)) 
	    				$getn3 = '?ambiente='.$N3_id; 
  		?>
		<div class="col-6 col-md-4 col-lg-3 materialInd" data-linha="<?=$material['linha']?>" data-material="<?=$material['material']?>" data-cor="<?=$material['cor']?>" data-desc="<?=$material['desc_produto']?>" data-formato="<?=$material['desc_formato_nominal']?>">
	    	<div class="m-3 p-3">
	    		<a href="<?=base_url($locale.'/produto/linha/'.$material['groupColor'].$getn3)?>">
	    			<div class="rect-img-container">
					  <img class="rect-img" src="<?=$url_fonte_imgs?><?php if(isset($material['mainImage']) && $material['mainImage'] != "") echo $material['mainImage']; else echo $material['zoomImage'];?>" alt="">
					</div>
			    </a>
	      		<h5 style="margin-top:15px;color:white"><?=$material['linha']?></h5>
	      		<h5 style="color:white"><?=$material['desc_produto']?></h5>
	      	</div>
	    </div>
  		<?php endif; endforeach; ?>
  	</div>
</div>
<script type="text/javascript">
	 
	$(document).ready(function() {
    	$('#orderMaterial').multiselect({allSelectedText: "Materiais",
            onChange: function(element, checked) {
                if (checked === true) {
					$('[data-material="' + element.val() +'"]').show();
                }
                else if (checked === false) {
					$('[data-material="' + element.val() +'"]').hide();
                }
            }}
           );
    	$('#orderCor').multiselect({allSelectedText: "Cores",
            onChange: function(element, checked) {
                if (checked === true) {
					$('[data-cor="' + element.val() +'"]').show();
                }
                else if (checked === false) {
					$('[data-cor="' + element.val() +'"]').hide();
                }
            }}
           );
    	/*
    	$('#orderFormato').multiselect({allSelectedText: "Formatos",
            onChange: function(element, checked) {
                if (checked === true) {
					$('[data-formato="' + element.val() +'"]').show();
                }
                else if (checked === false) {
					$('[data-formato="' + element.val() +'"]').hide();
                }
            }}
           );
           */
		$('#orderAlfa').change(function(){
		  	if (this.value == "az")
				tinysort('.materialInd',{data:'linha',order:'asc'},{data:'desc',order:'asc'});
			else if(this.value == "za")
				tinysort('.materialInd',{data:'linha',order:'desc'},{data:'desc',order:'desc'});
		});	
		var ordenarVirgem = true;
		$('#orderMaterial').change(function(){
			console.log(this.value);
			//$('[data-material="' + this.value +'"]:visible').hide();
			//$('[data-material="' + this.value +'"]:hidden').show();
		});	
    });
</script>