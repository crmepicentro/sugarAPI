<?php

use App\Http\Controllers\Postventas\GestionPostVentaController;
use App\Http\Controllers\Postventas\PostVentaIndiceController;
use App\Http\Controllers\Postventas\ReportePostVentasControllerController;
use App\Http\Controllers\Postventas\Servicios3sController;
use App\Http\Controllers\Postventas\PostVentaListaServiciosController;
use App\Http\Controllers\Postventas\PostVentaEditaController;
use App\Http\Controllers\Postventas\SeguimientoPostVentasController;

Route::get('/consultaApiCabecera', [Servicios3sController::class, 'consultaApiCabecera']);
Route::get('/consultaApiCabecera_bulk', [Servicios3sController::class, 'consultaApiCabecera_bulk']);
Route::get('/consultaHistorial/{placa_vehiculo}', [Servicios3sController::class, 'consultaHistorial_pdf'])->name('postventa.consultaHistorial_pdf');
Route::get('/consultaDisponibilidad', [Servicios3sController::class, 'consultaDisponibilidad'])->name('postventa.consultaDisponibilidad');
Route::get('/sessionData/{session}/{valor}', [Servicios3sController::class, 'setSessionData'])->name('postventa.sessionData');
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_data',[GestionPostVentaController::class,'gestions3s'])->name('postventa.gestion');// actualizar cambio en VerifyCsrfToken
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/add_oportunidades',[GestionPostVentaController::class,'add_oportunidades'])->name('postventa.add_oportunidades');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/buscar_oportunidades_add',[GestionPostVentaController::class,'buscar_oportunidades_add'])->name('postventa.buscar_oportunidades_add');
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_final/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'gestion_do_final'])->name('postventa.gestion_do_final');// actualizar cambio en VerifyCsrfToken
Route::get('/vehiculos/faces/jsp/consulta/masters/list.jsp',[PostVentaIndiceController::class,'indice'])->name('postventa.indice');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}',[PostVentaListaServiciosController::class,'index'])->name('postventa.edita');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}/{id_auto}',[PostVentaEditaController::class,'index'])->name('postventa.edita_auto');
Route::get('/vehiculos/faces/jsp/consulta/masters/s3ssistemacore/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'s3spostdatacore_registro'])->name('postventa.s3spostdatacore');
Route::get('/vehiculos/faces/jsp/consulta/masters/s3ssistemacore_registro/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'s3spostdatacore_pantalla'])->name('postventa.s3spostdatacore_pantalla');
Route::get('/vehiculos/faces/jsp/consulta/masters/recupera_respuesta_s3ssistemacore/{codAgencia}/{placaVehiculo}/{gestion}',[GestionPostVentaController::class,'s3spostdatacore_consulta'])->name('postventa.s3spostdatacore_consulta');
Route::get('/vehiculos/faces/jsp/consulta/masters/cencela_reserva_s3ssistemacore/{detalle_gestion_oportunidad_id}',[GestionPostVentaController::class,'s3scancela_gestion'])->name('postventa.s3scancela_gestion');
Route::get('/vehiculos/faces/jsp/consulta/masters/respuesta_s3ssistemacore/{codigo_seguimiento}',[GestionPostVentaController::class,'s3spostdatacore_respuesta'])->name('postventa.s3spostdatacorerespuesta');
Route::get('/verificaStockTodo_sistema',[Servicios3sController::class,'consultaStockBulk'])->name('postventa.verificastocktodaTienda');

Route::get('s3s_sistema', function ( \App\Http\Requests\Request $request) {
    dd($request);
})->name('postventa.tests3s');
Route::get('seguimiento_postventa/{ordTaller}/{gestion_agendado_id}', [SeguimientoPostVentasController::class,'verificarEstadoSeguimientoPostVentas'])->name('postventa.seguimiento.estado_orden');



Route::get('/reporte_postventas/index', [ReportePostVentasControllerController::class, 'index'])->name('postventa.reporte_postventas.index');

Route::get('/login/postventas/redirect', function () {
    return view('postventas.auth.redirect');
})->name('postventas.auth.error');
