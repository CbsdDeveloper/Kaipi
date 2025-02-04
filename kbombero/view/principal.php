<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// session_start( ); 

// require_once('../model/Model-Incidentes.php');
require_once '../controller/Controller-ResumenAcciones.php';

$id_incidente = $_GET['id_incidente'] ?? null;

$controller = new ControllerResumenAcciones();
$acciones = $id_incidente ? $controller->listarPorIncidente($id_incidente) : [];
$incidente = $controller->obtenerIncidentePorId($id_incidente);

// if ($id_incidente) {
//     $incidente = obtenerIncidentePorId($id_incidente);
//     $_SESSION['id_incidente']  = $id_incidente;
// } else {
//     echo "No se ha seleccionado un incidente.";
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-201 Resumen de Acciones</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <?php require('bibliotecas.php') ?>
    <script type="text/javascript" src="../js/modulo.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto;
            margin-bottom: 5%;
        }
    </style>
</head>

<body class="colorB">
    <custom-header incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci'] ?? ''); ?>"></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="container">
            <!-- <div class="card" style="width: 18rem;">
                <div class="card-header">
                    SCI-201 Mapa
                </div>
            </div> -->
            <div class="top-bar">
                <a href="agregar.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fa fa-plus"></i> Agregar nueva acción
                </a>
            </div>
            <?php if ($id_incidente): ?>
                <?php if (is_array($acciones) && !empty($acciones)): ?>
                    <table class="ViewIncidentes">
                        <thead>
                            <tr>
                                <th>Fecha y Hora</th>
                                <th>Actividad</th>
                                <th>Reportó</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($acciones as $accion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($accion['fecha_hora']) ?></td>
                                    <td><?= htmlspecialchars($accion['actividad']) ?></td>
                                    <td><?= htmlspecialchars($accion['posicion_institucion']) ?></td>
                                    <td>
                                        <a href="editar.php?id=<?= $accion['id_bom_res_acc'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                        <a href="../view/eliminar.php?delete_id=<?= $accion['id_bom_res_acc'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>"
                                            onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                            class="btn icono fas fa-trash-o k"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay acciones registradas para este incidente.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No se ha especificado un incidente. Por favor, seleccione un incidente para ver sus acciones.</p>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="../js/acciones.js"></script>
</body>

</html>