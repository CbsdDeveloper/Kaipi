<?php
require_once '../model/Model-asignaciones_tacticas.php';

// Obtener el id_asignacion y id_incidente de los parámetros GET
$id_asignacion = isset($_GET['id_asignacion']) ? $_GET['id_asignacion'] : null;
$id_incidente = isset($_GET['id_incidente']) ? $_GET['id_incidente'] : null;

// Ahora podemos usar $id_asignacion de manera segura
if ($id_asignacion) {
    $resultado = obtenerAsignacionYResponsables($id_asignacion);
    $asignacion = $resultado['asignacion'];
    $responsables = $resultado['responsables'];
} else {
    // Si no se proporciona un ID de asignación, inicializar las variables
    $asignacion = null;
    $responsables = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asignaciones Tácticas</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_select2.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_datos_generales.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body class="colorB">
    <custom-header incidente-nombre="" incidente-cerrado="false">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h2>Editar Asignaciones Tácticas</h2>

            <form id="asignacionesTacticasForm">
                <div class="edit-info mb-4">
                    <div class="edit-info-cuadro">
                        <i class="fas fa-plus-square"></i>
                        <span id="created-info">Creado: <?php echo $asignacion['fecha_creacion_formatted']; ?></span>
                    </div>
                    <div class="edit-info-cuadro">
                        <i class="fas fa-edit"></i>
                        <span id="edited-info">Editado: <?php echo $asignacion['fecha_modificacion_formatted'] ?? 'No editado aún'; ?></span>
                    </div>
                </div>
                <input type="hidden" id="id_asignacion" name="id_asignacion" value="">
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="periodo" class="form-label">Periodo:</label>
                        <select id="periodo" name="periodo" class="form-select" required>
                            <option value="">Seleccione un periodo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="posicion_estructura" class="form-label">Posición de la Estructura:</label>
                        <select id="posicion_estructura" name="posicion_estructura" class="form-select" required>
                            <option value="" selected="selected">---------</option>
                            <option value="Comandante Adjunto">Comandante Adjunto</option>
                            <option value="Comandante Adjunto de Área">Comandante Adjunto de Área</option>
                            <option value="Comandante de Área">Comandante de Área</option>
                            <option value="Comandante del Incidente">Comandante del Incidente</option>
                            <option value="Comandante Unificado de Área">Comandante Unificado de Área</option>
                            <option value="Comando Unificado">Comando Unificado</option>
                            <option value="Coordinador Adjunto de la Rama">Coordinador Adjunto de la Rama</option>
                            <option value="Coordinador de Rama / Adjunto">Coordinador de Rama / Adjunto</option>
                            <option value="Coordinador Rama">Coordinador Rama</option>
                            <option value="Encargado A.C.V.">Encargado A.C.V.</option>
                            <option value="Encargado Área de Espera">Encargado Área de Espera</option>
                            <option value="Encargado Base">Encargado Base</option>
                            <option value="Encargado Campamento">Encargado Campamento</option>
                            <option value="Encargado Helibase">Encargado Helibase</option>
                            <option value="Encargado Helipunto">Encargado Helipunto</option>
                            <option value="Jefe Adjunto Sección">Jefe Adjunto Sección</option>
                            <option value="Jefe de Logística de Área">Jefe de Logística de Área</option>
                            <option value="Jefe Sección Admon. y Finanzas">Jefe Sección Admon. y Finanzas</option>
                            <option value="Jefe Sección Inteligencia">Jefe Sección Inteligencia</option>
                            <option value="Jefe Sección Logística">Jefe Sección Logística</option>
                            <option value="Jefe Sección Operaciones">Jefe Sección Operaciones</option>
                            <option value="Jefe Sección Planificación">Jefe Sección Planificación</option>
                            <option value="Líder de Equipo de Intervención">Líder de Equipo de Intervención</option>
                            <option value="Líder Fuerza de Tarea">Líder Fuerza de Tarea</option>
                            <option value="Líder Recurso Simple">Líder Recurso Simple</option>
                            <option value="Líder Unidad">Líder Unidad</option>
                            <option value="Oficial Enlace">Oficial Enlace</option>
                            <option value="Oficial Enlace de Área">Oficial Enlace de Área</option>
                            <option value="Oficial Información Pública">Oficial Información Pública</option>
                            <option value="Oficial Inteligencia">Oficial Inteligencia</option>
                            <option value="Oficial Seguridad">Oficial Seguridad</option>
                            <option value="Registrador de Recursos">Registrador de Recursos</option>
                            <option value="Supervisor División">Supervisor División</option>
                            <option value="Supervisor Grupo">Supervisor Grupo</option>
                            <option value="Técnico Especialista">Técnico Especialista</option>
                        </select>
                    </div>
                </div>

                <div id="responsablesContainer">
                    <!-- Aquí se agregarán dinámicamente los campos de responsables -->
                </div>

                <button type="button" id="agregarResponsable" class="btn btn-secondary mb-3">Agregar Responsable</button>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="elaborado_por" class="form-label">Elaborado por:</label>
                        <select id="elaborado_por" name="elaborado_por" class="form-select" required>
                            <option value="">Seleccione elaborador</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="aprobado_por" class="form-label">Aprobado por:</label>
                        <select id="aprobado_por" name="aprobado_por" class="form-select" required>
                            <option value="">Seleccione aprobador</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_asignacion = urlParams.get('id_asignacion');
            $('#id_asignacion').val(id_asignacion);

            $('#agregarResponsable').click(function() {
                agregarCamposResponsable();
            });

            $('#asignacionesTacticasForm').submit(function(e) {
                e.preventDefault();
                actualizarAsignacionYResponsables();
            });

            $('.select2').select2({
                width: '100%',
                placeholder: "Seleccione una opción",
                allowClear: true
            });

            cargarDatosAsignacion(id_asignacion);

            // Cargar periodos, elaboradores y aprobadores
            const id_incidente = $('#id_incidente').val();
            
            // Cargar periodos
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_periodos',
                    id_incidente: id_incidente
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var select = $('#periodo');
                        $.each(response.periodos, function(i, periodo) {
                            select.append($('<option></option>').val(periodo).text(periodo));
                        });
                        select.trigger('change');
                    } else {
                        console.error('Error al cargar periodos:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de periodos');
                }
            });

            // Cargar elaboradores y aprobadores
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_elaboradores',
                    id_incidente: id_incidente
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var selectElaborador = $('#elaborado_por');
                        var selectAprobador = $('#aprobado_por');
                        $.each(response.elaboradores, function(i, elaborador) {
                            selectElaborador.append($('<option></option>').val(elaborador).text(elaborador));
                            selectAprobador.append($('<option></option>').val(elaborador).text(elaborador));
                        });
                        selectElaborador.trigger('change');
                        selectAprobador.trigger('change');
                    } else {
                        console.error('Error al cargar elaboradores:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de elaboradores');
                }
            });
        });

        function cargarDatosAsignacion(id_asignacion) {
            if (!id_asignacion) {
                console.error('ID de asignación no proporcionado');
                toastr.error('Error: ID de asignación no válido');
                return;
            }

            console.log('Cargando datos para asignación ID:', id_asignacion);

            const id_incidente = $('#id_incidente').val();
            console.log('ID del incidente:', id_incidente);

            // Cargar periodos
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_periodos',
                    id_incidente: id_incidente
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var select = $('#periodo');
                        select.empty(); // Limpiar opciones existentes
                        select.append($('<option></option>').val('').text('Seleccione un periodo'));
                        $.each(response.periodos, function(i, periodo) {
                            select.append($('<option></option>').val(periodo).text(periodo));
                        });
                        select.trigger('change');
                    } else {
                        console.error('Error al cargar periodos:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de periodos');
                }
            });

            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                type: 'GET',
                data: {
                    action: 'obtener_asignacion_y_responsables',
                    id_asignacion: id_asignacion
                },
                dataType: 'json',
                beforeSend: function() {
                    console.log('Enviando solicitud...');
                },
                success: function(response) {
                    console.log('Respuesta recibida:', response);

                    if (response.success && response.data && response.data.asignacion) {
                        const asignacion = response.data.asignacion;
                        const responsables = response.data.responsables;

                        console.log('Asignación:', asignacion);
                        console.log('Responsables:', responsables);

                        // Rellenar los campos del formulario
                        $('#id_incidente').val(asignacion.id_incidente);
                        
                        $('#periodo').val(asignacion.periodo).trigger('change');
                        $('#posicion_estructura').val(asignacion.posicion_estructura).trigger('change');
                        $('#observaciones').val(asignacion.observaciones);
                        $('#elaborado_por').val(asignacion.elaborado_por).trigger('change');
                        $('#aprobado_por').val(asignacion.aprobado_por).trigger('change');

                        // Limpiar y agregar responsables
                        $('#responsablesContainer').empty();
                        if (Array.isArray(responsables) && responsables.length > 0) {
                            responsables.forEach(function(responsable) {
                                agregarCamposResponsable(responsable);
                            });
                        } else {
                            console.log('No hay responsables para mostrar');
                            // Agregar un responsable vacío por defecto
                            agregarCamposResponsable();
                        }

                        toastr.success('Datos cargados correctamente');
                    } else {
                        console.error('Error en la respuesta:', response);
                        toastr.error(response.message || 'Error al cargar los datos de la asignación');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud Ajax:', {
                        status: jqXHR.status,
                        textStatus: textStatus,
                        errorThrown: errorThrown,
                        responseText: jqXHR.responseText
                    });
                    toastr.error('Error al cargar los datos de la asignación: ' + textStatus);
                }
            });
        }

        function agregarCamposResponsable(responsable = null) {
            const index = $('#responsablesContainer').children().length;
            const responsableHtml = `
            <div class="row mb-3 responsable-row">
                <input type="hidden" name="responsables[${index}][id_responsable]" value="${responsable ? responsable.id_responsable : ''}">
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][nombre]" class="form-control" placeholder="Nombre" required value="${responsable ? responsable.nombre : ''}">
                </div>
                <div class="col-md-2">
                    <select name="responsables[${index}][funcion]" class="form-select select2" required>
                    <option value="" selected="selected">---------</option>
                    <option value="Comandante Adjunto" ${responsable && responsable.funcion === 'Comandante Adjunto' ? 'selected' : ''}>Comandante Adjunto</option>
                    <option value="Comandante Adjunto de Área" ${responsable && responsable.funcion === 'Comandante Adjunto de Área' ? 'selected' : ''}>Comandante Adjunto de Área</option>
                    <option value="Comandante de Área" ${responsable && responsable.funcion === 'Comandante de Área' ? 'selected' : ''}>Comandante de Área</option>
                    <option value="Comandante del Incidente" ${responsable && responsable.funcion === 'Comandante del Incidente' ? 'selected' : ''}>Comandante del Incidente</option>
                    <option value="Comandante Unificado de Área" ${responsable && responsable.funcion === 'Comandante Unificado de Área' ? 'selected' : ''}>Comandante Unificado de Área</option>
                    <option value="Comando Unificado" ${responsable && responsable.funcion === 'Comando Unificado' ? 'selected' : ''}>Comando Unificado</option>
                    <option value="Coordinador Adjunto de la Rama" ${responsable && responsable.funcion === 'Coordinador Adjunto de la Rama' ? 'selected' : ''}>Coordinador Adjunto de la Rama</option>
                    <option value="Coordinador de Rama / Adjunto" ${responsable && responsable.funcion === 'Coordinador de Rama / Adjunto' ? 'selected' : ''}>Coordinador de Rama / Adjunto</option>
                    <option value="Coordinador Rama" ${responsable && responsable.funcion === 'Coordinador Rama' ? 'selected' : ''}>Coordinador Rama</option>
                    <option value="Encargado A.C.V." ${responsable && responsable.funcion === 'Encargado A.C.V.' ? 'selected' : ''}>Encargado A.C.V.</option>
                    <option value="Encargado Área de Espera" ${responsable && responsable.funcion === 'Encargado Área de Espera' ? 'selected' : ''}>Encargado Área de Espera</option>
                    <option value="Encargado Base" ${responsable && responsable.funcion === 'Encargado Base' ? 'selected' : ''}>Encargado Base</option>
                    <option value="Encargado Campamento" ${responsable && responsable.funcion === 'Encargado Campamento' ? 'selected' : ''}>Encargado Campamento</option>
                    <option value="Encargado Helibase" ${responsable && responsable.funcion === 'Encargado Helibase' ? 'selected' : ''}>Encargado Helibase</option>
                    <option value="Encargado Helipunto" ${responsable && responsable.funcion === 'Encargado Helipunto' ? 'selected' : ''}>Encargado Helipunto</option>
                    <option value="Jefe Adjunto Sección" ${responsable && responsable.funcion === 'Jefe Adjunto Sección' ? 'selected' : ''}>Jefe Adjunto Sección</option>
                    <option value="Jefe de Logística de Área" ${responsable && responsable.funcion === 'Jefe de Logística de Área' ? 'selected' : ''}>Jefe de Logística de Área</option>
                    <option value="Jefe Sección Admon. y Finanzas" ${responsable && responsable.funcion === 'Jefe Sección Admon. y Finanzas' ? 'selected' : ''}>Jefe Sección Admon. y Finanzas</option>
                    <option value="Jefe Sección Inteligencia" ${responsable && responsable.funcion === 'Jefe Sección Inteligencia' ? 'selected' : ''}>Jefe Sección Inteligencia</option>
                    <option value="Jefe Sección Logística" ${responsable && responsable.funcion === 'Jefe Sección Logística' ? 'selected' : ''}>Jefe Sección Logística</option>
                    <option value="Jefe Sección Operaciones" ${responsable && responsable.funcion === 'Jefe Sección Operaciones' ? 'selected' : ''}>Jefe Sección Operaciones</option>
                    <option value="Jefe Sección Planificación" ${responsable && responsable.funcion === 'Jefe Sección Planificación' ? 'selected' : ''}>Jefe Sección Planificación</option>
                    <option value="Líder de Equipo de Intervención" ${responsable && responsable.funcion === 'Líder de Equipo de Intervención' ? 'selected' : ''}>Líder de Equipo de Intervención</option>
                    <option value="Líder Fuerza de Tarea" ${responsable && responsable.funcion === 'Líder Fuerza de Tarea' ? 'selected' : ''}>Líder Fuerza de Tarea</option>
                    <option value="Líder Recurso Simple" ${responsable && responsable.funcion === 'Líder Recurso Simple' ? 'selected' : ''}>Líder Recurso Simple</option>
                    <option value="Líder Unidad" ${responsable && responsable.funcion === 'Líder Unidad' ? 'selected' : ''}>Líder Unidad</option>
                    <option value="Oficial Enlace" ${responsable && responsable.funcion === 'Oficial Enlace' ? 'selected' : ''}>Oficial Enlace</option>
                    <option value="Oficial Enlace de Área" ${responsable && responsable.funcion === 'Oficial Enlace de Área' ? 'selected' : ''}>Oficial Enlace de Área</option>
                    <option value="Oficial Información Pública" ${responsable && responsable.funcion === 'Oficial Información Pública' ? 'selected' : ''}>Oficial Información Pública</option>
                    <option value="Oficial Inteligencia" ${responsable && responsable.funcion === 'Oficial Inteligencia' ? 'selected' : ''}>Oficial Inteligencia</option>
                    <option value="Oficial Seguridad" ${responsable && responsable.funcion === 'Oficial Seguridad' ? 'selected' : ''}>Oficial Seguridad</option>
                    <option value="Registrador de Recursos" ${responsable && responsable.funcion === 'Registrador de Recursos' ? 'selected' : ''}>Registrador de Recursos</option>
                    <option value="Supervisor División" ${responsable && responsable.funcion === 'Supervisor División' ? 'selected' : ''}>Supervisor División</option>
                    <option value="Supervisor Grupo" ${responsable && responsable.funcion === 'Supervisor Grupo' ? 'selected' : ''}>Supervisor Grupo</option>
                    <option value="Técnico Especialista" ${responsable && responsable.funcion === 'Técnico Especialista' ? 'selected' : ''}>Técnico Especialista</option>
                </select>                
                </div>
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][asignacion_tactica]" class="form-control" placeholder="Asignación Táctica" required value="${responsable ? responsable.asignacion_tactica : ''}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][ubicacion]" class="form-control" placeholder="Ubicación" required value="${responsable ? responsable.ubicacion : ''}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="responsables[${index}][no_personas]" class="form-control" placeholder="Nº Personas" required value="${responsable ? responsable.no_personas : ''}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger eliminar-responsable">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;
            $('#responsablesContainer').append(responsableHtml);

            $('.eliminar-responsable').click(function() {
                $(this).closest('.responsable-row').remove();
            });

            $(`select[name="responsables[${index}][funcion]"]`).select2({
                width: '100%',
                placeholder: "Seleccione una opción",
                allowClear: true
            });
        }

        function actualizarAsignacionYResponsables() {
            const formData = new FormData($('#asignacionesTacticasForm')[0]);
            formData.append('action', 'actualizar_asignacion_y_responsables');

            const responsables = [];
            $('.responsable-row').each(function(index) {
                const responsable = {
                    id_responsable: $(`input[name="responsables[${index}][id_responsable]"]`).val(),
                    nombre: $(`input[name="responsables[${index}][nombre]"]`).val(),
                    funcion: $(`select[name="responsables[${index}][funcion]"]`).val(),
                    asignacion_tactica: $(`input[name="responsables[${index}][asignacion_tactica]"]`).val(),
                    ubicacion: $(`input[name="responsables[${index}][ubicacion]"]`).val(),
                    no_personas: $(`input[name="responsables[${index}][no_personas]"]`).val()
                };
                responsables.push(responsable);
            });

            formData.append('responsables', JSON.stringify(responsables));

            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            var idIncidente = $('#id_incidente').val();
                            window.location.href = 'bom_asignaciones.php?page=sci204&id_incidente=' + idIncidente;
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    toastr.error('Error al actualizar la asignación y responsables');
                }
            });
        }
    </script>
</body>

</html>