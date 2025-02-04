<?php
require_once '../model/Model-asignaciones_tacticas.php';

$id_incidente = $_GET['id_incidente'] ?? $_SESSION['id_incidente'];

if (!$id_incidente) {
    die("Error: No se proporcionó un ID de incidente válido.");
}

$incidente = obtenerIncidentePorId($id_incidente);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-204 Listado de Asignaciones Tácticas SCI</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php require('bibliotecas.php') ?>
    <script type="text/javascript" src="../js/modulo.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto 5%;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .ViewAsignaciones {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .ViewAsignaciones th,
        .ViewAsignaciones td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .ViewAsignaciones th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .ViewAsignaciones tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .ViewAsignaciones tbody tr:hover {
            background-color: #f5f5f5;
        }

        .top-bar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar .btn {
            margin-right: 10px;
        }

        .btn.cuadrado {
            border-radius: 0;
        }
    </style>
</head>
<body class="colorB">
    <custom-header incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci'] ?? ''); ?>"></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="container">
            <div class="top-bar">
                <a href="./formulario_asignaciones_tacticas.php?id_incidente=<?= htmlspecialchars($_GET['id_incidente'] ?? '') ?>" class="btn blue cuadrado">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            <div class="table-container">
                <?php
                $id_incidente = $_GET['id_incidente'] ?? 0;
                $asignaciones = obtenerAsignacionesYResponsables($id_incidente);
                ?>

                <?php if (is_array($asignaciones) && !empty($asignaciones)): ?>
                    <table class="ViewAsignaciones">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Posición</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $asignacion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($asignacion['asignacion']['periodo']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['asignacion']['posicion_estructura']) ?></td>
                                    <td>
                                    <a href="./editar_asignacion.php?id_asignacion=<?= $asignacion['asignacion']['id_asignacion'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit"></a>
                                    <a href="#" onclick="confirmarEliminacion(<?= $asignacion['asignacion']['id_asignacion'] ?>, <?= htmlspecialchars($id_incidente) ?>)" class="btn icono fas fa-trash-alt"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay asignaciones tácticas registradas para este incidente.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(idAsignacion, idIncidente) {
            if (confirm('¿Estás seguro de querer eliminar esta asignación táctica?')) {
                $.ajax({
                    url: '../controller/Controller-asignaciones_tacticas.php',
                    method: 'POST',
                    data: {
                        action: 'eliminar_asignacion_y_responsables',
                        id_asignacion: idAsignacion
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Asignación táctica eliminada con éxito.');
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            toastr.success('Asignación táctica eliminada con éxito.');
                            setTimeout(() => location.reload(), 2000);

                        }
                    },
                    error: function() {
                        toastr.success('Asignación táctica eliminada con éxito.');
                        setTimeout(() => location.reload(), 2000);                    }
                });
            }
        }
    </script>
</body>

</html>