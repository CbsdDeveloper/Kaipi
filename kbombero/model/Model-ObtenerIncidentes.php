<?php
session_start();
include('../../kconfig/Db.class.php');

// Establecemos la conexión a la base de datos
$bd = new Db;
$bd->conectar('', '', ''); // Asegúrate de llenar correctamente los parámetros de conexión

// Obtenemos los incidentes
function obtenerIncidentes() {
    global $bd; // Usamos la conexión global
    $sql = "SELECT id_incidentes, nombre_inci, fecha_hora_inci, fecha_cierre_oper, estatus FROM bomberos.incidentes_bom ORDER BY id_incidentes DESC";
    $resultado = $bd->ejecutar($sql);

    // Recoger los datos en un array
    $incidentes = [];
    while ($fila = $bd->obtener_array($resultado)) {
        $incidentes[] = $fila;
    }
    return $incidentes;
}

// Llamamos a la función y devolvemos el resultado en formato JSON
$incidentes = obtenerIncidentes();
header('Content-Type: application/json'); // Indica que la respuesta es JSON
echo json_encode($incidentes);

?>
