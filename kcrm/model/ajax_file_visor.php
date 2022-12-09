<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
 
    $accion         = trim($_GET['accion']) ;
    $idcaso         = $_GET['idcaso'] ;
    $idcodigo       = $_GET['idcodigo'] ;
 
 
 
    
        
    
    if ( $accion == 'visor')    {
        
        BusquedaDoc($bd	, $idcaso);
        
     
    }
    
    
    if ( $accion == 'del')    {
        
        $tabla = 'flow.wk_proceso_descarga';
            
        $bd->JqueryDeleteSQL ($tabla ,'idproceso_des='.$bd->sqlvalue_inyeccion($idcodigo , true));
        
        
        BusquedaDoc($bd	, $idcaso);
        
        
    }
    
 //------------ funcion tabla
    function BusquedaDoc($bd	, $id){
        
        // Soporte Tecnico
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
        
        
        
        
        $qquery = array(
            array( campo => 'idproceso_des',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idproceso',valor => $id ,filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'prioridad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $bd->JqueryCursorVisor('flow.wk_proceso_descarga',$qquery  );
        
        
        echo '<table id="jsontableDocUserVisor" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th '. $estilo. ' width="40%" > Detalle </th>
                 <th '. $estilo. ' width="30%" > Archivo </th>
			     <th '. $estilo. ' width="20%" > Prioridad </th>
                 <th '. $estilo. ' width="10%" > Acciones</th></thead> </tr>';
        
        
        
        
        while ($fetch=$bd->obtener_fila($resultado)){
            
            $idproducto =   $fetch['idproceso_des'] ;
             
            $boton1 = ' ';
            
            
            $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            
            
            
            $boton2 = '<button class="btn btn-xs btn-warning"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
            
            echo ' <tr>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['archivo'].'</td>';
            echo ' <td>'.$fetch['prioridad'].'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    
    

?>