<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBSD - Gestión Bomberil</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>

<body class="colorB">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <custom-header></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Registro de nuevo incidente</h6><br>
            <form id="incidenteForm" action="../controller/Controller-incidente.php" method="POST">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="nombre">Nombre del Incidente *</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="lugar">Lugar del Incidente *</label>
                        <input type="text" class="form-control" name="lugar" id="lugar" required>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <label for="municipio">Municipio/Cantón *</label>
                        <select name="municipio" id="municipio" required>
                            <option value="" disabled selected>Seleccione una provincia</option>
                            <option value="azuay">Azuay</option>
                            <option value="bolivar">Bolívar</option>
                            <option value="canar">Cañar</option>
                            <option value="carchi">Carchi</option>
                            <option value="chimborazo">Chimborazo</option>
                            <option value="cotopaxi">Cotopaxi</option>
                            <option value="el-oro">El Oro</option>
                            <option value="esmeraldas">Esmeraldas</option>
                            <option value="galapagos">Galápagos</option>
                            <option value="guayas">Guayas</option>
                            <option value="imbabura">Imbabura</option>
                            <option value="loja">Loja</option>
                            <option value="los-rios">Los Ríos</option>
                            <option value="manabi">Manabí</option>
                            <option value="morona-santiago">Morona Santiago</option>
                            <option value="napo">Napo</option>
                            <option value="orellana">Orellana</option>
                            <option value="pastaza">Pastaza</option>
                            <option value="pichincha">Pichincha</option>
                            <option value="santa-elena">Santa Elena</option>
                            <option value="santo-domingo">Santo Domingo de los Tsáchilas</option>
                            <option value="sucumbios">Sucumbíos</option>
                            <option value="tungurahua">Tungurahua</option>
                            <option value="zamora-chinchipe">Zamora Chinchipe</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <label for="localidad">Localidad</label>
                        <input type="text" name="localidad" id="localidad" class="form-control">
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <label for="estatus">Estatus*</label>
                        <select name="estatus" id="estatus">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="CERRADO">CERRADO</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <label for="fecha_incidente">Fecha y hora del Incidente*</label>
                        <input type="datetime-local" name="fecha_incidente" id="fecha_incidente" class="form-control" required>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <label for="fecha_cierre">Fecha de cierre operacional (opcional)</label>
                        <input type="datetime-local" name="fecha_cierre" id="fecha_cierre" class="form-control">
                    </div>
                </div>
                <div class="form-buttons">
                    <a href="../view/inicio" class="btn btn-secondary">
                        Regresar
                    </a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>

            <script>
                document.getElementById('incidenteForm').onsubmit = function() {
                    var nombre = document.getElementById('nombre').value;
                    var lugar = document.getElementById('lugar').value;
                    var municipio = document.getElementById('municipio').value;
                    var estatus = document.getElementById('estatus').value;
                    var fecha_incidente = document.getElementById('fecha_incidente').value;

                    if (!nombre || !lugar || !municipio || !estatus || !fecha_incidente) {
                        alert('Error: Todos los campos obligatorios deben ser completados.');
                        return false;
                    }

                    return true;
                };
            </script>

        </div>
    </div>

</body>

</html>