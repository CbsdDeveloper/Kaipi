<?php
session_start();

include('../../kconfig/Db.class.php');

function insertarDatosGenerales(
    $evaluacion_inicial,
    $objetivos,
    $ubicacion_puesto_comando,
    $area_espera,
    $ruta_egreso,
    $ruta_ingreso,
    $mensaje_seguridad,
    $distribucion_canales_comunicacion,
    $datos_meteorologicos,
    $fecha_hora_preparacion,
    $id_incidente,
    $posicion,
    $elaborado_por
) {
    $bd = new Db;
    $bd->conectar('', '', '');

    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $email_usuario = $_SESSION['email'];
    } else {
        error_log("Email del usuario no está en la sesión.");
        return false;
    }

    $anio = date("Y");

    try {
        $sql = "INSERT INTO bomberos.bombero_sci_datos_generales (
            evaluacion_inicial, 
            ubicacion_puesto_comando, 
            area_espera, 
            ruta_egreso, 
            ruta_ingreso, 
            mensaje_seguridad, 
            distribucion_canales_comunicacion, 
            datos_meteorologicos, 
            fecha_hora_preparacion, 
            anio, 
            email_usuario,
            id_incidente,
            posicion,
            elaborado_por
        ) VALUES (
            {$bd->sqlvalue_inyeccion($evaluacion_inicial, true)},
            {$bd->sqlvalue_inyeccion($ubicacion_puesto_comando, true)},
            {$bd->sqlvalue_inyeccion($area_espera, true)},
            {$bd->sqlvalue_inyeccion($ruta_egreso, true)},
            {$bd->sqlvalue_inyeccion($ruta_ingreso, true)},
            {$bd->sqlvalue_inyeccion($mensaje_seguridad, true)},
            {$bd->sqlvalue_inyeccion($distribucion_canales_comunicacion, true)},
            {$bd->sqlvalue_inyeccion($datos_meteorologicos, true)},
            {$bd->sqlvalue_inyeccion($fecha_hora_preparacion, true)},
            {$bd->sqlvalue_inyeccion($anio, true)},
            {$bd->sqlvalue_inyeccion($email_usuario, true)},
            {$bd->sqlvalue_inyeccion($id_incidente, false)},
            {$bd->sqlvalue_inyeccion($posicion, true)},
            {$bd->sqlvalue_inyeccion($elaborado_por, true)}
        ) RETURNING id_bom_datos_g";
        $resultado = $bd->ejecutar($sql);
        $fila = $bd->obtener_fila($resultado);
        $id_bom_datos_g = $fila['id_bom_datos_g'];

        // Insertar los objetivos
        foreach ($objetivos as $obj) {
            $sql = "INSERT INTO bomberos.bombero_sci_objetivos (
                id_bom_datos_g, 
                objetivo, 
                estrategia, 
                tactica
            ) VALUES (
                {$bd->sqlvalue_inyeccion($id_bom_datos_g, false)},
                {$bd->sqlvalue_inyeccion($obj['objetivo'], true)},
                {$bd->sqlvalue_inyeccion($obj['estrategia'], true)},
                {$bd->sqlvalue_inyeccion($obj['tactica'], true)}
            )";
            $bd->ejecutar($sql);
        }

        return $id_bom_datos_g;
    } catch (Exception $e) {
        error_log("Error en insertarDatosGenerales: " . $e->getMessage());
        return false;
    }
}

function actualizarDatosGenerales(
    $id_bom_datos_g,
    $evaluacion_inicial,
    $objetivos,
    $ubicacion_puesto_comando,
    $area_espera,
    $ruta_egreso,
    $ruta_ingreso,
    $mensaje_seguridad,
    $distribucion_canales_comunicacion,
    $datos_meteorologicos,
    $fecha_hora_preparacion,
    $id_incidente,
    $posicion,
    $elaborado_por
) {
    $bd = new Db;
    $bd->conectar('', '', '');

    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $email_usuario = $_SESSION['email'];
    } else {
        error_log("Email del usuario no está en la sesión.");
        return false;
    }

    $anio = date("Y");

    try {
        $sql = "UPDATE bomberos.bombero_sci_datos_generales SET 
            evaluacion_inicial = {$bd->sqlvalue_inyeccion($evaluacion_inicial, true)},
            ubicacion_puesto_comando = {$bd->sqlvalue_inyeccion($ubicacion_puesto_comando, true)},
            area_espera = {$bd->sqlvalue_inyeccion($area_espera, true)},
            ruta_egreso = {$bd->sqlvalue_inyeccion($ruta_egreso, true)},
            ruta_ingreso = {$bd->sqlvalue_inyeccion($ruta_ingreso, true)},
            mensaje_seguridad = {$bd->sqlvalue_inyeccion($mensaje_seguridad, true)},
            distribucion_canales_comunicacion = {$bd->sqlvalue_inyeccion($distribucion_canales_comunicacion, true)},
            datos_meteorologicos = {$bd->sqlvalue_inyeccion($datos_meteorologicos, true)},
            fecha_hora_preparacion = {$bd->sqlvalue_inyeccion($fecha_hora_preparacion, true)},
            fecha_edicion = NOW(),
            anio = {$bd->sqlvalue_inyeccion($anio, true)},
            email_usuario = {$bd->sqlvalue_inyeccion($email_usuario, true)},
            id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)},
            posicion = {$bd->sqlvalue_inyeccion($posicion, true)},
            elaborado_por = {$bd->sqlvalue_inyeccion($elaborado_por, true)}
            WHERE id_bom_datos_g = {$bd->sqlvalue_inyeccion($id_bom_datos_g, false)}";
        $bd->ejecutar($sql);

        // Eliminar los objetivos anteriores
        $sql_eliminar_objetivos = "DELETE FROM bomberos.bombero_sci_objetivos WHERE id_bom_datos_g = {$bd->sqlvalue_inyeccion($id_bom_datos_g, false)}";
        $bd->ejecutar($sql_eliminar_objetivos);

        // Insertar los nuevos objetivos
        foreach ($objetivos as $obj) {
            $sql = "INSERT INTO bomberos.bombero_sci_objetivos (
                id_bom_datos_g, 
                objetivo, 
                estrategia, 
                tactica
            ) VALUES (
                {$bd->sqlvalue_inyeccion($id_bom_datos_g, false)},
                {$bd->sqlvalue_inyeccion($obj['objetivo'], true)},
                {$bd->sqlvalue_inyeccion($obj['estrategia'], true)},
                {$bd->sqlvalue_inyeccion($obj['tactica'], true)}
            )";
            $bd->ejecutar($sql);
        }

        return $id_bom_datos_g;
    } catch (Exception $e) {
        error_log("Error en actualizarDatosGenerales: " . $e->getMessage());
        return false;
    }
}

function obtenerFechasCreacionEdicion($id_bom_datos_g)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT fecha_creacion, fecha_edicion 
                FROM bomberos.bombero_sci_datos_generales 
                WHERE id_bom_datos_g = {$bd->sqlvalue_inyeccion($id_bom_datos_g, false)}";

        $resultado = $bd->ejecutar($sql);
        $fila = $bd->obtener_fila($resultado);

        return $fila ? $fila : false;
    } catch (Exception $e) {
        error_log("Error en obtener las fechas creacion y edición: " . $e->getMessage());
        return false;
    }
}

function obtenerDatosGeneralesPorIncidente($id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $sql = "SELECT * FROM bomberos.bombero_sci_datos_generales 
                WHERE id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ORDER BY fecha_creacion DESC LIMIT 1";

        $resultado = $bd->ejecutar($sql);
        $datos_generales = $bd->obtener_fila($resultado);

        if ($datos_generales) {
            // Obtener los objetivos asociados
            $sql_objetivos = "SELECT * FROM bomberos.bombero_sci_objetivos 
                              WHERE id_bom_datos_g = {$bd->sqlvalue_inyeccion($datos_generales['id_bom_datos_g'], false)}";
            $resultado_objetivos = $bd->ejecutar($sql_objetivos);

            $objetivos = array();
            while ($fila = $bd->obtener_fila($resultado_objetivos)) {
                $objetivos[] = array(
                    'id_objetivo' => $fila['id_objetivo'],
                    'objetivo' => $fila['objetivo'],
                    'estrategia' => $fila['estrategia'],
                    'tactica' => $fila['tactica']
                );
            }

            $datos_generales['objetivos'] = $objetivos;
        }

        return $datos_generales;
    } catch (Exception $e) {
        error_log("Error en obtenerDatosGeneralesPorIncidente: " . $e->getMessage());
        return false;
    }
}