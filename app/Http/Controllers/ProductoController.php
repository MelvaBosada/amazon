<?php
//Referencia de carpeta o (path)
namespace App\Http\Controllers;

//Agregamos la referencia del modelo
use App\Models\Producto;

//Agregamos la referencia de Request
use Illuminate\Http\Request;

//Agregamos la referencia del Storage
use Illuminate\Support\Facades\Storage;

//    NombreTablaController
class ProductoController extends Controller {
    //Original
    public function getListado() {
        //Se usa el metodo all para obtener todos los productos
        //"SELECT * FROM productos"
        $productos = Producto::all();
        return view("listado_producto",["productos" => $productos]);
    }

    //Agregamos un parametro
    public function getFormulario($id = null) {
        //Validar si estan enviando el id
        if($id == null) {
            //Generamos una instancia nueva
            $producto = new Producto();
        }
        else {
            //Ejecutamos el metodo find para buscar por el pk
            //"SELECT * FROM productos WHERE id=3"
            $producto = Producto::find($id);
        }
        return view("formulario_producto",$producto);
    }

    public function getEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM productos WHERE id=1
        $producto = Producto::find($id);

        //Se borra la imagen
        if(!empty($producto->imagen)){
            Storage::delete(public_path('imagenes_productos').'/'.$producto->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM productos WHERE id=1
        $producto->delete();

        //Redigimos a listado
        return redirect('listado_producto');
    }

    public function postGuardar(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //Validamos si el parametro de id es null
        if($data["id"] == null){
            //instanciamos un objeto producto
            $producto = new Producto();
        }
        else {
            //se busca el registro con el id
            $producto = Producto::find($data['id']);

            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($request->hasFile('imagen') && $producto->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_productos').'/'.$producto->imagen);
            }
        }

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_productos'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $producto->nombre = $data['nombre'];
        $producto->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $producto->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $producto->save();
        //Se hace la redirecion
        return redirect('listado_producto');
    }

    //URL APIS

    //Nuevo
    public function getApiListado() {
        //Se usa el metodo all para obtener todos los productos
        //"SELECT * FROM productos"
        $productos = Producto::all();
        return ["productos" => $productos];
    }

    //Agregamos un parametro
    public function getApiGetProductoByID($id = null) {
        //Ejecutamos el metodo find para buscar por el pk
        //"SELECT * FROM productos WHERE id=3"
        $producto = Producto::find($id);
        return $producto;
    }

    public function deleteApiEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM productos WHERE id=1
        $producto = Producto::find($id);

        //Se borra la imagen
        if(!empty($producto->imagen)){
            Storage::delete(public_path('imagenes_productos').'/'.$producto->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM productos WHERE id=1
        $producto->delete();
    }

    public function postApiAddProducto(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //instanciamos un objeto producto
        $producto = new Producto();

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_productos'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $producto->nombre = $data['nombre'];
        $producto->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $producto->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $producto->save();
    }

    public function putApiUpdateProducto($id, Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //se busca el registro con el id
        $producto = Producto::find($id);

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($producto->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_productos').'/'.$producto->imagen);
            }
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_productos'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $producto->nombre = $data['nombre'];
        $producto->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $producto->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $producto->save();
    }

    public function getApiFiltro(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los productos
        //"SELECT * FROM productos WHERE nombre like '%a%'"
        $productos = Producto::Where('nombre','LIKE',"%".$filtro."%")->get();
        return ["productos" => $productos];
    }
}