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
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
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
	
 
	 
   
	//--------------------------------------------  trim($cuenta0),$xid_asientod,$cuenta1

	function agregarEnlace( $cuenta0,$xid_asientod,$cuenta1){
	    
	    
	    $asiento = $this->bd->query_array('co_asientod',
	        'id_asiento,aux',
	        'id_asientod='.$this->bd->sqlvalue_inyeccion($xid_asientod,true).' and
             anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	        );
	        
	    
	    $estado = $this->bd->query_array('co_asiento',
	        'mes,anio,id_periodo,estado',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($asiento["id_asiento"],true).' and
             anio= '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	        );
	            

	    $anio1			   = $estado["anio"];
		$id_asiento        = $asiento["id_asiento"];
		$aux        = $asiento["aux"];


		$DivAsientosTareas = 'NO se actualizo';
	    
	    if ( trim($estado["estado"]) == 'digitado'){
	        
						$DivAsientosTareas = 'Actualizado';
						
						$sql = "update co_asientod
								set cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta1 , true).
								" where id_asiento=".$this->bd->sqlvalue_inyeccion($asiento["id_asiento"] , true).' and
										id_asientod='.$this->bd->sqlvalue_inyeccion($xid_asientod , true).' and
										cuenta='.$this->bd->sqlvalue_inyeccion($cuenta0 , true);
						
						
						$this->bd->ejecutar($sql);
						
					 

							$this->agregarEnlaceAux($anio1, $id_asiento,$cuenta0,$xid_asientod,$cuenta1);
							 
					 
 	        
	    }
	     	 echo $DivAsientosTareas;
	      
	 
	}

/*
saludos
*/
	function agregarEnlaceAux($anio, $id_asiento,$cuenta0,$xid_asientod,$cuenta1){

		$estado_periodo = $this->bd->query_array('co_asiento',
        'mes,anio,id_periodo,estado,fecha',
        'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true) 
        );
    
		$tipo_cuenta = substr($cuenta0,0,1);

  	    $anio1 = $anio - 1 ;
 
        
			$sql_det = "select cuenta,  idprov, sum(debe) as debe,sum(haber) as haber,sum(debe) - sum(haber) as saldo
			FROM view_aux
			where anio = ".$this->bd->sqlvalue_inyeccion($anio1, true)." and  
				  cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta0, true)." and 
				  estado= 'aprobado'
			group by cuenta ,idprov
			having sum(debe) - sum(haber) <> 0
			order by cuenta,  idprov";
			 
			


	 
		
		$stmt13 = $this->bd->ejecutar($sql_det);
    
		while ($x=$this->bd->obtener_fila($stmt13)){
			
			$idprov = trim($x["idprov"]);
			
			if ( $tipo_cuenta == '1'){
				$debe  = abs($x["saldo"]);
				$haber = 0;
			}else{
				$debe  = 0;
				$haber = abs($x["saldo"]);
			}
			$total = $debe + $haber ;
			$dato = strlen($idprov);
			//------------------------------------------------------------
			$sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, fecha,fechap,cuenta, debe, haber,parcial, id_periodo,
																	anio, mes, sesion, creacion, registro) VALUES (".
																	$this->bd->sqlvalue_inyeccion($xid_asientod  , true).",".
																	$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
																	$this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
																	$this->bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
																	$this->bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
																	$this->bd->sqlvalue_inyeccion($cuenta1 , true).",".
																	$this->bd->sqlvalue_inyeccion($debe , true).",".
																	$this->bd->sqlvalue_inyeccion($haber , true).",".
																	$this->bd->sqlvalue_inyeccion($total , true).",".
																	$this->bd->sqlvalue_inyeccion($estado_periodo["id_periodo"], true).",".
																	$this->bd->sqlvalue_inyeccion($anio, true).",".
																	$this->bd->sqlvalue_inyeccion($estado_periodo["mes"] , true).",".
																	$this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
																	$this->bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
																	$this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
																	
																	if ( $total > 0 )     {
																		if ($dato > 6 ){
																			$this->bd->ejecutar($sql);
																		}
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
	
    $cuenta0		=     trim($_GET["cuenta0"]);
    $cuenta1		=     trim($_GET["cuenta1"]);

 	$xid_asientod   =     $_GET["xid_asientod"];
 
 	if ( $cuenta1  <> '-') {
 	    
 	    $gestion->agregarEnlace( $cuenta0,$xid_asientod,$cuenta1);
 	    
 	}
  
	
 
 

?>
 
  