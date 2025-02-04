<?php
include('../../kconfig/Db.class.php');

class ModelSafetyAnalysis
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
        $this->db->conectar('', '', '');
    }

    public function addSafetyAnalysis($area, $riesgo, $accion_mitigante, $posicion, $id_incidente)
    {
        $sql = "INSERT INTO bomberos.bombero_sci_analisis_seguridad 
                (area, riesgo, accion_mitigante, posicion, id_incidente) 
                VALUES (
                {$this->db->sqlvalue_inyeccion($area, true)},
                {$this->db->sqlvalue_inyeccion($riesgo, true)},
                {$this->db->sqlvalue_inyeccion($accion_mitigante, true)},
                {$this->db->sqlvalue_inyeccion($posicion, true)},
                {$this->db->sqlvalue_inyeccion($id_incidente, false)})";

        return $this->db->ejecutar($sql);
    }


    public function updateSafetyAnalysis($id, $area, $riesgo, $accion_mitigante, $posicion)
    {
        $sql = "UPDATE bomberos.bombero_sci_analisis_seguridad
    SET area = " . $this->db->sqlvalue_inyeccion($area, true) . ",
    riesgo = " . $this->db->sqlvalue_inyeccion($riesgo, true) . ",
    accion_mitigante = " . $this->db->sqlvalue_inyeccion($accion_mitigante, true) . ",
    posicion = " . $this->db->sqlvalue_inyeccion($posicion, true) . ",
    fecha_edicion = CURRENT_TIMESTAMP
    WHERE id_analisis_seguridad = " . $this->db->sqlvalue_inyeccion($id, false);

        return $this->db->ejecutar($sql);
    }
    public function deleteSafetyAnalysis($id)
    {
        $sql = "DELETE FROM bomberos.bombero_sci_analisis_seguridad WHERE id_analisis_seguridad = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }

    public function getSafetyAnalysisById($id)
    {
        $where = "id_analisis_seguridad = " . $this->db->sqlvalue_inyeccion($id, false);
        $result = $this->db->query_array('bomberos.bombero_sci_analisis_seguridad', '*', $where);

        if ($result) {
            $result['fecha_creacion_formatted'] = $result['fecha_creacion'] ? date('d/m/Y H:i:s', strtotime($result['fecha_creacion'])) : 'No disponible';
            $result['fecha_edicion_formatted'] = $result['fecha_edicion'] ? date('d/m/Y H:i:s', strtotime($result['fecha_edicion'])) : 'No editado aún';
        }

        return $result;
    }

    public function getAllSafetyAnalysis($id_incidente = null)
    {
        $where = $id_incidente ? "id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false) : '1=1';
        return $this->db->query_array_all('bomberos.bombero_sci_analisis_seguridad', '*', $where);
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
