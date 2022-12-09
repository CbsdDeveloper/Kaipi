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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($id_asiento,$cuenta_aux,$idprov){
		


 
	    $sql1 = 'SELECT *
            FROM co_asientod
            where id_asiento= '.$this->bd->sqlvalue_inyeccion($id_asiento,true) .' and
                  cuenta = '.$this->bd->sqlvalue_inyeccion($cuenta_aux,true);
	    
                
	    
	    $stmt1 = $this->bd->ejecutar($sql1);
	    
	    while ($fila=$this->bd->obtener_fila($stmt1)){
	        
	        
	      $x= $this->bd->query_array('co_asiento_aux',
	                                   'count(*) as nn', 
	                                   'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true).' and 
                                        id_asientod='.$this->bd->sqlvalue_inyeccion($fila['id_asientod'],true).' and  
                                        idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
	            );
	        
	        
	        if ( $x['nn'] >  0 ){
            } else    {
	            
                    $mes  			= $fila["mes"];
    				$anio  			= $fila["anio"];
    				$debe           = $fila["debe"];
    				$haber          = $fila["haber"];
    				$cuenta         = $fila["cuenta"];
    				$id_periodo     = $fila["id_periodo"];
                    $id_asientod    = $fila['id_asientod'];


                    $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
                    anio, mes, sesion, creacion, registro) VALUES (".
                    $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
                    $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
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
    				          	
    				$guardarAux = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO </b>';

                    $sql = "update co_asientod
                               set aux = ".$this->bd->sqlvalue_inyeccion( 'S' , true)."
                            where id_asientod =".$this->bd->sqlvalue_inyeccion(  $id_asientod , true);
            
                    $this->bd->ejecutar($sql);

	        }
          
	    }
	  
 
		
	}
  
	//-------------------
 	    
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['idprov']))	{
	
	$id_asiento      = trim($_GET['id_asiento']);
	$cuenta_aux      = trim($_GET['cuenta_aux']);
	$idprov          = trim($_GET['idprov']);
  
	$longitudProv = strlen(trim($idprov));
	
	if ($longitudProv > 5) {
	
	    $gestion->agregar($id_asiento,$cuenta_aux,$idprov);
	
	}else  {
	   
	    $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Nro de identificacion no registrado</b>';
	    
	    echo $guardarAux;
	    
	}
	   
    	
 
		
}

 


?>
 
  