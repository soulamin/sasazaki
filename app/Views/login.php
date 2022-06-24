<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Rodrigo Furtado">
	<meta name="generator" content="BeeID">

	<title>Portobello Admin</title>

	<!-- Bootstrap core CSS -->
	<style>@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700&display=swap');</style>
	<link href="<?=base_url('assets')?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/splide.min.css">
	<link href="<?=base_url('assets')?>/css/all.css" rel="stylesheet">  
	<script src="<?=base_url('assets')?>/js/all.js"></script>
	<script src="<?=base_url('assets')?>/js/splide.min.js"></script>
	<link href="<?=base_url('assets')?>/css/portobello.css" rel="stylesheet">  

	<!-- LayerSlider stylesheet -->
	<link rel="stylesheet" href="<?=base_url('assets')?>/js/layerslider/css/layerslider.css" type="text/css">
	<!-- External libraries: jQuery & GreenSock -->
	<script src="<?=base_url('assets')?>/js/layerslider/js/jquery.js" type="text/javascript"></script>
</head>
<body>
	<main class="form-signin">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6">
				<?= form_open('admin/login') ?>
					<h1 class="h3 mb-3 fw-normal">Por favor, insira seus dados</h1>
					<div class="form-floating mb-3">
						<input name="email" type="email" class="form-control" id="floatingInput" placeholder="nome@exemplo.com" value="<?= esc($email) ?>">
						<label for="floatingInput">Email</label>
					</div>
					<div class="form-floating mb-3">
						<input name="senha" type="password" class="form-control" id="floatingPassword" placeholder="Senha" autocomplete="off" value="<?= esc($senha) ?>">
						<label for="floatingPassword">Senha</label>
					</div>
					<?php if($dadosNaoBatem): ?>
					<div class="alert alert-danger" role="alert">
						Dados não batem! Favor verificar email e senha.
					</div>
					<?php endif ?>
    				<?= $validation->listErrors('erros') ?>
					<button class="w-100 btn btn-lg btn-primary" type="submit">Logar</button>
				</form>
				</div>
			</div>
		</div>
	</main>
	<script src="<?=base_url('assets/js/bootstrap.bundle.min.js')?>"></script> 
</body>
</html>