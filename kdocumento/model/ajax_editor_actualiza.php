<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
      $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $contenido           = trim($_POST['editor1']);
    
    $idcasodoc           = $_POST['idcasodoc'];
    
    $idcaso =   $_POST['id'];
    
    $qquery = array(
        array( campo => 'id_proc_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'idcaso',valor => $idcaso,filtro => 'S', visor => 'S'),
        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'inicio',valor =>  'S',filtro => 'S', visor => 'S'),
        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S')
    );
    
    $resultado_doc = $bd->JqueryCursorVisor('flow.proceso_doc',$qquery,   );
    
    $anexo_doc = '';
    $k         = 1;
    
    while ($fetch_doc=$bd->obtener_fila($resultado_doc)){
        $detalle     =  trim($fetch_doc['detalle']) ;
        $anexo_doc  =   $anexo_doc.$detalle.'<br>';
        $k++;
    }
    
   
  

    $variable = "'times new roman',";

    $cabecera =  str_replace ( $variable, ' '  ,  $contenido   );
    $cabecera =  str_replace ('12pt',  '11pt', $cabecera);
    
    if ( $k >= 1 ){
        $anexo_doc = '<b>ANEXO</b><br>'.$anexo_doc;
        $cabecera =  str_replace ('#ANEXO_DOC', trim($anexo_doc) , trim($cabecera));
    }
    

    $sql = "UPDATE flow.wk_proceso_casodoc
                           SET  editor= "."'". $cabecera ."'" ."
                         WHERE idcasodoc =".$bd->sqlvalue_inyeccion($idcasodoc, true);

    $bd->ejecutar($sql);
    
    echo 'Estado de la tarea actualizada...';
     
?>
 
  