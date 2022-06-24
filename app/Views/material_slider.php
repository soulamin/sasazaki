<div class="slider-minis" class="container-fluid">
	<div><h3><?=lang('Pb.know_our_products');?></h3></div>
	<div class="splide" id="splide-material">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ($materiais as $material) { ?>
					<li class="splide__slide" style="position:relative; cursor: pointer;" onclick="location.href = '<?=base_url($locale.'/home/material/'.$material->slug)?>'">
		    			<div class="rect-img-container">
						  <img class="rect-img" width="100%" src="<?=base_url('uploads/materiais/'.$material->imagem)?>" />
						</div>
						<h6><?=$material->nome?></h6>
					</li>					
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<script>
	new Splide( '#splide-material', {
		gap: '2em',
		perPage: 4,
			breakpoints: {
				720: {
					perPage: 4,
				},
				960: {
					perPage: 4,
				},
			},
		rewind : true,
		pagination: false,
		cover: true
	} ).mount();
</script>