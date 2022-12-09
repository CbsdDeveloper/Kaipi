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
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
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
	function agregarDetalle( $id,$cuenta,$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod){
		
	    $periodo_s = $this->bd->query_array('co_asiento',
	        'mes,anio,id_periodo',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and
             anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	        );
	    
	    $id_periodo		= $periodo_s["id_periodo"];
	    $mes  			= $periodo_s["mes"];
	    $anio  			= $periodo_s["anio"];
	    
		$xxx = $this->bd->query_array('presupuesto.pre_gestion',
		'item',
		 'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
		  partida='.$this->bd->sqlvalue_inyeccion($partidad,true)
		);

		$item =  trim($xxx['item']); 


	    if ( $tipo_copia == '-'){
	    
	        $datosaux  = $this->bd->query_array('co_plan_ctas',
	            'aux,debito,credito',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true).' and
				 registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true). ' and
				 anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $aux		= $datosaux['aux'];
	        $longitud   = strlen(trim($cuenta1));
 	        
	        if ($longitud > 5 )  {
	     		
				
	            $sql_inserta = "INSERT INTO co_asientod(
    								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
    								sesion,codigo4, creacion,partida,item, registro)
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
    								$this->bd->sqlvalue_inyeccion('0' , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion($partidad , true).",".
									$this->bd->sqlvalue_inyeccion($item , true).",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
     								
    								
    								$this->bd->ejecutar($sql_inserta);
	        }
	    }
	    
	 
    	 $sql = "update co_asientod 
                   set partida = ".$this->bd->sqlvalue_inyeccion($partidad , true)." ,
					   item = ".$this->bd->sqlvalue_inyeccion($item  , true).
                " where id_asientod=".$this->bd->sqlvalue_inyeccion($xid_asientod , true) ;
    								
												  
    		 	$this->bd->ejecutar($sql);
    			$DivAsientosTareas= $this->div_resultado('editar',$id,1,$estado);
    			echo $DivAsientosTareas;
			 
		 								        
	}
	 
 //--------------------------------------------
	function agregarEnlace( $id,$cuenta,$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod){
	    
	    
	        
	    $sql1 = "UPDATE co_asientod set item = substring(partida,4,6) 
                      where cuenta like '213%' and item is null" ;
  
	    
	    $this->bd->ejecutar($sql1);
 
  
	        $longitud = strlen(trim($partidad));
 
	        $anio = $this->anio;
	        
	        $x = $this->bd->query_array('presupuesto.pre_gestion',   // TABLA
	            'clasificador',                       
	            'partida='.$this->bd->sqlvalue_inyeccion($partidad,true) .' and anio = '.$this->bd->sqlvalue_inyeccion($anio,true)
	            );
 
	        $item =   $x["clasificador"];
	        
	        
	        if ($longitud > 5 )  {
	            
	             			$sql = "update co_asientod 
                                       set partida = ".$this->bd->sqlvalue_inyeccion($partidad , true).',
                                           item='.$this->bd->sqlvalue_inyeccion($item , true).
    								" where id_asiento=".$this->bd->sqlvalue_inyeccion($id , true).' and
                                           id_asientod='.$this->bd->sqlvalue_inyeccion($xid_asientod , true);
    								
    								
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
	
    $cuenta0		=     trim($_GET["cuenta0"]);
    $cuenta1		=     trim($_GET["cuenta1"]);
    $partidad		=     trim($_GET["partidad"]);
    $id 		    =     trim($_GET["id_asiento"]);
    $estado         =     trim($_GET["estado"]);
    $tipo_copia     =     trim($_GET["tipo_copia"]);
 	$xid_asientod   =     $_GET["xid_asientod"];
 
 
 	if ( $tipo_copia == 'H')  {
 	    $gestion->agregarEnlace(  $id, trim($cuenta0),$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod);
		
 	}else {
 	    $gestion->agregarDetalle(  $id, trim($cuenta0),$estado,$cuenta1,$partidad,$tipo_copia,$xid_asientod);
		  
 	}
 	
	
 
 
 

?>
 
  