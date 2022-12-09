<?php
session_start( );
require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  

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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($id_asiento_aux,$comprobante,$spi_dato,$tipo,$fecha){
		
 
	    $longitudProv = strlen(trim($comprobante));
	    
	    $x = $this->bd->query_array('co_asiento_aux',   // TABLA
	        'id_asiento',                        // CAMPOS
	        'id_asiento_aux='.$this->bd->sqlvalue_inyeccion($id_asiento_aux,true) // CONDICION
	        );
	    
	    $id_asiento =  $x['id_asiento'];
	    
	    if ($longitudProv == 13) {
	        
	        $sqlq = "UPDATE co_asiento_aux
				        SET 	tipo    =".$this->bd->sqlvalue_inyeccion(trim($tipo), true).",
                                spi    =".$this->bd->sqlvalue_inyeccion(trim($spi_dato), true).",
                                fechap  =".$this->bd->sqlvalue_inyeccion($fecha, true).",
                                fecha  =".$this->bd->sqlvalue_inyeccion($fecha, true).",
                                comprobante    =".$this->bd->sqlvalue_inyeccion(trim($comprobante), true)."
 				WHERE  id_asiento_aux  =".$this->bd->sqlvalue_inyeccion($id_asiento_aux, true);
	        
	        $this->bd->ejecutar($sqlq);
	        
	        $sql = "UPDATE co_asiento
				        SET 	fecha  =".$this->bd->sqlvalue_inyeccion($fecha, true)."
 				WHERE  id_asiento =".$this->bd->sqlvalue_inyeccion($id_asiento, true);
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        // guarda auditoria de informacion
	        $texto = 'Actualizacion de estados pagos, comprobantes '.$comprobante.'-'.$spi_dato.'-'.$tipo;
	        $this->bd->audita($id_asiento_aux,'ACTUALIZACION','TESORERIA',$texto,'co_asiento_aux');
	        
	        
	        $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Informacion actualizada</b>';
	        
	    }else {
	        
	        $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Nro.Comprobante no valido...</b>';
	    }
	    
       
		  echo $guardarAux;
		   
		 
		
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

if (isset($_GET['id_asiento_aux']))	{
	
    $id_asiento_aux    = $_GET['id_asiento_aux'];
    $comprobante       = $_GET['comprobante'];
    $spi_dato          = $_GET['spi_dato'];
    $tipo              = $_GET['tipo'];
    
    $fecha              = $_GET['fecha'];
 
 	
	if ($id_asiento_aux > 0) {
	
	    $gestion->agregar($id_asiento_aux,$comprobante,$spi_dato,$tipo,$fecha);
	
	}else  {
	   
	    $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Nro de identificacion no registrado</b>';
	    
	    echo $guardarAux;
	    
	}
	   
    	
 
		
}

 


?>
 
  