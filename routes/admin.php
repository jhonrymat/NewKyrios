<?php

use App\Models\Reporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductMasukController;
use App\Http\Controllers\ProductKeluarController;


// Users
Route::get('users', [UserController::class, 'index'])->middleware('can:users.index')->name('users.index');
Route::post('users', [UserController::class, 'store'])->middleware('can:users.store')->name('users.store');
Route::put('users/{id}', [UserController::class, 'update'])->middleware('can:users.update')->name('users.update');
Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('can:users.delete')->name('users.destroy');


//roles
Route::get('roles', [RolesController::class, 'index'])->middleware('can:roles.index')->name('roles.index');
Route::post('roles', [RolesController::class, 'store'])->middleware('can:roles.store')->name('roles.store');
Route::put('roles/{id}', [RolesController::class, 'update'])->middleware('can:roles.update')->name('roles.update');
Route::delete('roles/{id}', [RolesController::class, 'destroy'])->middleware('can:roles.delete')->name('roles.destroy');

//permisos
Route::get('permisos', [PermisoController::class, 'index'])->middleware('can:permisos.index')->name('permisos.index');
Route::post('permisos', [PermisoController::class, 'store'])->middleware('can:permisos.store')->name('permisos.store');
Route::put('permisos/{id}', [PermisoController::class, 'update'])->middleware('can:permisos.update')->name('permisos.update');
Route::delete('permisos/{id}', [PermisoController::class, 'destroy'])->middleware('can:permisos.delete')->name('permisos.delete');



// Error Logs
Route::post('log-client-error', [ErrorLogController::class, 'store'])->middleware('can:log-client-error')->name('log-client-error');

// CSRF Token Refresh
Route::get('refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('can:refresh-csrf')->name('refresh-csrf');

// Órdenes
Route::get('/orden/{codigo}/pendientes', [OrdenController::class, 'generarPDFpendientes'])->middleware('can:ordenes.view')->name('ordenes.pdf.pendientes');
Route::get('/orden/{codigo}/finalizados', [OrdenController::class, 'generarPDFfinalizados'])->middleware('can:ordenes.view')->name('ordenes.pdf.finalizados');
Route::get('/orden/pendiente', [OrdenController::class, 'pendientes'])->middleware('can:ordenes.view')->name('ordenes.pendientes');
Route::get('/orden/finalizadas', [OrdenController::class, 'finalizadas'])->middleware('can:ordenes.view')->name('ordenes.finalizadas');
Route::post('/orden/store', [OrdenController::class, 'store'])->middleware('can:ordenes.create')->name('ordenes.store');
Route::put('orden/{codigo}', [OrdenController::class, 'update'])->middleware('can:ordenes.update')->name('ordenes.update');
Route::delete('orden/{codigo}', [OrdenController::class, 'destroy'])->middleware('can:ordenes.delete')->name('ordenes.destroy');
Route::get('/orden/{id}/edit', [OrdenController::class, 'edit'])->middleware('can:ordenes.edit')->name('ordenes.edit');
Route::put('orden/edit/finalizadas/{codigo}', [OrdenController::class, 'updatefinalizadas'])->middleware('can:ordenes.update')->name('ordenes.update.finalizadas');
Route::put('orden/finalizar/{codigo}', [OrdenController::class, 'finalizar'])->middleware('can:ordenes.finalizar')->name('ordenes.finalizar');
Route::put('/orden/update-reparado/{id}', [OrdenController::class, 'updateReparado'])->middleware('can:ordenes.update')->name('ordenes.update.reparado');
Route::post('/orden/delete-image/{codigo}', [OrdenController::class, 'deleteImage'])->middleware('can:ordenes.deleteImage')->name('ordenes.deleteImage');
Route::get('/orden/{id}/send-whatsapp-message', [OrdenController::class, 'enviarMensajeWhatsApp'])->middleware('can:ordenes.sendWhatsAppMessage')->name('ordenes.sendWhatsAppMessage');



// Bodega
Route::get('/orden/bodega', [OrdenController::class, 'bodega'])->middleware('can:ordenes.view')->name('ordenes.bodega');
Route::put('orden/edit/bodega/{codigo}', [OrdenController::class, 'updateBodega'])->middleware('can:ordenes.update')->name('ordenes.update.bodega');

// AJAX para obtener datos
Route::get('/buscar-datos', [OrdenController::class, 'buscarDatos'])->middleware('can:ordenes.view')->name('buscar.datos');
Route::get('/orden/{codigo}/ajax', [OrdenController::class, 'Orden'])->middleware('can:ordenes.view')->name('ordenes.ajax');

// Categorías
Route::resource('categories', CategoryController::class)->middleware('can:categories.manage');
Route::get('/apiCategories', [CategoryController::class, 'apiCategories'])->middleware('can:categories.view')->name('api.categories');
Route::get('/exportCategoriesAll', [CategoryController::class, 'exportCategoriesAll'])->middleware('can:categories.export')->name('exportPDF.categoriesAll');
Route::get('/exportCategoriesAllExcel', [CategoryController::class, 'exportExcel'])->middleware('can:categories.export')->name('exportExcel.categoriesAll');

// Clientes
Route::resource('customers', CustomerController::class)->middleware('can:customers.manage');
Route::get('/apiCustomers', [CustomerController::class, 'apiCustomers'])->middleware('can:customers.view')->name('api.customers');
Route::post('/importCustomers', [CustomerController::class, 'ImportExcel'])->middleware('can:customers.import')->name('import.customers');
Route::get('/exportCustomersAll', [CustomerController::class, 'exportCustomersAll'])->middleware('can:customers.export')->name('exportPDF.customersAll');
Route::get('/exportCustomersAllExcel', [CustomerController::class, 'exportExcel'])->middleware('can:customers.export')->name('exportExcel.customersAll');

// Ventas
Route::resource('sales', SaleController::class)->middleware('can:sales.manage');
Route::get('/apiSales', [SaleController::class, 'apiSales'])->middleware('can:sales.view')->name('api.sales');
Route::post('/importSales', [SaleController::class, 'ImportExcel'])->middleware('can:sales.import')->name('import.sales');
Route::get('/exportSalesAll', [SaleController::class, 'exportSalesAll'])->middleware('can:sales.export')->name('exportPDF.salesAll');
Route::get('/exportSalesAllExcel', [SaleController::class, 'exportExcel'])->middleware('can:sales.export')->name('exportExcel.salesAll');

// Proveedores
Route::resource('suppliers', SupplierController::class)->middleware('can:suppliers.manage');
Route::get('/apiSuppliers', [SupplierController::class, 'apiSuppliers'])->middleware('can:suppliers.view')->name('api.suppliers');
Route::post('/importSuppliers', [SupplierController::class, 'ImportExcel'])->middleware('can:suppliers.import')->name('import.suppliers');
Route::get('/exportSupplierssAll', [SupplierController::class, 'exportSuppliersAll'])->middleware('can:suppliers.export')->name('exportPDF.suppliersAll');
Route::get('/exportSuppliersAllExcel', [SupplierController::class, 'exportExcel'])->middleware('can:suppliers.export')->name('exportExcel.suppliersAll');

// Productos
Route::resource('products', ProductController::class)->middleware('can:products.manage');
Route::get('/apiProducts', [ProductController::class, 'apiProducts'])->middleware('can:products.view')->name('api.products');

// Productos Entrantes (Products In)
Route::resource('productsIn', ProductMasukController::class)->middleware('can:productsIn.manage');
Route::get('/apiProductsIn', [ProductMasukController::class, 'apiProductsIn'])->middleware('can:productsIn.view')->name('api.productsIn');
Route::get('/exportProductMasukAll', [ProductMasukController::class, 'exportProductMasukAll'])->middleware('can:productsIn.export')->name('exportPDF.productMasukAll');
Route::get('/exportProductMasukAllExcel', [ProductMasukController::class, 'exportExcel'])->middleware('can:productsIn.export')->name('exportExcel.productMasukAll');
Route::get('/exportProductMasuk/{id}', [ProductMasukController::class, 'exportProductMasuk'])->middleware('can:productsIn.export')->name('exportPDF.productMasuk');

// Productos Salientes (Products Out)
Route::resource('productsOut', ProductKeluarController::class)->middleware('can:productsOut.manage');
Route::get('/apiProductsOut', [ProductKeluarController::class, 'apiProductsOut'])->middleware('can:productsOut.view')->name('api.productsOut');
Route::get('/exportProductKeluarAll', [ProductKeluarController::class, 'exportProductKeluarAll'])->middleware('can:productsOut.export')->name('exportPDF.productKeluarAll');
Route::get('/exportProductKeluarAllExcel', [ProductKeluarController::class, 'exportExcel'])->middleware('can:productsOut.export')->name('exportExcel.productKeluarAll');
Route::get('/exportProductKeluar/{id}', [ProductKeluarController::class, 'exportProductKeluar'])->middleware('can:productsOut.export')->name('exportPDF.productKeluar');

// Perfil de usuario
Route::get('/perfil', [ProfileController::class, 'edit'])->middleware('can:perfil.edit')->name('perfil.edit');
Route::put('/perfil', [ProfileController::class, 'update'])->middleware('can:perfil.update')->name('perfil.update');

