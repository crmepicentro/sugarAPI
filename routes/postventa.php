<?php
use \App\Http\Controllers\Servicios3sController;
use \App\Http\Controllers\GestionPostVentaController;
use \App\Http\Controllers\ReportePostVentasControllerController;
use \App\Http\Controllers\PostVentaIndiceController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/consultaApiCabecera', [Servicios3sController::class, 'consultaApiCabecera']);
Route::get('/consultaApiCabecera_bulk', [Servicios3sController::class, 'consultaApiCabecera_bulk']);
Route::get('/consultaHistorial/{placa_vehiculo}', [Servicios3sController::class, 'consultaHistorial_pdf'])->name('postventa.consultaHistorial_pdf');
Route::get('/consultaDisponibilidad', [Servicios3sController::class, 'consultaDisponibilidad'])->name('postventa.consultaDisponibilidad');
Route::get('/sessionData/{session}/{valor}', [Servicios3sController::class, 'setSessionData'])->name('postventa.sessionData');
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_data',[GestionPostVentaController::class,'gestions3s'])->name('postventa.gestion');// actualizar cambio en VerifyCsrfToken
Route::post('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_final/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'gestion_do_final'])->name('postventa.gestion_do_final');// actualizar cambio en VerifyCsrfToken
Route::get('/vehiculos/faces/jsp/consulta/masters/list.jsp',[PostVentaIndiceController::class,'indice'])->name('postventa.indice');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}',PostVentaListaServiciosController::class)->name('postventa.edita');
Route::get('/vehiculos/faces/jsp/consulta/masters/detalle.jsp/{id}/{id_auto}',PostVentaEditaController::class)->name('postventa.edita_auto');
Route::get('/vehiculos/faces/jsp/consulta/masters/s3ssistemacore/{gestionAgendado}/{auto}',[GestionPostVentaController::class,'s3spostdatacore'])->name('postventa.s3spostdatacore');
Route::get('/vehiculos/faces/jsp/consulta/masters/respuesta_s3ssistemacore/{codigo_seguimiento}',[GestionPostVentaController::class,'s3spostdatacore_respuesta'])->name('postventa.s3spostdatacorerespuesta');
Route::get('s3s_sistema', function ( \App\Http\Requests\Request $request) {
    dd($request);
})->name('postventa.tests3s');;


Route::get('/reporte_postventas/index', [ReportePostVentasControllerController::class, 'index'])->name('postventa.reporte_postventas.index');

Route::get('/login/postventas/redirect', function () {
    return view('postventas.auth.redirect');
})->name('postventas.auth.error');
