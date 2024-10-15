<?php
//Referencia de carpeta o (path)
namespace App\Http\Controllers;

//Agregamos la referencia del modelo
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\Producto;


//    NombreTablaController
class PrincipalController extends Controller {

    public function getListado() {
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios"

        $usuarios = Usuario::all();
        $ventas = Venta::all();
        $productos = Producto::all();

        return view("principal",[
            "usuarios" => $usuarios,
            "ventas" => $ventas,
            "productos" => $productos
    ]);
    }
}
