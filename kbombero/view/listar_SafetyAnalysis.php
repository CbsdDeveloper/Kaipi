<?php
require_once '../controller/Controller_SafetyAnalysis.php';

$id_incidente = $_GET['id_incidente'] ?? null;

$controller = new ControllerSafetyAnalysis();
$analisis = $controller->listar($id_incidente);
$incidente = $controller->obtenerIncidentePorId($id_incidente);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-215a Análisis de Seguridad</title>
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
                <a href="agregar_SafetyAnalysis.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <?php if ($id_incidente): ?>
                <?php if (is_array($analisis) && !empty($analisis)): ?>
                    <table class="ViewIncidentes">
                        <thead>
                            <tr>
                                <th>Área</th>
                                <th>Riesgo</th>
                                <th>Acción Mitigante</th>
                                <th>Posición</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($analisis as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['area']) ?></td>
                                    <td><?= htmlspecialchars($item['riesgo']) ?></td>
                                    <td><?= htmlspecialchars($item['accion_mitigante']) ?></td>
                                    <td><?= htmlspecialchars($item['posicion']) ?></td>
                                    <td>
                                        <a href="editar_SafetyAnalysis.php?id=<?= $item['id_analisis_seguridad'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                        <a href="#" onclick="eliminarAnalisis(<?= $item['id_analisis_seguridad'] ?>, <?= htmlspecialchars($id_incidente) ?>)"
                                            class="btn icono fas fa-trash-o k"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay análisis de seguridad registrados para este incidente.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No se ha especificado un incidente. Por favor, seleccione un incidente para ver sus análisis de seguridad.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function eliminarAnalisis(id, id_incidente) {
            if (confirm('¿Estás seguro de eliminar este análisis de seguridad?')) {
                $.ajax({
                    url: '../controller/Controller_SafetyAnalysis.php',
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