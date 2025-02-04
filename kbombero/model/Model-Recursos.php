<?php
session_start();

include('../../kconfig/Db.class.php');

function guardarRecursoBomberoSCI(
    $clase,
    $tipo,
    $fecha_hora_solicitud,
    $solicitado_por,
    $fecha_hora_arribo,
    $institucion,
    $matricula,
    $numero_personas,
    $estado_recurso,
    $asignado_a,
    $periodo_operacional,
    $fecha_hora_desmovilizacion,
    $responsable_desmovilizacion,
    $observaciones,
    $id_incidente
) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        $sql = "INSERT INTO bomberos.bombero_sci_recursos (
                    clase, tipo, fecha_hora_solicitud, solicitado_por, fecha_hora_arribo,
                    institucion, matricula, numero_personas, estado_recurso, asignado_a,
                    periodo_operacional, fecha_hora_desmovilizacion, responsable_desmovilizacion,
                    observaciones, id_incidente
                ) VALUES (
                    {$bd->sqlvalue_inyeccion($clase, true)},
                    {$bd->sqlvalue_inyeccion($tipo, true)},
                    {$bd->sqlvalue_inyeccion($fecha_hora_solicitud, true)},
                    {$bd->sqlvalue_inyeccion($solicitado_por, true)},
                    {$bd->sqlvalue_inyeccion($fecha_hora_arribo, true)},
                    {$bd->sqlvalue_inyeccion($institucion, true)},
                    {$bd->sqlvalue_inyeccion($matricula, true)},
                    {$bd->sqlvalue_inyeccion($numero_personas, true)},
                    {$bd->sqlvalue_inyeccion($estado_recurso, true)},
                    {$bd->sqlvalue_inyeccion($asignado_a, true)},
                    {$bd->sqlvalue_inyeccion($periodo_operacional, true)},
                    {$bd->sqlvalue_inyeccion($fecha_hora_desmovilizacion, true)},
                    {$bd->sqlvalue_inyeccion($responsable_desmovilizacion, true)},
                    {$bd->sqlvalue_inyeccion($observaciones, true)},
                    {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ) RETURNING id, fecha_hora_solicitud";

        $resultado = $bd->ejecutar($sql);
        $fila = $bd->obtener_fila($resultado);
        $recurso_id = $fila['id'];

        $bd->ejecutar("COMMIT");

        return $recurso_id;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en guardarRecursoBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function obtenerRecursosBomberoSCI($id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT *
                FROM bomberos.bombero_sci_recursos 
                WHERE id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ORDER BY id";

        $resultado = $bd->ejecutar($sql);
        $recursos = array();
        while ($fila = $bd->obtener_fila($resultado)) {
            $recursos[] = $fila;
        }
        return $recursos;
    } catch (Exception $e) {
        error_log("Error en obtenerRecursosBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function eliminarRecursoBomberoSCI($id_recurso)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        $sql_eliminar = "DELETE FROM bomberos.bombero_sci_recursos 
                         WHERE id = {$bd->sqlvalue_inyeccion($id_recurso, false)}";

        $resultado = $bd->ejecutar($sql_eliminar);

        $bd->ejecutar("COMMIT");

        if ($bd->filas_afectadas($resultado) > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en eliminarRecursoBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function duplicarRecursoBomberoSCI($id_recurso)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Obtener los datos del recurso original
        $sql_original = "SELECT * FROM bomberos.bombero_sci_recursos WHERE id = {$bd->sqlvalue_inyeccion($id_recurso, false)}";
        $resultado_original = $bd->ejecutar($sql_original);
        $recurso_original = $bd->obtener_fila($resultado_original);

        if (!$recurso_original) {
            throw new Exception("Recurso original no encontrado");
        }

        // Insertar el nuevo recurso con los mismos datos
        $sql_insertar = "INSERT INTO bomberos.bombero_sci_recursos (
            clase, tipo, fecha_hora_solicitud, solicitado_por, fecha_hora_arribo,
            institucion, matricula, numero_personas, estado_recurso, asignado_a,
            periodo_operacional, fecha_hora_desmovilizacion, responsable_desmovilizacion,
            observaciones, id_incidente
        ) VALUES (
            {$bd->sqlvalue_inyeccion($recurso_original['clase'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['tipo'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['fecha_hora_solicitud'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['solicitado_por'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['fecha_hora_arribo'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['institucion'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['matricula'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['numero_personas'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['estado_recurso'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['asignado_a'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['periodo_operacional'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['fecha_hora_desmovilizacion'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['responsable_desmovilizacion'], true)},
            {$bd->sqlvalue_inyeccion($recurso_original['observaciones'] . ' (Duplicado)', true)},
            {$bd->sqlvalue_inyeccion($recurso_original['id_incidente'], false)}
        ) RETURNING id";

        $resultado_insertar = $bd->ejecutar($sql_insertar);
        $fila_insertada = $bd->obtener_fila($resultado_insertar);
        $nuevo_recurso_id = $fila_insertada['id'];

        $bd->ejecutar("COMMIT");

        return $nuevo_recurso_id;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en duplicarRecursoBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function obtenerRecursoBomberoSCI($id_recurso)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT *, 
                TO_CHAR(fecha_creacion, 'DD/MM/YYYY HH24:MI:SS') as fecha_creacion_formatted,
                TO_CHAR(fecha_edicion, 'DD/MM/YYYY HH24:MI:SS') as fecha_edicion_formatted 
                FROM bomberos.bombero_sci_recursos 
                WHERE id = {$bd->sqlvalue_inyeccion($id_recurso, false)}";

        $resultado = $bd->ejecutar($sql);
        return $bd->obtener_fila($resultado);
    } catch (Exception $e) {
        error_log("Error en obtenerRecursoBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function actualizarRecursoBomberoSCI(
    $id,
    $clase,
    $tipo,
    $fecha_hora_solicitud,
    $solicitado_por,
    $fecha_hora_arribo,
    $institucion,
    $matricula,
    $numero_personas,
    $estado_recurso,
    $asignado_a,
    $periodo_operacional,
    $fecha_hora_desmovilizacion,
    $responsable_desmovilizacion,
    $observaciones,
    $id_incidente
) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        $sql = "UPDATE bomberos.bombero_sci_recursos SET
                    clase = {$bd->sqlvalue_inyeccion($clase, true)},
                    tipo = {$bd->sqlvalue_inyeccion($tipo, true)},
                    fecha_hora_solicitud = {$bd->sqlvalue_inyeccion($fecha_hora_solicitud, true)},
                    solicitado_por = {$bd->sqlvalue_inyeccion($solicitado_por, true)},
                    fecha_hora_arribo = {$bd->sqlvalue_inyeccion($fecha_hora_arribo, true)},
                    institucion = {$bd->sqlvalue_inyeccion($institucion, true)},
                    matricula = {$bd->sqlvalue_inyeccion($matricula, true)},
                    numero_personas = {$bd->sqlvalue_inyeccion($numero_personas, true)},
                    estado_recurso = {$bd->sqlvalue_inyeccion($estado_recurso, true)},
                    asignado_a = {$bd->sqlvalue_inyeccion($asignado_a, true)},
                    periodo_operacional = {$bd->sqlvalue_inyeccion($periodo_operacional, true)},
                    fecha_hora_desmovilizacion = {$bd->sqlvalue_inyeccion($fecha_hora_desmovilizacion, true)},
                    responsable_desmovilizacion = {$bd->sqlvalue_inyeccion($responsable_desmovilizacion, true)},
                    observaciones = {$bd->sqlvalue_inyeccion($observaciones, true)},
                    id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)},
                    fecha_edicion = CURRENT_TIMESTAMP
                WHERE id = {$bd->sqlvalue_inyeccion($id, false)}";

        $resultado = $bd->ejecutar($sql);

        $bd->ejecutar("COMMIT");

        return $bd->filas_afectadas($resultado) > 0;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en actualizarRecursoBomberoSCI: " . $e->getMessage());
        return false;
    }
}

function obtenerIncidentePorId($id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    // Consulta para obtener el incidente específico
    $sql = "SELECT id_incidentes, nombre_inci, lugar_inci, municipio_canton, localidad, estatus, fecha_hora_inci, fecha_cierre_oper 
            FROM bomberos.incidentes_bom 
            WHERE id_incidentes = {$bd->sqlvalue_inyeccion($id_incidente, true)}";

    $resultado = $bd->ejecutar($sql);

    // Devuelve solo una fila (un incidente)
    return $bd->obtener_array($resultado);
}