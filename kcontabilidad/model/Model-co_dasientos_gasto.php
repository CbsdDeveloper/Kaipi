<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
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
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
 
  			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Registro Actualizado</b><br>';
 			
 			echo '<script type="text/javascript">DetalleAsiento();</script>';
 		
 		 return $resultado;
		
	}
	
 
	 
  
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id, $cuenta,$estado,$partida,$id_tramite,$item,$monto){
 
	    
		if ($estado == 'digitado') {
			
					$periodo_s = $this->bd->query_array('co_asiento',
														 'mes,anio,id_periodo',
														 'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
																				   	);
					$id_periodo=$periodo_s["id_periodo"];
					$mes  			= $periodo_s["mes"];
					$anio  			= $periodo_s["anio"];
					//-------------
					$datosaux  = $this->bd->query_array('co_plan_ctas',
											'aux,debito,credito',
						                	'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true).' and 
										    registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
											);
					 		
					$aux		= $datosaux['aux'];
					
					$longitud = strlen(trim($cuenta));
					
					$tipo_cuenta = substr(trim($cuenta), 0,2);
					
				 
					$tipo = 1;
					
					if ($tipo_cuenta == '62'){
					    $item =$datosaux['credito'];
					    $tipo = 1;
					}
					
					if ($tipo_cuenta == '63'){
					    $item =$datosaux['debito'];
					    $tipo = 2;
					}
					
					if ($tipo_cuenta == '13'){
					    $item =$datosaux['debito'];
					    $tipo = 2;
					}
					 
					if ($tipo_cuenta == '14'){
					    $item =$datosaux['debito'];
					    $tipo = 2;
					}
					    
					if ($tipo_cuenta == '15'){
					    $item =$datosaux['debito'];
					    $tipo = 2;
					}
					
					if ($longitud > 5 )  {
				 	
    					$sql_inserta = "INSERT INTO co_asientod(
    								id_asiento, cuenta, aux,monto1,monto2,debe, haber, id_periodo, partida,anio, mes,
    								sesion,item,codigo1,codigo4, principal,creacion, registro)
    								VALUES (".
    								$this->bd->sqlvalue_inyeccion($id , true).",".
    								$this->bd->sqlvalue_inyeccion( trim($cuenta), true).",".
    								$this->bd->sqlvalue_inyeccion( $aux, true).",".
    								$this->bd->sqlvalue_inyeccion($monto, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion($monto, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
    								$this->bd->sqlvalue_inyeccion( trim($partida), true).",".
    								$this->bd->sqlvalue_inyeccion( $anio, true).",".
    								$this->bd->sqlvalue_inyeccion( $mes, true).",".
    								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
    								$this->bd->sqlvalue_inyeccion(trim($item) , true).",".
    								$this->bd->sqlvalue_inyeccion($id_tramite , true).",".
    								$this->bd->sqlvalue_inyeccion($tipo , true).",".
    								$this->bd->sqlvalue_inyeccion('S' , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
    								
    								$this->bd->ejecutar($sql_inserta);
    								
    								$DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    							
    								echo $DivAsientosTareas;
					}else {
					    $DivAsientosTareas = 'Seleccione cuenta';
					    echo $DivAsientosTareas;
					}
					
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
	
	$cuenta 		=     $_GET["cuenta"];
 	$id 		    =     $_GET["id_asiento"];
 	$estado         =     $_GET["estado"];
 	$partida        =     $_GET["partida"];
 	$id_tramite     =     $_GET["id_tramite"];
 	$item           =     $_GET["item"];
 	$monto           =    $_GET["monto"];
	
 	$gestion->agregarDetalle(  $id, $cuenta,$estado,$partida,$id_tramite,$item,$monto);
	
 
	
 


?>
 
  