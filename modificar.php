<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermercado anselmi";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$codigo = $_POST['codigo'];
$codigonuevo = $_POST['codigonuevo'];
$articulo = $_POST['articulo'];
$seccion = $_POST['seccion'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];

$sql = "UPDATE `productos` SET `codigoarticulo`='$codigonuevo',`articulo`='$articulo',`seccion`='$seccion',`cantidad`='$cantidad',`precio`='$precio' WHERE codigoarticulo='$codigo'";
$resultado = mysqli_query($conn,$sql);
   
    if ($resultado == true) {
        echo "Artículo modificados correctamente <br>";
        echo "Codigo: " . $codigo. "<br>";
        echo "Codigo nuevo : " . $codigonuevo. "<br>";
        echo "Articulo: " . $articulo. "<br>";
        echo "Seccion : " . $seccion. "<br>";
        echo "Cantidad: " . $cantidad. "<br>";
        echo "Precio : $ " . $precio. "<br>";
        echo '<a href="index.php">Volver al inicio</a>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

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

