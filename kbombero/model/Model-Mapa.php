<?php
session_start();
include('../../kconfig/Db.class.php');

function guardarMarcador($latitud, $longitud, $titulo, $observaciones, $clase_icono, $color_icono, $imagen_url, $id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Insertar detalles del marcador
        $sql_detalles = "INSERT INTO bomberos.detalles_marcador (
            titulo,
            latitud,
            longitud,
            observaciones,
            id_incidente
        ) VALUES (
            {$bd->sqlvalue_inyeccion($titulo, true)},
            {$bd->sqlvalue_inyeccion($latitud, true)},
            {$bd->sqlvalue_inyeccion($longitud, true)},
            {$bd->sqlvalue_inyeccion($observaciones, true)},
            {$bd->sqlvalue_inyeccion($id_incidente, false)}
        ) RETURNING id";

        $resultado = $bd->ejecutar($sql_detalles);
        $fila = $bd->obtener_fila($resultado);
        $marcador_id = $fila['id'];

        // Insertar icono del marcador
        $sql_iconos = "INSERT INTO bomberos.iconos_marcador (
            marcador_id,
            clase_icono,
            color_icono,
            imagen_url
        ) VALUES (
            {$bd->sqlvalue_inyeccion($marcador_id, false)},
            {$bd->sqlvalue_inyeccion($clase_icono, true)},
            {$bd->sqlvalue_inyeccion($color_icono, true)},
            {$bd->sqlvalue_inyeccion($imagen_url, true)}
        )";

        $bd->ejecutar($sql_iconos);

        $bd->ejecutar("COMMIT");

        return $marcador_id;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en guardarMarcador: " . $e->getMessage());
        return false;
    }
}

function obtenerMarcadores($id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        // Obtener marcadores por id_incidente
        $sql = "SELECT d.id, d.titulo, d.latitud, d.longitud, d.observaciones, d.fecha_creacion,
                        i.clase_icono, i.color_icono, i.imagen_url, i.fecha_creacion as icono_fecha_creacion
                FROM bomberos.detalles_marcador d
                LEFT JOIN bomberos.iconos_marcador i ON d.id = i.marcador_id
                WHERE d.id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ORDER BY d.id";

        $resultado = $bd->ejecutar($sql);
        $marcadores = array();
        while ($fila = $bd->obtener_fila($resultado)) {
            $marcadores[] = $fila;
        }
        return $marcadores;
    } catch (Exception $e) {
        error_log("Error en obtenerMarcadores: " . $e->getMessage());
        return false;
    }
}

function eliminarMarcador($id_marcador)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Eliminar el icono del marcador
        $sql_eliminar_icono = "DELETE FROM bomberos.iconos_marcador
                               WHERE marcador_id = {$bd->sqlvalue_inyeccion($id_marcador, false)}";
        $bd->ejecutar($sql_eliminar_icono);

        // Eliminar el marcador de detalles_marcador
        $sql_eliminar_marcador = "DELETE FROM bomberos.detalles_marcador
                                  WHERE id = {$bd->sqlvalue_inyeccion($id_marcador, false)}";

        $resultado = $bd->ejecutar($sql_eliminar_marcador);

        $bd->ejecutar("COMMIT");

        // Verificar si se eliminó algún registro
        if ($bd->filas_afectadas($resultado) > 0) {
            return true;
        } else {
            return false; // No se encontró el marcador para ese incidente
        }
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en eliminarMarcador: " . $e->getMessage());
        return false;
    }
}
function guardarImagenMapa($id_incidente, $imagen_url)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    try {
        $bd->ejecutar("BEGIN");

        // Obtener la imagen anterior si existe
        $sql_check = "SELECT id,imagen_url FROM bomberos.detalles_marcador 
                      WHERE id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}";
        $resultado_check = $bd->ejecutar($sql_check);
        $fila = $bd->obtener_fila($resultado_check);

        if ($fila && !empty($fila['imagen_url'])) {
            // Si existe una imagen anterior, eliminarla
            $old_image_path = $_SERVER['DOCUMENT_ROOT'] . $fila['imagen_url'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            // Actualizar la nueva URL de la imagen
            $sql = "UPDATE bomberos.detalles_marcador imagen_url ={$bd->sqlvalue_inyeccion($imagen_url, true)}
                    WHERE id = {$bd->sqlvalue_inyeccion($fila['id'], true)}";
        } else {
            // Insertar la nueva URL de la imagen
            $sql = "INSERT INTO bomberos.detalles_marcador (id_incidente, imagen_url) 
                    VALUES ({$bd->sqlvalue_inyeccion($id_incidente, false)}, 
                            {$bd->sqlvalue_inyeccion($imagen_url, true)})";
        }

        // Actualizar o insertar la nueva URL de la imagen
        // $sql = "INSERT INTO bomberos.detalles_marcador (id_incidente, imagen_url) 
        //         VALUES ({$bd->sqlvalue_inyeccion($id_incidente, false)}, 
        //                 {$bd->sqlvalue_inyeccion($imagen_url, true)})
        //         ON CONFLICT (id_incidente) 
        //         DO UPDATE SET imagen_url = EXCLUDED.imagen_url";

        // $resultado = $bd->ejecutar($sql);

        $bd->ejecutar("COMMIT");

        // return $bd->filas_afectadas($resultado) > 0;
    } catch (Exception $e) {
        $bd->ejecutar("ROLLBACK");
        error_log("Error en guardarImagenMapa: " . $e->getMessage());
        return false;
    }
}
