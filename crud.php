<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermercado_anselmi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = "";

// Eliminar producto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM productos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Producto eliminado correctamente";
    } else {
        $message = "Error al eliminar el producto: " . $stmt->error;
    }

    $stmt->close();
}

// Editar producto
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $articulo = $_POST['articulo'];
    $seccion = $_POST['seccion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $sql = "UPDATE productos SET codigoarticulo=?, articulo=?, seccion=?, cantidad=?, precio=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $codigo, $articulo, $seccion, $cantidad, $precio, $id);

    if ($stmt->execute()) {
        $message = "Producto actualizado correctamente";
    } else {
        $message = "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
}

// Insertar nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo']) && !isset($_POST['update'])) {
    $codigo = $_POST['codigo'];
    $articulo = $_POST['articulo'];
    $seccion = $_POST['seccion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO productos (codigoarticulo, articulo, seccion, cantidad, precio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $codigo, $articulo, $seccion, $cantidad, $precio);

    if ($stmt->execute()) {
        $message = "Producto ingresado correctamente";
    } else {
        $message = "Error al ingresar el producto: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener producto para editar
$producto_actual = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM productos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto_actual = $result->fetch_assoc();
    $stmt->close();
}

// Obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos - Supermercado EASY</title>
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
        .message {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Supermercado EASY</h1>
    <h2><?php echo isset($producto_actual) ? "Editar artículo" : "Ingresar nuevo artículo"; ?></h2>

    <?php
    if (!empty($message)) {
        echo "<p class='message'>$message</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id" value="<?php echo isset($producto_actual) ? $producto_actual['id'] : ''; ?>">
        Código artículo: <input type="text" name="codigo" value="<?php echo isset($producto_actual) ? $producto_actual['codigoarticulo'] : ''; ?>" required><br>
        Nombre: <input type="text" name="articulo" value="<?php echo isset($producto_actual) ? $producto_actual['articulo'] : ''; ?>" required><br>
        Sección: <input type="text" name="seccion" value="<?php echo isset($producto_actual) ? $producto_actual['seccion'] : ''; ?>" required><br>
        Cantidad: <input type="number" name="cantidad" value="<?php echo isset($producto_actual) ? $producto_actual['cantidad'] : ''; ?>" required><br>
        Precio: <input type="number" step="0.01" name="precio" value="<?php echo isset($producto_actual) ? $producto_actual['precio'] : ''; ?>" required><br>
        <input type="submit" name="<?php echo isset($producto_actual) ? 'update' : 'submit'; ?>" value="<?php echo isset($producto_actual) ? 'Actualizar artículo' : 'Ingresar artículo'; ?>">
    </form>

    <h2>Lista de artículos</h2>
    <table border="1">
        <tr>
            <th>Código Artículo</th>
            <th>Nombre</th>
            <th>Sección</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["codigoarticulo"] . "</td>";
                echo "<td>" . $row["articulo"] . "</td>";
                echo "<td>" . $row["seccion"] . "</td>";
                echo "<td>" . $row["cantidad"] . "</td>";
                echo "<td>$" . $row["precio"] . "</td>";
                echo "<td>
                        <a href='?edit=" . $row['id'] . "'>Editar</a> |
                        <a href='?delete=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay artículos en la base de datos</td></tr>";
        }
        ?>
    </table>
</div>

<?php
$conn->close();
?>

</body>
</html>
