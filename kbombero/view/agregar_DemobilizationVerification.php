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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Verificación de Desmovilización</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body class="colorB">
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci'] ?? ''); ?>"
        incidente-cerrado="<?php echo isset($incidente['estatus']) && $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Registro: Verificación de Desmovilización</h6><br>
            <form id="agregarVerificacionForm">
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo $id_incidente; ?>">
                <input type="hidden" name="action" value="add">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="periodo" class="form-label">Periodo:</label>
                        <select class="form-select select2" id="periodo" name="periodo" required>
                            <option value="">Seleccione un periodo</option>
                        </select>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="fecha_hora" class="form-label">Desmovilización (Fecha y Hora):</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="unidad_personal" class="form-label">Unidad/Personal desmovilizado:</label>
                        <textarea class="form-control" id="unidad_personal" name="unidad_personal" rows="3" required></textarea>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="notas" class="form-label">Notas:</label>
                        <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="elaborado_por" class="form-label">Elaborado por:</label>
                        <select class="form-select" id="elaborado_por" name="elaborado_por" required>
                            <option value="">Seleccione elaborador</option>
                        </select>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="posicion" class="form-label">Posición:</label>
                        <select class="form-select" id="posicion" name="posicion" required>
                            <option value="">---------</option>
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
                <div class="form-buttons">
                    <button type="button" onclick="history.back()" class="btn btn-secondary">Volver</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Cargar periodos
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_periodos',
                    id_incidente: $('#id_incidente').val()
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

            // Cargar elaboradores 
            $.ajax({
                url: '../controller/Controller-asignaciones_tacticas.php',
                method: 'GET',
                data: {
                    action: 'obtener_elaboradores',
                    id_incidente: $('#id_incidente').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var selectElaborador = $('#elaborado_por');
                        $.each(response.elaboradores, function(i, elaborador) {
                            selectElaborador.append($('<option></option>').val(elaborador).text(elaborador));
                        });
                    } else {
                        console.error('Error al cargar elaboradores:', response.message);
                    }
                },
                error: function() {
                    console.error('Error en la solicitud AJAX de elaboradores');
                }
            });

            $('#agregarVerificacionForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../controller/Controller_DemobilizationVerification.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = 'listar_DemobilizationVerification.php?id_incidente=' + $('#id_incidente').val();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Status: ' + status + ', Error: ' + error);
                        console.log('Response:', xhr.responseText);
                        alert('Error al procesar la solicitud');
                    }
                });
            });
        });
    </script>
</body>

</html>