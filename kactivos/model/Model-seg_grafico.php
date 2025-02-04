<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
 
    
 
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd     = 	new Db;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
         $this->hoy 	     =  $this->bd->hoy();
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
 
        
        
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_anio($currentYear){
        
 
        
        $sql = 'SELECT   anio_perido as texto , count(*) as registros
                FROM view_recomedacion_doc
                group by anio_perido';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Anio';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r['texto'].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r['registros']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //--- unidad
    //-----------------------------------------
    function _pie_unidad($currentYear){
        
        
        
        $sql = 'SELECT   departamento as texto , count(*) as registros
                FROM view_recomedacion_doc
                group by departamento';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Unidad';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r['texto'].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r['registros']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------
    function _pie_estado($currentYear){
        
        
        
        $sql = 'SELECT   estado_tramite as texto , count(*) as registros
                FROM view_recomedacion_doc
                group by estado_tramite';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Estado';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r['texto'].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r['registros']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //-----------------------------------------
    function _pie_tipo($currentYear){
        
        
        
        $sql = 'SELECT   tipo_examen as texto , count(*) as registros
                FROM view_recomedacion_doc
                group by tipo_examen';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Tipo_examen';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r['texto'].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r['registros']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_cumplimiento($currentYear){
        
        
        $sql = 'SELECT   cumplimiento as texto , count(*) as registros
                FROM view_recomedacion_doc
                group by cumplimiento';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Cumplimiento';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r['texto'].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r['registros']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_discapacidad($currentYear){
        
        
        $sql = ' SELECT   TIENE_DISCAPACIDAD , count(*) as registros
                FROM KAI_FORMULARIO_01
                group by TIENE_DISCAPACIDAD';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Grupo';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = (string)$r[0].'  ';    // $items === "5";
            
            $rows['data'][] = array($items, $r[1]);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _barra_unidad($currentYear){
        
        
         
        $sql = " SELECT departamento, count(*) as nro, id_departamento
        FROM view_recomedacion_doc
        group by departamento,id_departamento";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        
        $category = array();
        $series1 = array();
        $series2 = array();
        $series3 = array();
        $series4 = array();
        
        $category['name'] ='Unidad';
        $series1['name'] ='Nro_Tramites';
        $series2['name'] ='En_Proceso';
        $series3['name'] ='No_Cumple';
        $series4['name'] ='Total';
        
       
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
           $a =  $this->_total_cumplimiento(1, $r['id_departamento'] ) ;
           $b =  $this->_total_cumplimiento(2, $r['id_departamento'] );
           $c =  $this->_total_cumplimiento(3, $r['id_departamento'] );
            
            $category['data'][] = $r['departamento']  ;
            $series1['data'][] =  $r['nro'];
            $series2['data'][] =  (int)$a;
            $series3['data'][] =  (int)$b;
            $series4['data'][] =  (int)$c;
            
        }
         
        $result = array();
        
        array_push($result,$category);
        array_push($result,$series1);
        array_push($result,$series2);
        array_push($result,$series3);
        array_push($result,$series4);
        
        
        print json_encode($result, JSON_NUMERIC_CHECK);
        
         
        
    }
    //--------------------------------------
    function _total_cumplimiento($tipo,$id_departamento){
        
        /*
         $MATRIZ = array(
         'No aplica'    => 'No aplica' ,
         'Cumplimiento Parcial'    => 'Cumplimiento Parcial',
         'Cumplimiento Total'    => 'Cumplimiento Total',
         'No cumplimiento'    => 'No cumplimiento' ,
         'Cumplimiento en proceso'    => 'Cumplimiento en proceso'
         
         );*/
        
        if ($tipo == 1){
            $where = "id_departamento = ".$id_departamento." and cumplimiento in ('Cumplimiento Parcial', 'Cumplimiento en proceso')";
        }
            
        if ($tipo == 2){
            $where = "id_departamento = ".$id_departamento." and cumplimiento in ( 'No aplica','No cumplimiento')";
        }
        
        if ($tipo == 3){
            $where = "id_departamento = ".$id_departamento." and cumplimiento in ('Cumplimiento Total')";
        }
        
        
        $ATotal = $this->bd->query_array('view_recomedacion_doc',
                                         ' count(*) as nro', 
                                         $where
            );
        
        return $ATotal['nro'];
        
    }
 //--------------------------------------
    function _grilla_unidad($currentYear,$nombre){
        
           
        echo '<h5>'.$nombre.'</h5>';
        
        $sql = "SELECT   departamento , count(*) as nro,id_departamento,sum(porcentaje) / count(*) as p1
                FROM view_recomedacion_doc
                where   estado <> 'A'
                group by departamento,id_departamento ";
        
        $resultado    =  $this->bd->ejecutar($sql);
        
      
        
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" >
            <thead>
                <tr>
                     <th width="70%">Unidad<th>
                     <th width="10%">%<th>
                     <th width="10%">Indicador<th>
                    </tr>
            </thead><tbody>';
        
        $porcentaje ='0';
        
        
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            $p1 = round($row['p1'],2);
            
            if ( $p1 < 65 ){
                $val= ' <img src="../../kimages/zz_rojo.png" width="16" height="16"/>';
            }
           
            if ( ( $p1 > 65 ) && ( $p1 <= 85 ) ){
                $val= ' <img src="../../kimages/zz_amarillo.png" width="16" height="16"/>';
            }
            
            if ( ($p1 > 85 ) && ( $p1 <= 100 ) ){
                $val= ' <img src="../../kimages/zz_verde.png" width="16" height="16"/>';
            }
       
                
                
            echo '<tr>
            <td>'.$row['departamento'].' <td>
              <td> '. $p1.' <td>
             <td> '. $val.' <td>
             </tr>';
        }
        
        echo "</tbody></table>";
 
    
    }
    //--------------------------------------
    function _grilla_unidad_his($currentYear,$nombre){
        
        
      
        
 
        $ATabla = $this->bd->query_array('par_usuario',
                                         'id_departamento', 
                                         'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
     
        
        $id_departamento =   $ATabla['id_departamento'];
        
        
        $Unidad = $this->bd->query_array('nom_departamento',
            'nombre',
            'id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamento,true)
            );
       
        
        echo '<h5><b>'.$nombre.' '.trim($Unidad['nombre']).'</b></h5>';
        
        
        $sql = "SELECT  nro_informe,ultimo_comentario,estado_tramite,porcentaje,tipo_examen,responsable
                FROM view_recomedacion_doc
                where   estado <> 'A' and 
                        id_departamento = ".$this->bd->sqlvalue_inyeccion($id_departamento,true)." 
                order by  fecha desc   ";
        
       
        
        $resultado    =  $this->bd->ejecutar($sql);
        
        
        
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" >
            <thead>
                <tr>
                     <th width="30%">Nro.Informe<th>
                     <th width="30%">Tipo Examen<th>
                     <th width="35%">Estado<th>
                     <th width="5%">%<th>
                    </tr>
            </thead><tbody>';
        
        $porcentaje ='0';
        
        
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            $p1 = round($row['porcentaje'],2);
            
            if ( $p1 < 65 ){
                $val= ' <img src="../../kimages/zz_rojo.png" width="16" height="16" title=".'.$p1.'%"/>';
            }
            
            if ( ( $p1 > 65 ) && ( $p1 <= 85 ) ){
                $val= ' <img src="../../kimages/zz_amarillo.png" width="16" height="16" title=".'.$p1.'%"/>';
            }
            
            if ( ($p1 > 85 ) && ( $p1 <= 100 ) ){
                $val= ' <img src="../../kimages/zz_verde.png" width="16" height="16" title=".'.$p1.'%"/>';
            }
    
            $historial = trim($row['ultimo_comentario']);
            
            $responsable = trim($row['responsable']);
            
            echo '<tr>
              <td>'.$row['nro_informe'].' <td>
               <td><a href="#" data-toggle="tooltip" title="'.$responsable.'">'.$row['tipo_examen'].' </a><td>
              <td><a href="#" data-toggle="tooltip" title="'.$historial.'">'.$row['estado_tramite'].' </a><td>
             <td>'.$val.' <td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
//---------------------------------
}
//-------------------------

        $gestion         = 	new proceso;
        $currentYear  = date('Y');

//------ poner informacion en los campos del sistema
        $tipo = 0 ;
        
        $nombre =   $_GET['nombre'];
        
        if (isset($_GET['tipo']))	{
            $tipo    = $_GET['tipo'];
        }
          
        if ($tipo == 1) {
            $gestion->_pie_anio($currentYear);
        }

        if ($tipo == 2) {
            $gestion->_pie_estado($currentYear);
        }

        if ($tipo == 3) {
            $gestion->_pie_unidad($currentYear);
        }
        
        if ($tipo == 4) {
            $gestion->_pie_cumplimiento($currentYear);
        }
        
        
        if ($tipo == 5) {
            $gestion->_grilla_unidad($currentYear,$nombre);
        }
        
        if ($tipo == 6) {
            $gestion->_pie_tipo($currentYear);
        }
        
        if ($tipo == 7) {
            $gestion->_barra_unidad($currentYear);
        }

        if ($tipo == 8) {
            $gestion->_grilla_unidad_his($currentYear,$nombre);
        }

?>

