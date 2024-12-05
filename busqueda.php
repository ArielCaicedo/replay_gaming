<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Obtener los parámetros de búsqueda y filtros
$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$ordenar_por = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : '';

// Lógica de filtro y búsqueda en la base de datos
$query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.stock, p.descuento 
          FROM productos p
          LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
          WHERE p.nombre LIKE :searchTerm AND p.activo = 1";

$params = [':searchTerm' => "%{$searchTerm}%"];

if ($categoria != '') {
    $query .= " AND p.id_categoria = :categoria";
    $params[':categoria'] = $categoria;
}

if ($ordenar_por == 'precio_mayor') {
    $query .= " ORDER BY p.precio DESC";
} elseif ($ordenar_por == 'precio_menor') {
    $query .= " ORDER BY p.precio ASC";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener categorías para el filtro
$query_categorias = "SELECT id_categoria, nombre FROM categorias";
$stmt_categorias = $pdo->prepare($query_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Busqueda</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <main class="my-5">
        <div class="container">
            <!-- Título de resultados -->
            <div class="text-center mb-5">
                <h1 class="text-warning">Encuentra lo que necesitas</h1>
            </div>

            <form method="GET" class="row g-3 mb-5">
                <!-- Campo de búsqueda animado -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for="searchTerm" class="form-label">Buscar por nombre</label>
                    <input type="text"
                        name="query"
                        id="query"
                        class="form-control search-input"
                        placeholder="God of War"
                        value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Selector de categoría -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($cat['id_categoria'] == $categoria) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Selector de orden -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="ordenar_por" class="form-label">Ordenar por</label>
                    <select name="ordenar_por" id="ordenar_por" class="form-select">
                        <option value="">--</option>
                        <option value="precio_mayor" <?php echo ($ordenar_por == 'precio_mayor') ? 'selected' : ''; ?>>Precio: mayor a menor</option>
                        <option value="precio_menor" <?php echo ($ordenar_por == 'precio_menor') ? 'selected' : ''; ?>>Precio: menor a mayor</option>
                    </select>
                </div>

                <!-- Botón de Filtrar -->
                <div class="col-lg-1 col-md-6 col-sm-6 align-self-end">
                    <button type="submit" class="btn btn-warning w-100"><i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <!-- Botón de Limpiar -->
                <div class="col-lg-1 col-md-6 col-sm-6 align-self-end gx-0">
                    <a href="busqueda.php" id="btnLimpiar" class="btn btn-secondary w-100 d-none">Limpiar</a>
                </div>
            </form>

            <!-- Resultados -->
            <div class="row mt-4 g-4 py-3">
                <?php if (!empty($resultados)): ?>
                    <?php foreach ($resultados as $producto): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
                            <div class="card shadow-lg border-0 bg-dark text-white d-flex flex-column">
                                <!-- Imagen y precio -->
                                <div class="thumb position-relative">
                                    <?php
                                    $imagen = "img/" . htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8');
                                    if (!file_exists($imagen)) {
                                        $imagen = "img/single-game.png"; // Imagen por defecto si no existe
                                    }
                                    ?>
                                    <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>">
                                        <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top rounded" alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </a>
                                    <!-- Precio -->
                                    <span class="price position-absolute bottom-0 start-0 p-2 text-white bg-dark bg-opacity-75 rounded">
                                        <?php echo MONEDA . ' ' . number_format($producto['precio'], 2, ',', '.'); ?>
                                    </span>
                                </div>

                                <!-- Detalles del producto -->
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h5 class="card-title mb-2"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="card-text mb-1">
                                        <strong>Descuento:</strong> <?php echo $producto['descuento']; ?>%
                                    </p>
                                    <p class="card-text mb-3">
                                        <strong>Stock:</strong>
                                        <span class="<?php echo $producto['stock'] > 0 ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $producto['stock'] > 0 ? 'Disponible' : 'No Disponible'; ?>
                                        </span>
                                    </p>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex justify-content-center mt-auto mb-3">
                                    <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>" class="btn btn-outline-warning btn-sm me-2">Detalles</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No se encontraron productos que coincidan con la búsqueda.</p>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/filtro_busqueda.js"></script>
    
</body>

</html>