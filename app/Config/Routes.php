<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// página principal (controller home)

$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('homeDepartamento/(:num)', 'Home::homeDepartamento/$1');
$routes->get('sobrenos', 'Home::sobrenos');
$routes->get('contato', 'Home::contato');
$routes->post('contatoEnviaEmail', 'Home::contatoEnviaEmail');
$routes->get('login', 'Home::login');
$routes->get('criarNovaConta', 'Home::criarNovaConta');
$routes->post('gravarNovaConta', 'Home::gravarNovaConta');
$routes->post('addProdutoCarrinho', 'Home::addProdutoCarrinho');
$routes->post('atualizaProdutoCarrinho', 'Home::atualizaProdutoCarrinho');
$routes->post('atualizaFrete', 'Home::atualizaFrete');
$routes->post('atualizaCarrinho', 'Home::atualizaCarrinho');
$routes->get('carrinhoCompras', 'Home::carrinhoCompras');
$routes->get('carrinhoPagamento', 'Home::carrinhoPagamento');
$routes->get('carrinhoConfirmacao', 'Home::carrinhoConfirmacao');
$routes->get('produtodetalhe/(:num)', 'Home::produtoDetalhe/$1');

// Login
$routes->group('Login', function ($routes) {
    $routes->post('signIn', 'Login::signIn');
    $routes->get('signOut', 'Login::signOut');
});

// sistema
$routes->group('Sistema', function ($routes) {
    $routes->get('/', 'Sistema::home');
    $routes->get('home', 'Sistema::home');
});

// Crud UF
$routes->group('Uf', function ($routes) {
    $routes->get('/', 'Uf::index');
    $routes->get('lista', 'Uf::index');
    $routes->get('form/(:segment)/(:num)', 'Uf::form/$1/$2');
    $routes->post('store', 'Uf::store');
    $routes->post('delete', 'Uf::delete');
});

// Crud Departamento
$routes->group('Departamento', function ($routes) {
    $routes->get('/', 'Departamento::index');
    $routes->get('lista', 'Departamento::index');
    $routes->get('form/(:segment)/(:num)', 'Departamento::form/$1/$2');
    $routes->post('store', 'Departamento::store');
    $routes->post('delete', 'Departamento::delete');
});

// Crud Produto
$routes->group('Produto', function ($routes) {
    $routes->get('/', 'Produto::index');
    $routes->get('lista', 'Produto::index');
    $routes->get('form/(:segment)/(:num)', 'Produto::form/$1/$2');
    $routes->post('store', 'Produto::store');
    $routes->post('delete', 'Produto::delete');
    $routes->get('excluirImagem/(:num)/(:segment)/(:segment)', 'Produto::excluirImagem/$1/$2/$3');
});

// Crud Pessoa
$routes->group('Pessoa', function ($routes) {
    $routes->get('form/(:segment)/(:num)', 'Pessoa::form/$1/$2');
    $routes->post('store', 'Pessoa::store');
    $routes->get('getCidade/(:num)', 'Pessoa::getCidade/$1');
});

// Crud PessoaEndereco
$routes->group('PessoaEndereco', function ($routes) {
    $routes->get('/', 'PessoaEndereco::index');
    $routes->get('lista', 'PessoaEndereco::index');
    $routes->get('form/(:segment)/(:num)', 'PessoaEndereco::form/$1/$2');
    $routes->post('store', 'PessoaEndereco::store');
    $routes->post('delete', 'PessoaEndereco::delete');
});

// Crud Pedido
$routes->group('Pedido', function ($routes) {
    $routes->get('/', 'Pedido::index');
    $routes->get('lista', 'Pedido::index');
    $routes->get('viewPedido/(:num)', 'Pedido::viewPedido/$1');
});
