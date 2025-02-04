<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

require 'Model-asientos_saldos.php';  

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
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
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
 
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		 	
		$qquery = array(
				array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_periodo',    valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_tramite',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'razon',  valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'sesion_archivo',  valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'fecha_archivo',  valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'archivo',  valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'ubicacion_archivo',  valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		
		   
		
 		$datos = $this->bd->JqueryArrayVisor('view_asientos_diario',$qquery );
 		
		
	 
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
 
	//--------------------------------------------------------------------------------
  	//--------------------------------------------------------------------------------
  
	function guarda_archivo($id_asiento,$comprobante,$fecha_archivo,$ubicacion_archivo){
		
	    
	    $fecha		   = $this->bd->fecha($fecha_archivo);
	    
	    
	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>INGRESE LA UBICACION DEL ARCHIVO</b>';
	    
	    $len = strlen(trim($ubicacion_archivo));
	    
	    $sql = "UPDATE co_asiento
        			  SET 	ubicacion_archivo   =".$this->bd->sqlvalue_inyeccion(trim($ubicacion_archivo), true).",
        			        comprobante         =".$this->bd->sqlvalue_inyeccion(trim($comprobante), true).",
                            sesion_archivo      =".$this->bd->sqlvalue_inyeccion($this->sesion , true).",
                            fecha_archivo       =".$fecha.",
         					archivo             =".$this->bd->sqlvalue_inyeccion('S', true)."
        		   WHERE id_asiento             =".$this->bd->sqlvalue_inyeccion($id_asiento, true);
	    
	    
	    if ( $len > 8 ){
	        
	        $this->bd->ejecutar($sql);
	        
	        $result   = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>DATOS ACTUALIZADOS</b>';
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
	
	$accion    		    = $_GET['accion'];
	$id            		= $_GET['id'];
	  
	if ( $accion == 'archivo'){
	    $id_asiento = $_GET['id_asiento'];
	    $comprobante= $_GET['comprobante'];
	    $fecha_archivo= $_GET['fecha_archivo'];
	    $ubicacion_archivo= $_GET['ubicacion_archivo'];
	    
	    $gestion->guarda_archivo($id_asiento,$comprobante,$fecha_archivo,$ubicacion_archivo);
	    
	}else{
	    $gestion->consultaId($accion,$id);
	}
	
	 
	 
	
}

 

?>
 
  