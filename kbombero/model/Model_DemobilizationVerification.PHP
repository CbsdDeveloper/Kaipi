<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../../kconfig/Db.class.php');

class ModelDemobilizationVerification
{
    private $db;

    public function __construct() {
        $this->db = new Db;
        $this->db->conectar('', '', '');
    }

    public function addDemobilizationVerification($periodo, $fecha_hora, $unidad_personal, $notas, $elaborado_por, $posicion, $id_incidente)
    {
        $sql = "INSERT INTO bomberos.bombero_sci_verificacion_desmovilizacion 
                (periodo, fecha_hora_desmovilizacion, unidad_personal_desmovilizado, notas, elaborado_por, posicion, id_incidente) 
                VALUES (
                {$this->db->sqlvalue_inyeccion($periodo, true)},
                {$this->db->sqlvalue_inyeccion($fecha_hora, true)},
                {$this->db->sqlvalue_inyeccion($unidad_personal, true)},
                {$this->db->sqlvalue_inyeccion($notas, true)},
                {$this->db->sqlvalue_inyeccion($elaborado_por, true)},
                {$this->db->sqlvalue_inyeccion($posicion, true)},
                {$this->db->sqlvalue_inyeccion($id_incidente, false)})";

        return $this->db->ejecutar($sql);
    }

    public function updateDemobilizationVerification($id, $periodo, $fecha_hora, $unidad_personal, $notas, $elaborado_por, $posicion)
    {
        $sql = "UPDATE bomberos.bombero_sci_verificacion_desmovilizacion
                SET periodo = " . $this->db->sqlvalue_inyeccion($periodo, true) . ",
                    fecha_hora_desmovilizacion = " . $this->db->sqlvalue_inyeccion($fecha_hora, true) . ",
                    unidad_personal_desmovilizado = " . $this->db->sqlvalue_inyeccion($unidad_personal, true) . ",
                    notas = " . $this->db->sqlvalue_inyeccion($notas, true) . ",
                    elaborado_por = " . $this->db->sqlvalue_inyeccion($elaborado_por, true) . ",
                    posicion = " . $this->db->sqlvalue_inyeccion($posicion, true) . "
                WHERE id_verificacion_desmovilizacion = " . $this->db->sqlvalue_inyeccion($id, false);

        return $this->db->ejecutar($sql);
    }

    public function deleteDemobilizationVerification($id)
    {
        $sql = "DELETE FROM bomberos.bombero_sci_verificacion_desmovilizacion WHERE id_verificacion_desmovilizacion = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->ejecutar($sql);
    }

    public function getDemobilizationVerificationById($id)
    {
        $where = "id_verificacion_desmovilizacion = " . $this->db->sqlvalue_inyeccion($id, false);
        return $this->db->query_array('bomberos.bombero_sci_verificacion_desmovilizacion', '*', $where);
    }

    public function getAllDemobilizationVerifications($id_incidente = null)
    {
        $where = $id_incidente ? "id_incidente = " . $this->db->sqlvalue_inyeccion($id_incidente, false) : '1=1';
        return $this->db->query_array_all('bomberos.bombero_sci_verificacion_desmovilizacion', '*', $where);
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


}
