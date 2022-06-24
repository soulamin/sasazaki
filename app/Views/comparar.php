<div class="container-fluid">
	<form>
		<div class="row pt-3 pb-0 fundo-cinza-escuro">
			<h2 style="font-size:2rem;">
				<i class="fas fa-exchange-alt mb-0" style="color:white;"></i> <?=lang('Pb.comparison');?>
			</h2>
			<p class="py-0 mt-0 ps-4" style="font-size: 1rem;"> 
			<strong>
			<?php 
				$totalProdutos = 0;
				if (!empty($produtos) && sizeof($produtos) > 0) 
					$totalProdutos = $produtos;
				
				echo lang('Pb.you_are_comparing', [$totalProdutos]);
			?> 
			</strong></p>
		</div>
		<div class="float-end px-2 py-2 mt-1">
			<a href="<?= previous_url() ?>" style="color:white; text-decoration: none;">
				<h5><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5>
			</a>
		</div>
		<div class="clearfix"></div>
		<?php if (empty($produtos)) : ?>
			<div class="alert alert-danger" role="alert">
				<?=lang('Pb.product_not_selected_comparison')?>
			</div>
		<?php else : ?>
			<div class="row">
				<div class="col-12">
					<div class="table-responsive comparador" style="/*border-radius: 15px; overflow:hidden; margin: 20px;*/">
						<table class="table table-hover" style="max-width: 
							<?php 
								$useragent=$_SERVER['HTTP_USER_AGENT'];
								if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
									echo 50*sizeof($produtos); 
								}else{
									echo 33.33*sizeof($produtos); 
								}	  
							?>%;">
							<thead style="font-size: 2em; padding-top:20px; padding-bottom:20px;">
								<tr style="padding-top:20px; padding-bottom:20px;">
									<?php foreach ($produtos as $produto) : ?>
										<th scope="col">
											<div class="fakecol primeira">
												<dt scope="row"><small><?= $produto['linha'] ?></small></dt>
												<dd><?= $produto['desc_produto'] ?></dd>
											</div>
										</th>
									<?php endforeach ?>
								</tr>
							</thead>
							<tbody style="">
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td style="padding:0;margin: 0; text-indent:0;">
											<div class="fakecol">
												<div class="rect-img-container">
													<img class="rect-img" src="<?= $url_fonte_imgs ?><?= $produto['zoomImage']; ?>" alt="">
												</div>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) :
										$url_cod = $produto['cod_produto'];
										if (!empty($produto['sufixo']))
											$url_cod .= '/' . $produto['sufixo'];
									?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.code')?></dt>
												<dd><?= $url_cod ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.water_absorption')?></dt>
												<dd><?= $produto['absorcao_dagua'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.wet_friction_coef')?></dt>
												<dd><?= $produto['atrito_molhado_iso'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.place_of_use')?></dt>
												<dd><?= $produto['uso'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.resiste_product_cleaning_spot')?></dt>
												<dd><?= $produto['resultado_minimo_limpeza'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>
											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.res_ata_quim_low_concentration')?></dt>
												<dd><?= $produto['ataque_qui_baixa_conc'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>
											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.res_ata_quim_high_concentration')?></dt>
												<dd><?= $produto['ataque_qui_alta_conc'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.expansion_umi_mm')?></dt>
												<dd><?= $produto['expansao_por_umidade'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.breaking_load')?></dt>
												<dd><?= $produto['carga_ruptura'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.resist_gretamento')?></dt>
												<dd><?= $produto['gretagem_port'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.freeze_resistence')?></dt>
												<dd><?= $produto['congelamento_port'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) : ?>
										<td>

											<div class="fakecol">
												<dt scope="row"><?=lang('Pb.thermal_shock_resistance')?></dt>
												<dd><?= $produto['choque_termico_port'] ?></dd>
											</div>
										</td>
									<?php endforeach ?>
								</tr>
								<tr>
									<?php foreach ($produtos as $produto) :
										$remover_url = $locale.'/favoritos/remover/' . $produto['cod_produto'];
										if ($produto['sufixo'])
											$remover_url = $remover_url . '/' . $produto['sufixo']
									?>
										<td>
											<a href="<?= base_url($remover_url) ?>">
												<div class="fakecol ultima">
													<i class="fas fa-trash-alt"></i> <?=lang('Pb.remove_from_fav')?>
												</div>
											</a>
										</td>
									<?php endforeach ?>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>


			<script>
				$(window).load(function() {
					var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
					var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
						return new bootstrap.Tooltip(tooltipTriggerEl)
					})
				});
			</script>
		<?php endif; ?>