<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);




$id   = $_GET['id'] ;

if (isset($_GET['accion']))	{
    
    if ( $_GET['accion'] == 'del'){
        
        $id_bien_historico  = $_GET['id_bien_historico'] ;
        
        $sql = 'delete from activo.ac_bienes_historico
                     where id_bien_historico='.$bd->sqlvalue_inyeccion($id_bien_historico, true);
        
        $bd->ejecutar($sql);
    }
}
 

    $qquery = array(
        array( campo => 'id_bien_historico',    valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
        array( campo => 'tipo_h',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'fecha_a',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'documento_h',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'detalle_h',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'depreciacion',valor => '-',filtro => 'N', visor => 'S') ,
        array( campo => 'costo_bien',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'costo_bien_h',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'vida_util_h',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S')
     );
    
    $bd->_order_by('id_bien_historico desc');
    
    $resultado = $bd->JqueryCursorVisor('activo.view_revalorizacion',$qquery );
    
   
    
    echo '<table id="jsontableReval" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Codigo </th>
                <th> Fecha </th>
                <th> Novedad </th>
                <th> Documento </th>
                <th> Detalle </th>
                <th> Depreciacion? </th>
                <th> Costo Anterior </th>
                <th> Costo Actual </th>
                <th> Vida Util Anterior </th>
                <th> Vida Util Actual</th>
                <th> Acciones</th></thead> </tr>';
    
    
    
    
    while ($fetch=$bd->obtener_fila($resultado)){
        
        $idproducto =  $fetch['id_bien_historico'] ;
        
         
        $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURL_Revaldel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
        
     
        
        echo ' <tr>';
        
        echo ' <td>'.$idproducto.'</td>';
        echo ' <td>'.$fetch['fecha_a'].'</td>';
        echo ' <td>'.$fetch['tipo_h'].'</td>';
        echo ' <td>'.$fetch['documento_h'].'</td>';
        echo ' <td>'.$fetch['detalle_h'].'</td>';
        echo ' <td>'.$fetch['depreciacion'].'</td>';
        echo ' <td>'.$fetch['costo_bien'].'</td>';
        echo ' <td>'.$fetch['costo_bien_h'].'</td>';
        echo ' <td>'.$fetch['vida_util'].'</td>';
        echo ' <td>'.$fetch['vida_util_h'].'</td>';
        echo ' <td>'.$boton1.'</td>';
        
        echo ' </tr>';
    }
    
    
    echo "   </tbody>
               </table>";
    
    
    pg_free_result($resultado);
     

?>