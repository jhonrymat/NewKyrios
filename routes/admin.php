<?php

use App\Models\Reporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
// use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClocalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NumerosController;
use App\Http\Controllers\PermisoController;

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\AplicacionesController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ProgramadosControllers;

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
        if (!empty ($results)) {
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

// ordenes
Route::get('/orden/{codigo}/pendientes', [OrdenController::class, 'generarPDFpendientes'])->name('ordenes.pdf.pendientes');
Route::get('/orden/{codigo}/finalizados', [OrdenController::class, 'generarPDFfinalizados'])->name('ordenes.pdf.finalizados');
Route::get('/orden/pendiente', [OrdenController::class, 'pendientes'])->name('ordenes.pendientes');
Route::get('/orden/finalizadas', [OrdenController::class, 'finalizadas'])->name('ordenes.finalizadas');
Route::post('/orden/store', [OrdenController::class, 'store'])->name('ordenes.store');
Route::put('orden/{codigo}', [OrdenController::class, 'update'])->middleware('can:ordenes.update')->name('ordenes.update');
Route::delete('orden/{codigo}', [OrdenController::class, 'destroy'])->middleware('can:ordenes.destroy')->name('ordenes.destroy');
Route::get('/orden/{id}/edit', [OrdenController::class, 'edit'])->name('ordenes.edit');

Route::put('orden/edit/finalizadas/{codigo}', [OrdenController::class, 'updatefinalizadas'])->name('ordenes.update.finalizadas');
// Finalizar orden pendiente
Route::put('orden/finalizar/{codigo}', [OrdenController::class, 'finalizar'])->name('ordenes.finalizar');

// Actualizar columna reparado
Route::put('/orden/update-reparado/{id}', [OrdenController::class, 'updateReparado'])->name('ordenes.update.reparado');

//bodega
Route::get('/orden/bodega', [OrdenController::class, 'bodega'])->name('ordenes.bodega');
//Actualizar datos de la bodega
Route::put('orden/edit/bodega/{codigo}', [OrdenController::class, 'updateBodega'])->name('ordenes.update.bodega');
// Ruta para obtener datos vía AJAX

Route::get('/buscar-datos', [OrdenController::class, 'buscarDatos'])->name('buscar.datos');

// ajax para obtener datos para finalizar orden
Route::get('/orden/{codigo}/ajax', [OrdenController::class, 'Orden'])->name('ordenes.ajax');
