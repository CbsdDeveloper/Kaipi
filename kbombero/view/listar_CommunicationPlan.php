<?php
session_start();
require_once '../controller/Controller_CommunicationPlan.php';

$id_incidente = $_GET['id_incidente'] ?? $_SESSION['id_incidente'];

$controller = new ControllerCommunicationPlan();
$planes = $controller->listar($id_incidente);
$incidente = $controller->obtenerIncidentePorId($id_incidente);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-205 Planes de Comunicación</title>
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
                <a href="agregar_CommunicationPlan.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <?php if ($id_incidente): ?>
                <?php if (is_array($planes) && !empty($planes)): ?>
                    <table class="ViewIncidentes">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Sistema</th>
                                <th>Canal/Frecuencia</th>
                                <th>Asignado</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($planes as $plan): ?>
                                <tr>
                                    <td><?= htmlspecialchars($plan['periodo']) ?></td>
                                    <td><?= htmlspecialchars($plan['sistema']) ?></td>
                                    <td><?= htmlspecialchars($plan['canal_frecuencia']) ?></td>
                                    <td><?= htmlspecialchars($plan['asignado']) ?></td>
                                    <td><?= htmlspecialchars($plan['ubicacion']) ?></td>
                                    <td>
                                        <a href="editar_CommunicationPlan.php?id=<?= $plan['id_plan_comunicaciones'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                        <a href="#" onclick="eliminarPlan(<?= $plan['id_plan_comunicaciones'] ?>, <?= htmlspecialchars($id_incidente) ?>)"
                                            class="btn icono fas fa-trash-o k"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay planes de comunicación registrados para este incidente.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No se ha especificado un incidente. Por favor, seleccione un incidente para ver sus planes de comunicación.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function eliminarPlan(id, id_incidente) {
            if (confirm('¿Estás seguro de eliminar este plan de comunicación?')) {
                $.ajax({
                    url: '../controller/Controller_CommunicationPlan.php',
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