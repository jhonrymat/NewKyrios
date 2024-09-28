<?php

use App\Models\Reporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
// use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClocalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NumerosController;

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\AplicacionesController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ProductMasukController;
use App\Http\Controllers\ProgramadosControllers;
use App\Http\Controllers\ProductKeluarController;

Route::resource(
    'aplicaciones',
    AplicacionesController::class,
)->names('aplicaciones');

//obteniendo numeros telefonicos
Route::get('numbers', [AplicacionesController::class, 'numbers'])->middleware('can:numbers')->name('numbers');

//numeros
Route::resource(
    'numeros',
    NumerosController::class,
)->names('numeros');

//Contactos
Route::get('contactos', [ContactoController::class, 'index'])->middleware('can:contactos.index')->name('contactos.index');
; //mostrar todos los registros
Route::get('contactos/getData', [ContactoController::class, 'getData'])->name('contactos.getData');
Route::post('contactos', [ContactoController::class, 'store'])->name('contactos.store'); //crear un registro
Route::get('contactos/edit/{id}', [ContactoController::class, 'edit']); //obtener datos para editar un registro
Route::post('contactos/update', [ContactoController::class, 'update'])->name('contactos.update'); //actualizare un registro
Route::get('contactos/delete/{id}', [ContactoController::class, 'destroy'])->name('contactos.delete'); //actualizare un registro

// Tags
Route::get('tags', [TagController::class, 'index'])->middleware('can:tags.index')->name('tags.index'); //mostrar todos los registros
Route::post('tags', [TagController::class, 'store'])->name('tags.store'); //crear un registro
Route::put('tags/{id}', [TagController::class, 'update']); //actualizare un registro
Route::delete('tags/{id}', [TagController::class, 'destroy']); //actualizare un registro
Route::get('tags/{id}/contactos', [TagController::class, 'showContacts'])->name('tags.showContacts');

// Users
Route::get('users', [UserController::class, 'index'])->middleware('can:users.index')->name('users.index'); //mostrar todos los registros
Route::post('users', [UserController::class, 'store'])->name('users.store'); //crear un registro
Route::put('users/{id}', [UserController::class, 'update']); //actualizare un registro
Route::delete('users/{id}', [UserController::class, 'destroy']); //actualizare un registro


//roles
Route::get('roles', [RolesController::class, 'index'])->middleware('can:roles.index')->name('roles.index'); //mostrar todos los registros
Route::post('roles', [RolesController::class, 'store'])->name('roles.store'); //crear un registro
Route::put('roles/{id}', [RolesController::class, 'update']); //actualizare un registro
Route::delete('roles/{id}', [RolesController::class, 'destroy']); //actualizare un registro

//permisos
Route::get('permisos', [PermisoController::class, 'index'])->middleware('can:permisos.index')->name('permisos.index'); //mostrar todos los registros
Route::post('permisos', [PermisoController::class, 'store'])->middleware('can:permisos.store')->name('permisos.store'); //crear un registro
Route::put('permisos/{id}', [PermisoController::class, 'update'])->middleware('can:permisos.update')->name('permisos.update'); //actualizare un registro
Route::delete('permisos/{id}', [PermisoController::class, 'destroy'])->middleware('can:permisos.delete')->name('permisos.delete'); //actualizare un registro


// importar contactos
Route::post('upload-contactos', [ContactoController::class, 'uploadUsers'])->middleware('can:importar-contactos')->name('importar-contactos');
// exporta contactos
Route::get('exportar-contactos', [ContactoController::class, 'exportar'])->name('exportar-contactos');


// enviar mensaje plantilla
Route::get('plantillas', [MessageController::class, 'NumbersApps'])->middleware('can:plantillas')->name('plantillas');

Route::get('send-message', [MessageController::class, 'sendMessages']);
Route::get('message-templates', [MessageController::class, 'loadMessageTemplates'])->name('message.templates');
Route::post('send-message-templates', [MessageController::class, 'sendMessageTemplate'])->name('send.message.templates');
Route::post('upload-pdf', [MessageController::class, 'upload'])->middleware('can:upload.pdf')->name('upload.pdf');

//estadisticas
Route::get('estadisticas', [EstadisticasController::class, 'index'])->middleware('can:estadisticas')->name('estadisticas'); //mostrar todos los registros
Route::post('/estadisticas/get-statistics', [EstadisticasController::class, 'getStatistics'])->name('get-statistics');
Route::get('envios-plantillas', [EnvioController::class, 'index'])->middleware('can:envios-plantillas')->name('envios-plantillas'); //mostrar todos los registros
// exporta mensajes
Route::get('exportar-mensajes/{id}', [EstadisticasController::class, 'exportar'])->name('exportar-mensajes');

//programados
Route::get('programados', [ProgramadosControllers::class, 'index'])->middleware('can:programados')->name('programados'); //mostrar todos los registros
Route::get('/descargar-archivo/{id}', [ProgramadosControllers::class, 'descargar'])->name('descargar-archivo');
Route::put('/actualizar-estado/{id}', [ProgramadosControllers::class, 'actualizarEstado'])->name('actualizar-estado');

//contratacion local
Route::get('solicitudes', [ClocalController::class, 'index'])->middleware('can:solicitudes')->name('solicitudes'); //mostrar todos los registroscl
Route::get('solicitudes/send/{id}', [ClocalController::class, 'send'])->name('enviar.solicitud'); //mostrar todos los registroscl
//Cambiar los estados de la tabla de contratacion local
Route::post('update-status', [ClocalController::class, 'updateStatus'])->name('update.status');


//descargar informe
Route::get('download/{id}', function ($id) {
    $reporte = Reporte::findOrFail($id);
    $filePath = storage_path('app/' . $reporte->archivo);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        return response()->json(['error' => 'Archivo no encontrado.'], 404);
    }
})->name('download');

Route::get('data', function () {
    try {
        $results = DB::select('CALL GetMessagesReport(?, ?)', ['2024-03-29', '2024-04-15']);
        if (!empty($results)) {
            // foreach ($results as $result) {
            //     echo "Nombre: " . $result->contacto_nombre . ", Teléfono: " . $result->contacto_telefono . ", Estado: " . $result->estado . ", enviado: " . $result->distintivo_nombre . ", fecha: " . $result->created_at . "\n";
            // }
            dd($results);
        } else {
            echo "No se encontraron resultados.";
        }
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
});


Route::resource(
    'messages',
    MessageController::class
);

Route::resource('custom_fields', CustomFieldController::class);

Route::get('messages-index', [MessageController::class, 'chat'])->name('admin.chat'); //mostrar todos los registroscl

//envios de errores
Route::post('log-client-error', [ErrorLogController::class, 'store'])->middleware('can:log-client-error')->name('log-client-error');

//verificar si no esta inactiva la sesion del usuario


//actualizando el tocken si este vencio
Route::get('refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('can:refresh-csrf')->name('refresh-csrf');

Route::get('descargar-plantilla', [ContactoController::class, 'descargarPlantilla'])->name('descargar-plantilla');

// Ordenes
Route::get('/orden/{codigo}/pendientes', [OrdenController::class, 'generarPDFpendientes'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.pdf.pendientes');

Route::get('/orden/{codigo}/finalizados', [OrdenController::class, 'generarPDFfinalizados'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.pdf.finalizados');

Route::get('/orden/pendiente', [OrdenController::class, 'pendientes'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.pendientes');

Route::get('/orden/finalizadas', [OrdenController::class, 'finalizadas'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.finalizadas');

Route::post('/orden/store', [OrdenController::class, 'store'])
    ->middleware('can:ordenes.create')
    ->name('ordenes.store');

Route::put('orden/{codigo}', [OrdenController::class, 'update'])
    ->middleware('can:ordenes.update')
    ->name('ordenes.update');

Route::delete('orden/{codigo}', [OrdenController::class, 'destroy'])
    ->middleware('can:ordenes.destroy')
    ->name('ordenes.destroy');

Route::get('/orden/{id}/edit', [OrdenController::class, 'edit'])
    ->middleware('can:ordenes.edit')
    ->name('ordenes.edit');

Route::put('orden/edit/finalizadas/{codigo}', [OrdenController::class, 'updatefinalizadas'])
    ->middleware('can:ordenes.update')
    ->name('ordenes.update.finalizadas');

Route::put('orden/finalizar/{codigo}', [OrdenController::class, 'finalizar'])
    ->middleware('can:ordenes.finalizar')
    ->name('ordenes.finalizar');

Route::put('/orden/update-reparado/{id}', [OrdenController::class, 'updateReparado'])
    ->middleware('can:ordenes.update')
    ->name('ordenes.update.reparado');

// Bodega
Route::get('/orden/bodega', [OrdenController::class, 'bodega'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.bodega');

Route::put('orden/edit/bodega/{codigo}', [OrdenController::class, 'updateBodega'])
    ->middleware('can:ordenes.update')
    ->name('ordenes.update.bodega');

// AJAX para obtener datos
Route::get('/buscar-datos', [OrdenController::class, 'buscarDatos'])
    ->middleware('can:ordenes.view')
    ->name('buscar.datos');

Route::get('/orden/{codigo}/ajax', [OrdenController::class, 'Orden'])
    ->middleware('can:ordenes.view')
    ->name('ordenes.ajax');

// Inventory
// Categorías
Route::resource('categories', CategoryController::class)->middleware('can:categories.manage');
Route::get('/apiCategories', [CategoryController::class, 'apiCategories'])
    ->middleware('can:categories.view')
    ->name('api.categories');

Route::get('/exportCategoriesAll', [CategoryController::class, 'exportCategoriesAll'])
    ->middleware('can:categories.export')
    ->name('exportPDF.categoriesAll');

Route::get('/exportCategoriesAllExcel', [CategoryController::class, 'exportExcel'])
    ->middleware('can:categories.export')
    ->name('exportExcel.categoriesAll');

// Clientes
Route::resource('customers', CustomerController::class)->middleware('can:customers.manage');
Route::get('/apiCustomers', [CustomerController::class, 'apiCustomers'])
    ->middleware('can:customers.view')
    ->name('api.customers');

Route::post('/importCustomers', [CustomerController::class, 'ImportExcel'])
    ->middleware('can:customers.import')
    ->name('import.customers');

Route::get('/exportCustomersAll', [CustomerController::class, 'exportCustomersAll'])
    ->middleware('can:customers.export')
    ->name('exportPDF.customersAll');

Route::get('/exportCustomersAllExcel', [CustomerController::class, 'exportExcel'])
    ->middleware('can:customers.export')
    ->name('exportExcel.customersAll');

// Ventas
Route::resource('sales', SaleController::class)->middleware('can:sales.manage');
Route::get('/apiSales', [SaleController::class, 'apiSales'])
    ->middleware('can:sales.view')
    ->name('api.sales');

Route::post('/importSales', [SaleController::class, 'ImportExcel'])
    ->middleware('can:sales.import')
    ->name('import.sales');

Route::get('/exportSalesAll', [SaleController::class, 'exportSalesAll'])
    ->middleware('can:sales.export')
    ->name('exportPDF.salesAll');

Route::get('/exportSalesAllExcel', [SaleController::class, 'exportExcel'])
    ->middleware('can:sales.export')
    ->name('exportExcel.salesAll');

// Proveedores
Route::resource('suppliers', SupplierController::class)->middleware('can:suppliers.manage');
Route::get('/apiSuppliers', [SupplierController::class, 'apiSuppliers'])
    ->middleware('can:suppliers.view')
    ->name('api.suppliers');

Route::post('/importSuppliers', [SupplierController::class, 'ImportExcel'])
    ->middleware('can:suppliers.import')
    ->name('import.suppliers');

Route::get('/exportSupplierssAll', [SupplierController::class, 'exportSuppliersAll'])
    ->middleware('can:suppliers.export')
    ->name('exportPDF.suppliersAll');

Route::get('/exportSuppliersAllExcel', [SupplierController::class, 'exportExcel'])
    ->middleware('can:suppliers.export')
    ->name('exportExcel.suppliersAll');

// Productos
Route::resource('products', ProductController::class)->middleware('can:products.manage');
Route::get('/apiProducts', [ProductController::class, 'apiProducts'])
    ->middleware('can:products.view')
    ->name('api.products');

// Productos salientes
Route::resource('productsOut', ProductKeluarController::class)->middleware('can:productsOut.manage');
Route::get('/apiProductsOut', [ProductKeluarController::class, 'apiProductsOut'])
    ->middleware('can:productsOut.view')
    ->name('api.productsOut');

Route::get('/exportProductKeluarAll', [ProductKeluarController::class, 'exportProductKeluarAll'])
    ->middleware('can:productsOut.export')
    ->name('exportPDF.productKeluarAll');

Route::get('/exportProductKeluarAllExcel', [ProductKeluarController::class, 'exportExcel'])
    ->middleware('can:productsOut.export')
    ->name('exportExcel.productKeluarAll');

Route::get('/exportProductKeluar/{id}', [ProductKeluarController::class, 'exportProductKeluar'])
    ->middleware('can:productsOut.export')
    ->name('exportPDF.productKeluar');

// Productos entrantes
Route::resource('productsIn', ProductMasukController::class)->middleware('can:productsIn.manage');
Route::get('/apiProductsIn', [ProductMasukController::class, 'apiProductsIn'])
    ->middleware('can:productsIn.view')
    ->name('api.productsIn');

Route::get('/exportProductMasukAll', [ProductMasukController::class, 'exportProductMasukAll'])
    ->middleware('can:productsIn.export')
    ->name('exportPDF.productMasukAll');

Route::get('/exportProductMasukAllExcel', [ProductMasukController::class, 'exportExcel'])
    ->middleware('can:productsIn.export')
    ->name('exportExcel.productMasukAll');

Route::get('/exportProductMasuk/{id}', [ProductMasukController::class, 'exportProductMasuk'])
    ->middleware('can:productsIn.export')
    ->name('exportPDF.productMasuk');
