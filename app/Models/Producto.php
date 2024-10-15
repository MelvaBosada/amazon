<?php
//ruta de refencia
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    //Definimos que tabla es de la base de datos
    protected $table = "productos";

    //Definimos el primary key de la tabla
    protected $primaryKey = "id";

    //Dehabilitar los campos de created_at y update_at
    public $timestamps = false;

    //Definimos las demas columnas que tenemos en la tabla
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'fecha',
        'precio'
    ];

}
