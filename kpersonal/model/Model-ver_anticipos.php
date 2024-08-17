<?php 
session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     
     
     $obj   = 	new objects;
     $bd	   =	new Db;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
     $anio       =  $_SESSION['anio'];

     $tipo = $bd->retorna_tipo();
     
 

     $sql = 'select  identificacion,
                    funcionario,
                     solicitado, 
                     coalesce(pagado,0) as pagado,
                     solicitado - coalesce(pagado,0) saldo, 
                     mensual,mes as MES_SOLICITA,plazo
     from view_anticipo_res
     where solicitado - coalesce(pagado,0) > 0 and
           anio = '.$bd->sqlvalue_inyeccion( $anio , true).' order by funcionario';
 

    $resultado = $bd->ejecutar($sql);

    $variables  = 'id_rol=0';

    //$obj->grid->KP_sumatoria(7,"Ingreso","Descuento", "Pagar","");

    $obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'N','','','' ,$bd  );

     
   
 ?>
 
  