<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermercado anselmi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $articulo = $_POST['articulo'];
    $seccion = $_POST['seccion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO `productos`(`codigoarticulo`, `articulo`, `seccion`, `cantidad`, `precio`) VALUES ('$codigo','$articulo','$seccion','$cantidad','$precio')";
    $stmt = $conn->prepare($sql);
   

    if ($stmt->execute()) {
        echo "Artículo ingresado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <title>Stock Supermercado EASY</title>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        input[type='text'], input[type='number'] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        input[type='submit'] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        input[type='submit']:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .mensaje {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
<body>
<h1>Supermercado EASY</h1>
<h2>Ingresar nuevo artículo</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Codigo articulo: <input type="text" name="codigo"><br>
    Nombre: <input type="text" name="articulo"><br>
    Seccion: <input type="text" name="seccion"><br>
    Cantidad: <input type="number" name="cantidad"><br>
    Precio: <input type="number" step="0.01" name="precio"><br>
    <input type="submit" value="Ingresar artículo">

</form>
</body>
</html>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermercado anselmi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los artículos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Lista de artículos</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Codigo Articulos</th><th>Nombre</th><th>Seccion</th><th>Cantidad</th><th>Precio</th><th>Eliminar</th><th>Modificar</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["codigoarticulo"] . "</td>";
        echo "<td>" . $row["articulo"] . "</td>";
        echo "<td>" . $row["seccion"] . "</td>";
        echo "<td>" . $row["cantidad"] . "</td>";
        echo "<td>$" . $row["precio"] . "</td>";
        echo "<td>" . '<input type="submit" value="Eliminar">' . "</td>";
        echo "<td>" . '<input type="submit" value="Modificar">' . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay artículos en la base de datos";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <title>Stock Supermercado EASY</title>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        input[type='text'], input[type='number'] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        input[type='submit'] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        input[type='submit']:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .mensaje {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
<body>
<h1>Supermercado EASY</h1>
<h2>Eliminar artículo</h2>
<form method="post" action="eliminar.php">
    Codigo articulo: <input type="text" name="codigo"><br>
    <input type="submit" value="Eliminar artículo">
    
</form>
</body>
</html>

<!DOCTYPE html>
<html>
    <title>Stock Supermercado EASY</title>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        input[type='text'], input[type='number'] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        input[type='submit'] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        input[type='submit']:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .mensaje {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
<body>
<h1>Supermercado EASY</h1>
<h2>Modificar articulos</h2>
<form method="post" action="modificar.php">
    Codigo articulo viejo: <input type="text" name="codigo"><br>
    Codigo articulo nuevo: <input type="text" name="codigonuevo"><br>
    Nombre: <input type="text" name="articulo"><br>
    Seccion: <input type="text" name="seccion"><br>
    Cantidad: <input type="number" name="cantidad"><br>
    Precio: <input type="number" step="0.01" name="precio"><br>
    <input type="submit" value="Modificar artículo">
    
</form>
</body>
</html>


