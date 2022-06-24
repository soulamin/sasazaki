<div class="container-fluid pt-4">
	<div class="row">
		<div class="col-sm-9">
			<h3>Escolha Produto Desejado Final</h3>
		</div>
		<div class="col-sm-3 text-end">
			<a href="<?=previous_url()?>" style="color:white; text-decoration: none;"><h5><i class="fas fa-arrow-left me-3"></i> Voltar</h5></a>
		</div>
	</div>
  	<div class="row">
  		<?php foreach ($materiais as $material): 
  				if($material['zoomImage']):
  		?>
		<div class="col-sm-6 col-md-4 col-lg-3">
	    	<div class="m-3 p-3">
	    		<?php 
	    			$url_cod = $material['cod_produto'];
	    			if(!empty($material['sufixo']))
	    				$url_cod .= '/'.$material['sufixo'];
	    		?>
	    		<a href="<?=base_url('produto/codigo/'.$url_cod)?>">
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