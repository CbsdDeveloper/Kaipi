<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

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
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->anio       =  $_SESSION['anio'];
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$comprobante,$idasiento){
		//inicializamos la clase para conectarnos a la bd
	
	    echo '<script type="text/javascript">accion('.$idasiento.','.$id.',"'.$accion.'","'.trim($comprobante).'"  );</script>';
 
	    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>PAGO REALIZADO CON EXITO... INFORMACION ACTUALIZADA ['.$id.']</b>';
	    
 
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id,$idp ){
		
	 	$qquery = array(
 		        array( campo => 'id_asiento',    valor => $id,  filtro => 'S',   visor => 'S'),
 				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
	 	        array( campo => 'id_asientod',   valor => $idp,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_tramite',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'item',     valor => '-',  filtro => 'N',   visor => 'S'),
	 	        array( campo => 'debe',     valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'haber',     valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
	 	
	 	
		$datos = $this->bd->JqueryArrayVisor('view_diario_conta',$qquery );
		
		
		echo '<script> DetalleAsiento('.$datos['id_tramite'].','."'".$datos['item']."'".');</script>';
 
		$result =  $this->div_resultado($accion,$id,'-',0). '['.$id.'] '.$accion;
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	function quita_item($accion,$id,$idp){
	    
	     
	    $sql = "UPDATE co_asientod
		 		           SET principal= '',
                               item = '',
                               partida = '',
                               codigo4 = 0
				         WHERE id_asientod  = ".$this->bd->sqlvalue_inyeccion($idp,true) ;
	        
	        $this->bd->ejecutar($sql);
	        
	        echo 'Actualizado '.$idp;
	    
	}
	//--------------------pago_individual
	 
	    
 
	//aprobaci�n de asientos
	function aprobacion($action, $id  ){

	    $id_asiento		= $id;
	    $partida   		    = trim($_POST["partida"]);
	    $partidap   		= trim($_POST["partidap"]);
  	    
	    $id_asientod		= $_POST["id_asientod"] ;
	    $id_tramite			= $_POST["id_tramite"];
	    
	    if ( $partida == '-'){
	        $partida = $partidap;
	    }
	    
	    $x = $this->bd->query_array('co_asientod',
	        'cuenta,anio',
	        'id_asientod='.$this->bd->sqlvalue_inyeccion($id_asientod,true) 
	        );
 
	    $y = $this->bd->query_array('co_plan_ctas',
	        'partida_enlace',
	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($x["cuenta"]),true).' and 
              anio ='.$this->bd->sqlvalue_inyeccion($x["anio"],true)
	        );
	      
	 
	    if ( $y["partida_enlace"] == '-' ){
	        
	        $sql = "UPDATE co_asientod
		 		           SET principal= 'N',
                               partida =".$this->bd->sqlvalue_inyeccion($partida,true)."
				         WHERE id_asientod  = ".$this->bd->sqlvalue_inyeccion($id_asientod,true) ;
	        
	    }else {
	        
	        if ( $y["partida_enlace"] == 'gasto'){
	           
	            $programa = substr($partida,0,3);
	            
	            $sql = "UPDATE co_asientod
		 		           SET principal= 'S', 
                               codigo1 =".$this->bd->sqlvalue_inyeccion($id_tramite,true).",
                               partida =".$this->bd->sqlvalue_inyeccion($partida,true).",
                               codigo3 = 1,
                               codigo4 = 1,
                               programa= ".$this->bd->sqlvalue_inyeccion($programa,true)."
				         WHERE id_asientod  = ".$this->bd->sqlvalue_inyeccion($id_asientod,true) ;
	            
	        } 
	        
 
	    }
	        
	        

	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>Transaccion '.$id_asiento.'</b>';
	   
	    
 
		echo $result;
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
 		 
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'editar'){
			
			$this->aprobacion($action,$id );
			
		}
		
	}
 
	
	//--------------------------------------------------------------------------------
  
 
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
	$idp            	= $_GET['idp'];
	  
 
	if  ($accion == 'del'){
	    $gestion->quita_item($accion,$id,$idp);
	}else{
	    $gestion->consultaId($accion,$id,$idp);
	}
	    
	
	    
	 
	
	 
 
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 			=     $_POST["action"];
 	$id 				=     $_POST["id_asiento"];
 
   $gestion->xcrud( trim($action) ,  $id  );
 
	
}



?>
 
  