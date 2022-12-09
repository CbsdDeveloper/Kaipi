<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
        
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
    function consultaId($accion,$id ){
        
        
        $qquery = array(
            array( campo => 'id_reforma',    valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',         valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo_reforma',     valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_departamento',     valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        $datos = $this->bd->JqueryArrayVisor('presupuesto.view_reforma',$qquery );
        
        
        $result =  $this->div_resultado($accion,$id,0,$datos['estado']);
        
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
    function gasto($id_reforma,$partida,$saldo ){
        
       
        //------------ seleccion de periodo
       
        $anio =  $this->anio  ;
     
        
        //------------------------------------------------------------
        $sql = "INSERT INTO presupuesto.pre_reforma_det (fsesion,id_reforma, registro, partida, tipo, saldo, aumento, sesion, 
                                                          anio, disminuye)
										        VALUES (".$this->hoy.",".
										        $this->bd->sqlvalue_inyeccion($id_reforma, true).",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($partida, true).",".
										        $this->bd->sqlvalue_inyeccion('G', true).",".
										        $this->bd->sqlvalue_inyeccion($saldo, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										     
										        
										        $guardarCosto = 'Transaccion guardada';
										        
										        echo $guardarCosto;
										        
    }
    
    function ingreso($id_reforma,$partida,$saldo ){
        
        
        $anio =  $this->anio  ;
        
        //------------------------------------------------------------
        $sql = "INSERT INTO presupuesto.pre_reforma_det (fsesion,id_reforma, registro, partida, tipo, saldo, aumento, sesion,
                                                          anio, disminuye)
										        VALUES (".$this->hoy.",".
										        $this->bd->sqlvalue_inyeccion($id_reforma, true).",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($partida, true).",".
										        $this->bd->sqlvalue_inyeccion('I', true).",".
										        $this->bd->sqlvalue_inyeccion($saldo, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										        $guardarCosto = 'Transaccion guardada';
										        
										        echo $guardarCosto;
										        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function gastoaumenta($id,$monto1,$monto2){
        
        
            
            $sql = " UPDATE presupuesto.pre_reforma_det 
							              SET 	aumento    =".$this->bd->sqlvalue_inyeccion($monto1, true).",
											    disminuye  =".$this->bd->sqlvalue_inyeccion($monto2, true)."
							      WHERE id_reforma_det     =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
           
            $guardarCosto = 'Transaccion guardada';
            
            echo $guardarCosto;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $sql = "DELETE FROM presupuesto.pre_reforma_det 
				 WHERE id_reforma_det     =".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
         
        $result = 'Eliminado detalle';
         
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
if (isset($_GET['tipo']))	{
    
    $tipo   		            = $_GET['tipo'];
    $id_reforma           		= $_GET['id_reforma'];
    $partida           		    = $_GET['partida'];
    $saldo                      = $_GET['saldo'];
    
    if ( $tipo== 'gasto'){
        
        $gestion->gasto($id_reforma,$partida,$saldo);
        
    } 
    
    if ( $tipo== 'ingreso'){
        
        $gestion->ingreso($id_reforma,$partida,$saldo);
        
    } 
    
    if ( $tipo== 'gastoa'){
        
        $id          		= $_GET['id'];
        $monto1          	= $_GET['monto1'];
        $monto2           	= $_GET['monto2'];
        
        $gestion->gastoaumenta($id,$monto1,$monto2);
        
    } 
    
    
    
}
//------------------
if (isset($_GET['accion']))	{
    
    $tipo   = $_GET['accion'];
    
    if ( $tipo == 'del'){
        
        $id_reforma_det = $_GET['id_reforma_det'];
        
        $gestion->eliminar($id_reforma_det);
        
    } 
}


 
?>