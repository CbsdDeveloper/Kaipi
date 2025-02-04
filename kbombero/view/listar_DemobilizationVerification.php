<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controller/Controller_DemobilizationVerification.php';

$id_incidente = $_GET['id_incidente'] ?? null;

try {
    $controller = new ControllerDemobilizationVerification();
    $verificaciones = $controller->listar($id_incidente);
    $incidente = $controller->obtenerIncidentePorId($id_incidente);
} catch (Exception $e) {
    error_log("Error en listar_DemobilizationVerification.php: " . $e->getMessage());
    die("Ocurrió un error al procesar la solicitud. Por favor, contacte al administrador.");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-221 Verificaciones de Desmovilización</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php require('bibliotecas.php')?>
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
            <div class="top-bar">
                <a href="agregar_DemobilizationVerification.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <?php if ($id_incidente): ?>
                <?php if (is_array($verificaciones) && !empty($verificaciones)): ?>
                    <table class="ViewIncidentes">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Fecha y Hora</th>
                                <th>Unidad/Personal</th>
                                <th>Elaborado por</th>
                                <th>Posición</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($verificaciones as $verificacion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($verificacion['periodo']) ?></td>
                                    <td><?= htmlspecialchars($verificacion['fecha_hora_desmovilizacion']) ?></td>
                                    <td><?= htmlspecialchars($verificacion['unidad_personal_desmovilizado']) ?></td>
                                    <td><?= htmlspecialchars($verificacion['elaborado_por']) ?></td>
                                    <td><?= htmlspecialchars($verificacion['posicion']) ?></td>
                                    <td>
                                        <a href="editar_DemobilizationVerification.php?id=<?= $verificacion['id_verificacion_desmovilizacion'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                        <a href="#" onclick="eliminarVerificacion(<?= $verificacion['id_verificacion_desmovilizacion'] ?>, <?= htmlspecialchars($id_incidente) ?>)"
                                            class="btn icono fas fa-trash-o k"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay verificaciones de desmovilización registradas para este incidente.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No se ha especificado un incidente. Por favor, seleccione un incidente para ver sus verificaciones de desmovilización.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function eliminarVerificacion(id, id_incidente) {
            if (confirm('¿Estás seguro de eliminar esta verificación de desmovilización?')) {
                $.ajax({
                    url: '../controller/Controller_DemobilizationVerification.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error al procesar la solicitud');
                    }
                });
            }
        }
    </script>
</body>

</html>