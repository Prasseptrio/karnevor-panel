<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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

//Common Routes
$routes->get('/', 'Welcome::index');
$routes->post('GetLogin', 'Welcome::index');
$routes->get('blocked', 'Welcome::forbiddenPage');
$routes->get('register', 'Welcome::forbiddenPage');
// $routes->post('register', 'Welcome::registration');
$routes->get('home', 'Common\Home::index');

$routes->get('cart', 'Common\Cart::showCart');
$routes->post('cart/insert', 'Common\Cart::insert');
$routes->post('cart/remove', 'Common\Cart::remove');
$routes->post('cart/destroy', 'Common\Cart::destroy');

// Setting Routes
$routes->get('users', 'Master\Users::index');
$routes->get('users/role-access', 'Master\Users::userRoleAccess');
$routes->post('users/create-role', 'Master\Users::createRole');
$routes->post('users/update-role', 'Master\Users::updateRole');
$routes->delete('users/delete-role', 'Master\Users::deleteRole');
$routes->post('users/create', 'Master\Users::createUser');
$routes->post('users/update', 'Master\Users::updateUser');
$routes->delete('users/delete', 'Master\Users::deleteUser');
$routes->post('users/change-menu-permission', 'Master\Users::changeMenuPermission');
$routes->post('users/change-menu-category-permission', 'Master\Users::changeMenuCategoryPermission');
$routes->post('users/change-submenu-permission', 'Master\Users::changeSubMenuPermission');

$routes->post('menu-management/create-menu-category', 'Developers\MenuManagement::createMenuCategory');
$routes->post('menu-management/create-menu', 'Developers\MenuManagement::createMenu');
$routes->post('menu-management/create-submenu', 'Developers\MenuManagement::createSubMenu');

//Developer Routes
$routes->get('menu-management', 'Developers\MenuManagement::index');
$routes->get('crud-generator', 'Developers\CRUDGenerator::index');

//Sales Routes
$routes->get('customers', 'Sales\Customers::index');
$routes->post('customers/create', 'Sales\Customers::createCustomer');
$routes->post('customers/update', 'Sales\Customers::updateCustomer');
$routes->get('customers/pet', 'Sales\Customers::customerPet');
$routes->post('customers/addPet', 'Sales\Customers::createCustomerPet');
$routes->delete('customers/delete/(:num)', 'Sales\Customers::deleteCustomer/$1');
$routes->get('posale', 'Sales\SalesOrder::sales');
$routes->get('posale/print', 'Sales\SalesOrder::printSalesOrder');
$routes->post('posale/create', 'Sales\SalesOrder::createSalesOrder');
$routes->get('salesorder-list', 'Sales\ServiceOrder::index');
$routes->get('poservice/print', 'Sales\ServiceOrder::printServiceOrder');
$routes->post('poservice/create', 'Sales\ServiceOrder::createServiceOrder');
$routes->get('reservation', 'Sales\ServiceOrder::reservation');
$routes->post('reservation', 'Sales\ServiceOrder::saveReservation');
$routes->get('reservation/followUp', 'Sales\ServiceOrder::followUpReservation');
$routes->get('reservation/Approved', 'Sales\ServiceOrder::approveReservation');
$routes->get('reservation/cancel', 'Sales\ServiceOrder::cancelReservation');
$routes->post('reservation/reschadule', 'Sales\ServiceOrder::reschaduleReservation');
$routes->get('reservation/getArrivalTime', 'Sales\ServiceOrder::getArrivalTime');

//Purchasing
$routes->get('purchase-order', 'Purchasing\PurchaseOrder::index');
$routes->get('purchase-order/form', 'Purchasing\PurchaseOrder::form');
$routes->post('purchase-order/create', 'Purchasing\PurchaseOrder::createPurchaseOrder');
$routes->post('purchase-order/pay', 'Purchasing\PurchaseOrder::paidPurchaseOrder');
$routes->get('suppliers', 'Purchasing\Suppliers::index');
$routes->get('suppliers/form', 'Purchasing\Suppliers::form');
$routes->post('suppliers/create', 'Purchasing\Suppliers::createSupplier');
$routes->post('suppliers/update', 'Purchasing\Suppliers::updateSupplier');
$routes->delete('suppliers/delete/(:num)', 'Purchasing\Suppliers::deleteSupplier/$1');

//Inventory
$routes->get('initial-stock', 'Inventory\Stock::initial_stock');
$routes->post('initial-stock/create', 'Inventory\Stock::createInitialStock');
$routes->post('initial-stock/delete', 'Inventory\Stock::deleteInitialStock');
$routes->get('stock-card', 'Inventory\Stock::stock_card');
$routes->post('stock-card/insert', 'Inventory\Stock::insertPOStockCard');

// Finance
$routes->get('petty-cash', 'Finance\Bank::index');
$routes->get('petty-cash/get', 'Finance\Bank::getPettyCash');
$routes->post('petty-cash/create', 'Finance\Bank::createPettyCash');
$routes->post('petty-cash/update', 'Finance\Bank::updatePettyCash');
$routes->post('petty-cash/transfer', 'Finance\Bank::transferPettyCash');
$routes->get('loan', 'Finance\Loan::index');
$routes->post('loan/create', 'Finance\Loan::createLoan');
$routes->post('loan/payment', 'Finance\Loan::paymentLoan');
$routes->get('capital', 'Finance\Capital::index');
$routes->post('capital/create', 'Finance\Capital::createCapital');
$routes->get('operational-cost', 'Finance\Budget::index');
$routes->post('operational-cost/create', 'Finance\Budget::createOperationalCost');


//Website
$routes->get('blog', 'Website\Blogs::index');
$routes->get('blog/form', 'Website\Blogs::form');
$routes->post('blog/create', 'Website\Blogs::createBlogPosts');
$routes->post('blog/create-category', 'Website\Blogs::createBlogCategory');
$routes->delete('blog/delete/(:num)', 'Website\Blogs::deleteBlogPosts/$1');

//Master
$routes->get('products', 'Master\Products::index');
$routes->post('products/createProduct', 'Master\Products::createProduct');
$routes->post('products/updateProduct', 'Master\Products::updateProduct');
$routes->delete('products/deleteProduct/(:num)', 'Master\Products::deleteProduct/$1');
$routes->post('products/createProductCategory', 'Master\Products::createProductCategory');
$routes->delete('products/deleteProductCategory/(:num)', 'Master\Products::deleteProductCategory/$1');
$routes->post('products/createBrand', 'Master\Products::createBrands');
$routes->delete('products/deleteBrand/(:num)', 'Master\Products::deleteBrands/$1');

$routes->get('services', 'Master\Services::index');
$routes->get('services/package', 'Master\Services::servicePackage');
$routes->post('services/create', 'Master\Services::createServices');
$routes->post('services/create-package', 'Master\Services::createServicePackage');
$routes->post('services/create-feature', 'Master\Services::createServiceFeature');

//Report
$routes->get('service-report', 'Report\Transactions::index');
$routes->get('profit', 'Report\Finance::profit');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
