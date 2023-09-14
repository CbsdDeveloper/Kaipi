<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

class Model_liquidaciones{
    
     
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function Model_liquidaciones( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
        $this->ATabla = array(
            array( campo => 'id_liquida',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '01', key => 'N'),
            array( campo => 'fecharegistro',tipo => 'DATE',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secuencial',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechaemision',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
            array( campo => 'formapago',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '00', key => 'N'),
            array( campo => 'formadepago',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'codigoe',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'transaccion',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'serie',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'estab',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'ptoemi',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N') 
        );
        
  
       
        $this->tabla 	  	      = 'co_liquidacion';
        
        $this->secuencia 	     = 'co_liquidacion_id_liquida_seq';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
         
        return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'REGISTRO ELIMINADO ';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        $qqueryCompras = array(
            array( campo => 'id_liquida',valor => $id ,filtro => 'S', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecharegistro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'formapago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'transaccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S')
       
        );
        
        $estado = '';
    
        
        $this->bd->JqueryArrayVisor('view_liquidaciones',$qqueryCompras );
        
        $result =  $this->div_resultado($accion,$id,0,$estado);
        
        echo  $result;
    }
     //--------------------------------------------------------------------------------
     function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id);
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
     //--------------------------------------------------------------------------------
    function actualizar_secuencia( $id_liquida){
        
 
        $sql = "UPDATE co_liquidacion_d
                        SET 	id_liquida=".$this->bd->sqlvalue_inyeccion($id_liquida, true)."
                        WHERE id_liquida=".$this->bd->sqlvalue_inyeccion(-1, true).' and 
                              sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
     
        
        $this->bd->ejecutar($sql);
       
            
    }
    //----------------------------------------------------
    function agregar( ){
        
       
        $id = -1;
        
        $total_detalle = $this->bd->query_array('co_liquidacion_d',
            'sum(baseimponible) as baseimponible, sum(baseimpgrav) as baseimpgrav, sum(montoiva) as montoiva ',
            'id_liquida='.$this->bd->sqlvalue_inyeccion($id,true).' and
             sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true)
            );
        
        $this->ATabla[7][valor] =  $total_detalle['baseimponible'];
        $this->ATabla[8][valor] =  $total_detalle['baseimpgrav'];
        $this->ATabla[9][valor] =  $total_detalle['montoiva'];
       
 
        
        $this->ATabla[17][valor] =  substr($_POST["serie"],0,3);
        $this->ATabla[18][valor] =  substr($_POST["serie"],3,3);
        
        $secuencia  = $this->BusquedaFactura(); 
 
        
        $this->ATabla[4][valor] =  $secuencia;
         
 
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
            
            $this->actualizar_secuencia( $id );
             
            $result = $this->div_resultado('editar',$id,1,'N');
            
      
        echo $result;
        
										        
    }
    //--------------------------------.
    //----------------------------------------------------
    function BusquedaFactura(){
        
        
        $sql = "SELECT max(secuencial::int) as secuencia
			      FROM co_liquidacion
			      where  1 = 1";
        
        $parametros 			= $this->bd->ejecutar($sql);
        
        $secuencia 				= $this->bd->obtener_array($parametros);
        
        
        $contador = $secuencia['secuencia']  + 1;
        
        $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
        
        return $input;
        
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function edicion($id){
        
                
        $total_detalle = $this->bd->query_array('co_liquidacion_d',
            'sum(baseimponible) as baseimponible, sum(baseimpgrav) as baseimpgrav, sum(montoiva) as montoiva ',
            'id_liquida='.$this->bd->sqlvalue_inyeccion($id,true).' and
             sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true)
            );
        
        $this->ATabla[7][valor] =  $total_detalle['baseimponible'];
        $this->ATabla[8][valor] =  $total_detalle['baseimpgrav'];
        $this->ATabla[9][valor] =  $total_detalle['montoiva'];
          
        $this->ATabla[17][valor] =  substr($_POST["serie"],0,3);
        $this->ATabla[18][valor] =  substr($_POST["serie"],3,3);
        
        $transaccion = $_POST["transaccion"];
        
        if ( trim($transaccion) == 'N'){
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        }
 
     
            
       
            
            $result = $this->div_resultado('editar',$id,1,'N');
 
         
     
        
        echo $result;
    }
    
    
    function anula_lote($id ){
        
        $AAnexo = $this->bd->query_array('co_liquidacion',
            '*',
            'id_liquida='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $result = '<b> NO SE PUEDE ANULAR LA TRANSACCION - ENLACE CONTABLE NRO.'.$AAnexo['id_asiento'] .' </b>';
        
        if ($AAnexo['transaccion'] == 'S' ) {
            
            $sql = 'UPDATE  co_liquidacion  
                       SET transaccion ='.$this->bd->sqlvalue_inyeccion('X', true).'
                       where id_liquida='.$this->bd->sqlvalue_inyeccion($id, true);
                       
            $this->bd->ejecutar($sql);
          
            $result = $this->div_limpiar();
          
            $result = '<b> ANULADO LA TRANSACCION - ENLACE CONTABLE </b>';
        }else {

            $result = '<b> NO SE PUEDE ANULAR LA TRANSACCION - ENLACE CONTABLE </b>';
            

            
        }
           
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $AAnexo = $this->bd->query_array('co_liquidacion',
            '*',
            'id_liquida='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ENLACE CONTABLE NRO.'.$AAnexo['id_asiento'] .' </b>';
        
        if ($AAnexo['transaccion'] == 'S' ) {
            
            $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ENLACE CONTABLE </b>';
            
        }else {
            
            $sql = 'delete from co_liquidacion  where id_liquida='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_liquidacion_d  where id_liquida='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();
            
        }
           
        echo $result;
        
    }
 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_liquidaciones;


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    		    = $_GET['accion'];
    $id            		= $_GET['id'];

    if (    trim($accion)   == 'anula')	{
        $gestion->anula_lote($id);
    }else	{
        $gestion->consultaId($accion,$id);
    }

   
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		=     @$_POST["action"];
    
    $id 			=     @$_POST["id_liquida"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  