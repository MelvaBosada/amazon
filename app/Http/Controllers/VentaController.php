<?php
//Referencia de carpeta o (path)
namespace App\Http\Controllers;

//Agregamos la referencia del modelo
use App\Models\Venta;

//Agregamos la referencia de Request
use Illuminate\Http\Request;

//Agregamos la referencia del Storage
use Illuminate\Support\Facades\Storage;

//    NombreTablaController
class VentaController extends Controller {
    //Original
    public function getListado() {
        //Se usa el metodo all para obtener todos los ventas
        //"SELECT * FROM ventas"
        $ventas = Venta::all();
        return view("listado_venta",["ventas" => $ventas]);
    }

    //Agregamos un parametro
    public function getFormulario($id = null) {
        //Validar si estan enviando el id
        if($id == null) {
            //Generamos una instancia nueva
            $venta = new Venta();
        }
        else {
            //Ejecutamos el metodo find para buscar por el pk
            //"SELECT * FROM ventas WHERE id=3"
            $venta = Venta::find($id);
        }
        return view("formulario_venta",$venta);
    }

    public function getEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM ventas WHERE id=1
        $venta = Venta::find($id);

        //Se borra la imagen
        if(!empty($venta->imagen)){
            Storage::delete(public_path('imagenes_ventas').'/'.$venta->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM ventas WHERE id=1
        $venta->delete();

        //Redigimos a listado
        return redirect('listado_venta');
    }

    public function postGuardar(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //Validamos si el parametro de id es null
        if($data["id"] == null){
            //instanciamos un objeto venta
            $venta = new Venta();
        }
        else {
            //se busca el registro con el id
            $venta = Venta::find($data['id']);

            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($request->hasFile('imagen') && $venta->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_ventas').'/'.$venta->imagen);
            }
        }

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_ventas'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $venta->nombre = $data['nombre'];
        $venta->descripcion = $data['descripcion'];
        $venta->precio = $data['precio'];
        $venta->fecha = $data['fecha'];

        if($request->hasFile('imagen')) {
            $venta->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $venta->save();
        //Se hace la redirecion
        return redirect('listado_venta');
    }

    //URL APIS

    //Nuevo
    public function getApiListado() {
        //Se usa el metodo all para obtener todos los ventas
        //"SELECT * FROM ventas"
        $ventas = Venta::all();
        return ["ventas" => $ventas];
    }

    //Agregamos un parametro
    public function getApiGetVentaByID($id = null) {
        //Ejecutamos el metodo find para buscar por el pk
        //"SELECT * FROM ventas WHERE id=3"
        $venta = Venta::find($id);
        return $venta;
    }

    public function deleteApiEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM ventas WHERE id=1
        $venta = Venta::find($id);

        //Se borra la imagen
        if(!empty($venta->imagen)){
            Storage::delete(public_path('imagenes_ventas').'/'.$venta->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM ventas WHERE id=1
        $venta->delete();
    }

    public function postApiAddVenta(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //instanciamos un objeto venta
        $venta = new Venta();

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_ventas'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $venta->nombre = $data['nombre'];
        $venta->descripcion = $data['descripcion'];
        $venta->precio = $data['precio'];
        $venta->fecha = $data['fecha'];

        if($request->hasFile('imagen')) {
            $venta->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $venta->save();
    }

    public function putApiUpdateVenta($id, Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //se busca el registro con el id
        $venta = Venta::find($id);

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($venta->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_ventas').'/'.$venta->imagen);
            }
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_ventas'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $venta->nombre = $data['nombre'];
        $venta->descripcion = $data['descripcion'];
        $venta->precio = $data['precio'];
        $venta->fecha = $data['fecha'];

        if($request->hasFile('imagen')) {
            $venta->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $venta->save();
    }

    public function getApiFiltro(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los ventas
        //"SELECT * FROM ventas WHERE nombre like '%a%'"
        $ventas = Venta::Where('nombre','LIKE',"%".$filtro."%")->get();
        return ["ventas" => $ventas];
    }
}