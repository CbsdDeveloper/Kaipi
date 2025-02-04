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
		
 
	    
	    $sql ='delete  from co_diario    
                WHERE registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                       anio ='.$this->bd->sqlvalue_inyeccion($anio, true)    ;
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $this->LibroFecha();
 
	    $this->LibroDiario( $anio );
 
	    
 
        $resultadoFin = '<br>'.' Saldos Actualizados [ '.$anio.' ]</br>';
		
		echo $resultadoFin;
	
	}
 //---------------
	function LibroDiario( $anio ){
	    
  				   
						   $sql_det = "INSERT INTO co_diario (id_asiento, fecha, detalle, cuenta, debe, haber, id_periodo, anio, mes, sesion, creacion, registro, 
						   comprobante, tipo, id_asientod, partida, item, programa)  
							SELECT id_asiento, fecha, substring(detalle,1,200) as detalle, cuenta, debe, haber, coalesce(id_periodo,1), anio, mes, sesion, creacion, registro, 
						   comprobante, 'N' as tipo, id_asientod, partida, item,programa_pre as programa
						   FROM  view_diario 
						   WHERE anio_asiento  = ".$this->bd->sqlvalue_inyeccion($anio, true).' and 
                           registro      ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).'
						   order by fecha';

						   $this->bd->ejecutar($sql_det);
 
	     
	}
/*
Verifica el libro
*/
	function LibroFecha(  ){
	   
	    
	}
/*
Actualiza datos de asientos
*/

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
 
  