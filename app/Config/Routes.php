<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route admin dashboard
$routes->get('dashboard', 'Admin\DashboardController::index');

// Route admin products
$routes->get('products', 'Admin\ProductsController::product');
$routes->post('product/add', 'Admin\ProductsController::addProduct');
$routes->get('product/detail/(:num)', 'Admin\ProductsController::detailProduct/$1');
$routes->put('product/edit/(:num)', 'Admin\ProductsController::editProduct/$1');
$routes->delete('product/delete/(:num)', 'Admin\ProductsController::deleteProduct/$1');

// Route admin product category
$routes->get('categories', 'Admin\ProductsController::category');
$routes->post('category/add', 'Admin\ProductsController::addCategory');
$routes->put('category/edit/(:num)', 'Admin\ProductsController::editCategory/$1');
$routes->delete('category/delete/(:num)', 'Admin\ProductsController::deleteCategory/$1');
