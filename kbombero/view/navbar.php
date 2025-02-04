<?php

session_start( ); 

include_once('../model/Model-Incidentes.php');

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : $_SESSION['id_incidente'];
$incidente = null;

if ($id_incidente) {
    $incidente = obtenerIncidentePorId($id_incidente);
    $_SESSION['id_incidente']  = $id_incidente;
} else {
    echo "No se ha seleccionado un incidente.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBSD - Sistema de Comando de Incidentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body>
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>

    <custom-menu></custom-menu>
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>

</html>