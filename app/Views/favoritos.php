<style type="text/css">
	#imagemPai {
		padding: 15px;
		margin: 15px;
	}

	@media (max-width: 1200px) {

		#imagemPai {
			padding: 2px;
			padding-top: 15px;
			margin: 2px;
		}
	}
</style>
<div class="container-fluid">
	<?= form_open($locale.'/comparar', ['id' => 'comparar']); ?>
	<div class="row pt-3 pb-0 fundo-cinza-escuro">
		<div class="col-4 text-start">
			<h2 style="font-size:2rem;">
				<i class="fas fa-heart mb-0" style="color:white;"></i> <?= lang('Pb.favorites');?>
			</h2>
			<p class="py-0 mt-0 ps-4" style="font-size: 1rem;"> Você favoritou <strong><?php if (!empty($_SESSION['favoritos']) && sizeof($_SESSION['favoritos']) > 0) echo sizeof($_SESSION['favoritos']);
																						else echo '0'; ?> produto(s)</strong></p>
		</div>
		<div class="col-4 text-center pt-3">
			<?php if (!empty($_SESSION['favoritos']) && sizeof($_SESSION['favoritos']) > 0) :
				$url_qr = '';
				$jornada = '';
				foreach ($_SESSION['favoritos'] as $fav) {
					if ($fav['jornada'] != '')
						$jornada .= $fav['jornada'] . '/' . $fav['cod_produto'] . $fav['sufixo'] . ',';
					else
						$url_qr .= $fav['cod_produto'] . $fav['sufixo'] . ',';
				}
				$jornada = substr_replace($jornada, "", -1);
				$url_qr = substr_replace($url_qr, "", -1);
				$url_qr .= '&journeys=' . $jornada;
			?>

				<button type="button" class="btn btn-light px-2 py-2 my-1" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-weight: bold;"><i class="fas fa-qrcode me-2"></i> Receber por E-mail!</button>

			<?php endif  ?>
		</div>
		<div class="col-4 text-end pt-3">
			<a href="<?= base_url($locale.'/favoritos/remover/') ?>">
				<button type="button" class="btn btn-light px-5 py-2" style="font-weight: bold;"><i class="fas fa-trash-alt me-2"></i> <?= lang('Pb.delete_all');?></button>
			</a>
		</div>
	</div>
	<div class="float-end px-2 py-2 mt-1">
		<a href="<?= previous_url() ?>" style="color:white; text-decoration: none;">
			<h5><i class="fas fa-arrow-left me-3"></i> <?= lang('Pb.back');?></h5>
		</a>
	</div>
	<div class="clearfix"></div>
	<?php if (empty($_SESSION['favoritos'])) : ?>
		<div class="alert alert-danger" role="alert">
			Nenhum produto foi favoritado.
		</div>
	<?php else : ?>
		<style>
			.imagem {
				border: 4px white solid;
				border-radius: 5px;
			}
		</style>
		<?php
		foreach ($_SESSION['favoritos'] as $favorito) :
			$key = array_search($favorito['cod_produto'], array_column($materiais, 'cod_produto'));
			$key2 = false;
			$material = $materiais[$key];
			$url_cod = $material['cod_produto'];
			if (!empty($material['sufixo']))
				$url_cod .= '/' . $material['sufixo'];
		?>
			<div class="row pd-3 mb-3 fundo-cinza-escuro">
				<div class="col-xl-2 col-lg-3 col-4">
					<?php if ($material['zoomImage']) : ?>
						<div id="imagemPai">
							<a href="<?= base_url($locale.'/produto/codigo/' . $url_cod) ?>">
								<div class="rect-img-container">
									<input name="produtos[]" type="checkbox" value="<?= $url_cod ?>" style="position: absolute; top: 3%; right: 3%; z-index: 1; width:1.8rem; height:1.8rem;">
									<img class="rect-img" src="<?= $url_fonte_imgs ?><?= $material['zoomImage']; ?>" alt="">
								</div>
							</a>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="col-xl-10 col-lg-9 col-8">		
					<h4 class="ms-2 mt-4" style="color:white"><small><?=$material['linha']?></small> <?=$material['desc_produto']?></h4>    	
						<?php 
							if(!empty($ambientes)){
								if($key !== false) {
									if($favorito['jornada'] !== '') {
										$key2 = array_search($favorito['jornada'], array_column($ambientes, 'N3_id')); 
											if($key2 !== false) { 
													$crumbs = explode(' - ', $ambientes[$key2]['N1_Uso_N2']);
												?>
												<nav class="ms-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
											<ol class="breadcrumb">
												<li class="breadcrumb-item"><?=lang('Pb.home');?></li>
												<li class="breadcrumb-item"><a href="<?=base_url('?uso='.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'&n1='.str_replace(' ', '_',convert_accented_characters($crumbs[0])))?>"><?=$crumbs[1]?> > <?=$crumbs[0]?></a></li>
												<li class="breadcrumb-item"><a href="<?=base_url('/ambientes/pesquisa/'.str_replace(' ', '_',convert_accented_characters($crumbs[1])).'/'.str_replace(' ', '_',convert_accented_characters($crumbs[0])).'/'.$ambientes[$key2]['N2_id'])?>"><?=$crumbs[2]?></a></li>
												<li class="breadcrumb-item active" aria-current="page">
													<?php $suf = ''; if($material['sufixo']) $suf = $material['sufixo'].'/';?>
												<a href="<?=base_url($locale.'/produto/codigo/'.$material['cod_produto'].'/'.$suf.'?ambiente='.$ambientes[$key2]['N3_id'])?>">
												<?=$ambientes[$key2]['N3']?>
												</a>
												</li>
											</ol>
											</nav>
								<?php
											}
									}
								}
							}
						?>
					<div class="container-fluid">
					<dl class="row" style="border-left: solid 1rem #777">
						<div class="col col-xl-3 col-md-4 col-6">
						<dt><?= lang('Pb.code');?></dt>
						<dd><?=$material['cod_produto']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Acabamento</dt>
						<dd><?=$material['caracteristica_acabamento']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Quant. da Caixa</dt>
						<dd><?=$material['qt_pc_caixa']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Tipo</dt>
						<dd><?=$material['tipologia_comercial']?></dd>
						</div>  
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Formato</dt>
						<dd><?=$material['desc_formato_nominal']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Número de Faces</dt>
						<dd><?=$material['nr_faces']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Var. de Tonalidade</dt>
						<dd><?=$material['cod_variacao_tonalidade']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Material</dt>
						<dd><?=$material['material']?></dd>
						</div>  
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Borda</dt>
						<dd><?=$material['acabamento_de_borda']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Espessura</dt>
						<dd><?=$material['espessura']?>mm</dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Junta de assent.</dt>
						<dd><?=$material['junta_de_assentamento']?></dd>
						</div>
						<div class="col col-xl-3 col-md-4 col-6">
						<dt>Reprodução</dt>
						<dd><?=$material['material']?></dd>
						</div>  
					</dl>
					</div>
					<div class="row px-4">
						<div class="col-lg-3 col-4 px-2 mb-2">
							<?php 
								$remover_url = $locale.'/favoritos/remover/'.$material['cod_produto'];
								if($material['sufixo']) 
								$remover_url = $remover_url.'/'.$material['sufixo'];
								if(!empty($favorito['jornada']) && !empty($ambientes[$key2]['N3']))
									$remover_url .= '?ambiente='.$ambientes[$key2]['N3_id'];
							?>
							<a href="<?=base_url($remover_url)?>">
								<button type="button" class="btn btn-dark pd-3" style="font-weight: bold;"><i class="fas fa-trash-alt"></i> <?= lang('Pb.delete');?></button>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php
		endforeach; ?>
	<?php endif ?>
	<button type="submit" class="btn btn-success ms-3">Comparar selecionados!</button>
</div>

</form>
<!-- Modal -->
<?php 
	$qrcode = '';
if (!empty($_SESSION['favoritos']) && sizeof($_SESSION['favoritos']) > 0) : 
	$qrcode = "http://34.203.87.184:3000/qrcode?store_id=".$totem_id."&date=".time()."&favorites=".$url_qr;	
?>
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Receba sua lista de Favoritos:</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="qrcode" class="text-center"></div>
					<script type="text/javascript">
						var qrcode = new QRCode("qrcode", {
							text: '<?= $qrcode?>',
							width: 240,
							height: 240,
							colorDark: "#000000",
							colorLight: "#ffffff",
							correctLevel: QRCode.CorrectLevel.H
						});
					</script>
				</div>
				<div class="modal-footer">
					<?php if ($totem_tipo != 'totem') : ?>
						 <a href="http://34.203.87.184:3000/qrcode?store_id=<?= $totem_id ?>&date=<?= time() ?>&favorites=<?= $url_qr ?>" target="_blank"> 
						<!-- <a href="http://localhost:3000/qrcode?store_id=<?= $totem_id ?>&date=<?= time() ?>&favorites=<?= $url_qr ?>" target="_blank"> -->
					<?php endif; ?>
						<h6 class="text-center">ACESSE AQUI O LINK PELO QRCODE</h6>
					<?php if ($totem_tipo != 'totem') : ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<script>
	$(function() {

		$('#exampleModal').on('hidden.bs.modal', function () {
			
			var sessao = JSON.parse(localStorage.getItem("@PortoBeloSessao"));
			
			sessao['datatermino'] = '<?= date('Y-m-d H:i:s')?>'
			sessao['qrcode'] = '<?= $qrcode?>'
			$.ajax({
				method: "POST",
				url: "/api/setarsessao",
				data:sessao,
				success: function() {
					localStorage.removeItem('@PortoBeloSessao')
					window.location.href= '<?=base_url($locale.'/home/reiniciar')?>'
				}
			})
		})
	})
</script>
