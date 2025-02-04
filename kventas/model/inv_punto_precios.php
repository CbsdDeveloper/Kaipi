 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
 
 $idproducto  = $_GET['idproducto'];
 $id          = $_GET['id'];
  
 
 
 $sql1 = 'select detalle,monto 
           from inv_producto_vta 
          where id_producto ='.$bd->sqlvalue_inyeccion($idproducto,true) ;
 
 
 
 $stmt1 = $bd->ejecutar($sql1);
 
 $VisorArticuloPrecios = ' <h2>Lista de Precios</h2> <ul class="list-group">';

 
 while ($fila=$bd->obtener_fila($stmt1)){
     
     $evento = ' onClick="ActualizaPrecio('.$id.','.$fila['monto'].','."'".trim($fila['detalle'])."'".','.$idproducto.' )" ';
   
     $VisorArticuloPrecios .= '<li class="list-group-item"><a href="#"  '.$evento.' >'.
                                $fila['detalle'].'<span class="badge">'.
                                $fila['monto'].'</span></a>
                              </li>';
 }
 
 $VisorArticuloPrecios .= '</ul>';
     
 echo $VisorArticuloPrecios;
 
?>