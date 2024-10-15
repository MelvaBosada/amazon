<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get(
"/listado_usuario",
[
    UsuarioController::class,
    "getApiListado"
]);


Route::get(
"/get_usuario/{id}",
[
    UsuarioController::class,
    "getApiGetUsuarioByID"
]);


Route::delete(
"/delete_usuario/{id}",
[
    UsuarioController::class,
    "deleteApiEliminar"
]);

Route::post(
    "add_usuario",
[
    UsuarioController::class,
    "postApiAddUsuario"
]);

Route::put(
    "update_usuario/{id}",
[
    UsuarioController::class,
    "putApiUpdateUsuario"
]);






Route::get(
    "/listado_venta",
    [
        VentaController::class,
        "getApiListado"
    ]);
    
    
    Route::get(
    "/get_venta/{id}",
    [
        VentaController::class,
        "getApiGetVentaByID"
    ]);
    
    
    Route::delete(
    "/delete_venta/{id}",
    [
        VentaController::class,
        "deleteApiEliminar"
    ]);
    
    Route::post(
        "add_venta",
    [
        VentaController::class,
        "postApiAddVenta"
    ]);
    
    Route::put(
        "update_usuario/{id}",
    [
        VentaController::class,
        "putApiUpdateVenta"
    ]);

    




    Route::get(
"/listado_producto",
[
    ProductoController::class,
    "getApiListado"
]);


Route::get(
"/get_producto/{id}",
[
    ProductoController::class,
    "getApiGetProductoByID"
]);


Route::delete(
"/delete_producto/{id}",
[
    ProductoController::class,
    "deleteApiEliminar"
]);

Route::post(
    "add_producto",
[
    ProductoController::class,
    "postApiAddProducto"
]);

Route::put(
    "update_producto/{id}",
[
    ProductoController::class,
    "putApiUpdateProducto"
]);
