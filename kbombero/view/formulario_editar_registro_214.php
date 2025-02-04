<?php
include_once('../model/Model-registro-214.php');
include_once('../controller/Controller-registro-214.php');

$id_bombero = isset($_GET['id_bombero']) ? intval($_GET['id_bombero']) : null;
$id_incidente = $_GET['id_incidente'] ?? null;

if (!$id_bombero || !$id_incidente) {
    die("Error: No se proporcionó un ID de bombero o incidente válido.");
}

$controller = new ControllerRegistroSCI();
$bombero = $controller->obtenerBomberoPorId($id_bombero);

if (!$bombero) {
    die("Error: No se ha encontrado el bombero.");
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Registro de Bomberos SCI</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto;
            margin-bottom: 5%;
        }

        .edit-info {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .edit-info>div {
            display: flex;
            align-items: center;
        }

        .edit-info i {
            margin-right: 0.3rem;
        }

        .edit-info-cuadro {
            margin-right: 1rem;
        }
    </style>
</head>

<body class="colorB">
    <custom-header></custom-header>
    <custom-menu></custom-menu>

    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Editar Registro de Bomberos SCI</h6>
            <div class="card-body">
                <div class="edit-info mb-4">
                    <div class="edit-info-cuadro">
                        <i class="fas fa-plus-square"></i>
                        <span id="created-info">Creado: <?php echo date('d/m/Y, H:i', strtotime($bombero['fecha_hora'])); ?></span>
                    </div>
                    <div class="edit-info-cuadro">
                        <i class="fas fa-edit"></i>
                        <span id="edited-info">Editado: <?php echo $bombero['fecha_edicion'] ? date('d/m/Y, H:i', strtotime($bombero['fecha_edicion'])) : 'No editado'; ?></span>
                    </div>
                </div>
                <form id="formEditarBombero214" method="POST">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">
                    <input type="hidden" id="id_bombero" name="id_bombero" value="<?php echo htmlspecialchars($id_bombero); ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($bombero['nombre']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="posicion" class="form-label">Posición*</label>
                            <select name="posicion" id="posicion" class="select2" required>
                                <option value="">---------</option>
                                <option value="Comandante Adjunto" <?php echo $bombero['posicion'] == 'Comandante Adjunto' ? 'selected' : ''; ?>>Comandante Adjunto</option>
                                <option value="Comandante Adjunto de Área" <?php echo $bombero['posicion'] == 'Comandante Adjunto de Área' ? 'selected' : ''; ?>>Comandante Adjunto de Área</option>
                                <option value="Comandante de Área" <?php echo $bombero['posicion'] == 'Comandante de Área' ? 'selected' : ''; ?>>Comandante de Área</option>
                                <option value="Comandante del Incidente" <?php echo $bombero['posicion'] == 'Comandante del Incidente' ? 'selected' : ''; ?>>Comandante del Incidente</option>
                                <option value="Comandante Unificado de Área" <?php echo $bombero['posicion'] == 'Comandante Unificado de Área' ? 'selected' : ''; ?>>Comandante Unificado de Área</option>
                                <option value="Comando Unificado" <?php echo $bombero['posicion'] == 'Comando Unificado' ? 'selected' : ''; ?>>Comando Unificado</option>
                                <option value="Coordinador Adjunto de la Rama" <?php echo $bombero['posicion'] == 'Coordinador Adjunto de la Rama' ? 'selected' : ''; ?>>Coordinador Adjunto de la Rama</option>
                                <option value="Coordinador de Rama / Adjunto" <?php echo $bombero['posicion'] == 'Coordinador de Rama / Adjunto' ? 'selected' : ''; ?>>Coordinador de Rama / Adjunto</option>
                                <option value="Coordinador Rama" <?php echo $bombero['posicion'] == 'Coordinador Rama' ? 'selected' : ''; ?>>Coordinador Rama</option>
                                <option value="Encargado A.C.V." <?php echo $bombero['posicion'] == 'Encargado A.C.V.' ? 'selected' : ''; ?>>Encargado A.C.V.</option>
                                <option value="Encargado Área de Espera" <?php echo $bombero['posicion'] == 'Encargado Área de Espera' ? 'selected' : ''; ?>>Encargado Área de Espera</option>
                                <option value="Encargado Base" <?php echo $bombero['posicion'] == 'Encargado Base' ? 'selected' : ''; ?>>Encargado Base</option>
                                <option value="Encargado Campamento" <?php echo $bombero['posicion'] == 'Encargado Campamento' ? 'selected' : ''; ?>>Encargado Campamento</option>
                                <option value="Encargado Helibase" <?php echo $bombero['posicion'] == 'Encargado Helibase' ? 'selected' : ''; ?>>Encargado Helibase</option>
                                <option value="Encargado Helipunto" <?php echo $bombero['posicion'] == 'Encargado Helipunto' ? 'selected' : ''; ?>>Encargado Helipunto</option>
                                <option value="Jefe Adjunto Sección" <?php echo $bombero['posicion'] == 'Jefe Adjunto Sección' ? 'selected' : ''; ?>>Jefe Adjunto Sección</option>
                                <option value="Jefe de Logística de Área" <?php echo $bombero['posicion'] == 'Jefe de Logística de Área' ? 'selected' : ''; ?>>Jefe de Logística de Área</option>
                                <option value="Jefe Sección Admon. y Finanzas" <?php echo $bombero['posicion'] == 'Jefe Sección Admon. y Finanzas' ? 'selected' : ''; ?>>Jefe Sección Admon. y Finanzas</option>
                                <option value="Jefe Sección Inteligencia" <?php echo $bombero['posicion'] == 'Jefe Sección Inteligencia' ? 'selected' : ''; ?>>Jefe Sección Inteligencia</option>
                                <option value="Jefe Sección Logística" <?php echo $bombero['posicion'] == 'Jefe Sección Logística' ? 'selected' : ''; ?>>Jefe Sección Logística</option>
                                <option value="Jefe Sección Operaciones" <?php echo $bombero['posicion'] == 'Jefe Sección Operaciones' ? 'selected' : ''; ?>>Jefe Sección Operaciones</option>
                                <option value="Jefe Sección Planificación" <?php echo $bombero['posicion'] == 'Jefe Sección Planificación' ? 'selected' : ''; ?>>Jefe Sección Planificación</option>
                                <option value="Líder de Equipo de Intervención" <?php echo $bombero['posicion'] == 'Líder de Equipo de Intervención' ? 'selected' : ''; ?>>Líder de Equipo de Intervención</option>
                                <option value="Líder Fuerza de Tarea" <?php echo $bombero['posicion'] == 'Líder Fuerza de Tarea' ? 'selected' : ''; ?>>Líder Fuerza de Tarea</option>
                                <option value="Líder Recurso Simple" <?php echo $bombero['posicion'] == 'Líder Recurso Simple' ? 'selected' : ''; ?>>Líder Recurso Simple</option>
                                <option value="Líder Unidad" <?php echo $bombero['posicion'] == 'Líder Unidad' ? 'selected' : ''; ?>>Líder Unidad</option>
                                <option value="Oficial Enlace" <?php echo $bombero['posicion'] == 'Oficial Enlace' ? 'selected' : ''; ?>>Oficial Enlace</option>
                                <option value="Oficial Enlace de Área" <?php echo $bombero['posicion'] == 'Oficial Enlace de Área' ? 'selected' : ''; ?>>Oficial Enlace de Área</option>
                                <option value="Oficial Información Pública" <?php echo $bombero['posicion'] == 'Oficial Información Pública' ? 'selected' : ''; ?>>Oficial Información Pública</option>
                                <option value="Oficial Inteligencia" <?php echo $bombero['posicion'] == 'Oficial Inteligencia' ? 'selected' : ''; ?>>Oficial Inteligencia</option>
                                <option value="Oficial Seguridad" <?php echo $bombero['posicion'] == 'Oficial Seguridad' ? 'selected' : ''; ?>>Oficial Seguridad</option>
                                <option value="Registrador de Recursos" <?php echo $bombero['posicion'] == 'Registrador de Recursos' ? 'selected' : ''; ?>>Registrador de Recursos</option>
                                <option value="Supervisor División" <?php echo $bombero['posicion'] == 'Supervisor División' ? 'selected' : ''; ?>>Supervisor División</option>
                                <option value="Supervisor Grupo" <?php echo $bombero['posicion'] == 'Supervisor Grupo' ? 'selected' : ''; ?>>Supervisor Grupo</option>
                                <option value="Técnico Especialista" <?php echo $bombero['posicion'] == 'Técnico Especialista' ? 'selected' : ''; ?>>Técnico Especialista</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución*</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" value="<?php echo htmlspecialchars($bombero['institucion']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_hora" class="form-label">Fecha y Hora*</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" value="<?php echo date('Y-m-d\TH:i', strtotime($bombero['fecha_hora'])); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="actividad" class="form-label">Actividad*</label>
                        <textarea class="form-control" id="actividad" name="actividad" rows="4" required><?php echo htmlspecialchars($bombero['actividad']); ?></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#formEditarBombero214').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var idIncidente = $('#id_incidente').val();

                $.ajax({
                    url: '../controller/Controller-registro-214.php',
                    type: 'POST',
                    data: formData + '&action=actualizar',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Bombero actualizado con éxito!');
                            // Actualizar la información de edición
                            $('#edited-info').text('Editado: ' + response.fecha_edicion);
                            setTimeout(function() {
                                window.location.href = 'registro_sci-214.php?id_incidente=' + idIncidente;
                            }, 2000);
                        } else {
                            toastr.error('Error al actualizar el bombero: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.success('Bombero actualizado con éxito!');
                        setTimeout(function() {
                            window.location.href = 'registro_sci-214.php?id_incidente=' + idIncidente;
                        }, 2000);
                    }
                });
            });
        });
    </script>

</body>

</html>