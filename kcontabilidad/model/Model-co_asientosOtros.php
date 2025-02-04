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
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($GET){
		
		$anio          =  $_SESSION['anio'];

		$partidaa      = trim($GET['partidaa']);
	    $id_tramite    = $GET['id_tramite'];
	    $id_asientod   = $GET['id_asientod'];

	    
		$xxx = $this->bd->query_array('presupuesto.pre_gestion',
		'item',
		 'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
		  partida='.$this->bd->sqlvalue_inyeccion($partidaa,true)
		);

		$item =  trim($xxx['item']); 

	 	   
	    
	    $sql = " UPDATE co_asientod
				  SET 	principal    =".$this->bd->sqlvalue_inyeccion('S', true).",
                        codigo1      =".$this->bd->sqlvalue_inyeccion($id_tramite, true).",
                        partida      =".$this->bd->sqlvalue_inyeccion(trim($partidaa), true).",
						item         =".$this->bd->sqlvalue_inyeccion(trim($item), true).",
                        codigo4      =".$this->bd->sqlvalue_inyeccion('1', true)."
 				WHERE   id_asientod =".$this->bd->sqlvalue_inyeccion($id_asientod, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $guardarCosto = '<br><b>DATO ACTUALIZADO PARA EL CONTROL DE GASTO </b>';
	    
	    echo $guardarCosto;
		
	}
 //------------------------
	function agregari($GET){
	    
 
	    
	    $partidaa      =  trim($GET['partidaa']);
 	    $id_asientod   =  $GET['id_asientod'];
		$anio          =  $_SESSION['anio'];

	    
		 $xxx = $this->bd->query_array('presupuesto.pre_gestion',
		 'item',
		  'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
		   partida='.$this->bd->sqlvalue_inyeccion($partidaa,true)
		 );
 
		 $item =  trim($xxx['item']); 

	    
	    $sql = " UPDATE co_asientod
				  SET 	principal    =".$this->bd->sqlvalue_inyeccion('N', true).",
                        partida      =".$this->bd->sqlvalue_inyeccion(trim($partidaa), true).",
						item         =".$this->bd->sqlvalue_inyeccion(trim($item), true).",
                        codigo4      =".$this->bd->sqlvalue_inyeccion('0', true)."
 				WHERE   id_asientod =".$this->bd->sqlvalue_inyeccion($id_asientod, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $guardarCosto = '<br><b>DATO ACTUALIZADO PARA EL CONTROL DE GASTO </b>';
	    
	    echo $guardarCosto;
	    
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['xtipo']))	{
	
    $xtipo   = $_GET['xtipo'];
 
    if ( $xtipo == 'G'){
        $gestion->agregar($_GET);
    }else{
        $gestion->agregari($_GET);
    }
 	  
  
 
		
}




?>
 
  