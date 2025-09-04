<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// --- Rute Publik & Autentikasi ---
$routes->get('/', 'HomeController::index');
$routes->get('/home/sekolah-json', 'HomeController::sekolahJson');
$routes->get('/home/jenjang-json', 'HomeController::jenjangJson');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/profil', 'ProfilController::index');

$routes->post('kontak/kirim', 'KontakController::kirim');

// ====================================================================
// GRUP UTAMA UNTUK SEMUA RUTE YANG MEMERLUKAN LOGIN (FILTER 'auth')
// ====================================================================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // --- Rute Dashboard (bisa diakses semua role yang sudah login) ---
    $routes->group('dashboard', function ($routes) { // Hapus filter 'role:admin' dari sini
        $routes->get('/', 'DashboardController::index');
        $routes->get('getData', 'DashboardController::getData');
        $routes->get('getChartData', 'DashboardController::getChartData');
    });

    // --- Rute yang hanya bisa diakses ADMIN ---
    $routes->group('', ['filter' => 'role:admin'], function ($routes) {
        // Grup untuk Kecamatan
        $routes->group('kecamatan', function ($routes) {
            $routes->get('/', 'KecamatanController::index');
            $routes->get('data', 'KecamatanController::data');
            $routes->get('select2', 'KecamatanController::getSelect2Data');
            $routes->get('(:num)', 'KecamatanController::show/$1');
            $routes->post('store', 'KecamatanController::store');
            $routes->post('update/(:num)', 'KecamatanController::update/$1');
            $routes->delete('destroy/(:num)', 'KecamatanController::destroy/$1');
        });

        // Grup untuk Desa
        $routes->group('desa', function ($routes) {
            $routes->get('/', 'DesaController::index');
            $routes->get('data', 'DesaController::data');
            $routes->get('select2', 'DesaController::getSelect2Data');
            $routes->get('(:num)', 'DesaController::show/$1');
            $routes->post('store', 'DesaController::store');
            $routes->post('update/(:num)', 'DesaController::update/$1');
            $routes->delete('destroy/(:num)', 'DesaController::destroy/$1');
        });

        // Grup untuk Jenjang Pendidikan
        $routes->group('jenjang_pendidikan', function ($routes) {
            $routes->get('/', 'JenjangPendidikanController::index');
            $routes->get('data', 'JenjangPendidikanController::data');
            $routes->get('select2', 'JenjangPendidikanController::getSelect2Data');
            $routes->get('(:num)', 'JenjangPendidikanController::show/$1');
            $routes->post('store', 'JenjangPendidikanController::store');
            $routes->post('update/(:num)', 'JenjangPendidikanController::update/$1');
            $routes->delete('destroy/(:num)', 'JenjangPendidikanController::destroy/$1');
        });

        // Grup untuk Operator
        $routes->group('operator', function ($routes) {
            $routes->get('/', 'OperatorController::index');
            $routes->get('data', 'OperatorController::data');
            $routes->get('select2', 'OperatorController::getSelect2Data');
            $routes->get('(:num)', 'OperatorController::show/$1');
            $routes->post('store', 'OperatorController::store');
            $routes->post('update/(:num)', 'OperatorController::update/$1');
            $routes->delete('destroy/(:num)', 'OperatorController::destroy/$1');
            $routes->post('cetak', 'OperatorController::cetak');
        });
    });


    // --- Rute yang bisa diakses ADMIN dan OPERATOR ---
    $routes->group('', ['filter' => 'role:admin,operator'], function ($routes) {
        // Grup untuk Sekolah
        $routes->group('sekolah', function ($routes) {
            $routes->get('/', 'SekolahController::index');
            $routes->get('data', 'SekolahController::data');
            $routes->get('select2', 'SekolahController::getSelect2Data');
            $routes->get('(:num)', 'SekolahController::show/$1');
            $routes->post('store', 'SekolahController::store');
            $routes->post('update/(:num)', 'SekolahController::update/$1');
            $routes->delete('destroy/(:num)', 'SekolahController::destroy/$1');
            $routes->post('cetak', 'SekolahController::cetak');
        });

        // Grup untuk Kepala Sekolah
        $routes->group('kepala_sekolah', function ($routes) {
            $routes->get('/', 'KepalaSekolahController::index');
            $routes->get('data', 'KepalaSekolahController::data');
            $routes->get('(:num)', 'KepalaSekolahController::show/$1');
            $routes->post('store', 'KepalaSekolahController::store');
            $routes->post('update/(:num)', 'KepalaSekolahController::update/$1');
            $routes->delete('destroy/(:num)', 'KepalaSekolahController::destroy/$1');
        });
    });
});
