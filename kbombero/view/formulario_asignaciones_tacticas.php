<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones Tácticas</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_select2.css">
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
    <custom-header
        incidente-nombre=""
        incidente-cerrado="false">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h2>Asignaciones Tácticas</h2>

            <form id="asignacionesTacticasForm">
                <input type="hidden" id="id_incidente" name="id_incidente" value="">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="periodo" class="form-label">Periodo:</label>
                        <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($_GET['id_incidente'] ?? ''); ?>">
                        <select id="periodo" name="periodo" required>
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

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label for="elaborado_por" class="form-label">Elaborado por:</label>
                        <select id="elaborado_por" name="elaborado_por" class="form-select "  required>
                            <option value="">Seleccione un elaborador</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="aprobado_por" class="form-label">Aprobado por:</label>
                        <select id="aprobado_por" name="aprobado_por" class="form-select " required>
                            <option value="">Seleccione aprobador</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_incidente = urlParams.get('id_incidente');
            $('#id_incidente').val(id_incidente);

            $('#agregarResponsable').click(function() {
                agregarCamposResponsable();
            });

            $('#asignacionesTacticasForm').submit(function(e) {
                e.preventDefault();
                guardarAsignacionYResponsables();
            });

            $('.select2').select2({
                width: '100%',
                placeholder: "Seleccione una opción",
                allowClear: true
            });
        });

        function agregarCamposResponsable() {
            const index = $('#responsablesContainer').children().length;
            const responsableHtml = `
            <div class="row mb-3 responsable-row">
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][nombre]" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-2">
                    <select name="responsables[${index}][funcion]" class="form-select " required>
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
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][asignacion_tactica]" class="form-control" placeholder="Asignación Táctica" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="responsables[${index}][ubicacion]" class="form-control" placeholder="Ubicación" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="responsables[${index}][no_personas]" class="form-control" placeholder="Nº Personas" required>
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

        function guardarAsignacionYResponsables() {
            const formData = new FormData($('#asignacionesTacticasForm')[0]);
            formData.append('action', 'guardar_asignacion_y_responsables');

            const responsables = [];
            $('.responsable-row').each(function(index) {
                const responsable = {
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
                        $('#asignacionesTacticasForm')[0].reset();
                        $('#responsablesContainer').empty();
                        $('.select2').val(null).trigger('change');
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
                    toastr.error('Error al guardar la asignación y responsables');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var id_incidente = $('#id_incidente').val();

            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_elaboradores'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var select = $('#elaborado_por');
                        $.each(response.elaboradores, function(i, elaborador) {
                            select.append($('<option></option>').val(elaborador).text(elaborador));
                        });
                    } else {
                        console.error('Error al cargar elaboradores:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de elaboradores');
                }
            });
            //
            
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_elaboradores'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var select = $('#aprobado_por');
                        $.each(response.elaboradores, function(i, elaborador) {
                            select.append($('<option></option>').val(elaborador).text(elaborador));
                        });
                    } else {
                        console.error('Error al cargar elaboradores:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de elaboradores');
                }
            });
            //
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
                    } else {
                        console.error('Error al cargar periodos:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de periodos');
                }
            });
        });
    </script>
</body>

</html>