<?php
include_once('../model/Model-Incidentes.php');

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : $_SESSION['id_incidente'];
$incidente = null;

if ($id_incidente) {
    $incidente = obtenerIncidentePorId($id_incidente);
} else {
    echo "No se ha seleccionado un incidente.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Incluir Toastr CSS y JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="./menu-desplegable.js"></script>
    <link rel="stylesheet" href="./lib/css/estilos.css">
</head>

<body class="colorB">
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>

    <div class="content">

        <!-- Main content -->
        <div class="cuadro">
            <div class="formulario">

                <form action="../../kbombero/controller/Controller-pai_datos_generales.php" method="POST">
                    <div class="row">
                        <input type="hidden" name="accion" value="agregar">
                        <input type="hidden" name="id_incidente" value="<?php echo isset($id_incidente) ? intval($id_incidente) : ''; ?>">

                        <div class="col-6">
                            <label>Fecha y hora de inicio</label>
                            <input type="datetime-local" class="form-control form-fecha" id="id_fecha_hora_inicio" name="fecha_hora_inicio" required>

                        </div>
                        <div class="col-6">
                            <label>Fecha y hora de finalización</label>
                            <input type="datetime-local" class="form-control form-fecha" id="id_fecha_hora_fin" name="fecha_hora_fin" required>
                        </div>
                        <!-- Botón para agregar objetivos dinámicos -->
                        <div class="form-section mt-3">
                            <button class="btn btn-secondary" id="addObjectiveBtn" type="button">Agregar</button>
                        </div>

                        <!-- Objetivos fijos con opción de eliminar -->
                        <div class="form-section mt-3" id="fixed_objectives">
                            <div class="row row-spacing mb-3">
                                <div class="col-md-3">
                                    <div class='note'>Objetivo</div>
                                    <textarea class="form-control" maxlength="1000" name="objective[]" rows="4"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <div class='note'>Estrategia</div>
                                    <textarea class="form-control" maxlength="1000" name="strategy[]" rows="4"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <div class='note'>Táctica</div>
                                    <textarea class="form-control" maxlength="1000" name="tactic[]" rows="4"></textarea>
                                </div>
                                <div class="eliminacion col-md-3 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger remove-fixed-objective">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Objetivos dinámicos -->
                        <div class="form-section mt-3" id="div_objectives">
                            <!-- Aquí se agregarán dinámicamente las filas de objetivos -->
                        </div>

                        <!-- Demás datos -->
                        <div class="col-6">
                            <label>Mensaje de seguridad</label>
                            <textarea class="form-control" id="id_mensaje_seguridad" maxlength="500" name="mensaje_seguridad" rows="3"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Pronóstico de Tiempo</label>
                            <textarea class="form-control" id="id_pronostico_tiempo" maxlength="500" name="pronostico_tiempo" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label>Observaciones a los recursos asignados para este periodo</label>
                            <textarea class="form-control" id="id_observaciones" maxlength="500" name="observaciones" rows="3"></textarea>
                        </div>

                        <!-- Elaborado por -->
                        <div class="col-4 col-md-6">
                            <div class="note">Posición:</div>
                            <label class="select form-label">
                                <select class="form-select " id="id_posicion" name="posicion" required>
                                    <option value="">---------</option>
                                    <option value="Comandante Adjunto">Comandante Adjunto</option>
                                    <option value="Comandante Adjunto de Área">Comandante Adjunto de Área</option>
                                    <option value="Comandante de Área">Comandante de Área</option>
                                    <option value="Comandante del Incidente">Comandante del Incidente</option>
                                </select>
                            </label>
                        </div>

                        <!-- Fecha y hora de preparación -->
                        <div class="col-4">
                            <label>Fecha y hora de preparación</label>
                            <input type="datetime-local" class="form-control form-fecha" id="id_fecha_hora_preparacion" name="fecha_hora_preparacion" required>
                        </div>
                        <div class="col-4">
                            <label for="id_elaborador">Elaborado por:</label>
                            <select id="id_elaborador" name="elaborador" class="form-select">
                                <option value="">Seleccione un elaborador</option>
                                <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                            </select>
                        </div>

                        <!-- Nombre completo y firma -->
                        <div class="form-buttons">
                            <label class="form-label">&nbsp;</label>
                            <div class="border-top pt-2">
                                <center><strong>Nombre completo y firma</strong></center>
                            </div>
                        </div>

                        <!-- Botón de Envío -->
                        <div class="form-buttons">
                            <button onclick="history.back()" class="btn btn-secondary">Volver</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // Inicializar Select2 en el campo de elaborador
                $('#id_elaborador').select2({
                    placeholder: "Buscar elaborador...",
                    allowClear: true
                });

                // Inicializar Select2 en el campo de posición
                $('#id_posicion').select2({
                    placeholder: "Buscar...",
                    allowClear: true,
                });

                // Cargar los elaboradores desde el servidor
                $.ajax({
                    url: '../../kbombero/controller/Controller-pai_datos_generales.php',
                    method: 'GET',
                    data: { action: 'obtener_elaboradores' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var select = $('#id_elaborador');
                            $.each(response.elaboradores, function(index, elaborador) {
                                select.append(new Option(elaborador, elaborador));
                            });
                            // Actualizar Select2 después de añadir las opciones
                            select.trigger('change');
                        } else {
                            console.error('Error al cargar elaboradores:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });

                // Función para eliminar objetivos fijos
                $(document).on('click', '.remove-fixed-objective', function() {
                    const row = $(this).closest('.row');
                    if (confirm('¿Desea Borrar?')) {
                        row.remove();
                        toastr.info('Objetivo eliminado correctamente', 'Información', {
                            timeOut: 3000,
                            positionClass: "toast-top-right",
                            closeButton: true,
                            progressBar: true
                        });
                    }
                });

                // Función para agregar objetivos dinámicos
                $('#addObjectiveBtn').click(function() {
                    const objectivesDiv = $('#div_objectives');
                    const newRow = $('<div class="row row-spacing mb-3"></div>');

                    // Función para crear una sección de textarea
                    function createTextareaSection(title, name) {
                        return $(`
                            <div class="col-md-3">
                                <div class='note'>${title}</div>
                                <textarea class="form-control" maxlength="1000" name="${name}" rows="4"></textarea>
                            </div>
                        `);
                    }

                    // Agregar secciones
                    newRow.append(createTextareaSection('Objetivo', 'objective[]'));
                    newRow.append(createTextareaSection('Estrategia', 'strategy[]'));
                    newRow.append(createTextareaSection('Táctica', 'tactic[]'));

                    // Botón de eliminar
                    const deleteSection = $(`
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-danger remove-objective">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    `);
                    newRow.append(deleteSection);

                    // Agregar fila al div
                    objectivesDiv.append(newRow);

                    // Añadir funcionalidad al botón de eliminar
                    deleteSection.find('.remove-objective').click(function() {
                        if (confirm('¿Desea Borrar?')) {
                            newRow.remove();
                            toastr.info('Objetivo eliminado correctamente', 'Información', {
                                timeOut: 3000,
                                positionClass: "toast-top-right",
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    });
                });

                // Manejar el envío del formulario
                $('form').submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: '../../kbombero/controller/Controller-pai_datos_generales.php',
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message, 'Éxito', {
                                    timeOut: 1000,
                                    positionClass: "toast-top-right",
                                    closeButton: true,
                                    progressBar: true
                                });
                                setTimeout(function() {
                                    window.location.href = "table_datos_generales.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>";
                                }, 1000);
                            } else {
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000,
                                    positionClass: "toast-top-right",
                                    closeButton: true,
                                    progressBar: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', error);
                            toastr.error('Error al procesar la solicitud', 'Error', {
                                timeOut: 3000,
                                positionClass: "toast-top-right",
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    });
                });
            });
        </script>
    </div>
</body>

</html>