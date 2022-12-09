<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $bd	   =	new Db ;
    
  
    $sesion 	 =    $_SESSION['email'];
   
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
    $tipodoc   =     trim($_GET["tipodoc"]);

    $filtro    =     trim($_GET["tipo"]);
    
    $anio      =     date('Y');

    $f1    =     trim($_GET["f1"]);
    $f2    =     trim($_GET["f2"]);
     
    $nombre = 'IdTablaMemos';

    
    if (  $filtro  == '1') {
        
                $sqlmemo = "SELECT *
                FROM flow.wk_doc_user_temp
              WHERE   anio =".$bd->sqlvalue_inyeccion( $anio ,true) .' and
                      sesion ='.$bd->sqlvalue_inyeccion( trim($sesion) ,true)  .'
                    order by  documento desc limit 25';
    }

    if (  $filtro  == '2') {
        
        $sqlmemo = "SELECT idcaso,anio,tipodoc as tipo,documento,fecha,nombre_solicita,asunto
                FROM flow.view_doc_generados
              WHERE   anio =".$bd->sqlvalue_inyeccion( $anio ,true) .' and
                      sesion ='.$bd->sqlvalue_inyeccion( trim($sesion) ,true)  .' and
                      fecha between '.$bd->sqlvalue_inyeccion( $f1 ,true). ' and '.$bd->sqlvalue_inyeccion( $f2 ,true).' 
                    order by  documento desc';
        
     
    }
 
    
    if (  $filtro  == '3') {
        
        $sqlmemo = "select  a.idcaso,a.anio,b.tipo_temp as tipo,b.documento,a.fecha,a.nombre_solicita,b.asunto
                 from flow.view_doc_tarea a
                   join flow.view_doc_generados b on a.idcaso = b.idcaso  and 
                        a.sesion = b.sesion and 
                        a.leido = 1 and 
                        a.sesion = ".$bd->sqlvalue_inyeccion( trim($sesion) ,true)  .' and
                      a.fecha between '.$bd->sqlvalue_inyeccion( $f1 ,true). ' and '.$bd->sqlvalue_inyeccion( $f2 ,true).'
                    order by  b.documento desc';
 
         
    }
    
 
    
    if (  $filtro  == '4') {
        
        $sqlmemo = "select  a.idcaso,a.anio,b.tipo_temp as tipo,b.documento,a.fecha,a.nombre_solicita,b.asunto
                 from flow.view_doc_tarea a
                   join flow.view_doc_generados b on a.idcaso = b.idcaso  and
                        a.sesion = b.sesion and
                        a.reasignado = 'S' and
                        a.sesion = ".$bd->sqlvalue_inyeccion( trim($sesion) ,true)  .' and
                      a.fecha between '.$bd->sqlvalue_inyeccion( $f1 ,true). ' and '.$bd->sqlvalue_inyeccion( $f2 ,true).'
                    order by  b.documento desc';
        
        
    }
    
      

    echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%" style="font-size: 11px">
    <thead> <tr>';
      echo '<th width="25%" bgcolor="#167cd8" style="color: #F4F4F4">Documento</th>';
      echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Tramite</th>';
      echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
      echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Funcionario</th>';
      echo '<th width="20%" bgcolor="#167cd8" style="color: #F4F4F4">Asunto</th>';
      echo '<th width="25%" bgcolor="#167cd8" style="color: #F4F4F4">Caso</th>';
     echo '</tr></thead><tbody>';
 


 

  $resultadosqlmemo  = $bd->ejecutar($sqlmemo);

    while($row=pg_fetch_assoc($resultadosqlmemo)) {
            
        
      $anio       =  $row['anio'];
      $tipodoc    =  trim($row['tipo']);
      $memorando  =  trim($row['documento']);
      $idcaso     =  trim($row['idcaso']);

 

      $xx = $bd->query_array('flow.view_proceso_doc',  '*',
                             'tipodoc='.$bd->sqlvalue_inyeccion( $tipodoc ,true)  .' and 
                             documento='.$bd->sqlvalue_inyeccion(  $memorando ,true)
      );

      $xy = $bd->query_array('flow.wk_proceso_caso', '*', 'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true)  );

      $evento = 'CargaDatos('. $idcaso.')';
      $referencia = ' href="#" title= "Visualizar recorrido del tramite" onClick="'.$evento.'"  ';
     
      $eventoa     = 'Ver_doc_prov_m('. $idcaso.')';
      $referenciaa = ' href="#" title= "Visualizar recorrido del tramite" onClick="'.$eventoa.'"   ';
     
 
      $eventoa     = 'Ver_doc_prov_a('. $idcaso.')';
      $referencia2=  ' href="#" title= "Verificar documentos"  onClick="'.$eventoa.'"  ';
      
      
      echo "<td><a ".$referencia2." ><b>".  $memorando.'</b></a></td>';
      echo "<td><a title='VISUALIZAR ARCHIVOS ADJUNTOS' ".$referenciaa." >".trim($xx['idcaso']).'</a></td>';
      echo "<td><a title='VISUALIZAR RECORRIDO DEL TRAMITE' ".$referencia." >".trim($xx['fecha']).'</a></td>';
      echo "<td>".trim($xx['nombre_solicita']).'</td>';
      echo "<td>".trim($xx['asunto']).'</td>';
  
      // $memito = $url.trim( $memorando ).'.pdf';

    

      echo "<td>".trim($xy['caso']).'</td>';
      
  
      echo "</tr>";
      
  }
  
  
  echo "</tbody></table>";
  
  pg_free_result ($resultadosqlmemo) ;

?>
 
  