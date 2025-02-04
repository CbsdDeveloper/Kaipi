<?php
require_once '../model/Model-pai_datos_generales.php';
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$id_incidente = $_GET['id_incidente'] ?? $_SESSION['id_incidente'];

if (!$id_incidente) {
    die("Error: No se proporcionó un ID de incidente válido.");
}

$pai_datos_generales = obtenerDatosPaiGeneralesPorIncidente($id_incidente);
$incidente = obtenerIncidentePorId($id_incidente);

$mensaje = $_GET['mensaje'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-202 Datos Generales PAI</title>
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
                <a href="pai_crear_datos.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            <?php if (!empty($pai_datos_generales)): ?>
                <table class="ViewIncidentes">
                    <thead>
                        <tr>
                            <th>Elaborado por</th>
                            <th>Fecha/Hora Inicio</th>
                            <th>Fecha/Hora Fin</th>
                            <th>Fecha de Preparacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pai_datos_generales as $registro): ?>
                            <tr>
                                <td><?= htmlspecialchars($registro['elaborador']) ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($registro['fecha_hora_inicio']))) ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($registro['fecha_hora_fin']))) ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($registro['fecha_hora_preparacion']))) ?></td>
                                <td>
                                    <a href="pai_editar_datos.php?action=actualizar&id_pai_datos_generales=<?= $registro['id_bom_pai_datos_g'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                    <a href="#" onclick="confirmarEliminacion(<?= $registro['id_bom_pai_datos_g'] ?>, <?= htmlspecialchars($id_incidente) ?>)" class="btn icono fas fa-trash-o k"></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>                    
                </table>
            <?php else: ?>
                <p>No hay datos generales PAI registrados para este incidente.</p>
            <?php endif; ?>

        </div>
    </div>

    <script>
        function confirmarEliminacion(id, id_incidente) {
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                $.ajax({
                    type: 'POST',
                    url: '../controller/Controller-pai_datos_generales.php',
                    data: {
                        accion: 'eliminar',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = 'table_datos_generales.php?id_incidente=' + id_incidente + '&mensaje=eliminado_exitoso';
                        } else {
                            toastr.error(response.message || 'Error al eliminar el registro.');
                        }
                    },
                    error: function() {
                        toastr.error('Error en la solicitud.');
                    }
                });
            }
        }


        $(document).ready(function() {
            const mensaje = getParameterByName('mensaje');
            if (mensaje) {
                switch (mensaje) {
                    case 'eliminado_exitoso':
                        toastr.success('Datos generales PAI eliminados con éxito.');
                        break;
                    case 'error_eliminar':
                        toastr.error('Error al eliminar los datos generales PAI.');
                        break;
                    case 'guardado_exitoso':
                        toastr.success('Datos generales PAI guardados con éxito.');
                        break;
                    case 'error_guardar':
                        toastr.error('Error al guardar los datos generales PAI.');
                        break;
                }

                setTimeout(function() {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('mensaje');
                    window.history.replaceState({}, document.title, url.toString());
                }, 2000);
            }
        });

        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
    </script>
</body>

</html>