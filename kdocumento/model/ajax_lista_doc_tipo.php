<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
     $sesion 	 =  $_SESSION['email'];
   
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
    $tipodoc   =     $_GET["tipodoc"];
    $f1        =     $_GET["f1"];
    $f2        =     $_GET["f2"];
    $nombre    =     'tabla_lista';
    
 

    $unidad_actual                 = $bd->query_array('par_usuario','*',  "email = ".$bd->sqlvalue_inyeccion( $sesion  ,true) );
    $id_departamento_unidad        = $unidad_actual['id_departamento'] ;


 

    $sql = "select idcasodoc ,idcaso ,sesion,documento ,tipodoc ,fecha,envia ,caso,completo,id_departamento ,id_temp_doc
             from flow.view_doc_generados
            where tipodoc = ".$bd->sqlvalue_inyeccion( trim($tipodoc) ,true)." and 
                  id_departamento= ".$bd->sqlvalue_inyeccion( trim($id_departamento_unidad) ,true)." and
                  fecha between ".$bd->sqlvalue_inyeccion( $f1 ,true)."  and 
                                ".$bd->sqlvalue_inyeccion( $f2,true)." 
            order by secuencia desc";
 
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
    
    
    echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%" style="font-size: 11px">
    <thead> <tr>';
    echo '<th width="25%" bgcolor="#167cd8" style="color: #F4F4F4">Documento</th>';
    echo '<th width="25%" bgcolor="#167cd8" style="color: #F4F4F4">Generado por</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Tramite</th>';
    echo '<th width="20%" bgcolor="#167cd8" style="color: #F4F4F4">Asunto</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Accion</th>';
    echo '</tr></thead><tbody>';
    
    
     
    while($row=pg_fetch_assoc($resultado)) {
        
        echo "<tr>";
        
        $envia = trim($row['envia']);
        
        if (  $envia == '1') {
            $imagen= '<img src="../../kimages/m_verde.png" width="16" height="16"/>';
        }else {
            $imagen= ' <img src="../../kimages/m_rojo.png" width="16" height="16"/>';
        }
        
        
        
       
        echo "<td><b>".trim($row['documento']).'</b></td>';
        echo "<td>".trim($row['completo']).'</td>';
        echo "<td>".trim($row['fecha']).'</td>';
        echo "<td>".trim($row['idcaso']).'</td>';
        echo "<td>".trim($row['caso']).'</td>';
        
        echo '<td>'.$imagen.'</td>';
        
        echo "</tr>";
    }
     
 
 
    echo "</tbody></table>";
    
    pg_free_result ($resultado) ;

?>
 
  