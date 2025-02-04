<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	       
    $idprov	    =	trim($_GET["idprov"]);
    $accion	    =	trim($_GET["accion"]);
    
    if ( $accion == 'editar') {
    
                 $hoy 	     =   date("Y-m-d");  
                 $comment	=	$hoy.' '.trim($_GET["comment"]);
                
                $sql = "update par_ciu
                          set novedad = ".$bd->sqlvalue_inyeccion($comment, true)."
             		    where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true) ;
                
                
                $bd->ejecutar($sql);
         
        $guardarNovedad = 'Guardado con exito';
        
        echo $guardarNovedad;
    }
    
    if ( $accion == 'visor') {
        
        $x = $bd->query_array('par_ciu','novedad', 'idprov='.$bd->sqlvalue_inyeccion($idprov,true));
        
        $comment = trim($x["novedad"]);
        
        echo  $comment;
    }
    
    
?>