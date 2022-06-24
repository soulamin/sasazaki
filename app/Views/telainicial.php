<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>" />

</head>
<body>
	<?php 
		require_once(APPPATH.'views/includes/header.php');
	?>
	<div style='height:20px;'></div>  
    <div style="padding: 10px">
		<h1><?php echo $title?></h1>
		<?php echo $mensagem;?>
    </div>

	<div class="alert" style="width: 250px; margin: 15px; border: solid 1px #eee; text-align:center; display:inline-flex">
		<h4>Tempo médio de uso: <strong><?= $tempoMedio;?></strong></h4>
	</div>
	<div class="alert" style="width: 250px; margin: 15px; border: solid 1px #eee; text-align:center; display:inline-flex">
		<h4>Quantidade de Acessos: <strong><?= $total;?></strong></h4>
	</div>
	<div style="display: inline-flex; width:100vw; padding: 15px">

		<div style="width: 56%; height: 500px; padding: 15px">
			<canvas id="chartProdutos" ></canvas>
		</div>
		<div style="width: 35%; height: 350px; padding: 15px">
			<canvas id="chartSessao" ></canvas>
		</div>
	</div>

	<script src="<?=base_url('assets/js/bootstrap.bundle.min.js')?>"></script> 
	<script src="<?=base_url('assets/grocery_crud/js/jquery-1.11.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/chart.js')?>"></script>
	<script>
		$(function() {
			buscarTotalizadores()
			buscarSessao()
		})
		
		function buscarTotalizadores() {
			$.ajax({
				method: 'GET',
				url: '/api/dados-sessao-produtos',
				success: function(data) {
					montarChart(data)
				}
			})
		}
		
		function buscarSessao() {
			$.ajax({
				method: 'GET',
				url: '/api/dados-sessao',
				success: function(data) {
					console.log('data', data)
					montarChartSessao(data)
				}
			})
		}

		function montarChart(dados) {
			const ctx = document.getElementById('chartProdutos');
			var produtos = []
			var data = []

			for(var item of dados) {
				produtos.push(item.nome)
				data.push(item.total)
			}
			const myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: produtos,
					datasets: [{
						label: 'TOP 10 Produtos com mais acessos',
						data: data,
						backgroundColor: [
							'rgba(106,90,205, 0.5)',
							'rgba(0,0,205, 0.5)',
							'rgba(176,196,222, 0.5)',
							'rgba(50,205,50, 0.5)',
							'rgba(184,134,11, 0.5)',
							'rgba(245,222,179, 0.5)',
							'rgba(148,0,211, 0.5)',
							'rgba(255,0,0, 0.5)',
							'rgba(255,165,0, 0.5)',
							'rgba(255,255,0, 0.5)'
						],
						borderColor: [
							'rgba(106,90,205, 1)',
							'rgba(0,0,205, 1)',
							'rgba(176,196,222, 1)',
							'rgba(50,205,50, 1)',
							'rgba(184,134,11, 1)',
							'rgba(245,222,179, 1)',
							'rgba(148,0,211, 1)',
							'rgba(255,0,0, 1)',
							'rgba(255,165,0, 1)',
							'rgba(255,255,0, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					indexAxis: 'y'
				}
			});
		}

		function montarChartSessao(dados) {
			const ctx = document.getElementById('chartSessao');
			var sessao = []
			var data = []

			for(var item of dados) {
				sessao.push(item.TipoJornada)
				data.push(item.total)
			}
			const myChart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: sessao,
					datasets: [{
						label: 'Jornada Completa X Jornada Incompleta',
						data: data,
						backgroundColor: [
							'rgba(255,0,0, 0.5)',
							'rgba(50,205,50, 0.5)'
						],
						borderColor: [
							'rgba(255,0,0, 1)',
							'rgba(50,205,50, 1)'
						],
						borderWidth: 1
					}]
				}
			});
		}
	</script>
</body>
</html>