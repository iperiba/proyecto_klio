<!DOCTYPE html>
<html>
<body>

<h1>Show a file-select field:</h1>

<h3>Show a file-select field which allows only one file to be chosen:</h3>
<form action="{{ route('anadir_modificar_pelicula02') }}" method="post" enctype="multipart/form-data">
    @csrf
    Select a file: <input type="file" name="cartel"><br><br>
    <input type="submit">
</form>
</body>
</html>
