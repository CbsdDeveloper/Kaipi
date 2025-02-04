<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  

 
    $obj     = 	new objects;

 
    $bd	   =	new Db ;
  
 
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
    
            $xx   = $_GET['idplantilla'];
            $para = trim($_GET['para']);
 
            $idcaso            	= $_GET['idcaso'];
            $asunto             = $_GET['asunto'];              
            
            $sesion 	        = trim($_SESSION['email']);
            $usuario_dato       = $bd->__user($sesion);
            $orden_unidad       = substr( $usuario_dato['orden'],0,1);
            $nombre_solicita    = trim($usuario_dato['completo_min']);
            $cargo_solicita1    = trim($usuario_dato['cargo_min']);

            $Aexiste          = $bd->query_array('flow.wk_doc_modelo', 'formato,esdetalle,vista,variable',   'id_docmodelo='.$bd->sqlvalue_inyeccion($xx,true) );
       /*     $detalle_datos    =  $Aexiste['esdetalle'];
            $sql_detalle      =  $Aexiste['vista'];
            $variable_detalle =  $Aexiste['variable']; */
                            
         
            $varios_user     = $bd->query_array('flow.view_proceso_doc_user',  'count(*) as nn', 
                               "bandera = 0 and 
                                inicio = 'N' and 
                                tipo = 'N' and 
                                idcaso= ".$bd->sqlvalue_inyeccion($idcaso, true) .' and 
                                orden like '.$bd->sqlvalue_inyeccion($orden_unidad .'%', true)  );

             $cabecera         = $Aexiste['formato'];   


             if ( $varios_user['nn'] > 0) {
                        $memo =   varios_usuarios($bd,$idcaso,$orden_unidad);
                        $cabecera =  str_replace ('#MEMO', $memo , $cabecera);
 
            }  else{
                        $cabeceraUs= para_usuarios($bd,$idcaso,$para,$asunto);
                        $cabecera =  str_replace ('#MEMO', $cabeceraUs , $cabecera);
            }
       
            $SOLICITA    =  ucwords($nombre_solicita).'<br>'. $cargo_solicita1  ;
            $cabecera    =  str_replace ('#SOLICITA',   $SOLICITA , $cabecera);
            $elabora     =  substr($usuario_dato['apellido'],0,1).'/'.substr($usuario_dato['nombre'],0,1).'.';
            $cabecera    =  str_replace ('#ELABORA',   $elabora   , $cabecera);
                
            $elaborac    = 'Elaborador por: '.trim($usuario_dato['apellido']).' '.trim($usuario_dato['nombre']).'/'.trim($usuario_dato['cargo']);
            $cabecera    =  str_replace ('#COMPLETO_DOC', $elaborac , $cabecera);
            
                               
            echo json_encode(    array("a"=> $cabecera  ) , JSON_INVALID_UTF8_IGNORE     );
 
/*
AGREGA UN  DESTINATARIO PARA EL ENVIO LA INFORMACION....
*/            
function para_usuarios($bd,$idcaso,$para,$asunto){   

    $xx            = $bd->query_array('view_nomina_user',    
                    'lower(cargo) as cargo,inicial,adicional,lower(completo) as completo',  
                    'email='.$bd->sqlvalue_inyeccion(trim($para),true)  );

    $cargo         = ucwords($xx['cargo']);

    $cabeceraUs   = '';
    $funcionario  = ucwords(trim($xx['completo']))  ;
    $inicial      = trim($xx['inicial']).' ' ;

    $tabulacions2       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $tabulacions3       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $adicional =  trim($xx['adicional']) ;

            if (!empty( $adicional)){
                $adicional = ','. trim($xx['adicional']) ;
            }  
            $cabeceraUs =  $cabeceraUs. $tabulacions2.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
            $cabeceraUs = '<b>PARA:</b>'.$cabeceraUs;
            $cabeceraUs = $cabeceraUs.'<br><b>ASUNTO:</b>'.$tabulacion2.$asunto.'<br><br>';

return   $cabeceraUs;

}             
/*
AGREGA VARIOS DESTINATARIOS PARA EL ENVIO LA INFORMACION....
*/            
  function varios_usuarios($bd,$idcaso,$orden_unidad){

            $sql = "SELECT  funcionario ,cedula
                    FROM flow.view_proceso_doc_user
                    where bandera = 0 and 
                                        inicio = 'N' and 
                                        tipo = 'N' and 
                                        idcaso= ".$bd->sqlvalue_inyeccion($idcaso, true) .' and 
                                        orden like '.$bd->sqlvalue_inyeccion($orden_unidad .'%', true);
 
        $stmtUsercc = $bd->ejecutar($sql);
        $cabeceraUs = '';

        $tabulacions2       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $tabulacions3       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

        $i = 1;

       
        while ($row=$bd->obtener_fila($stmtUsercc)){

            $idprov      =  trim($row['cedula']) ;

            $xy          =  $bd->query_array('view_nomina_user',
                                             'lower(cargo) as cargo,inicial,adicional,lower(completo) as completo',
                                              'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true)  );
        
            
            $cargo          =  ucwords(trim($xy['cargo'])) ;
            $funcionario    =  ucwords(trim($xy['completo'])) ;

            $inicial     =   trim($xy['inicial']).' ' ;
            $adicional   =   trim($xy['adicional']) ;
            

                if (!empty( $adicional)){
                    $adicional = ','. trim($xy['adicional']) ;
                }  
                if ( $i == 1 ){
                        $cabeceraUs =  trim($cabeceraUs). $tabulacions2.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
                } else {
                        $cabeceraUs =  trim($cabeceraUs). $tabulacions3.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
                }   
          

            $i++;
        }
 
        $cabeceraUsdato = '<b>PARA:</b>'.$cabeceraUs;

        return $cabeceraUsdato; 

  }

?>
 
  