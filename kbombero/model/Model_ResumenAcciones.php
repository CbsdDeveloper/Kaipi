<?php
include ('../../kconfig/Db.class.php');

class ModelResumenAcciones {
    private $db;

    public function __construct() {
        $this->db = new Db;
        $this->db->conectar('', '', '');
    }

    public function eliminarAccion($id) {
        $sql = "DELETE FROM bomberos.bombero_sci_resumen_acciones WHERE id_bom_res_acc = ".$this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }

    public function agregarAccion($actividad, $fecha_hora, $posicion_institucion, $id_incidente) {
        $bd = new Db;
        $bd->conectar('', '', '');
    
        $sql = "INSERT INTO bomberos.bombero_sci_resumen_acciones 
                (actividad, fecha_hora, posicion_institucion, id_incidente) 
                VALUES (
                {$bd->sqlvalue_inyeccion($actividad, true)},
                {$bd->sqlvalue_inyeccion($fecha_hora, true)}, 
                {$bd->sqlvalue_inyeccion($posicion_institucion, true)},
                {$bd->sqlvalue_inyeccion($id_incidente, false)})";
      
        return $bd->ejecutar($sql);
    }

    public function obtenerAcciones() {
        $sql = "SELECT * FROM bomberos.bombero_sci_resumen_acciones";
        $query = $this->db->query_array_all('bomberos.bombero_sci_resumen_acciones', '*', '1=1');//($tabla,$campo,$where,$debug='0',$order='',$limit='')
        return $query;
    }

    public function obtenerAccionPorId($id) {
        $tabla = 'bomberos.bombero_sci_resumen_acciones';
        $campo = '*';
        $where = 'id_bom_res_acc = ' . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->query_array($tabla, $campo, $where);
    }

    public function actualizarAccion($id, $actividad, $fecha_hora, $posicion_institucion, $id_incidente) {
        $sql = "UPDATE bomberos.bombero_sci_resumen_acciones
                SET actividad = " . $this->db->sqlvalue_inyeccion($actividad, true) . ",
                    fecha_hora = " . $this->db->sqlvalue_inyeccion($fecha_hora, true) . ",
                    posicion_institucion = " . $this->db->sqlvalue_inyeccion($posicion_institucion, true) . ",
                    id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false) . "
                WHERE id_bom_res_acc = " . $this->db->sqlvalue_inyeccion($id, false);
    
        return $this->db->ejecutar($sql);
    }


    public function buscarAcciones($term) {
        $term = $this->db->sqlvalue_inyeccion('%' . $term . '%', true);
        $sql = "SELECT * FROM bomberos.bombero_sci_resumen_acciones 
                WHERE actividad LIKE $term 
                OR fecha_hora LIKE $term 
                OR posicion_institucion LIKE $term";
        return $this->db->query_array_all('bomberos.bombero_sci_resumen_acciones', '*', $sql);
    }
    
    public function obtenerAccionesPorIncidente($id_incidente) {
        $where = "id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false);
        return $this->db->query_array_all('bomberos.bombero_sci_resumen_acciones', '*', $where);
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


