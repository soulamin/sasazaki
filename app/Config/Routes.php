<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/{locale}', 'Home::index');
$routes->get('/{locale}/home/reiniciar', 'Home::reiniciar');
$routes->get('/{locale}/home/material/(:any)', 'Home::material/$1');
$routes->get('/{locale}/home/linha/(:any)', 'Home::linha/$1');
$routes->get('/{locale}/home/produto/(:any)', 'Home::produto/$1');
$routes->get('/{locale}/home/ambientes/(:any)', 'Home::ambientes/$1');

$routes->get('/{locale}/ambientes', 'Ambientes::index');
$routes->get('/{locale}/ambientes/id/(:num)', 'Ambientes::id/$1');
$routes->get('/{locale}/ambientes/pesquisa/(:any)', 'Ambientes::pesquisa/$1');

$routes->get('/{locale}/caracteristicas', 'Caracteristicas::index');
$routes->post('/{locale}/caracteristicas/pesquisa', 'Caracteristicas::pesquisa');

$routes->post('/{locale}/comparar', 'Comparar::index');

$routes->get('/{locale}/favoritos', 'Favoritos::index');
$routes->get('/{locale}/favoritos/adicionar/(:any)', 'Favoritos::adicionar/$1');
$routes->get('/{locale}/favoritos/remover', 'Favoritos::remover');
$routes->get('/{locale}/favoritos/remover/(:any)', 'Favoritos::remover/$1');

$routes->get('/{locale}/produto/linha/(:any)', 'Produto::linha/$1');
$routes->get('/{locale}/produto/codigo/(:any)', 'Produto::codigo/$1');

$routes->group('api', function($routes) {
	
	$routes->get('produto/(:num)', 'ImportarProduto::getList/$1');
	$routes->get('atualizar-produto/(:num)', 'ImportarProduto::atualizandoLista/$1');
	$routes->get('banners/(:num)', 'ImportarBanner::getList/$1');
	$routes->get('ambiente-uso', 'ImportarAmbientes::importarAmbienteUso');
	$routes->get('ambiente-n1', 'ImportarAmbientes::importarAmbienteN1');
	$routes->get('ambiente-n2', 'ImportarAmbientes::importarAmbienteN2');
	$routes->get('ambiente-n3', 'ImportarAmbientes::importarAmbienteN3');
	$routes->get('materiais', 'ImportarMateriais::importarMateriais');
	$routes->get('group-images', 'ImportarProduto::importarGroupImages');
	
	$routes->post('setarsessao', 'Analytics::setSession');
	$routes->post('setarnalyticsprodutos', 'Analytics::setAnalyticsProdutos');
	$routes->get('dados-sessao-produtos', 'Analytics::getTotalizadores');
	$routes->get('dados-sessao', 'Analytics::getSessaoDash');
	
});

$routes->group('sincronizador', function($routes) {
	
	$routes->get('produto', 'AdicionarProduto::importarProduto');
	$routes->get('banners', 'AdicionarBanner::importarBanners');
	$routes->get('ambiente-uso', 'AdicionarAmbientes::importarAmbienteUso');
	$routes->get('ambiente-n1', 'AdicionarAmbientes::importarAmbienteN1');
	$routes->get('ambiente-n2', 'AdicionarAmbientes::importarAmbienteN2');
	$routes->get('ambiente-n3', 'AdicionarAmbientes::importarAmbienteN3');
	$routes->get('buscar-images', 'AdicionarAmbientes::baixarImagens');
	$routes->get('buscar-imagesn3', 'AdicionarAmbientes::baixarImagensN3');
	$routes->get('materiais', 'AdicionarMateriais::importarMateriais');
	$routes->get('group-images', 'AdicionarProduto::importarGroupImages');
	$routes->get('baixar-images-produtos', 'AdicionarProduto::baixarImagesProdutos');
	
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
