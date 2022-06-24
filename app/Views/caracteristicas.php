<?php if ($totem_tipo == 'totem') : ?>
	<style type="text/css">
		label {
			margin-right: 30px;
		}

		#principal {
			padding-left: 80px;
		}
	</style>
<?php endif ?>
<div class="container-fluid">
	<div class="row py-1 fundo-cinza-escuro">
		<?php $titulo = explode(' ', lang('Pb.advanced_search')) ?>
		<h2 style="font-size:2rem"><small style="font-size:0.4em"><?= $titulo[0] ?></small><br /> <?= $titulo[1] ?></h2>
	</div>
	<div class="row pt-4">
		<div class="col-sm-9">
			<h4><?=lang('Pb.select_filters');?></h4>
		</div>
		<div class="col-sm-3 text-end">
			<?php if (!empty($ambiente)) :
				$crumbs = explode(' - ', $ambiente->N1_Uso_N2);
				$voltar = base_url($locale.'/ambientes/pesquisa/' . str_replace(' ', '_', convert_accented_characters($crumbs[1])) . '/' . str_replace(' ', '_', convert_accented_characters($crumbs[0])) . '/' . $ambiente->N2_id);
			else :
				$voltar = base_url($locale);
			?>
			<?php endif ?>
			<a href="<?= $voltar ?>" style="color:white; text-decoration: none;">
				<h5><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5>
			</a>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-12" id="principal">
			<?php if (isset($_SESSION['aviso']) && $_SESSION['aviso']) : ?>
				<div class="alert alert-danger" role="alert">
					<h5><?=lang('Pb.product_not_found');?></h5>
					<?php
					if (!empty($pesquisa_feita)) :
						$pesq_str = '<p style="font-size: 0.8rem">';
						if (!empty($pesquisa_feita['coeficiente_atrito_molhado'])) {
							$pesq_str .= 'Coeficiente Atrito Molhado: ';
							foreach ($pesquisa_feita['coeficiente_atrito_molhado'] as $value) {
								$pesq_str .=  $value . ' / ';
							}
						}
						if (!empty($pesquisa_feita['absorcao_dagua']))
							$pesq_str .= 'Absorção de água: ' . $pesquisa_feita['absorcao_dagua'] . ' / ';
						if (!empty($pesquisa_feita['resistencia_manchas']))
							$pesq_str .= 'Resistência à Manchas: ' . $pesquisa_feita['resistencia_manchas'] . ' / ';
						if (!empty($pesquisa_feita['res_ata_quimico_alta']))
							$pesq_str .= 'Res Ata Químico Alta: ' . $pesquisa_feita['res_ata_quimico_alta'] . ' / ';
						if (!empty($pesquisa_feita['res_ata_quimico_baixa']))
							$pesq_str .= 'Res Ata Químico Baixa: ' . $pesquisa_feita['res_ata_quimico_baixa'] . ' / ';
						if (!empty($pesquisa_feita['expansao_por_umidade']))
							$pesq_str .= 'Expansão por Umidade: ' . $pesquisa_feita['expansao_por_umidade'] . ' / ';
						if (!empty($pesquisa_feita['tipologia_comercial'])) {
							$pesq_str .= 'Local de Uso: ';
							foreach ($pesquisa_feita['tipologia_comercial'] as $value) {
								$pesq_str .=  $value . ' / ';
							}
						}
						if (!empty($pesquisa_feita['caracteristica_acabamento'])) {
							$pesq_str .= 'Características Acabamento: ';
							foreach ($pesquisa_feita['caracteristica_acabamento'] as $value) {
								$pesq_str .=  $value . ' / ';
							}
						}
						if (!empty($pesquisa_feita['acabamento_de_borda'])) {
							$pesq_str .= 'Acabamento de Borda: ';
							foreach ($pesquisa_feita['acabamento_de_borda'] as $value) {
								$pesq_str .=  $value . ' / ';
							}
						}
						if (!empty($pesquisa_feita['resultado_minimo_limpeza'])) {
							$pesq_str .= 'Resistência Produto de Limpeza: ';
							foreach ($pesquisa_feita['resultado_minimo_limpeza'] as $value) {
								$pesq_str .=  $value . ' / ';
							}
						}
						//$pesq_str .= $lastQuery;

						$pesq_str = substr($pesq_str, 0, -3) . '</p>';
						echo $pesq_str;
					endif; ?>
				</div>
			<?php endif ?>
			<?= form_open($locale.'/caracteristicas/pesquisa', ['id' => 'caracteristicas']); ?>
			<div class="accordion" id="acordionCaracteristicas">
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading1">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
							<?=lang('Pb.wet_friction_coef');?>						
						<p id="coefAtr" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 14rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto maior o valor do coeficiente de atrito molhado, menos escorregadia é a superfície da peça">
								<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1">
						<div class="accordion-body">
							<!--
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado1" value="0.1">
								<label class="form-check-label" for="coeficiente_atrito_molhado1">
									0,1
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado2" value="0.2">
								<label class="form-check-label" for="coeficiente_atrito_molhado2">
									0,2
								</label>
							</div>
							-->
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado3" value="0.3">
								<label class="form-check-label" for="coeficiente_atrito_molhado3">
									0,3
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado4" value="0.4">
								<label class="form-check-label" for="coeficiente_atrito_molhado4">
									0,4
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado5" value="0.5">
								<label class="form-check-label" for="coeficiente_atrito_molhado5">
									0,5
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado6" value="0.6">
								<label class="form-check-label" for="coeficiente_atrito_molhado6">
									0,6
								</label>
							</div>
							<!--
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado7" value="0.7">
								<label class="form-check-label" for="coeficiente_atrito_molhado7">
									0,7
								</label>
							</div>
							
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="coeficiente_atrito_molhado[]" id="coeficiente_atrito_molhado8" value="0.8">
								<label class="form-check-label" for="coeficiente_atrito_molhado8">
									0,8
								</label>
							</div>
							-->
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro" id="heading2">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
							<?=lang('Pb.place_of_use');?>
							<p id="localUso" class="itens-selecionados fw-bold"></p>
						</button>
					</h2>
					<div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso6" value="RI" >
								<label class="form-check-label" for="local_uso6">
									RI - <?=lang('Pb.internal_coating');?>
								</label>
							</div>	
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso7" value="PE" >
								<label class="form-check-label" for="local_uso7">
									PE - <?=lang('Pb.external_wall');?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso3" value="FA">
								<label class="form-check-label" for="local_uso3">
									FA - <?=lang('Pb.facade');?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso5" value="RE">
								<label class="form-check-label" for="local_uso5">
									RE - <?=lang('Pb.residential');?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso1" value="CL">
								<label class="form-check-label" for="local_uso1">
									CL - <?=lang('Pb.commercial_light');?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso2" value="CP">
								<label class="form-check-label" for="local_uso2">
									CP - <?=lang('Pb.heavy_commercial');?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="local_uso[]" id="local_uso4" value="IU">
								<label class="form-check-label" for="local_uso4">
									IU - <?=lang('Pb.industrial');?>
								</label>
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro" id="heading3">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
							PEI
						</button>
					</h2>
					<div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="pei" id="pei1">
								<label class="form-check-label" for="pei1">
									1
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="pei" id="pei2">
								<label class="form-check-label" for="pei2">
									2
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="pei" id="pei3">
								<label class="form-check-label" for="pei3">
									3
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="pei" id="pei4">
								<label class="form-check-label" for="pei4">
									4
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="pei" id="pei5">
								<label class="form-check-label" for="pei5">
									5
								</label>
							</div>
						</div>
					</div>
				</div>
				-->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading4">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
							<?=lang('Pb.water_absorption');?> 
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto menor a absorção de água, maior será a resistência mecânica da peça."><i class="fas fa-info-circle"></i></a>-->
							<p id="absAgua" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 10rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto menor a absorção de água, maior será a resistência mecânica da peça.">
								<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" flag="< 0.5%" name="absorcao_dagua" id="absorcao_dagua1" value="0.5">
								<label class="form-check-label" for="absorcao_dagua1">
									<?=lang('Pb.below');?> de 0,5% (Bla)
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" flag="0.5% <= 3%" name="absorcao_dagua" id="absorcao_dagua2" value="3">
								<label class="form-check-label" for="absorcao_dagua2">
									0,5% <?=lang('Pb.to');?> 3% (Blb) 
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" flag="3% <= 6%" name="absorcao_dagua" id="absorcao_dagua3" value="6">
								<label class="form-check-label" for="absorcao_dagua3">
									3% <?=lang('Pb.to');?> 6% (Blla)
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" flag="6% <= 10%" name="absorcao_dagua" id="absorcao_dagua4" value="10">
								<label class="form-check-label" for="absorcao_dagua4">
									6% <?=lang('Pb.to');?> 10% (Bllb)
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" flag="> 10%" name="absorcao_dagua" id="absorcao_dagua5" value="10+">
								<label class="form-check-label" for="absorcao_dagua5">
									<?=lang('Pb.above');?> 10% (Blll)
								</label>
							</div>
							<!--
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="absorcao_dagua" id="absorcao_dagua6" value="20">
									<label class="form-check-label" for="absorcao_dagua6">
										20
									</label>
								</div>
							-->
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading5">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
							<?=lang('Pb.min_cleanability');?>
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto maior o número, mais fácil é sua limpeza."><i class="fas fa-info-circle"></i></a>-->
							<p id="resManc" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 16rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto maior o número, mais fácil é sua limpeza.">
							<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="resistencia_manchas" id="resistencia_manchas1" value="1">
								<label class="form-check-label" for="resistencia_manchas1">
									1
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="resistencia_manchas" id="resistencia_manchas2" value="2">
								<label class="form-check-label" for="resistencia_manchas2">
									2
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="resistencia_manchas" id="resistencia_manchas3" value="3">
								<label class="form-check-label" for="resistencia_manchas3">
									3
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="resistencia_manchas" id="resistencia_manchas4" value="4">
								<label class="form-check-label" for="resistencia_manchas4">
									4
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="resistencia_manchas" id="resistencia_manchas5" value="5">
								<label class="form-check-label" for="resistencia_manchas5">
									5
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading6">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
							<?=lang('Pb.min_staining_high');?>
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos HA resistem mais que produtos HB que, por sua vez, resistem mais que produtos HC."><i class="fas fa-info-circle"></i></a>-->
							<p id="resQuimAlta" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 15rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos HA resistem mais que produtos HB que, por sua vez, resistem mais que produtos HC.">
							<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_alta" value="HA" id="res_ata_quimico_alta1">
								<label class="form-check-label" for="res_ata_quimico_alta1">
									HA
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_alta" value="HB" id="res_ata_quimico_alta2">
								<label class="form-check-label" for="res_ata_quimico_alta2">
									HB
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_alta" value="HC" id="res_ata_quimico_alta3">
								<label class="form-check-label" for="res_ata_quimico_alta3">
									HC
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading7">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
							<?=lang('Pb.min_staining_low');?>
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos LA resistem mais que produtos LB que, por sua vez, resistem mais que produtos LC."><i class="fas fa-info-circle"></i></a>-->
							<p id="resQuimBaixa" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 15.5rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos LA resistem mais que produtos LB que, por sua vez, resistem mais que produtos LC.">
							<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_baixa" value="LA" id="res_ata_quimico_baixa1">
								<label class="form-check-label" for="res_ata_quimico_baixa1">
									LA
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_baixa" value="LB" id="res_ata_quimico_baixa2">
								<label class="form-check-label" for="res_ata_quimico_baixa2">
									LB
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="res_ata_quimico_baixa" value="LC" id="res_ata_quimico_baixa3">
								<label class="form-check-label" for="res_ata_quimico_baixa3">
									LC
								</label>
							</div>
						</div>
					</div>
				</div>

				<!-- Resistência Produto de Limpeza -->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="limpezas_h1">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#limpezas" aria-expanded="true" aria-controls="limpezas">
							<?=lang('Pb.min_res_cleaning_product');?>
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos A resistem mais que produtos B que, por sua vez, resistem mais que produtos C."><i class="fas fa-info-circle"></i></a>-->
							<p id="resProdLimp" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 20rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Produtos A resistem mais que produtos B que, por sua vez, resistem mais que produtos C.">
							<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="limpezas" class="accordion-collapse collapse" aria-labelledby="limpezas_h1">
						<div class="accordion-body">
							<?php $cnt = 1;
							foreach ($limpezas as $limpeza) :
								foreach ($limpeza as $key => $value) :
									if ($value) : ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" name="<?= $key ?>[]" id="<?= $key . $cnt ?>" value="<?= $value ?>">
											<label class="form-check-label" for="<?= $key . $cnt++ ?>">
												<?= $value ?>
											</label>
										</div>
								<?php endif;
								endforeach; ?>
							<?php
							endforeach ?>
						</div>
					</div>
				</div>
				<!-- Expansão por Umidade -->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro position-relative" id="heading8">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
							<?=lang('Pb.max_epu');?>
							<!--<a href="#" class="px-2 information-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto maior este valor, maior o revestimento dilatará na presença de água."><i class="fas fa-info-circle"></i></a>-->
							<p id="expUmd" class="itens-selecionados fw-bold"></p>
						</button>
						<button type="button" class="informative-icon" style="top: 1.7rem; left: 16rem;" data-bs-toggle="tooltip" data-bs-placement="right" title="Quanto maior este valor, maior o revestimento dilatará na presença de água.">
							<i class="fas fa-info-circle"></i>
						</button>
					</h2>
					<div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8">
						<div class="accordion-body">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="expansao_por_umidade" id="expansao_por_umidade2" value="0.1">
								<label class="form-check-label" for="expansao_por_umidade2">
									0,2
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="expansao_por_umidade" id="expansao_por_umidade3" value="0.3">
								<label class="form-check-label" for="expansao_por_umidade3">
									0,3
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="expansao_por_umidade" id="expansao_por_umidade4" value="0.4">
								<label class="form-check-label" for="expansao_por_umidade4">
									0,4
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="expansao_por_umidade" id="expansao_por_umidade5" value="0.5">
								<label class="form-check-label" for="expansao_por_umidade5">
									0,5
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="expansao_por_umidade" id="expansao_por_umidade6" value="0.6">
								<label class="form-check-label" for="expansao_por_umidade6">
									0,6
								</label>
							</div>
						</div>
					</div>
				</div>
				<!-- Tipologia Comercial -->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro" id="tipologias_h1">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipologias" aria-expanded="true" aria-controls="tipologias">
							<?=lang('Pb.cormecial_tipology');?>
							<p id="tipCom" class="itens-selecionados fw-bold"></p>
						</button>
					</h2>
					<div id="tipologias" class="accordion-collapse collapse" aria-labelledby="tipologias_h1">
						<div class="accordion-body">
							<?php $cnt = 1;
							foreach ($tipologias as $tipologia) :
								foreach ($tipologia as $key => $value) :
									if ($value) : ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" name="<?= $key ?>[]" id="<?= $key . $cnt ?>" value="<?= $value ?>">
											<label class="form-check-label" for="<?= $key . $cnt++ ?>">
												<?= $value ?>
											</label>
										</div>
								<?php
									endif;
								endforeach; ?>
							<?php
							endforeach ?>
						</div>
					</div>
				</div>
				<!-- Características Acabamento -->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro" id="acabamentos_h1">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acabamentos" aria-expanded="true" aria-controls="acabamentos">
							<?=lang('Pb.finishing_characteristics');?>
							<p id="carAcab" class="itens-selecionados fw-bold"></p>
						</button>
					</h2>
					<div id="acabamentos" class="accordion-collapse collapse" aria-labelledby="acabamentos_h1">
						<div class="accordion-body">
							<?php $cnt = 1;
							foreach ($acabamentos as $acabamento) :
								foreach ($acabamento as $key => $value) :
									if ($value) : ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" name="<?= $key ?>[]" id="<?= $key . $cnt ?>" value="<?= $value ?>">
											<label class="form-check-label" for="<?= $key . $cnt++ ?>">
												<?= $value ?>											
											</label>
										</div>
								<?php endif;
								endforeach; ?>
							<?php
							endforeach ?>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="caracteristica_acabamento[]" id="caracteristica_acabamento-NA" value="N/A">
								<label class="form-check-label" for="caracteristica_acabamento-NA" style="text-transform:uppercase">	
									<?=lang('Pb.others');?>
								</label>
							</div>
						</div>
					</div>
				</div>
				<!-- Acabamento de Borda -->
				<div class="accordion-item">
					<h2 class="accordion-header fundo-cinza-escuro" id="bordas_h1">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bordas" aria-expanded="true" aria-controls="bordas">
							<?=lang('Pb.edge_finish');?>
							<p id="acabBor" class="itens-selecionados fw-bold"></p>
						</button>
					</h2>
					<div id="bordas" class="accordion-collapse collapse" aria-labelledby="bordas_h1">
						<div class="accordion-body">
							<?php $cnt = 1;
							foreach ($bordas as $borda) :
								foreach ($borda as $key => $value) :
									if ($value) : ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" name="<?= $key ?>[]" id="<?= $key . $cnt ?>" value="<?= $value ?>">
											<label class="form-check-label" for="<?= $key . $cnt++ ?>">
												<?= $value ?>
											</label>
										</div>
								<?php endif;
								endforeach; ?>			
							<?php
							endforeach ?>
							<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" name="acabamento_de_borda[]" id="acabamento_de_borda-NA" value="N/A">
									<label class="form-check-label" for="acabamento_de_borda-NA" style="text-transform:uppercase">	
										<?=lang('Pb.others');?>
									</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row py-4">
				<div class="col-md-3 pe-1">
					<button type="button" class="btn btn-dark py-3" style="width:100%; font-weight: bold;" onclick="document.getElementById('caracteristicas').reset();"><i class="fas fa-trash-alt"></i> <?=lang('Pb.reset_filter');?></button>
				</div>
				<div class="col-md-9">
					<button type="submit" class="btn btn-light py-3" style="width:100%; font-weight: bold;"><i class="fas fa-search"></i> <?=lang('Pb.filter');?></button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(window).load(function() {
		$("input[type='radio']").click(function(evt) {
			evt.preventDefault();
			setTimeout(function() {
				if ($('#' + evt.target.id).is(':checked'))
					$('#' + evt.target.id).prop('checked', false);
				else
					$('#' + evt.target.id).prop('checked', true);
			}, 200);
		});
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  			return new bootstrap.Tooltip(tooltipTriggerEl)
		});
	});
/*$('[data-bs-toggle="tooltip"]').on('click', function () {
    $(this).tooltip('hide');
})*/
</script>

<script>
	$('#collapse1 .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#collapse1 .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#coefAtr').html(text);
	});

	$('#collapse2 .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#collapse2 .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#localUso').html(text);
	});

	$('#collapse4').on('click', function (event) {
		setTimeout(()=>{
			let checked_itens = Object.values($("input[name=absorcao_dagua]:checked")).slice(0,-4);
			let text = "";
			checked_itens.forEach((element)=>{
				text = text + $(element).attr('flag');
			});
			if(!checked_itens.length){
				text = ""
			}
			$('#absAgua').html(text);
		},500);
	});

	$('#collapse5').on('click', function (event) {
		setTimeout(()=>{
			let checked_itens = Object.values($("input[name=resistencia_manchas]:checked")).slice(0,-4);
			let text = "";
			checked_itens.forEach((element)=>{
				text = text + element.value;
			});
			if(!checked_itens.length){
				text = ""
			}
			$('#resManc').html(text);
		},500);
	});

	$('#collapse6').on('click', function (event) {
		setTimeout(()=>{
			let checked_itens = Object.values($("input[name=res_ata_quimico_alta]:checked")).slice(0,-4);
			let text = "";
			checked_itens.forEach((element)=>{
				text = text + element.value;
			});
			if(!checked_itens.length){
				text = ""
			}
			$('#resQuimAlta').html(text);
		},500);
	});

	$('#collapse7').on('click', function (event) {
		setTimeout(()=>{
			let checked_itens = Object.values($("input[name=res_ata_quimico_baixa]:checked")).slice(0,-4);
			let text = "";
			checked_itens.forEach((element)=>{
				text = text + element.value;
			});
			if(!checked_itens.length){
				text = ""
			}
			$('#resQuimBaixa').html(text);
		},500);
	});

	$('#limpezas .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#limpezas .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#resProdLimp').html(text);
	});

	$('#collapse8').on('click', function (event) {
		setTimeout(()=>{
			let checked_itens = Object.values($("input[name=expansao_por_umidade]:checked")).slice(0,-4);
			let text = "";
			checked_itens.forEach((element)=>{
				text = text + element.value;
			});
			if(!checked_itens.length){
				text = ""
			}
			$('#expUmd').html(text);
		},500);
	});

	$('#tipologias .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#tipologias .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#tipCom').html(text);
	});

	$('#acabamentos .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#acabamentos .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#carAcab').html(text);
	});	

	$('#bordas .form-check-input').on('change', function (event) {
		let id = event.target.id;
		let checked_itens = Object.values($('#bordas .form-check-input:checked')).slice(0,-4);
		let text = "";
		checked_itens.forEach((element)=>{
			text = text + element.value + ", ";
		});
		text = text.slice(0, -2);
		$('#acabBor').html(text);
	});
</script>