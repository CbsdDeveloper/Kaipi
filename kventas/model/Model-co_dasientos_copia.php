<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
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
	function agregarDetalle( $id,$cuenta,$estado,$partida){
		
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
					                        'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true).' and 
										    registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
											);
					 		
					$aux		= $datosaux['aux'];
					
					$longitud = strlen(trim($cuenta));
					
					$tipo_cuenta = substr(trim($cuenta), 0,2);
					
					$item ='-';
					$tipo = 0;
					
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
    								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
    								sesion,item,codigo4, creacion,partida, registro)
    								VALUES (".
    								$this->bd->sqlvalue_inyeccion($id , true).",".
    								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
    								$this->bd->sqlvalue_inyeccion( $aux, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
    								$this->bd->sqlvalue_inyeccion( $anio, true).",".
    								$this->bd->sqlvalue_inyeccion( $mes, true).",".
    								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
    								$this->bd->sqlvalue_inyeccion($item , true).",".
    								$this->bd->sqlvalue_inyeccion($tipo , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion($partida , true).",".
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
	
    $cuenta		    =     $_GET["cuenta"];
    $partida		=     $_GET["partida"];
 	$id 		    =     $_GET["id_asiento"];
 	$estado         =     $_GET["estado"];
	
 
 	
 	$gestion->agregarDetalle(  $id, trim($cuenta),$estado,$partida);
	
 
 
 

?>
 
  