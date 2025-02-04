<?php

session_start( ); 

require_once '../controller/Controller-registro-214.php';

$id_incidente = $_GET['id_incidente'] ?? $_SESSION['id_incidente'];

if (!$id_incidente) {
    die("Error: No se proporcionó un ID de incidente válido.");
}

$controller = new ControllerRegistroSCI();
$bomberos = $controller->obtenerBomberosPorIncidente($id_incidente);
$incidente = $controller->obtenerIncidentePorId($id_incidente);

$mensaje = $_GET['mensaje'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-214 Registro de Actividades</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
            <div class="top-bar">
                <a href="./formulario_agregar_registro_214.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            <?php if (is_array($bomberos) && !empty($bomberos)): ?>
                <table class="ViewIncidentes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Posición</th>
                            <th>Institución</th>
                            <th>Fecha y Hora</th>
                            <th>Actividad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bomberos as $bombero): ?>
                            <tr>
                                <td><?= htmlspecialchars($bombero['nombre']) ?></td>
                                <td><?= htmlspecialchars($bombero['posicion']) ?></td>
                                <td><?= htmlspecialchars($bombero['institucion']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($bombero['fecha_hora']))) ?></td>
                                <td><?= htmlspecialchars(substr($bombero['actividad'], 0, 50)) . (strlen($bombero['actividad']) > 50 ? '...' : '') ?></td>
                                <td>
                                    <a href="formulario_editar_registro_214.php?id_bombero=<?= $bombero['id_bombero'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit"></a>
                                    <a href="#" onclick="confirmarEliminacion(<?= $bombero['id_bombero'] ?>, <?= htmlspecialchars($id_incidente) ?>)" class="btn icono fas fa-trash-alt"></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay bomberos registrados para este incidente.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            window.confirmarEliminacion = function(idBombero, idIncidente) {
                if (confirm('¿Estás seguro de eliminar este bombero?')) {
                    $.ajax({
                        url: '../controller/Controller-registro-214.php',
                        type: 'POST',
                        data: {
                            action: 'eliminar',
                            id_bombero: idBombero,
                            id_incidente: idIncidente
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                // Eliminar la fila de la tabla
                                $('tr').has('a[onclick="confirmarEliminacion(' + idBombero + ', ' + idIncidente + ')"]').remove();

                                // Si la tabla está vacía, mostrar un mensaje
                                if ($('.ViewIncidentes tbody tr').length === 0) {
                                    $('.ViewIncidentes').after('<p>No hay bomberos registrados para este incidente.</p>');
                                    $('.ViewIncidentes').remove();
                                }
                            } else {
                                toastr.error(response.message || 'No se pudo eliminar el bombero.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                            console.log('Respuesta del servidor:', jqXHR.responseText);
                            toastr.success('Registro eliminado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_sci-214.php?id_incidente=' + idIncidente;
                            }, 2000);
                        }
                    });
                }
            };
        });
    </script>
</body>

</html>