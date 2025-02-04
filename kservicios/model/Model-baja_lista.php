<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    
    function proceso( ){
         
        $this->obj     = 	new objects;
        $this->bd     = 	new Db;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    //-------------------------------
    function eliminar_baja($id,$id_par_ciu){
        
        $x = $this->bd->query_array('rentas.ren_tramites_baja_his ',   // TABLA
            'bandera',                        // CAMPOS
            'id_ren_baja_his='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        if ( $x['bandera'] == '0'){
            $sql = 'delete from rentas.ren_tramites_baja_his where id_ren_baja_his='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
        }
       
        
        $this->busqueda_visor($id_par_ciu);
    }
    //-----------------------------------------
    function generar_baja($GET){
        
        $ATabla = array(
            array( campo => 'id_ren_baja',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N',  valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S',          valor => $GET['fechab'], key => 'N'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S',   valor => $GET['id_par_ciu'], key => 'N'),
            array( campo => 'motivo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S',     valor => trim($GET['tipo']), key => 'N'),
            array( campo => 'resolucion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => trim($GET['resolucion']), key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S',     valor => $this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S',       valor => $this->hoy, key => 'N'),
        );
        
        $id = $this->bd->_InsertSQL('rentas.ren_tramites_baja',$ATabla, 'rentas.ren_tramites_baja_id_ren_baja_seq' );
        
        $this->actualizar_titulos($id,$GET);
        
        echo '<b>TRANSACCION GENERADA CON EXITO... SE HA DADO DE BAJA LOS TITULOS SELECCIONADOS...NRO. BAJA '.$id.' </b>';
        
    }
    //------------------------------------------
    function actualizar_titulos($id,$GET){
        
        $sql = "SELECT id_ren_baja_his, id_ren_movimiento, bandera, sesion, creacion,
                id_par_ciu, detalle, total, anio, nombre_rubro, fecha
                FROM rentas.view_ren_baja_his
                where bandera = 0 and  id_par_ciu = ".$this->bd->sqlvalue_inyeccion($GET['id_par_ciu'],true);
        
        
        $resultado    =  $this->bd->ejecutar($sql);
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            
            if ( $row['bandera'] == '0'){
                
                $sql = 'UPDATE rentas.ren_tramites_baja_his 
                           SET bandera = 1 , 
                               id_ren_baja = '.$this->bd->sqlvalue_inyeccion($id, true).' 
                        WHERE id_ren_baja_his ='.$this->bd->sqlvalue_inyeccion($row['id_ren_baja_his'], true);
                
                $this->bd->ejecutar($sql);
                
                 //-------------------------------------------------------
                $sql = 'UPDATE rentas.ren_movimiento
                           SET sesion_baja ='.$this->bd->sqlvalue_inyeccion($this->sesion, true).' ,
                               fechab = '.$this->bd->sqlvalue_inyeccion($GET['fechab'], true).' ,
                               estado = '.$this->bd->sqlvalue_inyeccion('B', true).' 
                        WHERE id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion($row['id_ren_movimiento'], true);
                
                $this->bd->ejecutar($sql);
                
            }
         }
     }
    //------------------------------------------
    function agregar_baja($id,$id_ren_movimiento){
        
        $ATabla = array(
            array( campo => 'id_ren_baja_his',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor =>$id_ren_movimiento, key => 'N'),
            array( campo => 'bandera',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor =>$id, key => 'N')
        );
        
        $this->bd->_InsertSQL('rentas.ren_tramites_baja_his',$ATabla, 'rentas.ren_tramites_baja_his_id_ren_baja_his_seq' );
        
        $this->busqueda_visor($id);
    }
    //-------------------------------
    function busqueda_visor($id){
        
        
        
        $sql = "SELECT id_ren_baja_his, id_ren_movimiento, bandera, sesion, creacion, 
                id_par_ciu, detalle, total, anio, nombre_rubro, fecha
                FROM rentas.view_ren_baja_his
                where id_par_ciu = ".$this->bd->sqlvalue_inyeccion($id,true);
 
        
        $resultado    =  $this->bd->ejecutar($sql);
        
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" id="TablaAsignadaBaja" >
            <thead>
                <tr>
                     <th width="5%">Emision</th>
                     <th width="5%">Periodo</th>
                     <th width="10%">Fecha</th>
                     <th width="25%">Rubro</th>
                     <th width="40%">Detalle</th>
                     <th width="10%">Monto</th>
                      <th width="5%"></th>
                    </tr>
            </thead><tbody>';
        
        
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            
            $bandera = '<button class="btn btn-xs" onClick="javascript:goToURLDel('.$row['id_ren_baja_his'] .')"><i class="glyphicon glyphicon-trash"></i></button> ';
            
            echo '<tr>
             <td>'.$row['id_ren_movimiento'].' </td>
             <td> '. $row['anio'].' </td>
             <td> <b>'. $row['fecha'].' </b></td>
             <td> '. $row['nombre_rubro'].' </td>
             <td> '. $row['detalle'].' </td>
            <td> '. $row['total'].' </td>
            <td> '. $bandera.' </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
        
    }
    //----------------------------------------
    function titulo_busqueda($id){
        
         
        
        $sql = "SELECT id_ren_movimiento, anio, fecha, nombre_rubro,detalle,sesionm,total 
                FROM rentas.view_ren_movimiento_emitido
                where id_par_ciu = ".$this->bd->sqlvalue_inyeccion($id,true)."  and 
                      estado = 'E'";
        
 
        
        $resultado    =  $this->bd->ejecutar($sql);
        
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" id="TablaAsignadaTi" >
            <thead>
                <tr>
                     <th width="5%">Emision</th>
                     <th width="5%">Periodo</th>
                     <th width="7%">Fecha</th>
                     <th width="25%">Rubro</th>
                     <th width="36%">Detalle</th>
                     <th width="12%">Sesions</th>
                     <th width="5%">Monto</th>
                      <th width="5%"></th>
                    </tr>
            </thead><tbody>';
        
        
        
        
        
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            
            $bandera = '<button class="btn btn-xs" onClick="javascript:goToURLPone('.$row['id_ren_movimiento'] .')"><i class="glyphicon glyphicon-copy"></i></button> ';
            
            echo '<tr>
             <td>'.$row['id_ren_movimiento'].' </td>
             <td> '. $row['anio'].' </td>
             <td> <b>'. $row['fecha'].' </b></td>
             <td> '. $row['nombre_rubro'].' </td>
             <td> '. $row['detalle'].' </td>
            <td> '. $row['sesionm'].' </td>
            <td> '. $row['total'].' </td>
            <td> '. $bandera.' </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
  //----------------------------------
    function consultaId($id ){
        
   
        $qquery = array(
            array( campo => 'id_ren_baja',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'id_par_ciu',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'resolucion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'correo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'direccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
        
        $this->bd->JqueryArrayVisor('rentas.view_ren_baja',$qquery);
 
        
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION TRAMITE DE BAJA ['.$id.']</b>';
        
        echo $result ;
    }
    //--------------------
    //-------------------------------
    function DetalleBaja($id,$id_par_ciu){
         
        
        $sql = "SELECT id_ren_baja_his, id_ren_movimiento, bandera, sesion, creacion,
                id_par_ciu, detalle, total, anio, nombre_rubro, fecha
                FROM rentas.view_ren_baja_his
                where id_ren_baja = ".$this->bd->sqlvalue_inyeccion($id,true);
        
        
        $resultado    =  $this->bd->ejecutar($sql);
        
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" id="TablaAsignadaBaja" >
            <thead>
                <tr>
                     <th width="5%">Emision</th>
                     <th width="5%">Periodo</th>
                     <th width="10%">Fecha</th>
                     <th width="25%">Rubro</th>
                     <th width="40%">Detalle</th>
                     <th width="10%">Monto</th>
                      <th width="5%"></th>
                    </tr>
            </thead><tbody>';
        
        
        
        while($row=pg_fetch_assoc ($resultado)) {
            
            
            $bandera = '<button class="btn btn-xs" onClick="javascript:goToURLDel('.$row['id_ren_baja_his'] .')"><i class="glyphicon glyphicon-trash"></i></button> ';
            
            echo '<tr>
                     <td>'.$row['id_ren_movimiento'].' </td>
                     <td> '. $row['anio'].' </td>
                     <td> <b>'. $row['fecha'].' </b></td>
                     <td> '. $row['nombre_rubro'].' </td>
                     <td> '. $row['detalle'].' </td>
                    <td> '. $row['total'].' </td>
                    <td> '. $bandera.' </td>
                 </tr>';
        }
        
        echo "</tbody></table>";
        
        
        
    }
    
}
//------------------------------------------------------------------------
// Llama de la clase para creacion de formulario de busqueda
//------------------------------------------------------------------------
$gestion         = 	new proceso;


if (isset($_GET['accion']))	{
    
    $id         = $_GET['id_par_ciu'];
    $accion     = trim($_GET['accion']);
    
    if ( $accion == 'titulo')	{
        $gestion->titulo_busqueda($id) ;
    }
   
    if ( $accion == 'add')	{
        $id_ren_movimiento = $_GET['id_ren_movimiento'];
        $gestion->agregar_baja($id,$id_ren_movimiento) ;
    }
    
    if ( $accion == 'visor')	{
        $gestion->busqueda_visor($id) ;
    }
    
    if ( $accion == 'del')	{
        $id_par_ciu = $_GET['id_par_ciu'];
        $id         = $_GET['id'];
        $gestion->eliminar_baja($id,$id_par_ciu) ;
    }
    
    if ( $accion == 'aprobar')	{
        $gestion->generar_baja($_GET) ;
    }
    
    if ( $accion == 'busqueda')	{
        $id         = $_GET['id'];
        $gestion->consultaId($id) ;
    }
    
    if ( $accion == 'detalle')	{
        $id         = $_GET['idbaja'];
        $id_par_ciu = $_GET['id_par_ciu'];
        $gestion->DetalleBaja($id,$id_par_ciu) ;
    }
    
}



?>