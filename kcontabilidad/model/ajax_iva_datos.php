<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
  
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
  
  
 
        $x = $bd->query_array('view_anexos_compras',   // TABLA
        '(coalesce(sum( valorretbienes),0)  + coalesce(sum( valorretservicios),0) + coalesce(sum( valretserv100),0))  as suma',                        // CAMPOS
        'id_tramite='.$bd->sqlvalue_inyeccion($_GET['idtramite'],true)." and estado = 'S' "
        );

        $base     = 0;
        $retencion= 0 ;


        $sql_dato = "select coalesce(sum( a.valretair),0) retencion,coalesce(sum( a.baseimpair),0) as base
                    from view_anexos_fuente a , 
                         view_anexos_compras b
                    where a.id_compras = b.id_compras and 
                          b.estado = 'S' and 
                          b.id_tramite =".$bd->sqlvalue_inyeccion($_GET['idtramite'],true);

                    $resultado  = $bd->ejecutar($sql_dato);

                    while ($y=$bd->obtener_fila($resultado)){
                        $base     = $y['base'] +  $base;
                        $retencion= $y['retencion'] +  $retencion ;
                    }                    

     


       echo ' <h4>RETENCION IVA : '.   number_format($x['suma'],2).
       '<br>BASE RETENCION FUENTE:'. number_format($base,2).'<br>MONTO RETENCION FUENTE:'. number_format( $retencion,2) .'</h4>';


 
	 
      
 	 
?>