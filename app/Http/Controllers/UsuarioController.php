<?php
//Referencia de carpeta o (path)
namespace App\Http\Controllers;

//Agregamos la referencia del modelo
use App\Models\Usuario;

//Agregamos la referencia de Request
use Illuminate\Http\Request;

//Agregamos la referencia del Storage
use Illuminate\Support\Facades\Storage;

//    NombreTablaController
class UsuarioController extends Controller {
    //Original
    public function getListado() {
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios"
        $usuarios = Usuario::all();
        return view("listado_usuario",["usuarios" => $usuarios]);
    }

    //Agregamos un parametro
    public function getFormulario($id = null) {
        //Validar si estan enviando el id
        if($id == null) {
            //Generamos una instancia nueva
            $usuario = new Usuario();
        }
        else {
            //Ejecutamos el metodo find para buscar por el pk
            //"SELECT * FROM usuarios WHERE id=3"
            $usuario = Usuario::find($id);
        }
        return view("formulario_usuario",$usuario);
    }

    public function getEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM usuarios WHERE id=1
        $usuario = Usuario::find($id);

        //Se borra la imagen
        if(!empty($usuario->imagen)){
            Storage::delete(public_path('imagenes_usuarios').'/'.$usuario->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM usuarios WHERE id=1
        $usuario->delete();

        //Redigimos a listado
        return redirect('listado_usuario');
    }

    public function postGuardar(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //Validamos si el parametro de id es null
        if($data["id"] == null){
            //instanciamos un objeto usuario
            $usuario = new Usuario();
        }
        else {
            //se busca el registro con el id
            $usuario = Usuario::find($data['id']);

            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($request->hasFile('imagen') && $usuario->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_usuarios').'/'.$usuario->imagen);
            }
        }

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_usuarios'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $usuario->nombre = $data['nombre'];
        $usuario->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $usuario->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $usuario->save();
        //Se hace la redirecion
        return redirect('listado_usuario');
    }

    //URL APIS

    //Nuevo
    public function getApiListado() {
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios"
        $usuarios = Usuario::all();
        return ["usuarios" => $usuarios];
    }

    //Agregamos un parametro
    public function getApiGetUsuarioByID($id = null) {
        //Ejecutamos el metodo find para buscar por el pk
        //"SELECT * FROM usuarios WHERE id=3"
        $usuario = Usuario::find($id);
        return $usuario;
    }

    public function deleteApiEliminar($id) {
        //Se busca el registro de la tabla
        //SELECT * FROM usuarios WHERE id=1
        $usuario = Usuario::find($id);

        //Se borra la imagen
        if(!empty($usuario->imagen)){
            Storage::delete(public_path('imagenes_usuarios').'/'.$usuario->imagen);
        }

        //Se ejecuta el metodo delete
        //DELETE FROM usuarios WHERE id=1
        $usuario->delete();
    }

    public function postApiAddUsuario(Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //instanciamos un objeto usuario
        $usuario = new Usuario();

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_usuarios'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $usuario->nombre = $data['nombre'];
        $usuario->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $usuario->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $usuario->save();
    }

    public function putApiUpdateUsuario($id, Request $request) {
        //Obtenemos los parametros de la peticion
        $data = $request->all();
        //Establecemos un nombre de la imagen
        $ruta_archivo_original = null;

        //se busca el registro con el id
        $usuario = Usuario::find($id);

        //Validamos si la imagen se esta enviando
        if($request->hasFile('imagen')) {
            //valido si van a modificar la imagen y si tengo una imagen en la base de datos
            if ($usuario->imagen != null) {
                // Eliminar la imagen que se tiene en base datos
                Storage::delete(public_path('imagenes_usuarios').'/'.$usuario->imagen);
            }
            //Generamos un nombre aliatorio y concatenamos la extension de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            //Movemos el archivo a la carpeta publica con el nombre
            $request->imagen->move(public_path('imagenes_usuarios'), $nombreImagen);
            //Asignamos el nombre del archivo
            $ruta_archivo_original= $nombreImagen;
        }

        //se asignan los parametros de la peticion a objeto
        $usuario->nombre = $data['nombre'];
        $usuario->edad = $data['edad'];

        if($request->hasFile('imagen')) {
            $usuario->imagen = $ruta_archivo_original;
        }

        //Se ejecuta el metodo save para agregar o modificar el registro
        $usuario->save();
    }

    public function getApiFiltro(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios WHERE nombre like '%a%'"
        $usuarios = Usuario::Where('nombre','LIKE',"%".$filtro."%")->get();
        return ["usuarios" => $usuarios];
    }
}