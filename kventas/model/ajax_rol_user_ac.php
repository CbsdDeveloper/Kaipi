<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$idusuario 	    = $_GET['idusuario'];
$tipo	 		= $_GET['tipo'];
$sector	 		= $_GET['sector'];
$idvengrupo	 	= $_GET['idvengrupo'];

 

//-------------------------------------------------
if ( $tipo == 'add'){
    
    //                            idvengrupo=".$bd->sqlvalue_inyeccion($idvengrupo, true)." and
    
      
    $sql = "SELECT count(*) as nexiste
                	  FROM ven_cliente_zona
                      where idusuario=".$bd->sqlvalue_inyeccion($idusuario, true)." and 
                            sector=".$bd->sqlvalue_inyeccion(trim($sector), true) ;
    
    $resultado 			= $bd->ejecutar($sql);
    $validaRegistro     = $bd->obtener_array($resultado);
     
    if ( $validaRegistro['nexiste'] == 0 ) {
 
         $sql = 'INSERT INTO ven_cliente_zona  ( idusuario, sector,  idvengrupo)
			            				VALUES ('.$bd->sqlvalue_inyeccion($idusuario, true).','.
			            				          $bd->sqlvalue_inyeccion(trim($sector), true).','.
			            				          $bd->sqlvalue_inyeccion(trim($idvengrupo), true).')';
 			            				         
			            				          
		 $bd->ejecutar($sql);
    }
}

///-----------------------------------------

if ( $tipo == 'del'){
    $idcodigo 	    = $_GET['idcodigo'];
    $sql = " delete
               from ven_cliente_zona
               where idvenclizona		=".$bd->sqlvalue_inyeccion($idcodigo, true);
    
    $bd->ejecutar($sql);
}



///-----------------------------------------
$sql1 = 'select idvenclizona, idusuario, sector,  idvengrupo
           from ven_cliente_zona 
          where idusuario = '.$bd->sqlvalue_inyeccion($idusuario,true). ' and 
                idvengrupo='.$bd->sqlvalue_inyeccion($idvengrupo,true);
 
 
        $stmt1 = $bd->ejecutar($sql1);
 
        $asignado ='';

        while ($x=$bd->obtener_fila($stmt1)){
            
            $nombre         = trim($x['sector']);
         
            $idvenclizona   =  ($x['idvenclizona']);
            
            $mensaje = "javascript:asignav(". $idvenclizona. ",".$idusuario.",'del')";
            
            $asignado  = $asignado.' <a href="#" onClick="'.$mensaje.' " class="list-group-item">'.$nombre.'</a>';
            
        }

        $asignado= '<div class="alert alert-info"><div class="row"  style="padding: 8px">'.$asignado.'</div></div>';

echo $asignado;



?>
								
 
 
 