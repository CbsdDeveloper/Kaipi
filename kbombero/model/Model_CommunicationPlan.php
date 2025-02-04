<?php
include ('../../kconfig/Db.class.php');

class ModelCommunicationPlan {
    private $db;

    public function __construct() {
        $this->db = new Db;
        $this->db->conectar('', '', '');
    }

    public function addCommunicationPlan($periodo, $sistema, $canal_frecuencia, $asignado, $ubicacion, $observaciones, $elaborado_por, $posicion, $id_incidente) {
        $sql = "INSERT INTO bomberos.bombero_sci_plan_comunicaciones 
                (periodo, sistema, canal_frecuencia, asignado, ubicacion, observaciones, elaborado_por, posicion, id_incidente) 
                VALUES (
                {$this->db->sqlvalue_inyeccion($periodo, true)},
                {$this->db->sqlvalue_inyeccion($sistema, true)},
                {$this->db->sqlvalue_inyeccion($canal_frecuencia, true)},
                {$this->db->sqlvalue_inyeccion($asignado, true)},
                {$this->db->sqlvalue_inyeccion($ubicacion, true)},
                {$this->db->sqlvalue_inyeccion($observaciones, true)},
                {$this->db->sqlvalue_inyeccion($elaborado_por, true)},
                {$this->db->sqlvalue_inyeccion($posicion, true)},
                {$this->db->sqlvalue_inyeccion($id_incidente, false)})";
      
        return $this->db->ejecutar($sql);
    }

  
    public function updateCommunicationPlan($id, $periodo, $sistema, $canal_frecuencia, $asignado, $ubicacion, $observaciones, $elaborado_por, $posicion) {
        $sql = "UPDATE bomberos.bombero_sci_plan_comunicaciones
                SET periodo = " . $this->db->sqlvalue_inyeccion($periodo, true) . ",
                    sistema = " . $this->db->sqlvalue_inyeccion($sistema, true) . ",
                    canal_frecuencia = " . $this->db->sqlvalue_inyeccion($canal_frecuencia, true) . ",
                    asignado = " . $this->db->sqlvalue_inyeccion($asignado, true) . ",
                    ubicacion = " . $this->db->sqlvalue_inyeccion($ubicacion, true) . ",
                    observaciones = " . $this->db->sqlvalue_inyeccion($observaciones, true) . ",
                    elaborado_por = " . $this->db->sqlvalue_inyeccion($elaborado_por, true) . ",
                    posicion = " . $this->db->sqlvalue_inyeccion($posicion, true) . ",
                    fecha_edicion = CURRENT_TIMESTAMP
                WHERE id_plan_comunicaciones = " . $this->db->sqlvalue_inyeccion($id, false);
    
        return $this->db->ejecutar($sql);
    }

    public function deleteCommunicationPlan($id) {
        $sql = "DELETE FROM bomberos.bombero_sci_plan_comunicaciones WHERE id_plan_comunicaciones = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }

    
    public function getCommunicationPlanById($id) {
        $where = "id_plan_comunicaciones = " . $this->db->sqlvalue_inyeccion($id, false);
        $result = $this->db->query_array('bomberos.bombero_sci_plan_comunicaciones', '*', $where);
        
        if ($result) {
            $result['fecha_creacion_formatted'] = date('d/m/Y H:i:s', strtotime($result['fecha_creacion']));
            $result['fecha_edicion_formatted'] = $result['fecha_edicion'] ? date('d/m/Y H:i:s', strtotime($result['fecha_edicion'])) : 'No editado aún';
        }
        
        return $result;
    }

    public function getAllCommunicationPlans($id_incidente = null) {
        $where = $id_incidente ? "id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false) : '1=1';
        return $this->db->query_array_all('bomberos.bombero_sci_plan_comunicaciones', '*', $where);
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
?>