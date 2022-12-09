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
	private $ATabla;
	private $tabla ;
	private $secuencia;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =		new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function resumen_poa( $unidad,$anio){
	 
	    /*
	    $("#techo").val( response.a );
	    $("#inicial").val( response.b );
	    $("#ejecutado").val( response.c );
	    $("#ejecutadop").val( response.d );
	    
	    $("#nobjetivos").val( response.e );
	    $("#nindicadores").val( response.f );
	    $("#ntareas").val( response.g );
	    $("#ntareasp").val( response.h );  
		*/
	    
	    if ($anio=='0'){
	        $unidad = $this->unidad_activo(  );
	        $anio   = $this->periodo_activo(  );
	    }
		
	    $techo  = $this->techo_unidad($unidad);
	    
	    $x = $this->inicial_unidad($unidad,$anio);
	    
	    $inicio        = '$ '. number_format($x["inicio"],2,".",",");
	    $ejecutado     = '$ '. number_format($x["ejecucion"],2,".",",");
	    
	    if ( $x["inicio"] > 0  ){
	        
	        $pejecutado1 =  ($x["ejecucion"] / $x["inicio"]) * 100 ;
	        
	        $pejecutado =  number_format($pejecutado1,2,".",",") . ' %';
	        
	    }else{
	        $pejecutado = '0 %';
	        }
	    
	    
	    $tarea         = $x["tareas"];
	    
	    $oobjetivo   = $this->oo_unidad($unidad,$anio);
	    $oindicador  = $this->indicador_unidad($unidad,$anio);
	    
	    
 
	    echo json_encode( array(
	                                "a"=> $techo, 
	                                "b"=> $inicio, 
	                                "c"=> $ejecutado, 
	                                "d"=> $pejecutado, 
	                                "e"=> $oobjetivo, 
	                                "f"=> $oindicador, 
	                                "g"=> $tarea, 
                        	        "h"=> '0.00'
                         	    )  
	               );
	    
	    
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function techo_unidad($id ){
		
	    $x = $this->bd->query_array('nom_departamento',
	        'techo as total', 
	        'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    $total = '$ '. number_format($x["total"],2,".",",");
 
		
	    return   $total;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function inicial_unidad($id, $periodo ){
 	 
	    
	    $x = $this->bd->query_array('planificacion.view_tarea_poa',
	        'sum(codificado) as inicio, sum(ejecutado) as ejecucion, count(*) as tareas',
	        'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true). ' and 
                       anio ='.$this->bd->sqlvalue_inyeccion($periodo,true)
	        );
	    
	   
	    
	    
	    return   $x;
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function oo_unidad($id, $periodo ){
	    
	    $x = $this->bd->query_array('planificacion.view_unidad_oo',
	        'objetivos as total',
	        'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true).' and anio = '.$this->bd->sqlvalue_inyeccion($periodo,true)
	        );
 
 
	    
	    return   $x["total"];
	}
	
	//--------------------------------------------------------------------------------
	function indicador_unidad($id, $periodo ){
	    
	    $x = $this->bd->query_array('planificacion.view_indicadores_oo',
	        'count(*) as total',
	        'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true).' and anio = '.$this->bd->sqlvalue_inyeccion($periodo,true)
	        );
	    
 
	    
	    return   $x["total"];
	}
	//--------------------------------------
	function periodo_activo(  ){
	    
	    $x = $this->bd->query_array('presupuesto.view_periodo',
	        'anio',
	        'estado <> '.$this->bd->sqlvalue_inyeccion('cierre' ,true).' and 
             tipo <> '.$this->bd->sqlvalue_inyeccion('cierre',true)
	        );
	    
 
	    
	    return   $x["anio"];
	}
	//--------------------------------------
	function unidad_activo(  ){
	    
	    
	    
	    $x = $this->bd->query_array('par_usuario',
	        'id_departamento',
	        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) 
	        );
	    
 
	    
	    return   $x["id_departamento"];
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
if (isset($_GET["Q_IDUNIDAD"]))	{
	
    $unidad 		= $_GET["Q_IDUNIDAD"];
    $anio 			= $_GET["Q_IDPERIODO"];
 
	
    $gestion->resumen_poa( $unidad,$anio);
	
}

 

?>
 
  