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
    private $ATabla_acta ;
    
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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_acta',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'clase_documento',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'resolucion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idsede',tipo => 'NUMBER',id => '13',add => 'S', edit => 'N', valor => '-', key => 'N')
        );
        
 
        
        $this->tabla 	  	  = 'activo.ac_movimiento';
        
        $this->secuencia 	     = 'activo.ac_movimiento_id_acta_seq';
        
        
        $this->ATabla_acta = array(
            array( campo => 'id_acta_det',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'id_acta',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N')
        );
        
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
            'documento' => $comprobante
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
            array( campo => 'id_acta',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'clase_documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'resolucion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idsede',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S')
         );
 
        
        $datos =   $this->bd->JqueryArrayVisorDato('activo.ac_movimiento',$qquery );
        
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
        
        
        $clase_documento        = trim($_POST["clase_documento"]);
         
        $comprobante            = $this->K_comprobante( $clase_documento );
        
         
        $this->ATabla[2][valor] =  $comprobante;
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
   
           
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado',$comprobante) ;
        
        header('Content-Type: application/json');
         
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
       $estado    =     $_POST["estado"];
       
       $documento =     $_POST["documento"];
      
       if ( $estado == 'N'){
           
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
       }else{
           $this->ATabla[3][edit] =  'N';
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
       }
           
        
       
       $datos = $this->div_resultado('editar',$id, 1,'digitado',$documento) ;
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $estado =  $_POST["estado"];
        
        if (trim($estado) == 'digitado') {
            
            $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();
            
        }else {
            
            $sql = 'update inv_movimiento
                       set estado = '.$this->bd->sqlvalue_inyeccion('anulado', true).'
                    where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            
            $this->bd->ejecutar($sql);
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
            
            
        }
        
        
        
        echo $result;
        
        
    }
 
    
    //--------------------------------------------
    //----------------------------
    function aprobar_acta($id ){
        
        
        $sql_det = "SELECT estado, id_acta_det, id_acta, id_bien, sesion, creacion
                    FROM activo.ac_movimiento_det
                    where id_acta = ".$this->bd->sqlvalue_inyeccion($id,true);

 
        
        $stmt1 = $this->bd->ejecutar($sql_det);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
 
            
            $idbien = $x['id_bien']; 
          
            $sql = "UPDATE activo.ac_bienes
                   SET uso= ".$this->bd->sqlvalue_inyeccion('Baja',true) .',
                       baja_c= '.$this->bd->sqlvalue_inyeccion('S',true) .'
                 WHERE id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true);
            
            $this->bd->ejecutar($sql);
      
            
        }
 
        $sql = "UPDATE activo.ac_movimiento
                   SET estado= ".$this->bd->sqlvalue_inyeccion('S',true).'
                 WHERE id_acta='.$this->bd->sqlvalue_inyeccion($id,true);
        
        $this->bd->ejecutar($sql);
        
        echo 'Tramite generado.... baja de bienes actualizada';
        
    }
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
    
    if ( $accion == 'aprobar'){
        
        $gestion->aprobar_acta( $id );
        
    }else {
        $gestion->consultaId($accion,$id);
    }
  
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_acta"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  