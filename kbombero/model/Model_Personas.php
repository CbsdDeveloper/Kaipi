<?php
include('../../kconfig/Db.class.php');

class ModelPersonas
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
        $this->db->conectar('', '', '');
    }

    public function agregarPersona($nombre, $sexo, $edad, $clasificacion, $lugar_traslado, $trasladado_por, $fecha_hora, $probable_diagnostico, $id_incidente)
    {
        $sql = "INSERT INTO bomberos.sci_personas 
                (nombre, sexo, edad, clasificacion, lugar_traslado, trasladado_por, fecha_hora, probable_diagnostico, id_incidente)
                VALUES (
                {$this->db->sqlvalue_inyeccion($nombre, true)},
                {$this->db->sqlvalue_inyeccion($sexo, true)},
                {$this->db->sqlvalue_inyeccion($edad, false)},
                {$this->db->sqlvalue_inyeccion($clasificacion, true)},
                {$this->db->sqlvalue_inyeccion($lugar_traslado, true)},
                {$this->db->sqlvalue_inyeccion($trasladado_por, true)},
                {$this->db->sqlvalue_inyeccion($fecha_hora, true)},
                {$this->db->sqlvalue_inyeccion($probable_diagnostico, true)},
                {$this->db->sqlvalue_inyeccion($id_incidente, false)})";
        return $this->db->ejecutar($sql);
    }

    public function obtenerPersonas()
    {
        return $this->db->query_array_all('bomberos.sci_personas', '*', '1=1');
    }

    public function obtenerPersonaPorId($id)
    {
        $where = 'id = ' . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->query_array('bomberos.sci_personas', '*', $where);
    }

    public function actualizarPersona($id, $nombre, $sexo, $edad, $clasificacion, $lugar_traslado, $trasladado_por, $fecha_hora, $probable_diagnostico, $id_incidente)
    {
        $sql = "UPDATE bomberos.sci_personas SET 
                nombre = " . $this->db->sqlvalue_inyeccion($nombre, true) . ",
                sexo = " . $this->db->sqlvalue_inyeccion($sexo, true) . ",
                edad = " . $this->db->sqlvalue_inyeccion($edad, false) . ",
                clasificacion = " . $this->db->sqlvalue_inyeccion($clasificacion, true) . ",
                lugar_traslado = " . $this->db->sqlvalue_inyeccion($lugar_traslado, true) . ",
                trasladado_por = " . $this->db->sqlvalue_inyeccion($trasladado_por, true) . ",
                fecha_hora = " . $this->db->sqlvalue_inyeccion($fecha_hora, true) . ",
                probable_diagnostico = " . $this->db->sqlvalue_inyeccion($probable_diagnostico, true) . ",
                id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false) . "
                WHERE id = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }

    public function obtenerPersonasPorIncidente($id_incidente)
    {
        $where = "id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false);
        return $this->db->query_array_all('bomberos.sci_personas', '*', $where);
    }

    public function eliminarPersona($id)
    {
        $sql = "DELETE FROM bomberos.sci_personas WHERE id = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }
    public function insertarOActualizarPersona($persona)
    {
        // Convertir la fecha a un formato aceptado por PostgreSQL si es necesario
        $fecha_hora = date('Y-m-d H:i:s', strtotime($persona['fecha_hora']));

        // Primero, verificamos si el registro ya existe
        $checkSql = "SELECT COUNT(*) as count FROM bomberos.sci_personas 
                 WHERE nombre = " . $this->db->sqlvalue_inyeccion($persona['nombre'], true) . "
                 AND fecha_hora = " . $this->db->sqlvalue_inyeccion($fecha_hora, true);

        $result = $this->db->query_array(
            'bomberos.sci_personas',
            'COUNT(*) as count',
            "nombre = " . $this->db->sqlvalue_inyeccion($persona['nombre'], true) . "
                                      AND fecha_hora = " . $this->db->sqlvalue_inyeccion($fecha_hora, true)
        );

        if ($result && $result['count'] > 0) {
            // El registro existe, actualizamos
            $sql = "UPDATE bomberos.sci_personas SET 
                sexo = " . $this->db->sqlvalue_inyeccion($persona['sexo'], true) . ",
                edad = " . $this->db->sqlvalue_inyeccion($persona['edad'], false) . ",
                clasificacion = " . $this->db->sqlvalue_inyeccion($persona['clasificacion'], true) . ",
                lugar_traslado = " . $this->db->sqlvalue_inyeccion($persona['lugar_traslado'], true) . ",
                trasladado_por = " . $this->db->sqlvalue_inyeccion($persona['trasladado_por'], true) . ",
                probable_diagnostico = " . $this->db->sqlvalue_inyeccion($persona['probable_diagnostico'], true) . "
                WHERE nombre = " . $this->db->sqlvalue_inyeccion($persona['nombre'], true) . "
                AND fecha_hora = " . $this->db->sqlvalue_inyeccion($fecha_hora, true);
        } else {
            // El registro no existe, lo insertamos
            $sql = "INSERT INTO bomberos.sci_personas 
                (nombre, sexo, edad, clasificacion, lugar_traslado, trasladado_por, fecha_hora, probable_diagnostico)
                VALUES (
                " . $this->db->sqlvalue_inyeccion($persona['nombre'], true) . ",
                " . $this->db->sqlvalue_inyeccion($persona['sexo'], true) . ",
                " . $this->db->sqlvalue_inyeccion($persona['edad'], false) . ",
                " . $this->db->sqlvalue_inyeccion($persona['clasificacion'], true) . ",
                " . $this->db->sqlvalue_inyeccion($persona['lugar_traslado'], true) . ",
                " . $this->db->sqlvalue_inyeccion($persona['trasladado_por'], true) . ",
                " . $this->db->sqlvalue_inyeccion($fecha_hora, true) . ",
                " . $this->db->sqlvalue_inyeccion($persona['probable_diagnostico'], true) . ")";
        }

        return $this->db->ejecutar($sql);
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
