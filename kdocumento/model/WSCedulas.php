<?php 
session_start( );   
/*require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
$bd	   =    new Db ;
$bd->conectar_sesionWS();
*/
	
 	
      
    $ruc    =  ($_GET['vid']);
    
    
    $ch = curl_init();
    
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,"https://g-kaipi.cloud/GadMocha/kcrm/model/WSCedulas_service.php");
 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'vid='.$ruc);
    
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $remote_server_output = curl_exec ($ch);
    
    // cerramos la sesión cURL
    curl_close ($ch);
    
    // hacemos lo que queramos con los datos recibidos
    // por ejemplo, los mostramos
    print_r($remote_server_output);
    
    
 
 /*
        
    $sql = "SELECT    cli_cedula,   cli_nombre_completo, cli_fecha_nacimiento
				  FROM cli_cliente
				  where  cli_cedula  =".$bd->sqlvalue_inyeccion(trim($ruc),true) ;
 
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( 
                        array("a"=>trim($dataProv['cli_cedula']), 
                              "b"=> trim($dataProv['cli_nombre_completo']) ,
                              "c"=> trim($dataProv['cli_fecha_nacimiento']) ,
                        )  
            );
    
 */
  
    
?>