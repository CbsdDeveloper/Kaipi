<?php
require_once '../../kconfig/Db.class.php';

class ModelBomberoSCI
{
    private $db;

    // Conexión a la base de datos
    public function __construct()
    {
        $this->db = new Db();
        $this->db->conectar('', '', '');
    }

    // Método para agregar un bombero a la base de datos
    public function agregarBombero($nombre, $posicion, $institucion, $fecha_hora, $actividad, $id_incidente)
    {
        try {
            // Insertar el bombero en la tabla con retorno del id_incidente y la fecha de creación
            $sql = "INSERT INTO bomberos.bombero_sci_214 (
                nombre, posicion, institucion, fecha_hora, actividad, id_incidente
            ) VALUES (
                {$this->db->sqlvalue_inyeccion($nombre, true)},
                {$this->db->sqlvalue_inyeccion($posicion, true)},
                {$this->db->sqlvalue_inyeccion($institucion, true)},
                {$this->db->sqlvalue_inyeccion($fecha_hora, true)},
                {$this->db->sqlvalue_inyeccion($actividad, true)},
                {$this->db->sqlvalue_inyeccion($id_incidente, false)}
            ) RETURNING id_incidente, fecha_creacion";

            $resultado = $this->db->ejecutar($sql);
            return $this->db->obtener_fila($resultado);
        } catch (Exception $e) {
            error_log("Error en agregarBombero: " . $e->getMessage());
            return false;
        }
    }

    // Método para obtener todos los bomberos de un incidente
    public function obtenerBomberosPorIncidente($id_incidente)
    {
        try {
            // Consultar los bomberos según el id del incidente
            $sql = "SELECT * FROM bomberos.bombero_sci_214 WHERE id_incidente = {$this->db->sqlvalue_inyeccion($id_incidente, false)}";
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

    // Método para eliminar un bombero de la base de datos
    public function eliminarBombero($id_bombero)
    {
        try {
            $sql = "DELETE FROM bomberos.bombero_sci_214 WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";
            $resultado = $this->db->ejecutar($sql);
            return $resultado !== false;
        } catch (Exception $e) {
            error_log("Error en eliminarBombero: " . $e->getMessage());
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

    public function obtenerBomberoPorId($id_bombero)
    {
        try {
            $sql = "SELECT * FROM bomberos.bombero_sci_214 
                    WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";
            $resultado = $this->db->ejecutar($sql);
            return $this->db->obtener_fila($resultado);
        } catch (Exception $e) {
            error_log("Error en obtenerBomberoPorId: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarBombero214($id_bombero, $nombre, $posicion, $institucion, $fecha_hora, $actividad)
    {
        try {
            $sql = "UPDATE bomberos.bombero_sci_214 SET
                    nombre = {$this->db->sqlvalue_inyeccion($nombre, true)},
                    posicion = {$this->db->sqlvalue_inyeccion($posicion, true)},
                    institucion = {$this->db->sqlvalue_inyeccion($institucion, true)},
                    fecha_hora = {$this->db->sqlvalue_inyeccion($fecha_hora, true)},
                    actividad = {$this->db->sqlvalue_inyeccion($actividad, true)},
                    fecha_edicion = CURRENT_TIMESTAMP
                    WHERE id_bombero = {$this->db->sqlvalue_inyeccion($id_bombero, false)}";

            return $this->db->ejecutar($sql);
        } catch (Exception $e) {
            error_log("Error en actualizarBombero214: " . $e->getMessage());
            return false;
        }
    }
}
