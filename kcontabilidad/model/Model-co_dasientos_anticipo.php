<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $saldos;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
 
  			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Registro Actualizado</b><br>';
 			
  		
 		 return $resultado;
		
	}
	
 
	 
  
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para im $id, trim($cuenta),$estado,$partida
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id,$cuenta,$monto,$partida,$id_asientod){
		

			
					$periodo_s = $this->bd->query_array('co_asiento',
														 'mes,anio,id_periodo,estado,fecha,detalle',
														 'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
																				   	);
					 
					
					$estado         = trim($periodo_s["estado"]);
					$detalle1       = $periodo_s["detalle"];
					$fecha          = $periodo_s["fecha"];
					//-------------
					
					$canticipo = $this->bd->query_array('co_asientod',
					    'cuenta',
					    'id_asientod='.$this->bd->sqlvalue_inyeccion($id_asientod,true)
					    );
					
					$cuenta_anticipo = 	trim($canticipo['cuenta']);
					
					echo 	$cuenta_anticipo;
					
		if ($estado == 'digitado') {
					    
 		    
		    
		    /// asiento detalle
		    $id_asiento_det = $this->saldos->_detalle_contable($fecha,$id,$cuenta,$monto,0,$partida);
		    
		    // auxiliar
		    $this->saldos->_aux_contable($fecha,$id,$id_asiento_det,$detalle1,
		                                $cuenta,$this->ruc  ,$monto,0,$id,'S','-','S');
		    
		    
		    /// asiento detalle
		    $id_asiento_det = $this->saldos->_detalle_contable($fecha,$id,$cuenta,0,$monto,$partida);
		    
		    // auxiliar
		    $this->saldos->_aux_contable($fecha,$id,$id_asiento_det,$detalle1,
		        $cuenta,$this->ruc  ,0,$monto,$id,'S','-','S');
		    
    								
    			
		    
				$sql1 = "UPDATE co_asientod
				SET item      =".$this->bd->sqlvalue_inyeccion('-', true).",
					 partida      =".$this->bd->sqlvalue_inyeccion('-', true)."
			    WHERE  id_asiento = ".$this->bd->sqlvalue_inyeccion($id  ,true)."  and 
				  	   cuenta  like ".$this->bd->sqlvalue_inyeccion($cuenta_anticipo. '%', true) ;

			 $this->bd->ejecutar($sql1);

    							 
    	   $DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    							
    		 echo $DivAsientosTareas;
				 
					
		}									        
	}
	 
 
	 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 
    $gestion   = 	new proceso;
	
    $cuenta		    =     $_GET["cuentaa"];
    $partida		=     $_GET["partidaa"];
 	$id 		    =     $_GET["id_asiento"];
 	$monto         =     $_GET["monto"];
 	$id_asientod         =     $_GET["id_asientod"];
	
 	
 	
 	$gestion->agregarDetalle(  $id, trim($cuenta),$monto,$partida,$id_asientod);
	
 
 
 

?>
 
  