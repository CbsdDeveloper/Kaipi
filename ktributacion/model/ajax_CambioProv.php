 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $idprov      = trim($_GET['idprov']);
    $razon       = trim($_GET['razon']);
    $id_compras  = $_GET['id_compras'] ;
    
    $longitud = strlen( $idprov) ;

   
   if (  $longitud == 10  ){

        $idprov_cambio  = $idprov.'001';

        $x = $bd->query_array('par_ciu',   // TABLA
        'count(*) as nn ',                        // CAMPOS
        'idprov='.$bd->sqlvalue_inyeccion($idprov_cambio ,true) // CONDICION
       );

            if ( $x['nn']  > 0 ) {
 
                $sql = "update co_asiento set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql);
                
                $sql1 = "update co_asiento_aux set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql1);

                $sql2 = "update co_compras set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql2);

                $sql3 = "update inv_movimiento set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql3);

            }else
            {


                $sql21 = "update co_compras set idprov =".$bd->sqlvalue_inyeccion('9999999999999',true). " 
                          where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;

                $bd->ejecutar($sql21);

                $sql0 = "update par_ciu 
                            set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " ,
                                razon =".$bd->sqlvalue_inyeccion($razon,true). "
                          where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;

                $bd->ejecutar($sql0);

       
                $sql = "update co_asiento set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql);
                
                $sql1 = "update co_asiento_aux set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql1);

                 $sql2 = "update co_compras set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " 
                where idprov=".$bd->sqlvalue_inyeccion('9999999999999',true) ;
                $bd->ejecutar($sql2);

                $sql3 = "update inv_movimiento set idprov =".$bd->sqlvalue_inyeccion($idprov_cambio,true). " where idprov=".$bd->sqlvalue_inyeccion($idprov,true) ;
                $bd->ejecutar($sql3);
              
            }

            echo 'Dato Actualizado correctamente ... '.$x['nn'] .' - '.$idprov_cambio;

   }else
   {
    echo 'Cambio no se puede Actualizar  ... '.$idprov;
}


 
     
    
?>