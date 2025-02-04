<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        
        $this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
        
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
            
            echo '<script type="text/javascript">DetalleAsiento();</script>';
        }
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
            echo '<script type="text/javascript">DetalleAsiento();</script>';
            
        }
        
        if ($tipo == 2){
            
            $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
            
        }
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'TRANSACCION ELIMINADA';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId(  ){
        
        
 
        
        $qcabecera = array(
            array(etiqueta => 'Asiento',campo => 'id_asiento',ancho => '10%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
            array(etiqueta => 'Fecha',campo => 'fecha',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
            array(etiqueta => 'Anio',campo => 'anio',ancho => '0%', filtro => 'S', valor => $this->anio  , indice => 'N', visor => 'N'),
            array(etiqueta => 'Detalle',campo => 'detalle',ancho => '30%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Sesion',campo => 'sesion',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Estado',campo => 'estado',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Modulo',campo => 'modulo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Tipo',campo => 'tipo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Saldo',campo => 'saldo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         );
        
        $acciones = " '','','' ";
        $funcion  = 'goToURLParametro';
        
        $this->bd->JqueryArrayTable('view_asientos_diferencia',$qcabecera,$acciones,$funcion,'tabla_config' );
        
        
        $result='Diferencias';
        
        echo  $result;
    }
    //--------------------------------------------------------------------------------------
    //aprobaci�n de asientos
    function aprobacion( $id  ){
        
        $comprobante =  $this->saldos->_aprobacion($id);
        
        if ($comprobante <> '-')	{
            
            $result = $this->div_resultado('aprobado',$id,2,$comprobante);
            
        }else{
            
            $result = 'No se pudo actualizar y aprobar el asiento contable';
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
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
        
        $id_periodo    = @$_POST["id_periodo"];
        
        $fecha			= $this->bd->fecha(@$_POST["fecha"]);
        
        $cuenta   = @$_POST["cuenta"];
        
        $estado        = 'digitado';
        
        //------------ seleccion de periodo
        $periodo_s = $this->bd->query_array('co_periodo','mes,anio',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true));
        $mes  			= $periodo_s["mes"];
        $anio  			= $periodo_s["anio"];
        
        $comprobante    = '-';
        //------------------------------------------------------------
        $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,
                						comprobante, estado, tipo, documento,modulo,id_periodo)
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
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
										        
										        if  ( !empty(trim($cuenta))) {
										            
										            $this->agregarDetalle( $idAsiento,trim($cuenta));
										            
										        }
										        
										        
										        $result = $this->div_resultado('editar',$idAsiento,1,$estado);
										        
										        echo $result;
										        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function Tramite($id ,$estado ){
        
        
        if ( $id  > 0 ){
            
            
            
            $sql = " UPDATE presupuesto.pre_tramite
				    SET 	estado  =".$this->bd->sqlvalue_inyeccion($estado, true)."
                    WHERE id_tramite           =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
        
            echo 'CODIGO ...'.$id.' Estado actualizado: '. $estado ;


             if ( $estado == '3'){
                    $sql = " UPDATE presupuesto.pre_tramite_det
                    SET 	compromiso = 0, devengado=0
                    WHERE id_tramite           =".$this->bd->sqlvalue_inyeccion($id, true);
            
                    $this->bd->ejecutar($sql);

             }

             if ( $estado == '5'){
                 
                $sql = " UPDATE presupuesto.pre_tramite_det
                SET 	 devengado=0
                WHERE id_tramite           =".$this->bd->sqlvalue_inyeccion($id, true);
        
                $this->bd->ejecutar($sql);

            }

           

            
            
        }else{
            
            echo 'CODIGO NO VALIDO...';
            
        }
        
    
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id){
        
        $estado        = 'digitado';
        
        
        
        $sql = " UPDATE co_asiento
				    SET 	estado  =".$this->bd->sqlvalue_inyeccion($estado, true)."
                    WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
       
        
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    //---------------
    function aprobar_asiento($id){
        
        $estado        = 'aprobado';
        
        
        
        $sql = " UPDATE co_asiento
				    SET 	estado  =".$this->bd->sqlvalue_inyeccion($estado, true)."
                    WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $estado      = 'aprobado';
        
         $this->saldos->_elimina_asiento($id,$estado);
        
 
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
    
    $accion    		    = trim($_GET['accion']);
    $id            		= $_GET['id'];
    
    if ($accion == 'eliminar'){
        
        $gestion->eliminar($id);
        
    }
    
    if ($accion == 'editar'){
        
        $gestion->edicion($id);
        
    }
    
    
    if ($accion == 'aprobar'){
        
        $gestion->aprobar_asiento($id);
        
    }
    
    if ($accion == 'Diferencia'){
        
        $gestion->consultaid(  );
        
    }
    
    if ($accion == 'tramite'){
        
        $id            		= $_GET['cod_tramite'];
        $estado            	= $_GET['estado'];
        $gestion->Tramite($id ,$estado );
        
    }
 
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		    =     @$_POST["action"];
    
    $id 				=     @$_POST["id_asiento"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  