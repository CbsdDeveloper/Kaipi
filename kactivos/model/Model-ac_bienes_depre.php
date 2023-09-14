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
            array( campo => 'id_bien_dep',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'fecha2',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor => '-', key => 'N')
        );
        
 
        $this->tabla 	  	  = 'activo.ac_bienes_cab_dep';
        
        $this->secuencia 	     = 'activo.ac_bienes_cab_dep_id_bien_dep_seq';
        
        
       
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante){
        //inicializamos la clase para conectarnos a la bd
        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
        
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
        
        
        
        $datos = array(
            'resultado' => $resultado,
            'id' => $id,
            'accion' => $accion,
            'estado' => $estado
        );
        
        
        return $datos; 
        
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
            array( campo => 'id_bien_dep',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha2',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'mes',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S') 
        );
        
        
        
        
        $datos =   $this->bd->JqueryArrayVisorDato('activo.ac_bienes_cab_dep',$qquery );
        
        header('Content-Type: application/json');
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
        
    }
    
    
    
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
        
  
        $cuenta =   trim($_POST["cuenta"]);
        
        $anio   =   $_POST["anio"];
        
        $tipo   =   $_POST["tipo"];
        
        $fecha2   =   $_POST["fecha2"];
        
        $trozos = explode("-", $fecha2,3);
        
        $mes  = $trozos[1];
        
        if ( trim($tipo) == 'A'){
            $x = $this->bd->query_array('activo.ac_bienes_cab_dep',   // TABLA
                'count(id_bien_dep) as nn',                        // CAMPOS
                'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true) .' AND
                 anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
                );
            $this->ATabla[13][valor]         =   '-';
        }else{
            $x = $this->bd->query_array('activo.ac_bienes_cab_dep',   // TABLA
                'count(id_bien_dep) as nn',                        // CAMPOS
                'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true) .' AND
                anio ='.$this->bd->sqlvalue_inyeccion($anio,true).' AND
                mes ='.$this->bd->sqlvalue_inyeccion($mes,true) 
                );
            $this->ATabla[13][valor]         =   $mes;
            
        }
        

      
        
        if ( $cuenta <> '-') {
            
            if ( $x["nn"] > 0 ) {
                
                $datos = $this->div_resultado('add',0, -1,'N','') ;
                
                header('Content-Type: application/json');
                
                echo json_encode($datos, JSON_FORCE_OBJECT);
                
            }else{
         
                
                
                $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia  );
                 
                $datos = $this->div_resultado('editar',$id, 1,'N','') ;
                
                header('Content-Type: application/json');
                 
                echo json_encode($datos, JSON_FORCE_OBJECT);
            } 
        } 
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
      
        $documento ='';
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
         $datos = $this->div_resultado('editar',$id, 1,'N',$documento) ;
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function anula($id ){
        
             
            $sql = 'delete from activo.ac_bienes_cab_dep  
                     where id_bien_dep='.$this->bd->sqlvalue_inyeccion($id, true);
            
             
            $this->bd->ejecutar($sql);
            
            $sql = "delete from activo.ac_bienes_ddep
                 WHERE id_bien_dep=".$this->bd->sqlvalue_inyeccion($id,true);
            
            $this->bd->ejecutar($sql);
            
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
            
       
        
        
        echo $result;
        
        
    }
    //------------
    function anulabien($id ,$idbien){
        
             
 
        
        $sql = "delete from activo.ac_bienes_ddep
             WHERE id_bien_dep=".$this->bd->sqlvalue_inyeccion($id,true).' and 
                   id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true);
        
        $this->bd->ejecutar($sql);
        
        
        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
        
   
    
    
    echo $result;
    
    
}
    //---------------------------------------
    function actualiza_bien($idbien){
        
        $sql = "UPDATE activo.ac_bienes_cab_dep
                   SET estado = ".$this->bd->sqlvalue_inyeccion('S',true) .'
                 WHERE id_bien_dep='.$this->bd->sqlvalue_inyeccion($idbien,true);
                     
         $this->bd->ejecutar($sql);
         
         $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>TRAMITE AUTORIZADO CON EXITO ['.$idbien.']</b>';
         
         echo $resultado;
   }
   //---------------------------------------
   function elimina_bien($idbien){
       
       $sql = "delete from  activo.ac_bienes_ddep
                 WHERE id_bien_dep=".$this->bd->sqlvalue_inyeccion($idbien,true);
       
       $this->bd->ejecutar($sql);
       
       $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>GENERE EL PROCESO DE DEPRECIACION ['.$idbien.']</b>';
       
       echo $resultado;
   }
   //-------------
    
  
    //------------------------------
    function K_comprobante( $clase_documento ){
        
        
        $sql = "SELECT count(*) as secuencia
			      FROM activo.ac_movimiento
                where clase_documento=".$this->bd->sqlvalue_inyeccion($clase_documento,true);
        
        $parametros 			= $this->bd->ejecutar($sql);
        
        $secuencia 				= $this->bd->obtener_array($parametros);
        
        if( $clase_documento == 'Acta Baja de Bienes'){
            $letra= 'B-';
        }else{
            $letra= 'T-';
        }
        
        $contador = $secuencia['secuencia'] + 1;
        
        $input = $letra.str_pad($contador, 6, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    //------------------------------
    function BuscaCustodio($id){
        
        
        
        
        $x = $this->bd->query_array('activo.ac_bienes_custodio',
            'count(*) as nn',
            'id_bien='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        
        return $x['nn'];
        
        
    }
    //--------------------
   
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
    
    
    if ( $accion == 'autorizar'){
        
        $gestion->actualiza_bien($id);
        
    }elseif ( $accion == 'eliminar_datos')  {
        $gestion->elimina_bien($id);
    
    }elseif ( $accion == 'del')  {
        $gestion->anula($id);
    }
    elseif ( $accion == 'anula_bien')  {
        
        $idbien        = $_GET['idbien'];
       $gestion->anulabien($id,$idbien);
   }
    else{
            $gestion->consultaId($accion,$id);
        }
        
  
        
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_bien_dep"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  