<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
     
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_combus',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'hora_in',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'u_km_inicio',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'referencia',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'ubicacion_salida',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'ubicacion_llegada',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'No definido', key => 'N'),
            array( campo => 'tipo_comb',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'cantidad',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'costo',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'id_prov',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'fecha_creacion',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'fecha_modifica',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'uso',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => 'E', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'u_km_fin',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
  
         
        
        $this->tabla 	  	  = 'adm.ad_vehiculo_comb';
        
        $this->secuencia 	     = 'adm.ad_vehiculo_comb_id_combus_seq';
        
      
        
     
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante){
        //inicializamos la clase para conectarnos a la bd
        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
        
        
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
        }
        
        if ($tipo == 0){
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ? ( '.$id.' )</b>';
           if ($accion == 'del')
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?( '.$id.' )</b>';
        }
        
        if ($tipo == -1){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LA INFORMACION DEL PROVEEDOR/RESPONSABLE</b>';
        }
        
        if ($tipo == -2){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>DEBE APERTURAR EL PERIODO EN CONTABILIDAD</b>';
        }
        
        if ($tipo == 2){
            $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO ['.$id.']</b>';
        }
        
   
        
        
       
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        
        $qquery = array(
            array( campo => 'id_combus',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'referencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_comb',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'uso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km_fin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_prov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'conductor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S')
 
         );
        
        $this->bd->JqueryArrayVisor('adm.view_comb_vehi_estacion',$qquery );
       
         
        $datos = $this->div_resultado($accion,$id, 0,'digitado','0') ;
        
        echo $datos;
        
        
        
    }
//-------------------
  
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
         
 
                    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
                    
                    $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
                    
           
         
        
        echo $datos;
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
     
   
                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                
                $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
                
              
     
        
        echo $datos;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
  
        $sql = 'delete 
                  from adm.ad_vehiculo_comb  
                where id_combus='.$this->bd->sqlvalue_inyeccion($id, true). ' and 
                      sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
      
        $this->bd->ejecutar($sql);
            
 
        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
        
        echo $result;
        
        
    }
    //---------------------------------------
  
 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    if ( $accion == 'del'){
        
        $gestion->eliminar($id );
        
    }else {
        $gestion->consultaId($accion,$id);
        
    }
    
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action =  $_POST["action"];
    
    $id     =      $_POST["id_combus"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  