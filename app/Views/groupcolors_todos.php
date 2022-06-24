<div class="container-fluid pt-4">
	<div class="row">
		<div class="col-sm-9">
			<h3>Escolha o modelo de sua preferência:</h3>
		</div>
		<div class="col-sm-3 text-end">
			<?php 
				if(!empty($ambiente))
					$voltar = base_url($locale.'/ambientes/id/'.$ambiente->N3_id);
				elseif(!empty($materiais))
					$voltar = base_url($locale.'/home/material/'.strtolower(convert_accented_characters($materiais[0]['material'])));
				else
					$voltar = previous_url();

			?>
			<a href="<?=$voltar?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> <?= lang('Pb.back')?></h5></a>
		</div>
	</div>
  	<div class="row">
  		<?php if(!empty($ambiente)): 
  			$crumbs = explode(' - ', $ambiente->N1_Uso_N2);
  		?>
		<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?=base_url($locale)?>"><?=lang('Pb.home');?></a></li>
		    <li class="breadcrumb-item"><a href="<?=base_url($locale.'?uso='.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'&n1='.str_replace(' ', '_',convert_accented_characters($crumbs[0])))?>"><?=$crumbs[1]?> > <?=$crumbs[0]?></a></li>
		    <li class="breadcrumb-item"><a href="<?=base_url($locale.'/ambientes/pesquisa/'.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'/'.str_replace(' ', '_',convert_accented_characters($crumbs[0])).'/'.$ambiente->N2_id)?>">
		    	<?=$crumbs[2]?></a>
		    </li>
		    <li class="breadcrumb-item active" aria-current="page">
		    	<a href="<?=base_url($locale.'/ambientes/id/'.$ambiente->N3_id)?>"><?=$ambiente->N3?></a>
		    </li>
		  </ol>
		</nav>
		<?php endif; ?>
  		<?php foreach ($materiais as $material): 
  				if($material['zoomImage']):
  		?>
		<div class="col-sm-6 col-md-4 col-lg-3">
	    	<div class="m-3 p-3">
	    		<?php 
	    			$url_cod = $material['cod_produto'];
	    			if(!empty($material['sufixo']))
	    				$url_cod .= '/'.$material['sufixo'];
	    			if(!empty($ambiente))
	    				$url_cod .= '?ambiente='.$ambiente->N3_id;
	    		?>
	    		<a href="<?=base_url($locale.'/produto/codigo/'.$url_cod)?>">
		      		<div class="rect-img-container">
					  <img class="rect-img" src="<?=$url_fonte_imgs?><?=$material['zoomImage'];?>" alt="">
					</div>
	      		</a>
	      		<h5 style="margin-top:15px;color:white"><?=$material['linha']?></h5>
	      		<h5 style="color:white"><?=$material['desc_produto']?> <?=$material['caracteristica_acabamento']?> <?=$material['acabamento_de_borda']?></h5>
	      		<h5 style="color:white"><?=$material['desc_formato_nominal']?></h5>
	      	</div>
	    </div>
  		<?php endif; endforeach; ?>
  	</div>
</div>