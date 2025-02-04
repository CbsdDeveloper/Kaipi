<?php
session_start();

include('../../kconfig/Db.class.php');

function guardarAsignacionYResponsables($datos_asignacion, $responsables) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Insertar asignación
        $sql_asignacion = "INSERT INTO bomberos.bombero_sci_asignaciones (
                               periodo, posicion_estructura, observaciones, elaborado_por, aprobado_por, id_incidente
                           ) VALUES (
                               {$bd->sqlvalue_inyeccion($datos_asignacion['periodo'], true)},
                               {$bd->sqlvalue_inyeccion($datos_asignacion['posicion_estructura'], true)},
                               {$bd->sqlvalue_inyeccion($datos_asignacion['observaciones'], true)},
                               {$bd->sqlvalue_inyeccion($datos_asignacion['elaborado_por'], true)},
                               {$bd->sqlvalue_inyeccion($datos_asignacion['aprobado_por'], true)},
                               {$bd->sqlvalue_inyeccion($datos_asignacion['id_incidente'], false)}
                           ) RETURNING id_asignacion";

        $resultado_asignacion = $bd->ejecutar($sql_asignacion);
        $fila_asignacion = $bd->obtener_fila($resultado_asignacion);
        $id_asignacion = $fila_asignacion['id_asignacion'];

        // Insertar responsables
        foreach ($responsables as $responsable) {
            $sql_responsable = "INSERT INTO bomberos.bombero_sci_responsables (
                                    id_asignacion, nombre, funcion, asignacion_tactica, ubicacion, no_personas
                                ) VALUES (
                                    {$bd->sqlvalue_inyeccion($id_asignacion, false)},
                                    {$bd->sqlvalue_inyeccion($responsable['nombre'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['funcion'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['asignacion_tactica'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['ubicacion'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['no_personas'], false)}
                                )";
            $bd->ejecutar($sql_responsable);
        }

        $bd->ejecutar("COMMIT");
        return $id_asignacion;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en guardarAsignacionYResponsables: " . $e->getMessage());
        return false;
    }
}

function obtenerAsignacionesYResponsables($id_incidente) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT a.*, 
                TO_CHAR(a.fecha_creacion, 'DD/MM/YYYY HH24:MI:SS') as fecha_creacion_formatted,
                TO_CHAR(a.fecha_modificacion, 'DD/MM/YYYY HH24:MI:SS') as fecha_modificacion_formatted,
                r.id_responsable, r.nombre, r.funcion, r.asignacion_tactica, r.ubicacion, r.no_personas
                FROM bomberos.bombero_sci_asignaciones a
                LEFT JOIN bomberos.bombero_sci_responsables r ON a.id_asignacion = r.id_asignacion
                WHERE a.id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ORDER BY a.id_asignacion, r.id_responsable";

        $resultado = $bd->ejecutar($sql);
        $asignaciones = array();
        while ($fila = $bd->obtener_fila($resultado)) {
            $id_asignacion = $fila['id_asignacion'];
            if (!isset($asignaciones[$id_asignacion])) {
                $asignaciones[$id_asignacion] = array(
                    'asignacion' => $fila,
                    'responsables' => array()
                );
            }
            if ($fila['id_responsable']) {
                $asignaciones[$id_asignacion]['responsables'][] = array(
                    'id_responsable' => $fila['id_responsable'],
                    'nombre' => $fila['nombre'],
                    'funcion' => $fila['funcion'],
                    'asignacion_tactica' => $fila['asignacion_tactica'],
                    'ubicacion' => $fila['ubicacion'],
                    'no_personas' => $fila['no_personas']
                );
            }
        }
        return array_values($asignaciones);
    } catch (Exception $e) {
        error_log("Error en obtenerAsignacionesYResponsables: " . $e->getMessage());
        return false;
    }
}



function obtenerAsignacionYResponsables($id_asignacion) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        // Validar el ID
        $id_asignacion = intval($id_asignacion);
        if ($id_asignacion <= 0) {
            error_log("ID de asignación inválido: " . $id_asignacion);
            return false;
        }

        // Primero verificar si la asignación existe
        $sql_verificacion = "SELECT COUNT(*) as total FROM bomberos.bombero_sci_asignaciones 
                           WHERE id_asignacion = " . $bd->sqlvalue_inyeccion($id_asignacion, false);
        $result_verificacion = $bd->ejecutar($sql_verificacion);
        $fila_verificacion = $bd->obtener_fila($result_verificacion);
        
        if ($fila_verificacion['total'] == 0) {
            error_log("No se encontró la asignación con ID: " . $id_asignacion);
            return false;
        }

        $sql = "SELECT a.*, 
        TO_CHAR(a.fecha_creacion, 'DD/MM/YYYY HH24:MI:SS') as fecha_creacion_formatted,
        TO_CHAR(a.fecha_modificacion, 'DD/MM/YYYY HH24:MI:SS') as fecha_modificacion_formatted,
        r.id_responsable, r.nombre, r.funcion, r.asignacion_tactica, r.ubicacion, r.no_personas
        FROM bomberos.bombero_sci_asignaciones a
        LEFT JOIN bomberos.bombero_sci_responsables r ON a.id_asignacion = r.id_asignacion
        WHERE a.id_asignacion = " . $bd->sqlvalue_inyeccion($id_asignacion, false);

        error_log("Ejecutando consulta SQL: " . $sql);

        $resultado = $bd->ejecutar($sql);
        if (!$resultado) {
            error_log("Error en la consulta SQL: " );
            return false;
        }

        $asignacion = null;
        $responsables = array();

        while ($fila = $bd->obtener_fila($resultado)) {
            if (!$asignacion) {
                $asignacion = array(
                    'id_asignacion' => $fila['id_asignacion'],
                    'periodo' => $fila['periodo'],
                    'posicion_estructura' => $fila['posicion_estructura'],
                    'observaciones' => $fila['observaciones'],
                    'elaborado_por' => $fila['elaborado_por'],
                    'aprobado_por' => $fila['aprobado_por'],
                    'id_incidente' => $fila['id_incidente'],
                    'fecha_creacion_formatted' => $fila['fecha_creacion_formatted'],
                    'fecha_modificacion_formatted' => $fila['fecha_modificacion_formatted']
                );
            }

            if ($fila['id_responsable']) {
                $responsables[] = array(
                    'id_responsable' => $fila['id_responsable'],
                    'nombre' => $fila['nombre'],
                    'funcion' => $fila['funcion'],
                    'asignacion_tactica' => $fila['asignacion_tactica'],
                    'ubicacion' => $fila['ubicacion'],
                    'no_personas' => $fila['no_personas']
                );
            }
        }

        error_log("Datos recuperados - Asignación: " . print_r($asignacion, true));
        error_log("Datos recuperados - Responsables: " . print_r($responsables, true));

        if (!$asignacion) {
            error_log("No se encontraron datos para la asignación ID: " . $id_asignacion);
            return false;
        }

        return array('asignacion' => $asignacion, 'responsables' => $responsables);
    } catch (Exception $e) {
        error_log("Error en obtenerAsignacionYResponsables: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        return false;
    }
}

function eliminarAsignacionYResponsables($id_asignacion) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Eliminar responsables
        $sql_eliminar_responsables = "DELETE FROM bomberos.bombero_sci_responsables 
                                      WHERE id_asignacion = {$bd->sqlvalue_inyeccion($id_asignacion, false)}";
        $bd->ejecutar($sql_eliminar_responsables);

        // Eliminar asignación
        $sql_eliminar_asignacion = "DELETE FROM bomberos.bombero_sci_asignaciones 
                                    WHERE id_asignacion = {$bd->sqlvalue_inyeccion($id_asignacion, false)}";
        $resultado = $bd->ejecutar($sql_eliminar_asignacion);

        $bd->ejecutar("COMMIT");

        return $bd->filas_afectadas($resultado) > 0;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en eliminarAsignacionYResponsables: " . $e->getMessage());
        return false;
    }
}

function actualizarAsignacionYResponsables($id_asignacion, $datos_asignacion, $responsables) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Actualizar asignación
        $sql_asignacion = "UPDATE bomberos.bombero_sci_asignaciones SET
                           periodo = {$bd->sqlvalue_inyeccion($datos_asignacion['periodo'], true)},
                           posicion_estructura = {$bd->sqlvalue_inyeccion($datos_asignacion['posicion_estructura'], true)},
                           observaciones = {$bd->sqlvalue_inyeccion($datos_asignacion['observaciones'], true)},
                           elaborado_por = {$bd->sqlvalue_inyeccion($datos_asignacion['elaborado_por'], true)},
                           aprobado_por = {$bd->sqlvalue_inyeccion($datos_asignacion['aprobado_por'], true)},
                           id_incidente = {$bd->sqlvalue_inyeccion($datos_asignacion['id_incidente'], false)},
                           fecha_modificacion = CURRENT_TIMESTAMP
                           WHERE id_asignacion = {$bd->sqlvalue_inyeccion($id_asignacion, false)}";
        $bd->ejecutar($sql_asignacion);

        // Eliminar responsables existentes
        $sql_eliminar_responsables = "DELETE FROM bomberos.bombero_sci_responsables 
                                      WHERE id_asignacion = {$bd->sqlvalue_inyeccion($id_asignacion, false)}";
        $bd->ejecutar($sql_eliminar_responsables);

        // Insertar nuevos responsables
        foreach ($responsables as $responsable) {
            $sql_responsable = "INSERT INTO bomberos.bombero_sci_responsables 
                                (id_asignacion, nombre, funcion, asignacion_tactica, ubicacion, no_personas)
                                VALUES (
                                    {$bd->sqlvalue_inyeccion($id_asignacion, false)},
                                    {$bd->sqlvalue_inyeccion($responsable['nombre'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['funcion'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['asignacion_tactica'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['ubicacion'], true)},
                                    {$bd->sqlvalue_inyeccion($responsable['no_personas'], false)}
                                )";
            $bd->ejecutar($sql_responsable);
        }

        $bd->ejecutar("COMMIT");
        return true;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en actualizarAsignacionYResponsables: " . $e->getMessage());
        return false;
    }
}
function obtenerElaboradoresPorPrograma($programa = '223') {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT razon 
                FROM public.view_nomina_rol
                WHERE programa = {$bd->sqlvalue_inyeccion($programa, true)} AND estado = 'S'";

        $resultado = $bd->ejecutar($sql);
        $elaboradores = array();
        while ($fila = $bd->obtener_fila($resultado)) {
            $elaboradores[] = $fila['razon'];
        }
        return $elaboradores;
    } catch (Exception $e) {
        error_log("Error en obtenerElaboradoresPorPrograma: " . $e->getMessage());
        return false;
    }
}
function obtenerPeriodos($id_incidente) {
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT CONCAT(id_bom_pai_datos_g, ' - ', fecha_hora_inicio, ' - ', fecha_hora_fin) AS periodo 
                FROM bomberos.bombero_sci_pai_dat_gen
                WHERE id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}";

        $resultado = $bd->ejecutar($sql);
        $periodos = array();
        while ($fila = $bd->obtener_fila($resultado)) {
            $periodos[] = $fila['periodo'];
        }
        return $periodos;
    } catch (Exception $e) {
        error_log("Error en obtenerPeriodos: " . $e->getMessage());
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
