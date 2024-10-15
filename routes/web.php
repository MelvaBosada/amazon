<?php

use Illuminate\Support\Facades\Route;

//Agregamos la referencia de controllers
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PrincipalController;
Route::get(
"/",
[
    PrincipalController::class,
    "getListado"
]);
//usuario//
Route::get(
"/listado_usuario",
[
    UsuarioController::class,
    "getListado"
]);

Route::get(
    "formulario_usuario",
[
    UsuarioController::class,
    "getFormulario"
]);

Route::get(
    "formulario_usuario/{id}",
[
    UsuarioController::class,
    "getFormulario"
]);

Route::get(
    "eliminar_usuario/{id}",
[
    UsuarioController::class,
    "getEliminar"
]);

Route::post(
    "guardar_usuario",
[
    UsuarioController::class,
    "postGuardar"
]);



//ventas
Route::get(
    "/listado_venta",
    [
        VentaController::class,
        "getListado"
    ]);
    
    Route::get(
        "formulario_venta",
    [
        VentaController::class,
        "getFormulario"
    ]);
    
    Route::get(
        "formulario_venta/{id}",
    [
        VentaController::class,
        "getFormulario"
    ]);
    
    Route::get(
        "eliminar_venta/{id}",
    [
        VentaController::class,
        "getEliminar"
    ]);
    
    Route::post(
        "guardar_venta",
    [
        VentaController::class,
        "postGuardar"
    ]);


    //producto//

    Route::get(
        "/listado_producto",
        [
            ProductoController::class,
            "getListado"
        ]);
        
        Route::get(
            "formulario_producto",
        [
            ProductoController::class,
            "getFormulario"
        ]);
        
        Route::get(
            "formulario_producto/{id}",
        [
            ProductoController::class,
            "getFormulario"
        ]);
        
        Route::get(
            "eliminar_producto/{id}",
        [
            ProductoController::class,
            "getEliminar"
        ]);
        
        Route::post(
            "guardar_producto",
        [
            ProductoController::class,
            "postGuardar"
        ]);

