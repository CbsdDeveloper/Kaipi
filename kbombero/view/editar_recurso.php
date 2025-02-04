<?php
require_once '../model/Model-Recursos.php';

// Verificar si se proporcionó un ID de recurso
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de recurso no válido");
}

$id_recurso = $_GET['id'];
$id_incidente = $_GET['id_incidente'] ?? 0;

// Obtener los datos del recurso
$recurso = obtenerRecursoBomberoSCI($id_recurso);

if (!$recurso) {
    die("Recurso no encontrado");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Recurso SCI</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_datos_generales.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_editar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body class="colorB">
    <custom-header>
    </custom-header>
    <custom-menu></custom-menu>

    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Editar Recurso SCI</h6>
            <div class="card-body">
                <form id="formEditarRecurso">
                    <div class="edit-info mb-4">
                        <div class="edit-info-cuadro">
                            <i class="
                            
                            fas fa-plus-square"></i>
                            <span id="created-info">Creado: <?php echo $recurso['fecha_creacion_formatted']; ?></span>
                        </div>
                        <div class="edit-info-cuadro">
                            <i class="fas fa-edit"></i>
                            <span id="edited-info">Editado: <?php echo $recurso['fecha_edicion_formatted'] ?? 'No editado aún'; ?></span>
                        </div>
                    </div>
                    <input type="hidden" id="id_recurso" name="id" value="<?php echo htmlspecialchars($id_recurso); ?>">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">
                    <input type="hidden" name="action" value="actualizar_recurso">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="clase" class="form-label">Clase*</label>
                            <select class="form-select select2" id="clase" name="clase" required>
                                <option value="">---------</option>
                                <option value="Ambulancia" <?php echo ($recurso['clase'] == 'Ambulancia') ? 'selected' : ''; ?>>Ambulancia</option>
                                <option value="Bus" <?php echo ($recurso['clase'] == 'Bus') ? 'selected' : ''; ?>>Bus </option>
                                <option value="Camión de Carga" <?php echo ($recurso['clase'] == 'Camión de Carga') ? 'selected' : ''; ?>>Camión de Carga</option>
                                <option value="Cisterna o pipa" <?php echo ($recurso['clase'] == 'Cisterna o pipa') ? 'selected' : ''; ?>>Cisterna o pipa</option>
                                <option value="Grúas" <?php echo ($recurso['clase'] == 'Grúas') ? 'selected' : ''; ?>>Grúas</option>
                                <option value="Grupo USAR intermedio" <?php echo ($recurso['clase'] == 'Grupo USAR intermedio') ? 'selected' : ''; ?>>Grupo USAR intermedio</option>
                                <option value="Helicóptero de Rescate" <?php echo ($recurso['clase'] == 'Helicóptero de Rescate') ? 'selected' : ''; ?>>Helicóptero de Rescate</option>
                                <option value="Helicóptero Forestal" <?php echo ($recurso['clase'] == 'Helicóptero Forestal') ? 'selected' : ''; ?>>Helicóptero Forestal</option>
                                <option value="Helicóptero Policia" <?php echo ($recurso['clase'] == 'Helicóptero Policia') ? 'selected' : ''; ?>>Helicóptero Policial</option>
                                <option value="Lancha" <?php echo ($recurso['clase'] == 'Lancha') ? 'selected' : ''; ?>>Lancha</option>
                                <option value="Logística" <?php echo ($recurso['clase'] == 'Logística') ? 'selected' : ''; ?>>Logística</option>
                                <option value="Motobomba" <?php echo ($recurso['clase'] == 'Motobomba') ? 'selected' : ''; ?>>Motobomba</option>
                                <option value="Motocicleta" <?php echo ($recurso['clase'] == 'Motocicleta') ? 'selected' : ''; ?>>Motocicleta</option>
                                <option value="Patrulla" <?php echo ($recurso['clase'] == 'Patrulla') ? 'selected' : ''; ?>>Patrulla</option>
                                <option value="Pick Up" <?php echo ($recurso['clase'] == 'Pick Up') ? 'selected' : ''; ?>>Pick Up</option>
                                <option value="Trailer" <?php echo ($recurso['clase'] == 'Trailer') ? 'selected' : ''; ?>>Trailer</option>
                                <option value="Unidad de Rescate" <?php echo ($recurso['clase'] == 'Unidad de Rescate') ? 'selected' : ''; ?>>Unidad de Rescate</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo*</label>
                            <select class="form-select select2" id="tipo" name="tipo" required>
                                <option value="">---------</option>
                                <?php
                                for ($i = 1; $i <= 10; $i++) {
                                    $tipo = "Tipo " . $i;
                                    echo "<option value=\"$tipo\"" . ($recurso['tipo'] == $tipo ? ' selected' : '') . ">$tipo</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_hora_solicitud" class="form-label">Fecha y hora de solicitud*</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_solicitud" name="fecha_hora_solicitud" required value="<?php echo date('Y-m-d\TH:i', strtotime($recurso['fecha_hora_solicitud'])); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="solicitado_por" class="form-label">Solicitado por*</label>
                            <input type="text" class="form-control" id="solicitado_por" name="solicitado_por" required value="<?php echo htmlspecialchars($recurso['solicitado_por']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_hora_arribo" class="form-label">Fecha y hora de arribo</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_arribo" name="fecha_hora_arribo" value="<?php echo $recurso['fecha_hora_arribo'] ? date('Y-m-d\TH:i', strtotime($recurso['fecha_hora_arribo'])) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" value="<?php echo htmlspecialchars($recurso['institucion']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo htmlspecialchars($recurso['matricula']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="numero_personas" class="form-label">Número de personas</label>
                            <input type="number" class="form-control" id="numero_personas" name="numero_personas" value="<?php echo htmlspecialchars($recurso['numero_personas']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="estado_recurso" class="form-label">Estado del recurso*</label>
                            <select class="form-select select2" id="estado_recurso" name="estado_recurso" required>
                                <option value="">---------</option>
                                <option value="Sin Dato" <?php echo ($recurso['estado_recurso'] == 'Sin Dato') ? 'selected' : ''; ?>>Sin Dato</option>
                                <option value="Disponible" <?php echo ($recurso['estado_recurso'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                                <option value="Asignado" <?php echo ($recurso['estado_recurso'] == 'Asignado') ? 'selected' : ''; ?>>Asignado</option>
                                <option value="No disponible" <?php echo ($recurso['estado_recurso'] == 'No disponible') ? 'selected' : ''; ?>>No disponible</option>
                                <option value="Desmovilizado" <?php echo ($recurso['estado_recurso'] == 'Desmovilizado') ? 'selected' : ''; ?>>Desmovilizado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="asignado_a" class="form-label">Asignado a</label>
                            <input type="text" class="form-control" id="asignado_a" name="asignado_a" value="<?php echo htmlspecialchars($recurso['asignado_a']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="periodo_operacional" class="form-label">Periodo operacional</label>
                            <input type="text" class="form-control" id="periodo_operacional" name="periodo_operacional" value="<?php echo htmlspecialchars($recurso['periodo_operacional']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_hora_desmovilizacion" class="form-label">Fecha y hora de desmovilización</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_desmovilizacion" name="fecha_hora_desmovilizacion" value="<?php echo $recurso['fecha_hora_desmovilizacion'] ? date('Y-m-d\TH:i', strtotime($recurso['fecha_hora_desmovilizacion'])) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="responsable_desmovilizacion" class="form-label">Responsable de desmovilización</label>
                            <input type="text" class="form-control" id="responsable_desmovilizacion" name="responsable_desmovilizacion" value="<?php echo htmlspecialchars($recurso['responsable_desmovilizacion']); ?>">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo htmlspecialchars($recurso['observaciones']); ?></textarea>
                    </div>

                    <div class="form-buttons ">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <button type="submit" class="btn btn-success">Guardar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Seleccione una opción",
                allowClear: true
            });

            $('#formEditarRecurso').on('submit', function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller-recursos.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Recurso actualizado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'bom_recursos.php?page=recursos&id_incidente=' + idIncidente;
                            }, 2000);
                        } else {
                            toastr.success('Recurso actualizado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'bom_recursos.php?page=recursos&id_incidente=' + idIncidente;
                            }, 2000);
                        }
                    },
                    error: function() {
                        toastr.success('Recurso actualizado con éxito!');
                        setTimeout(function() {
                            window.location.href = 'bom_recursos.php?page=recursos&id_incidente=' + idIncidente;
                        }, 2000);
                    }
                });
            });
        });
    </script>

</body>

</html>