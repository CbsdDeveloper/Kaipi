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
		
		$this->anio       =  $_SESSION['anio'];
		
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
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id,$cuenta,$estado,$cuenta1,$partidad,$tipo_copia){
		
	   
			
					$periodo_s = $this->bd->query_array('co_asiento',
														 'mes,anio,id_periodo',
														 'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and 
                                                          anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
															);
					
					$id_periodo=$periodo_s["id_periodo"];
					$mes  			= $periodo_s["mes"];
					$anio  			= $periodo_s["anio"];
					
					//-----------------------------------------
					$datosaux  = $this->bd->query_array('co_plan_ctas',
											'aux,debito,credito',
					                        'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true).' and 
										     registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true). ' and 
					                         anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
											);
					 		
					$aux		= $datosaux['aux'];
					
					$longitud = strlen(trim($cuenta1));
					
					$tipo_cuenta = substr(trim($cuenta1), 0,2);
					
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
    								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta1)), true).",".
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
    								$this->bd->sqlvalue_inyeccion($partidad , true).",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
    								
    								
    								
    								$this->bd->ejecutar($sql_inserta);
    								
    								
    								$sql = "update co_asientod set partida = ".$this->bd->sqlvalue_inyeccion($partidad , true).
        								    "where id_asiento=".$this->bd->sqlvalue_inyeccion($id , true).' and 
                                                   cuenta='.$this->bd->sqlvalue_inyeccion($cuenta , true);
    								
    								
    								$this->bd->ejecutar($sql);
    								
    								$DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    							
    								echo $DivAsientosTareas;
					}else {
					    $DivAsientosTareas = 'Seleccione cuenta';
					    echo $DivAsientosTareas;
					}
					
		 								        
	}
	 
 //--------------------------------------------
	function agregarEnlace( $id,$cuenta,$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod){
	    
	    
	        
	    $sql1 = "UPDATE co_asientod set item = substring(partida,4,6) where cuenta like '213%' and item is null" ;
  
	    
	    $this->bd->ejecutar($sql1);
	    
	    
	    
	    
  
	        $longitud = strlen(trim($cuenta));
 
	        
	        
	        
	        if ($longitud > 5 )  {
	            
	             			$sql = "update co_asientod 
                                       set partida = ".$this->bd->sqlvalue_inyeccion($partidad , true).
    								"where id_asiento=".$this->bd->sqlvalue_inyeccion($id , true).' and
                                           id_asientod='.$this->bd->sqlvalue_inyeccion($xid_asientod , true).' and
                                           cuenta='.$this->bd->sqlvalue_inyeccion($cuenta , true);
    								
    								
    								$this->bd->ejecutar($sql);
    								
    								$DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    								
    								echo $DivAsientosTareas;
	        }else {
	            
	            $DivAsientosTareas = 'Seleccione cuenta';
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
	
    $cuenta0		=     $_GET["cuenta0"];
    $cuenta1		=     $_GET["cuenta1"];
    $partidad		=     $_GET["partidad"];
 	$id 		    =     $_GET["id_asiento"];
 	$estado         =     $_GET["estado"];
 	$tipo_copia     =     $_GET["tipo_copia"];
 	$xid_asientod   =     $_GET["xid_asientod"];
 
 	if ( $tipo_copia == 'H')  {
 	    $gestion->agregarEnlace(  $id, trim($cuenta0),$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod);
 	}else {
 	    $gestion->agregarDetalle(  $id, trim($cuenta0),$estado,$cuenta1,$partidad,$tipo_copia);
 	}
 	
	
 
 
 

?>
 
  