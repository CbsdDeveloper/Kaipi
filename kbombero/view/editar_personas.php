<?php
require_once '../controller/Controller_Personas.php';
$controller = new ControllerPersonas();
ini_set('display_errors', 0);
error_reporting(0);

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
$incidente = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $persona = $controller->obtenerPorId($id);
    if (!$persona) {
        echo "Persona no encontrada.";
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
    <title>Editar Persona</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>

    </style>
</head>

<body class="colorB">
    <custom-header></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <form id="editarPersonaForm">
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">
                <input type="hidden" name="action" value="actualizar">
                <input type="hidden" name="id" value="<?php echo $persona['id']; ?>">
                <div class="row">
                    <div class="col-xl-8 col-md-12 col-sm-12">
                        <label for="nombre" class="form-label">Nombre de la persona:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($persona['nombre']); ?>" required>
                    </div>

                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="">Seleccione</option>
                            <option value="masculino" <?php if (trim($persona['sexo']) === 'masculino') echo 'selected'; ?>>Masculino</option>
                            <option value="femenino" <?php if (trim($persona['sexo']) === 'femenino') echo 'selected'; ?>>Femenino</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" value="<?php echo htmlspecialchars($persona['edad']); ?>" required>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <label for="clasificacion" class="form-label">Clasificación:</label>
                        <select class="form-select" id="clasificacion" name="clasificacion" required>
                            <option value="">Seleccione</option>
                            <option value="Rojo" <?php echo ($persona['clasificacion'] == 'Rojo') ? 'selected' : ''; ?>>Rojo</option>
                            <option value="Amarillo" <?php echo ($persona['clasificacion'] == 'Amarillo') ? 'selected' : ''; ?>>Amarillo</option>
                            <option value="Verde" <?php echo ($persona['clasificacion'] == 'Verde') ? 'selected' : ''; ?>>Verde</option>
                            <option value="Negro" <?php echo ($persona['clasificacion'] == 'Negro') ? 'selected' : ''; ?>>Negro</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" value="<?php echo date('Y-m-d\TH:i', strtotime($persona['fecha_hora'])); ?>" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="lugar_traslado" class="form-label">Lugar de traslado:</label>
                        <input type="text" class="form-control" id="lugar_traslado" name="lugar_traslado" value="<?php echo htmlspecialchars($persona['lugar_traslado']); ?>" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="trasladado_por" class="form-label">Trasladado por:</label>
                        <input type="text" class="form-control" id="trasladado_por" name="trasladado_por" value="<?php echo htmlspecialchars($persona['trasladado_por']); ?>" required>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="probable_diagnostico" class="form-label">Probable Diagnóstico:</label>
                        <textarea class="form-control" id="probable_diagnostico" name="probable_diagnostico" rows="3" required><?php echo htmlspecialchars($persona['probable_diagnostico']); ?></textarea>
                    </div>
                </div>
                <div class="form-buttons">
                    <a href="../view/lista_personas.php?id_incidente=<?php echo htmlspecialchars($id_incidente); ?>" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editarPersonaForm').submit(function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller_Personas.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = 'lista_personas.php?id_incidente=' + idIncidente;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Status: ' + status + ', Error: ' + error);
                        alert('Persona actualizada con éxito');
                        window.location.href = 'lista_personas.php?id_incidente=' + idIncidente;
                    }
                });
            });
        });
    </script>
    ?>
</body>

</html>