<?php
require_once '../../kconfig/Db.class.php';

class ModelBombero
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
        $this->db->conectar('', '', '');
    }

    public function agregarBombero($nombre, $especialidad, $institucion, $matricula_vehiculo, $observaciones, $id_incidente)
    {
        try {
            $sql = "INSERT INTO bomberos.bombero_sci_registro_personal (
            nombre, 
            especialidad, 
            institucion, 
            matricula_vehiculo, 
            observaciones, 
            id_incidente
        ) VALUES (
            {$this->db->sqlvalue_inyeccion($nombre, true)},
            {$this->db->sqlvalue_inyeccion($especialidad, true)},
            {$this->db->sqlvalue_inyeccion($institucion, true)},
            {$this->db->sqlvalue_inyeccion($matricula_vehiculo, true)},
            {$this->db->sqlvalue_inyeccion($observaciones, true)},
            {$this->db->sqlvalue_inyeccion($id_incidente, false)}
        ) RETURNING id_bombero, fecha_creacion"; // Se devuelve también la fecha de creación

            $resultado = $this->db->ejecutar($sql);
            $fila = $this->db->obtener_fila($resultado);
            return $fila;
        } catch (Exception $e) {
            error_log("Error en agregarBombero: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerBomberosPorIncidente($id_incidente)
    {
        try {
            $sql = "SELECT * FROM bomberos.bombero_sci_registro_personal 
                    WHERE id_incidente = {$this->db->sqlvalue_inyeccion($id_incidente, false)}";
            $resultado = $this->db->ejecutar($sql);
            $bomberos = [];
            while ($fila = $this->db->obtener_fila($resultado)) {
                $bomberos[] = $fila;
            }
            return $bomberos;
        } catch (Exception $e) {
            error_log("Error en obtenerBomberosPorIncidente: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarBombero($id_bombero)
    {
        try {
            $sql = "DELETE FROM bomberos.bombero_sci_registro_personal 
                    WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";
            return $this->db->ejecutar($sql);
        } catch (Exception $e) {
            error_log("Error en eliminarBombero: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerBomberoPorId($id_bombero)
    {
        try {
            $sql = "SELECT * FROM bomberos.bombero_sci_registro_personal 
                    WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";
            $resultado = $this->db->ejecutar($sql);
            return $this->db->obtener_fila($resultado);
        } catch (Exception $e) {
            error_log("Error en obtenerBomberoPorId: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarBombero($id_bombero, $nombre, $especialidad, $institucion, $matricula_vehiculo, $observaciones)
    {
        try {
            $sql = "UPDATE bomberos.bombero_sci_registro_personal SET
            nombre = {$this->db->sqlvalue_inyeccion($nombre, true)},
            especialidad = {$this->db->sqlvalue_inyeccion($especialidad, true)},
            institucion = {$this->db->sqlvalue_inyeccion($institucion, true)},
            matricula_vehiculo = {$this->db->sqlvalue_inyeccion($matricula_vehiculo, true)},
            observaciones = {$this->db->sqlvalue_inyeccion($observaciones, true)},
            fecha_edicion = CURRENT_TIMESTAMP
            WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";

            return $this->db->ejecutar($sql);
        } catch (Exception $e) {
            error_log("Error en actualizarBombero: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerFechasCreacionEdicion($id_bombero)
    {
        try {
            $sql = "SELECT fecha_creacion, fecha_edicion 
            FROM bomberos.bombero_sci_registro_personal 
            WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";

            $resultado = $this->db->ejecutar($sql);
            $fila = $this->db->obtener_fila($resultado);

            return $fila ? $fila : false;
        } catch (Exception $e) {
            error_log("Error en obtener las fechas creación y edición: " . $e->getMessage());
            return false;
        }
    }

    public function guardarBomberoDesdeExcel($id_incidente, $nombre, $institucion, $especialidad, $matricula_vehiculo)
    {
        try {
            $sql = "INSERT INTO bomberos.bombero_sci_registro_personal (id_incidente, nombre, institucion, especialidad, matricula_vehiculo) 
                VALUES (
                    {$this->db->sqlvalue_inyeccion($id_incidente, false)},
                    {$this->db->sqlvalue_inyeccion($nombre, true)},
                    {$this->db->sqlvalue_inyeccion($institucion, true)},
                    {$this->db->sqlvalue_inyeccion($especialidad, true)},
                    {$this->db->sqlvalue_inyeccion($matricula_vehiculo, true)}
                )";

            return $this->db->ejecutar($sql);
        } catch (Exception $e) {
            error_log("Error en guardarBomberoDesdeExcel: " . $e->getMessage());
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
}
