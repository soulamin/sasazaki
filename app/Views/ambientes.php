<style type="text/css">
	<?php if ($totem_tipo == 'totem') : ?>
		.accordionPisos {
			padding-left: 80px;
		}

		.accordionParedes {
			padding-left: 80px;
		}

	<?php endif ?>
</style>
<div class="container-fluid">
	<div class="row py-1 fundo-cinza-escuro">
		<?php $titulo = explode(' ', lang('Pb.tech_search')) ?>
		<h2 style="font-size:2rem"><small style="font-size:0.4em"><?= $titulo[0] ?></small><br /> <?= $titulo[1] ?></h2>
	</div>
	<div class="row pt-4">
		<div class="col-sm-9">
			<h4 style=""><?=lang('Pb.select_filters');?></h4>
		</div>
		<div class="col-sm-3 text-end">
			<?php
			if (!empty($uri['uso']) && !empty($uri['n1'])) {
				if (!empty($uri['n2']))
					$voltar = base_url($locale.'/ambientes/pesquisa/' . $uri['uso'] . '/' . $uri['n1'] . '/' . $uri['n2']);
				else
					$voltar = base_url($locale.'?uso=' . $uri['uso'] . '&n1=' . $uri['n1']);
			} else
				$voltar = base_url($locale);
			?>
			<a href="<?= $voltar ?>" style="color:white; text-decoration: none;">
				<h5><i class="fas fa-arrow-left me-3"></i> <?=lang('Pb.back');?></h5>
			</a>
		</div>
	</div>
	<?php if (isset($_SESSION['aviso']) && $_SESSION['aviso']) : ?>
		<div class="alert alert-danger" role="alert">
			<?= $_SESSION['aviso'] ?>
			<?php //echo $lastQuery 
			?>

		</div>
	<?php endif ?>
	<div class="row">
		<div class="col-md-12">
			<form id="caracteristicas" name="caracteristicas">
				<div class="row py-3">
					<div class="col-md-3">
						<select id="N1Select" class="form-select fundo-cinza-escuro" aria-label="Piso ou Parede">
							<option value="Piso"><?=lang('Pb.floor');?></option>
							<option value="Parede"><?=lang('Pb.wall');?></option>
						</select>
					</div>
				</div>
				<?php
				$cont_uso = 0;
				$cont_n2 = 0;
				$cont_n3 = 0;
				$uso = '';
				$n2 = '';
				?>
				<div class="accordion py-3" id="accordionPisos">
					<?php foreach ($pisos as $piso) : ?>
						<?php if ($piso['Uso_nome'] != $uso) :
							$cont_uso++;
							$n2 = '';
							if ($uso != '')
								echo '</div></div></div></div></div></div></div>';
							$uso = $piso['Uso_nome'];
							$shown1 = '';
							if (!empty($uri) && strtolower(str_replace(' ', '_', convert_accented_characters($piso['Uso_nome']))) == strtolower($uri['uso']))
								$shown1 = 'show';
						?>
							<div class="accordion-item">
								<h2 class="accordion-header fundo-cinza-escuro" id="h2-<?= $cont_uso ?>">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-<?= $cont_uso ?>" aria-expanded="false" aria-controls="acc-<?= $cont_uso ?>">
										<?= $piso['Uso_nome'] ?>
									</button>
								</h2>
								<div id="acc-<?= $cont_uso ?>" class="accordion-collapse collapse <?= $shown1 ?>" aria-labelledby="h2-<?= $cont_uso ?>" data-bs-parent="#accordion1">
									<div class="accordion-body">
										<div class="accordion py-3" id="accordion-<?= $cont_uso ?>">
										<?php endif; ?>
										<?php if ($piso['N2_nome'] != $n2) :
											$cont_n2++;
											$cont_n3 = 0;
											if ($n2 != '')
												echo '</div></div></div>';
											$n2 = $piso['N2_nome'];
											$shown2 = '';
											if (!empty($uri) && $piso['N2_id'] == $uri['n2'])
												$shown2 = 'show';
										?>
											<div class="accordion-item">
												<h2 class="accordion-header fundo-cinza-escuro" id="h2-<?= $cont_uso ?>-<?= $cont_n2 ?>">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-<?= $cont_uso ?>-<?= $cont_n2 ?>" aria-expanded="false" aria-controls="acc-<?= $cont_uso ?>-<?= $cont_n2 ?>">
														<?= $piso['N2_nome'] ?>
													</button>
												</h2>
												<div id="acc-<?= $cont_uso ?>-<?= $cont_n2 ?>" class="accordion-collapse collapse <?= $shown2 ?>" aria-labelledby="h2-<?= $cont_uso ?>-<?= $cont_n2 ?>" data-bs-parent="#accordion-<?= $cont_uso ?>">
													<div class="accordion-body">

													<?php endif; ?>
													<div class="form-check">
														<input class="form-check-input" type="radio" name="ambiente_check" id="ambiente_check<?= $cont_uso ?>-<?= $cont_n2 ?>-<?= $cont_n3 ?>" onclick="location.href='<?= base_url($locale.'/ambientes/id/' . $piso['N3_id']) ?>';">
														<label class="form-check-label" for="ambiente_check<?= $cont_uso ?>-<?= $cont_n2 ?>-<?= $cont_n3++ ?>" onclick="location.href='<?= base_url($locale.'/ambientes/id/' . $piso['N3_id']) ?>';">
															<?= $piso['N3'] ?>
														</label>

														<?php if ($piso['ambiente_3_descricao'] != null): ?>
															<button type="button" class="informative-icon-ambient" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $piso['ambiente_3_descricao'] ?>">
																<i class="fas fa-info-circle"></i>
															</button>
														<?php endif ?>

													</div>
												<?php endforeach; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
				</div>
		</div>
		<?php
		$cont_n2 = 0;
		$cont_n3 = 0;
		$uso = '';
		?>
		<div class="accordion py-3" id="accordionParedes">
			<?php foreach ($paredes as $parede) : ?>
				<?php if ($parede['Uso_nome'] != $uso) :
					$cont_uso++;
					$n2 = '';
					if ($uso != '')
						echo '</div></div></div></div></div></div></div>';
					$uso = $parede['Uso_nome'];
					$shown1 = '';
					if (!empty($uri) && strtolower(str_replace(' ', '_', convert_accented_characters($parede['Uso_nome']))) == strtolower($uri['uso']))
						$shown1 = 'show';
				?>
					<div class="accordion-item">
						<h2 class="accordion-header fundo-cinza-escuro" id="h2-<?= $cont_uso ?>">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-<?= $cont_uso ?>" aria-expanded="false" aria-controls="acc-<?= $cont_uso ?>">
								<?= $parede['Uso_nome'] ?>
							</button>
						</h2>
						<div id="acc-<?= $cont_uso ?>" class="accordion-collapse collapse <?= $shown1 ?>" aria-labelledby="h2-<?= $cont_uso ?>" data-bs-parent="#accordion1">
							<div class="accordion-body">
								<div class="accordion py-3" id="accordion-<?= $cont_uso ?>">
								<?php endif; ?>
								<?php if ($parede['N2_nome'] != $n2) :
									$cont_n2++;
									$cont_n3 = 0;
									if ($n2 != '')  echo '</div></div></div>';
									$n2 = $parede['N2_nome'];
									$shown2 = '';
									if (!empty($uri) && $piso['N2_id'] == $uri['n2'])
										$shown2 = 'show';
								?>
									<div class="accordion-item">
										<h2 class="accordion-header fundo-cinza-escuro" id="h2-<?= $cont_uso ?>-<?= $cont_n2 ?>">
											<button class="accordion-button collapsed <?= $shown2 ?>" type="button" data-bs-toggle="collapse" data-bs-target="#acc-<?= $cont_uso ?>-<?= $cont_n2 ?>" aria-expanded="false" aria-controls="acc-<?= $cont_uso ?>-<?= $cont_n2 ?>">
												<?= $parede['N2_nome'] ?>
											</button>
										</h2>
										<div id="acc-<?= $cont_uso ?>-<?= $cont_n2 ?>" class="accordion-collapse collapse" aria-labelledby="h2-<?= $cont_uso ?>-<?= $cont_n2 ?>" data-bs-parent="#accordion-<?= $cont_uso ?>">
											<div class="accordion-body">
											<?php endif; ?>
											<div class="form-check">

												<input class="form-check-input" type="radio" name="ambiente_check" id="ambiente_check<?= $cont_uso ?>-<?= $cont_n2 ?>-<?= $cont_n3 ?>" onclick="location.href='<?= base_url($locale.'/ambientes/id/' . $parede['N3_id']) ?>';">
												<label class="form-check-label" for="ambiente_check<?= $cont_uso ?>-<?= $cont_n2 ?>-<?= $cont_n3++ ?>" onclick="location.href='<?= base_url($locale.'/ambientes/id/' . $parede['N3_id']) ?>';">
													<?= $parede['N3'] ?>
												</label>

												<?php if ($parede['ambiente_3_descricao'] != null): ?>
													<button type="button" class="informative-icon-ambient" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $parede['ambiente_3_descricao'] ?>">
														<i class="fas fa-info-circle"></i>
													</button>
												<?php endif ?>
											</div>
										<?php endforeach; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</div>
	</div>
	</form>
</div>
</div>
</div>
<script type="text/javascript">
	$(function() {
		<?php if (!empty($uri)) { ?>

			$("#usoSelect > option").each(function() {
				if (this.value == "<?= $uri['uso'] ?>")
					$(this).attr("selected", "selected");
			});
			$("#N1Select > option").each(function() {
				if (this.value == "<?= $uri['n1'] ?>")
					$(this).attr("selected", "selected");
			});
			<?php
			if ($uri['n1'] == 'Piso') { ?>
				$('#accordionParedes').hide();
			<?php 		} else { ?>
				$('#accordionPisos').hide();
			<?php		}
		} else { ?>
			$('#accordionParedes').hide();
		<?php	}
		?>

		$('#N1Select').change(function() {
			if ($('#N1Select').val() == 'Piso') {
				$('#accordionParedes').hide();
				$('#accordionPisos').show();
			}
			if ($('#N1Select').val() == 'Parede') {
				$('#accordionPisos').hide();
				$('#accordionParedes').show();
			}
		});
	});
</script>

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