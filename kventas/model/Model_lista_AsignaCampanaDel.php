<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sesion 	 =     trim($_SESSION['email']);
	
	$id			 =     $_GET["id"];
	
	$idcampana   =     $_GET["idcampana"];
	
	$accion		 =     trim($_GET["accion"]);
	
	
	if ( trim($accion) == 'del'){
	    
	    $sql = "DELETE  FROM  ven_cliente
                where idvencliente =".$bd->sqlvalue_inyeccion($id,true). ' and estado < '.$bd->sqlvalue_inyeccion('3',true);
	} 
	
	if ( trim($accion) == 'anular'){
	    
	    $sql = "UPDATE ven_cliente
                SET id_campana = ".$bd->sqlvalue_inyeccion('0',true).",
                     estado = ".$bd->sqlvalue_inyeccion('0',true)."   
              where idvencliente= ".$bd->sqlvalue_inyeccion($id,true). ' and estado < '.$bd->sqlvalue_inyeccion('3',true);
	    
	}
	 	    
	if ( trim($accion) == 'ver'){
	    
	    $sql = "UPDATE ven_cliente
                SET id_campana = ".$bd->sqlvalue_inyeccion($idcampana,true).",
                    proceso = ".$bd->sqlvalue_inyeccion('enviar',true).",
                    estado = ".$bd->sqlvalue_inyeccion('2',true)."
              where idvencliente= ".$bd->sqlvalue_inyeccion($id,true).' 
                    and   id_campana  ='.$bd->sqlvalue_inyeccion(0,true) ;
	    
	}
             
 
       $bd->ejecutar($sql);
		
       
       
       //---------------------
       if ( trim($accion) == 'ver'){
           
           $sql = "UPDATE ven_cliente
                SET   estado = ".$bd->sqlvalue_inyeccion('2',true).",
                      proceso = ".$bd->sqlvalue_inyeccion('enviar',true)." 
              where idvencliente= ".$bd->sqlvalue_inyeccion($id,true).' and  
                    id_campana  ='.$bd->sqlvalue_inyeccion($idcampana,true) ;
           
                  $bd->ejecutar($sql);
           
       }
       
     
       $ProcesoInformacion = 'Registros Procesado accion: '.$accion. ' '. $id  ;
  
       echo $ProcesoInformacion;
  
?>
 
  