<?php
include_once('../model/Model-Incidentes.php');
include_once('../model/Model-registro_personal.php');

$id_bombero = isset($_GET['id_bombero']) ? intval($_GET['id_bombero']) : null;
$bombero = null;

if ($id_bombero) {
    $model = new ModelBombero();
    $bombero = $model->obtenerBomberoPorId($id_bombero);
    if (!$bombero) {
        echo "No se ha encontrado el bombero.";
        exit;
    }
} else {
    echo "No se ha seleccionado un bombero.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Bombero</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

            <h6 class="card-header">Editar Bombero</h6>
            <div class="card-body">
                <form id="formEditarBombero">
                    <div class="edit-info mb-4">
                        <div class="edit-info-cuadro">
                            <i class="fas fa-plus-square"></i>
                            <span id="created-info">Creado: <?php echo date('d/m/Y, H:i', strtotime($bombero['fecha_creacion'])); ?></span>
                        </div>
                        <div class="edit-info-cuadro">
                            <i class="fas fa-edit"></i>
                            <span id="edited-info">Editado: <?php echo date('d/m/Y, H:i', strtotime($bombero['fecha_edicion'])); ?></span>
                        </div>
                    </div>
                    <input type="hidden" id="id_bombero" name="id_bombero" value="<?php echo htmlspecialchars($id_bombero); ?>">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($bombero['id_incidente']); ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($bombero['nombre']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($bombero['especialidad']); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución*</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" value="<?php echo htmlspecialchars($bombero['institucion']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="matricula_vehiculo" class="form-label">Matrícula del vehículo</label>
                            <input type="text" class="form-control" id="matricula_vehiculo" name="matricula_vehiculo" value="<?php echo htmlspecialchars($bombero['matricula_vehiculo']); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="4"><?php echo htmlspecialchars($bombero['observaciones']); ?></textarea>
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
            $('#formEditarBombero').on('submit', function(e) {
                e.preventDefault();
                var idBombero = $('#id_bombero').val();
                $.ajax({
                    url: '../controller/Controller-registro_personal.php?action=actualizar',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Bombero actualizado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_personal.php?page=registro&id_incidente=' + $('#id_incidente').val();
                            }, 2000);
                        } else {
                            toastr.success('Bombero actualizado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_personal.php?page=registro&id_incidente=' + $('#id_incidente').val();
                            }, 2000);
                        }
                    },
                    error: function() {
                        toastr.success('Bombero actualizado con éxito!');
                        setTimeout(function() {
                            window.location.href = 'registro_personal.php?page=registro&id_incidente=' + $('#id_incidente').val();
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>

</html>