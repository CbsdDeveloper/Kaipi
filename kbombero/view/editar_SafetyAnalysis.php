<?php
session_start();
ini_set('display_errors', 0);
error_reporting(0);
require_once '../controller/Controller_SafetyAnalysis.php';
$controller = new ControllerSafetyAnalysis();
$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
$incidente = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $analisis = $controller->getById($id);
    if (!$analisis) {
        echo "Análisis de seguridad no encontrado.";
        exit;
    }
} else {
    echo "ID no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Análisis de Seguridad</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body>
    <custom-header></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Editar Análisis de Seguridad</h6><br>
            <form id="editarAnalisisForm">

                <!-- Fechas de creacion y edicion -->
                <div class="edit-info mb-4">
                    <div class="edit-info-cuadro">
                        <i class="fas fa-plus-square"></i>
                        <span id="created-info">Creado: <?php echo $analisis['fecha_creacion_formatted']; ?></span>
                    </div>
                    <div class="edit-info-cuadro">
                        <i class="fas fa-edit"></i>
                        <span id="edited-info">Última edición: <?php echo $analisis['fecha_edicion_formatted']; ?></span>
                    </div>
                </div>
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo $_GET['id_incidente'] ?? ''; ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($analisis['id_analisis_seguridad']) ?>">
                <input type="hidden" name="action" value="edit">

                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="area" class="form-label">Área:</label>
                        <input type="text" class="form-control" id="area" name="area" value="<?= htmlspecialchars($analisis['area']) ?>" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="riesgo" class="form-label">Riesgo:</label>
                        <input type="text" class="form-control" id="riesgo" name="riesgo" value="<?= htmlspecialchars($analisis['riesgo']) ?>" required>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="accion_mitigante" class="form-label">Acción Mitigante:</label>
                        <textarea class="form-control" id="accion_mitigante" name="accion_mitigante" rows="3" required><?= htmlspecialchars($analisis['accion_mitigante']) ?></textarea>
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
                    <a href="listar_SafetyAnalysis.php?id_incidente=<?php echo htmlspecialchars($id_incidente); ?>" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editarAnalisisForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../controller/Controller_SafetyAnalysis.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#edited-info').text('Última edición: ' + response.fecha_edicion);
                            window.location.href = 'listar_SafetyAnalysis.php?id_incidente=' + id_incidente;
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