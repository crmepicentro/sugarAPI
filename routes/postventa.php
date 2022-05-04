<?php
use \App\Http\Controllers\Servicios3sController;
use \App\Http\Controllers\GestionPostVentaController;

Route::get('/consultaApiCabecera', [Servicios3sController::class, 'consultaApiCabecera']);
Route::get('/consultaApiCabecera_bulk', [Servicios3sController::class, 'consultaApiCabecera_bulk']);
Route::get('/consultaHistorial/{placa_vehiculo}', [Servicios3sController::class, 'consultaHistorial_pdf'])->name('postventa.consultaHistorial_pdf');
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_data',[GestionPostVentaController::class,'gestions3s'])->name('postventa.gestion');
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_final/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'gestion_do_final'])->name('postventa.gestion_do_final');
Route::get('/vehiculos/faces/jsp/consulta/masters/list.jsp',PostVentaIndiceController::class)->name('postventa.indice');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}',PostVentaListaServiciosController::class)->name('postventa.edita');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}/{id_auto}',PostVentaEditaController::class)->name('postventa.edita_auto');
Route::get('/vehiculos/faces/jsp/consulta/masters/s3ssistemacore/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'s3spostdatacore'])->name('postventa.s3spostdatacore');
Route::get('s3s_sistema', function ( \App\Http\Requests\Request $request) {
    dd($request);
})->name('postventa.tests3s');;

