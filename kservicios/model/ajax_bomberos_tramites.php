<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$servidor ='192.168.1.3';
$base_datos = 'db_cbsd';
$usuario = 'postgres';
$password = 'Cbsd2019';

$bd->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

 
 

        $tipo = $bd->retorna_tipo();

        $anio = date('Y');
            
            
        $sql = "SELECT  orden_id,   orden_codigo, orden_doc_identidad  ,
                         orden_cliente_nombre,orden_concepto, orden_total,orden_email , orden_direccion 
                            FROM recaudacion.tb_ordenescobro
                            where orden_estado = 'GENERADA' 
							order by orden_id";

  
        $resultado  = $bd->ejecutar($sql);
                

        // filtro para fechas
        
        
        while ($fetch=$bd->obtener_fila($resultado)){
          

            $nnombre        = reemplazar($fetch['orden_cliente_nombre']);

            $orden_concepto = reemplazar($fetch['orden_concepto']);

             
            
            $output[] = array (
                trim($fetch['orden_id']),
                trim($fetch['orden_codigo']),
                trim($fetch['orden_doc_identidad']),
                $nnombre,
                $orden_concepto,
                $fetch['orden_total'] ,
                trim($fetch['orden_email']),
                trim($fetch['orden_direccion'])
            );
        }


 
        pg_free_result($resultado);

        echo json_encode($output);

//------------------------------------------
function reemplazar($nombre){

    $nombre = trim($nombre);

         
    $resultado = str_replace('"','',  $nombre);

    $resultado = str_replace('/','',  $resultado);

    $resultado = str_replace('/','',  $resultado);
      
    
    return $resultado;
    
}        

?>
 