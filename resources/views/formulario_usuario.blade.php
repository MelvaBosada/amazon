<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="/listado_usuario">Usuarios</a>
        <a class="nav-link" href="/listado_personaje">Personajes</a>
        <a class="nav-link" href="/listado_powerups">PowerUps</a>
      </div>
    </div>
  </div>
</nav>
    <form action="/guardar_usuario" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ empty($id) ? '' : $id }}"/>
        <label>Nombre:</label>
        <br>
        <input type="text" name="nombre" value="{{ empty($nombre) ? '' : $nombre }}"/>
        <br>
        <label>Edad:</label>
        <br>
        <input type="text" name="edad" value="{{ empty($edad) ? '' : $edad }}"/>
        <br>
        <label>Imagen:</label>
        <br>
        <input type="file" name="imagen"/>
        <br>
        <button type="submit">{{ empty($id) ? 'Agregar' : 'Editar' }}</button>
        <a href="/listado_usuario">Cancelar</a>
    </form>
</body>
</html>
