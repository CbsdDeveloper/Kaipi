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
		
		
		$this->anio       =  $_SESSION['anio'];
		
	}
   
	//--- calcula libro diario
	function saldos( $anio ){
		
	     
	    $this->LibroPeriodo( $anio );
	    
	    
	    $sql ='UPDATE co_plan_ctas   
                  SET debe= 0, haber=0, saldo= 0  
                WHERE registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                      anio = '.$this->bd->sqlvalue_inyeccion($anio, true);
	    
	    $this->bd->ejecutar($sql);
	     
	    
	    $sql ='delete  from co_diario    
                WHERE registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                       anio ='.$this->bd->sqlvalue_inyeccion($anio, true)    ;
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $this->LibroFecha();
 
	    $this->LibroDiario( $anio );
	    
	    
	    $sql ='delete  from co_diario
                WHERE registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and
                       anio <>'.$this->bd->sqlvalue_inyeccion($anio, true)    ;
	    
	    $this->bd->ejecutar($sql);
	    
 
        $resultadoFin = '<br>'.' Saldos Actualizados [ '.$anio.' ]</br>';
		
		echo $resultadoFin;
	
	}
 //---------------
	function LibroDiario( $anio ){
	    
	    $sql_det = 'SELECT id_asiento, fecha, anio, mes, detalle, comprobante, 
                           tipo, id_periodo, cuenta, debe, haber, sesion, creacion, 
                           registro, id_asientod,anio_asiento,
                           partida_pre,programa_pre,item_pre
                     FROM view_diario 
                     WHERE anio_asiento  = '.$this->bd->sqlvalue_inyeccion($anio, true).' and 
                           registro      ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
 	    
	    $stmt13 = $this->bd->ejecutar($sql_det);
	    
	    while ($x=$this->bd->obtener_fila($stmt13)){
	        
 
	        $sql_inserta = "INSERT INTO co_diario(
					           id_asiento, fecha, detalle, cuenta, debe, haber, id_periodo,anio, mes,
					           sesion, creacion, comprobante,id_asientod,partida,item,programa,registro) VALUES ( ".
					           $this->bd->sqlvalue_inyeccion($x['id_asiento'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['fecha'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['detalle'], true).",".
					           $this->bd->sqlvalue_inyeccion(trim($x['cuenta']), true).",".
					           $this->bd->sqlvalue_inyeccion($x['debe'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['haber'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['id_periodo'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['anio_asiento'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['mes'], true).",".
					           $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
					           $this->hoy.",".
					           $this->bd->sqlvalue_inyeccion($x['comprobante'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['id_asientod'], true).",".
					           $this->bd->sqlvalue_inyeccion(trim($x['partida_pre']), true).",".
					           $this->bd->sqlvalue_inyeccion($x['item_pre'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['programa_pre'], true).",".
					           $this->bd->sqlvalue_inyeccion($x['registro'], true).")";
					                   			                      
					           $this->bd->ejecutar($sql_inserta);
	    }
 
	    
	    
	    
	    $sql_saldos = 'select cuenta, sum(debe) debe, sum(haber) haber
                        from co_diario
                        where registro = '.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                              anio     = '.$this->bd->sqlvalue_inyeccion($anio, true). ' 
                        group by cuenta
                        order by cuenta' ;
	    
	    $stmt_saldos = $this->bd->ejecutar($sql_saldos);
	    
	    while ($x=$this->bd->obtener_fila($stmt_saldos)){
	        
	        $saldo = $x['debe'] - $x['haber'];
	        
	        $sql_uno = 'UPDATE  co_plan_ctas
				 		             SET  debe  = '.$this->bd->sqlvalue_inyeccion($x['debe'], true).',
						  	              haber = '.$this->bd->sqlvalue_inyeccion($x['haber'], true).',
                                          saldo = '.$this->bd->sqlvalue_inyeccion($saldo, true).'
						            WHERE cuenta ='.$this->bd->sqlvalue_inyeccion(trim($x['cuenta']) ,true). ' and
		                                  registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true). ' and
		                                  anio ='.$this->bd->sqlvalue_inyeccion($anio, true);
	        
	        
	        $this->bd->ejecutar($sql_uno);
	    } 
	    
	}
	//-----------
	function LibroFecha(  ){
	  
	    /*
	    
	    $sql ='delete  from co_asientod
                WHERE  cuenta like '.$this->bd->sqlvalue_inyeccion('..%', true)    ;
	    
	    $this->bd->ejecutar($sql);
	 
	    
	    
	    $sql1 ='delete  from co_asiento_aux 
                WHERE  cuenta like '.$this->bd->sqlvalue_inyeccion('..%', true)    ;
	    
	    $this->bd->ejecutar($sql1);
	    
	    
	  
	    $sql2 ='delete  from co_asientod
                WHERE cuenta ='.$this->bd->sqlvalue_inyeccion('-', true)   ;
	    
	    $this->bd->ejecutar($sql2);
	    
	    
	    
	    $sql ='delete  from co_asiento_aux
                WHERE cuenta ='.$this->bd->sqlvalue_inyeccion('-', true)  ;
	    
	    $this->bd->ejecutar($sql);
	    

	    
	    
	    $sql_det = 'SELECT id_asiento, fecha,  anio_asiento
                     FROM view_diario
                     WHERE anio <> anio_asiento and
                           registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
	    
	    
	    $stmt13 = $this->bd->ejecutar($sql_det);
	    
	    while ($x=$this->bd->obtener_fila($stmt13)){
	        
	        $sql = "UPDATE  co_asiento   
                       SET   anio= ".$this->bd->sqlvalue_inyeccion($x['anio_asiento'], true)."
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql = "UPDATE  co_asientod
                       SET   anio= ".$this->bd->sqlvalue_inyeccion($x['anio_asiento'], true)."
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
	        
	        $sql = "UPDATE  co_asiento_aux
                       SET   anio= ".$this->bd->sqlvalue_inyeccion($x['anio_asiento'], true)."
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
					           
					         
	    }
 */
	    
	//    pg_free_result($stmt13);
	    
	}
//--------------------------------
	function LibroPeriodo( $anio ){
	    
	     
	    
	    $sql_det = 'SELECT id_asiento, fecha, registro, anio, mes,id_periodo
                    FROM co_asiento
                    where estado = '.$this->bd->sqlvalue_inyeccion('aprobado', true).' and  
                         registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and
                         anio ='.$this->bd->sqlvalue_inyeccion( $anio , true) ;
	    
	    
	    
	    $stmt13 = $this->bd->ejecutar($sql_det);
	    
	    while ($x=$this->bd->obtener_fila($stmt13)){
	        
	        $fecha = $x['fecha'];
	        
	        $matriz = explode('-', $fecha);
	        
	        $anio = $matriz[0];
	        $mes  = $matriz[1];
 	  
	        
	        $APeriodo = $this->bd->query_array(
	                           'co_periodo',
	                           'id_periodo', 
	                           'mes='.$this->bd->sqlvalue_inyeccion($mes,true).' and 
                                anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
	            );
	        
	        $sql = "UPDATE  co_asiento
                       SET   id_periodo= ".$this->bd->sqlvalue_inyeccion($APeriodo['id_periodo'], true)." ,
                             mes= ".$this->bd->sqlvalue_inyeccion($mes, true)." ,
                             anio= ".$this->bd->sqlvalue_inyeccion($anio, true)."  
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        
	        $sql = "UPDATE  co_asientod
                       SET   id_periodo= ".$this->bd->sqlvalue_inyeccion($APeriodo['id_periodo'], true)." ,
                             mes= ".$this->bd->sqlvalue_inyeccion($mes, true)." ,
                             anio= ".$this->bd->sqlvalue_inyeccion($anio, true)."  
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
	        
	        $sql = "UPDATE  co_asiento_aux
                        SET   id_periodo= ".$this->bd->sqlvalue_inyeccion($APeriodo['id_periodo'], true)." ,
                             mes= ".$this->bd->sqlvalue_inyeccion($mes, true)." ,
                             anio= ".$this->bd->sqlvalue_inyeccion($anio, true)."  
                    WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($x['id_asiento'], true);
	        
	        $this->bd->ejecutar($sql);
	        
	       
	        
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

 

//------ grud de datos insercion
if (isset($_POST["fanio"]))	{
	
 
	$anio 				=     $_POST["fanio"];
	
 
	$gestion->saldos( $anio );
 
	
}



?>
 
  