<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

//require 'Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
     
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        //$this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
        //inicializamos la clase para conectarnos a la bd
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';

        
        if ($tipo == 0){
            
            if ($accion == 'editar'){
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
            }
            
            if ($accion == 'del'){
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
            }
            
         }
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
 
            
        }
        
        if ($tipo == 2){
            
            $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
            
        }
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( $resultado){
        //inicializamos la clase para conectarnos a la bd
        
     
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
   function consultaId($accion,$id ){
        
        $_SESSION['id_sireprogra']  = $id;
        
        $qquery = array(
            array( campo => 'id_sireprogra',    valor =>$id,  filtro => 'S',   visor => 'S'),

            array( campo => 'fecha',            valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'detalle',          valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'comprobante',      valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'documento',        valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'estado',           valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'tipo',             valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'id_departamento',  valor => '-',  filtro => 'N',   visor => 'S'),

            array( campo => 'detalle',          valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        $datos = $this->bd->JqueryArrayVisor('presupuesto.pre_sireprogramacion',$qquery);
     
       
        $result =  $this->div_resultado($accion,$id,0,$datos['estado']);
        
        echo  $result;
    }
    //--------------------------------------------------------------------------------------
    //aprobación de asientos
    function aprobacion( $id  ){
        
        $comprobante =  $this->saldos->_aprobacion_reforma($id);
        
        $this->bd->audita($id,'APROBACION','PRESUPUESTO','Aprobacion de la rerforma');
        
        
        if ($comprobante <> '-')	{
            
            $result = $this->div_resultado('aprobado',$id,2,$comprobante);
            
        }else{
            
            $result = 'No se pudo actualizar y aprobar el reforma presupuestaria';
        }
        
        
        echo $result;
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
            
            $this->edicion($id);
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
        // ------------------  eliminar
        if ($action == 'aprobacion'){
            
            $this->aprobacion($id );
            
        }
        
        
        if ($action == 'revierte'){
            
            $this->revierte_dato($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){

        
        $id_departamento    = @$_POST["id_departamento"];
        $fecha_registro		= @$_POST["fecha"];
        $fecha			    = $this->bd->fecha(@$_POST["fecha"]);
        $estado             = 'digitado';
        
        //------------ seleccion de periodo
        $trozos = explode("-", $fecha_registro,3);
        $anio = $trozos[0];
        $mes =  $trozos[1];
         
        $bandera = 0;
        
        $comprobante    = '-';
        
        if ( $anio   <>  $this->anio ) {
            $bandera = -1;
            $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO NO VALIDO... REVISE PORFAVOR PERIODO ?'.$this->anio .'</b>';
        }
        
        if ( $bandera == 0){
            
                 $sql = "INSERT INTO presupuesto.pre_sireprogramacion (	fecha, registro, anio, mes, detalle, sesion, creacion, 
                                                comprobante, estado, tipo, documento, id_departamento)
        										        VALUES (".$fecha.",".

        										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".

        										        $this->bd->sqlvalue_inyeccion($anio, true).",".

        										        $this->bd->sqlvalue_inyeccion($mes, true).",".

        										        $this->bd->sqlvalue_inyeccion(@$_POST["detalle"], true).",".

        										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".

        										        $this->hoy.",".

        										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".

        										        $this->bd->sqlvalue_inyeccion($estado, true).",".

        										        $this->bd->sqlvalue_inyeccion(@$_POST["tipo"], true).",".

        										        $this->bd->sqlvalue_inyeccion(@$_POST["documento"], true).",".

                                                        $this->bd->sqlvalue_inyeccion($id_departamento, true).")";
        									        
        		
        										        $this->bd->ejecutar($sql);

                                                        
        										        
        										        $idAsiento =  $this->bd->ultima_secuenciaP('presupuesto.sireprogra_id_reprogra_seq');
        										        
        										        $_SESSION['id_sireprogra']  = $idAsiento;
         										        
        										        $result = $this->div_resultado('editar',$idAsiento,1,$estado);
        }
										        
		 echo $result;
										        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregarDetalle( $id,$cuenta){
        
      
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id){
        
       
        
        $estado             = @$_POST["estado"];
        $id_departamento    = @$_POST["id_departamento"];
   
        $fecha			    = $this->bd->fecha(@$_POST["fecha"]);
        
        $sql = " UPDATE presupuesto.pre_sireprogramacion 
        							              SET detalle =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["detalle"]), true).",

                                                      fecha           =".$fecha.",

        											  id_departamento =".$this->bd->sqlvalue_inyeccion($id_departamento, true).",

        											  documento      =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."

        							      WHERE id_sireprogra        =".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        $_SESSION['id_sireprogra']  = $id;
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    
    function revierte_dato($id ){
        
        
        $result = 'ESTADO NO VALIDO ';
        
        $x = $this->bd->query_array('presupuesto.pre_sireprogramacion',
            'estado', 'id_sireprogra='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        if ( trim($x["estado"]) == 'aprobado'){
            
            $sql = " UPDATE presupuesto.pre_sireprogramacion
        							              SET estado    =".$this->bd->sqlvalue_inyeccion(trim('digitado'), true)."
                                                  
        							      WHERE id_sireprogra      =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $this->bd->audita($id,'DIGITADO','PRESUPUESTO','Cambio de estado de la reforma.. estado aprobado cambia a digitado');
            
            $result =  'TRAMITE DIGITADO... VERIFIQUE LOS SALDOS EN ESTA TRANSACCION' ;
            
        }
        
        
         
        
        
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    function eliminar($id ){
        
        
        $result = 'ESTADO NO VALIDO ';
        
        $x = $this->bd->query_array('presupuesto.pre_sireprogramacion',
                                    'estado', 'id_sireprogra='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        if ( trim($x["estado"]) == 'aprobado'){
           
            $sql = " UPDATE presupuesto.pre_sireprogramacion
        							              SET estado    =".$this->bd->sqlvalue_inyeccion(trim('anulado'), true)."
        							      WHERE id_sireprogra      =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
             
            $result = $this->div_limpiar('TRAMITE ANULADO... VERIFIQUE LOS SALDOS EN ESTA TRANSACCION');
             
        }
        
        
        if ( trim($x["estado"]) == 'digitado'){
            
            $sql = " DELETE FROM presupuesto.pre_sireprogramacion
        							      WHERE id_sireprogra      =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar('TRAMITE ELIMINADO ... VERIFIQUE LA INFORMACION');
            
            
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

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    		= $_GET['accion'];
    
    $id            		= $_GET['id'];
    
    $gestion->consultaId($accion,$id);
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		    =     @$_POST["action"];
    
    $id 				=     @$_POST["id_sireprogra"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  