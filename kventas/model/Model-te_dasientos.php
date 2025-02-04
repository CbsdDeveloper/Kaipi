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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
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
	function agregarDetalle( $id,$cuenta,$estado){
		
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
						                	'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
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
    								sesion,item,codigo4, creacion, registro)
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
	 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetallePago( $id,$cuenta,$idprov){
		
		$periodo_s = $this->bd->query_array('co_asiento',
		'mes,anio,id_periodo,estado',
		'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
									  );
 


		$datos = $this->total_aux( $cuenta,$idprov);

		$saldo     = $datos['saldo'];
		$tipo_dato = $datos['tipo'];

	    $estado   = trim($periodo_s["estado"]);				
									  
		if ($estado == 'digitado') {
			
				
					$id_periodo=$periodo_s["id_periodo"];
					$mes  			= $periodo_s["mes"];
					$anio  			= $periodo_s["anio"];
					//-------------
					$datosaux  = $this->bd->query_array('co_plan_ctas',
											'aux,debito,credito',
						                	'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
										    registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
											);
					 		
					$aux		= $datosaux['aux'];

					$aux		= 'S';
					
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


					$saldo     = $datos['saldo'];
					$tipo_dato = $datos['tipo'];

					if ( $tipo_dato  == 'D'){
						$debe  = $saldo ;
						$haber = '0.00' ;
					}else{
						$debe  = '0.00';
						$haber = $saldo ;
					}
					
					if ($longitud > 5 )  {
				 	
    					$sql_inserta = "INSERT INTO co_asientod(
    								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
    								sesion,item,codigo4, creacion, registro)
    								VALUES (".
    								$this->bd->sqlvalue_inyeccion($id , true).",".
    								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
    								$this->bd->sqlvalue_inyeccion( $aux, true).",".
    								$this->bd->sqlvalue_inyeccion( $debe , true).",".
    								$this->bd->sqlvalue_inyeccion( $haber, true).",".
    								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
    								$this->bd->sqlvalue_inyeccion( $anio, true).",".
    								$this->bd->sqlvalue_inyeccion( $mes, true).",".
    								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
    								$this->bd->sqlvalue_inyeccion($item , true).",".
    								$this->bd->sqlvalue_inyeccion($tipo , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
    								
								 
    							    $this->bd->ejecutar($sql_inserta);
									$id_asientod = $this->bd->ultima_secuencia('co_asientod');
									
									//---------------
									$sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
									anio, mes, sesion, creacion, registro) VALUES (".
									$this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
									$this->bd->sqlvalue_inyeccion($id, true).",".
									$this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
									$this->bd->sqlvalue_inyeccion($cuenta , true).",".
									$this->bd->sqlvalue_inyeccion($debe , true).",".
									$this->bd->sqlvalue_inyeccion($haber , true).",".
									$this->bd->sqlvalue_inyeccion($saldo , true).",".
									$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
									$this->bd->sqlvalue_inyeccion($anio, true).",".
									$this->bd->sqlvalue_inyeccion($mes , true).",".
									$this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
									$this->hoy.",".
									$this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";

									$this->bd->ejecutar($sql);


    								$DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    							
    								echo $DivAsientosTareas;
					}else {
					    $DivAsientosTareas = 'Seleccione cuenta';
					    echo $DivAsientosTareas;
					}
					
		}									        
	}

	//--------
	function total_aux( $cuenta,$idprov){


				$anio   = $_SESSION['anio'];

				$datos[] = array();

				$datos['saldo'] = '0.00';
				$datos['tipo']  = 'D';


				$tipo_cta =  substr(trim($cuenta),0,1); 
	    
				if( $tipo_cta == '1'){

					$datosaux  = $this->bd->query_array('view_aux',
					'sum(debe) - sum(haber) as saldo',
					'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
					idprov ='.$this->bd->sqlvalue_inyeccion( $idprov,true).' and 
					estado ='.$this->bd->sqlvalue_inyeccion( 'aprobado',true).' and 
					anio ='.$this->bd->sqlvalue_inyeccion( $anio ,true)
					);

					$datos['saldo'] = $datosaux['saldo'] ;
					$datos['tipo']  = 'H';
	
					
				}else{

					$datosaux  = $this->bd->query_array('view_aux',
					'sum(haber) - sum(debe) as saldo',
					'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
					idprov ='.$this->bd->sqlvalue_inyeccion( $idprov,true).' and 
					estado ='.$this->bd->sqlvalue_inyeccion( 'aprobado',true).' and 
					anio ='.$this->bd->sqlvalue_inyeccion( $anio ,true)
					);

					$datos['saldo']  = $datosaux['saldo'] ;
					$datos['tipo']    = 'D';
	
					
				}

				return $datos ;

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

	 $accion 		=     $_GET["accion"];
	 
    if (  trim($accion)  == 'editar'){

		$idprov 		=     $_GET["idprov"];
		 
		$gestion->agregarDetallePago(  $id, trim($cuenta),$idprov);

 
	}else{

		$gestion->agregarDetalle(  $id, trim($cuenta),$estado);

	}
	
	
 
	
 


?>
 
  