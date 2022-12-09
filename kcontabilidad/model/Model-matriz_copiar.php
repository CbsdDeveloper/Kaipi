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
	
	private $ATabla;
	private $tabla ;
	private $secuencia;
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
		
		$this->anio      =  $_SESSION['anio'];
		
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		 
		
	}
 
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $id_registro ,$anio_old,$anio ){
		
 
	    $x = $this->bd->query_array('presupuesto.matriz_resultados',   // TABLA
	        'count(*) as valida',                        // CAMPOS
	        'anio='.$this->bd->sqlvalue_inyeccion($anio,true) // CONDICION
	        );
	    
	    if ( $x['valida'] > 0 ){
	        $resultado = 'Ya existe';
	    }else {
	        
	        $sql = "INSERT INTO presupuesto.matriz_resultados (orden1, orden2, grupo1, grupo2, guia, cta1, cta2, cta3, sinsigno, consigno, anio)
                SELECT orden1, orden2, grupo1, grupo2, guia, cta1, cta2, cta3, sinsigno, consigno, "."'".$anio."'"."  as anio
                FROM presupuesto.matriz_resultados
                where anio=".$this->bd->sqlvalue_inyeccion($anio_old,true);
	        
	        $this->bd->ejecutar($sql);
	    }
 	    
	    //--------------------------------------------------------------------------------------------------------
	    
	    $x = $this->bd->query_array('presupuesto.matriz_flujo',   
	        'count(*) as valida',                     
	        'anio='.$this->bd->sqlvalue_inyeccion($anio,true)  
	        );
 	     
	    if ( $x['valida'] > 0 ){
	        
	        $resultado = 'Ya existe';
	        
	    }else {
	        
     	     $sql = "INSERT INTO presupuesto.matriz_flujo (seccion, orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio)
     	     SELECT seccion, orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, "."'".$anio."'"."  as anio
     	     FROM presupuesto.matriz_flujo
     	     where anio=".$this->bd->sqlvalue_inyeccion($anio_old,true);
     	     
     	     $this->bd->ejecutar($sql);
	    }
	    
	    
	    //--------------------------------------------------------------------------------------------------------
 	     
	    $x = $this->bd->query_array('presupuesto.matriz_situacion',  
	        'count(*) as valida',                     
	        'anio='.$this->bd->sqlvalue_inyeccion($anio,true) 
	        );
	    
	    if ( $x['valida'] > 0 ){
	        
	        $resultado = 'Ya existe';
	        
	    }else {
	        
     	     $sql = " INSERT INTO presupuesto.matriz_situacion (orden1, orden2, orden3, grupo1, grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio)
     	     SELECT orden1, orden2, orden3, grupo1, grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta,"."'".$anio."'"."  as anio
     	     FROM presupuesto.matriz_situacion
     	     where anio=".$this->bd->sqlvalue_inyeccion($anio_old,true);
     	     
     	     $this->bd->ejecutar($sql);
 	    }
 	    
 	
 	     $resultado = 'Matriz generada con exito';
	     
	     
 	     echo $resultado;
	}
	 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['anio_selecciona']))	{
    
      $id              = $_SESSION['ruc_registro'];
  	  $anio            = $_GET['anio_selecciona'] - 1;
	  
  	  $gestion->agregar($id,$anio,$_GET['anio_selecciona']);
	 
}
 


?>
 
  