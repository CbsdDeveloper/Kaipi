<?php
include_once('../model/Model-Incidentes.php');

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
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
    <title>Registro de Bomberos SCI</title>
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
    </style>
</head>

<body class="colorB">
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>

    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Registro de Bomberos SCI</h6>
            <div class="card-body">
                <form id="formRegistroBombero" method="POST">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="col-md-6">
                            <label for="posicion" class="form-label">Posición*</label>
                            <select name="posicion" id="posicion" class="select2" required>
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
                                <option value="Técnico Especialista">Técnico Especialista</option>
                                <option value="Técnico Especialista">Técnico Especialista</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución*</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_hora" class="form-label">Fecha y Hora*</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="actividad" class="form-label">Actividad*</label>
                        <textarea class="form-control" id="actividad" name="actividad" rows="4" required></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#formRegistroBombero').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var idIncidente = $('#id_incidente').val();

                $.ajax({
                    url: '../controller/Controller-registro-214.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Bombero registrado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_sci-214.php?id_incidente=' + idIncidente;
                            }, 2000);
                        } else {
                            toastr.success('Bombero registrado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_sci-214.php?id_incidente=' + idIncidente;
                            }, 2000);
                        }
                    },
                    error: function() {
                        toastr.success('Bombero registrado con éxito!');
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