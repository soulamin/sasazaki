<?php 
$arrayPermissions = [];
$permissaoUsuario = ['FN_CADUSUARIO', 'FN_CADFUNCIONALIDADE','FN_CADPAPEL'];
$permissaoAmbientes = ['FN_CADAMBIENTEN3','FN_CADAMBIENTEN2', 'FN_CADAMBIENTEN1', 'FN_CADAMBIENTEUSO'];
$permissaoProdutos = ["FN_IMPPRODAPI","FN_IMPAGODESK","FN_CADPROD","FN_IMGRELATED","FN_IMGLAND","FN_GROUPIMG","FN_CADMATERIAL"];
$permissaoLojas = ['FN_CADBANNER', 'FN_CADCONSULTOR', 'FN_CADTOTEN'];
$isTemPermissaoLoja = false;
$isTemPermissaoAmbientes = false;
$isTemPermissaoProdutos = false;
$isTemPermissaoUsuario = false;

foreach($permissoes as $permissao) {
	array_push($arrayPermissions, $permissao->funcao);

	if (in_array($permissao->funcao, $permissaoAmbientes)) {
		$isTemPermissaoAmbientes = true;
	}

	if (in_array($permissao->funcao, $permissaoUsuario)) {
		$isTemPermissaoUsuario = true;
	}

	if (in_array($permissao->funcao, $permissaoLojas)) {
		$isTemPermissaoLoja = true;
	}

	if (in_array($permissao->funcao, $permissaoProdutos)) {
		$isTemPermissaoProdutos = true;
	}
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Admin Portobello</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<style type="text/css">.nav-link a {color: white;}</style>
			<div class="collapse navbar-collapse" id="navbarScroll">
				<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 200px;">
					<?php
						if ($isTemPermissaoLoja) {
					?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Lojas
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
									<?php
										if (in_array('FN_CADTOTEN', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/totens')?>'>Totens</a></li>
									<?php
										}
										/*if (in_array('FN_CADCONSULTOR', $arrayPermissions)){
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/consultor')?>'>Consultor</a></li>
									<?php 
										}*/
										if (in_array('FN_CADBANNER', $arrayPermissions)){
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/baners')?>'>Baners</a></li>
									<?php 
										}
									?>			
								</ul>
							</li>
					<?php
						}
						if ($isTemPermissaoProdutos) {
					?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Produtos
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
									<?php 
										if (in_array('FN_IMPPRODAPI', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/importar_produtos')?>'>Importar Produtos</a></li>
									<?php
										} 
										if (in_array('FN_IMPAGODESK', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/importar_agora')?>'>Agendar Atualização</a></li>
									<?php
										} 
										if (in_array('FN_CADPROD', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/produtos')?>'>Lista Produtos</a></li>
									<?php
										} 
										if (in_array('FN_IMGRELATED', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/related')?>'>Img Related</a></li>
									<?php
										} 
										if (in_array('FN_IMGLAND', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/related_landscape')?>'>Img Landscape</a></li>
									<?php
										} 
										if (in_array('FN_GROUPIMG', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/group_images')?>'>Group Image</a></li>
									<?php
										} 
									?>
										<li><hr class="dropdown-divider"></li>
									<?php
										
										if (in_array('FN_CADMATERIAL', $arrayPermissions)) {
									?>
										<li><a class="dropdown-item" href='<?php echo base_url('admin/materiais')?>'>Materiais</a></li>
										<?php
										}
									?>
								</ul>
							</li>
					<?php
						}
						if ($isTemPermissaoAmbientes) {
					?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									Ambientes
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
									<?php
										if (in_array('FN_CADAMBIENTEN3', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/ambientes_n3')?>'>Ambientes N3</a></li>
									<?php
										}
										if (in_array('FN_CADAMBIENTEN2', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/ambientes_n2')?>'>Ambientes N2</a></li>
									<?php
										}
										if (in_array('FN_CADAMBIENTEN1', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/ambientes_n1')?>'>Ambientes N1</a></li>
									<?php
										}
										if (in_array('FN_CADAMBIENTEUSO', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/ambientes_usos')?>'>Ambientes Usos</a></li>
									<?php
										}
									?>
								</ul>
							</li>
					<?php 
						}
						if ($isTemPermissaoUsuario) {
					?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									Usuários
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
								<?php
										if (in_array('FN_CADPAPEL', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/papeis')?>'>Papéis</a></li>
									<?php
										}
										if (in_array('FN_CADFUNCIONALIDADE', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/funcionalidades')?>'>Funcionalidades</a></li>
									<?php
										}
										if (in_array('FN_CADUSUARIO', $arrayPermissions)) {
									?>
											<li><a class="dropdown-item" href='<?php echo base_url('admin/usuarios')?>'>Usuários</a></li>
									<?php
										}
									?>
								</ul>						
							</li>
					<?php 
						}
					?>
					<li class="nav-item">						
	        			<a class="nav-link" href='<?php echo base_url('admin/logoff')?>'>Logoff</a>
					</li>
				</ul>

				<p><?php echo $usuario?></p>
			</div>
		</div>
	</nav>