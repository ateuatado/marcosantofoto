<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Inicial::index');
$routes->get('sitemap.xml', 'Sitemap::index');

service('auth')->routes($routes);
// O apelido 'ensaios' é o que o url_to procura
//$routes->get('ensaios', 'Pages::ensaios', ['as' => 'ensaios', 'filter' => 'session']);
$routes->get('ensaios', 'Ensaios::index', ['as' => 'ensaios', 'filter' => 'session']);

// Rotas de perfil do usuário
$routes->get('perfil/trocar_senha',  'Perfil::trocar_senha',  ['filter' => 'session']);
$routes->post('perfil/salvar_senha', 'Perfil::salvar_senha',  ['filter' => 'session']);

// Página do Método
$routes->get('metodo', 'Ensaios::metodo', ['as' => 'metodo', 'filter' => 'session']);

// Candidatura ao ensaio
$routes->get('candidatura',         'Candidaturas::index',  ['filter' => 'session']);
$routes->post('candidatura/enviar', 'Candidaturas::enviar', ['filter' => 'session']);

$routes->group('ensaios', ['filter' => 'session'], function($routes) {
    $routes->get('confirmar/(:segment)', 'Ensaios::confirmar/$1'); // Tela de atrito
    $routes->post('processar/(:segment)', 'Ensaios::processar/$1'); // Ação do form
    $routes->get('ver/(:segment)', 'Ensaios::ver/$1'); // O conteúdo real
});


$routes->get('ensaios/ver/(:segment)/(:num)', 'Ensaios::ver/$1/$2', ['filter' => 'session']); 
$routes->get('ensaios/ver/(:segment)', 'Ensaios::ver/$1', ['filter' => 'session']);
// Rota para ver as páginas do Santuário (Fichas, Galerias, etc)
$routes->get('ensaios/extra/(:num)', 'Ensaios::extra/$1', ['filter' => 'session']);
// Rota para o Mural de Descompressão (Santuário)
$routes->get('ensaios/santuario/(:segment)', 'Ensaios::santuario/$1', ['filter' => 'session']);

$routes->post('ensaios/registrar_interesse', 'Ensaios::registrar_interesse');

// ... suas rotas de 'ensaios' continuam iguais acima ...

// --- GRUPO ADMIN CORRIGIDO ---
// O filtro está AQUI, na entrada principal. Ninguém passa sem crachá.
$routes->group('admin', ['filter' => 'group:superadmin'], function($routes) {
    
    // Dashboard (Home do Admin)
    $routes->get('/', 'Admin::index');

    // Criação (Novo Ensaio)
    $routes->get('novo', 'Admin::novo');
    $routes->post('salvar', 'Admin::salvar');

    // Gerenciador de Conteúdo (Mapa)
    $routes->get('mapa/(:num)', 'Admin::mapa/$1'); 

    // Ações de Etapas e Itens
    $routes->post('adicionar_etapa', 'Admin::adicionar_etapa');
    $routes->post('adicionar_item', 'Admin::adicionar_item');
    $routes->get('excluir_etapa/(:num)', 'Admin::excluir_etapa/$1');
    $routes->get('excluir_item/(:num)', 'Admin::excluir_item/$1');
    $routes->post('atualizar_etapa', 'Admin::atualizar_etapa');
    $routes->post('atualizar_item', 'Admin::atualizar_item');

    // Reordenação e Status
    $routes->get('reordenar_etapa/(:num)/(:segment)', 'Admin::reordenar_etapa/$1/$2');
    $routes->get('reordenar_item/(:num)/(:segment)', 'Admin::reordenar_item/$1/$2');
    $routes->get('alternar_status/(:num)', 'Admin::alternar_status/$1');
    $routes->get('editar/(:num)', 'Admin::editar/$1');
    $routes->post('atualizar', 'Admin::atualizar');
    $routes->get('excluir/(:num)', 'Admin::excluir/$1');

    // --- CANDIDATURAS ---
    $routes->get('candidaturas',                   'Admin::candidaturas');
    $routes->get('candidatura/aceitar/(:num)',      'Admin::aceitar_candidatura/$1');
    $routes->get('candidatura/recusar/(:num)',      'Admin::recusar_candidatura/$1');

    // --- SANTUÁRIO (PÁGINAS EXTRAS) ---
    $routes->group('extras', function($routes) {
        $routes->get('/', 'AdminExtras::index');                 // Painel Seletor
        $routes->get('listar/(:num)', 'AdminExtras::listar/$1'); // Fragmento AJAX
        $routes->get('nova/(:num)', 'AdminExtras::nova/$1');     // Form Criação
        $routes->post('salvar', 'AdminExtras::salvar');          // Processar
        $routes->get('editar/(:num)', 'AdminExtras::editar/$1'); // Form Edição
        $routes->get('excluir/(:num)', 'AdminExtras::excluir/$1');
    });
});
