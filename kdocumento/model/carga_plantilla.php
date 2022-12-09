<?php
session_start();

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  

 
    $obj     = 	new objects;

 
    $bd	   =	new Db ;
  
 
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

    $xx      = $_GET['idplantilla'];
    $asunto  = $_GET['asunto'];
    $idproceso    		= $_GET['idproceso'];
    $idcaso            	= $_GET['idcaso'];
    $tipo              	= $_GET['tipo'];
    $sesion 	        =  trim($_SESSION['sesion']);

            $Aexiste = $bd->query_array('flow.wk_doc_modelo',  
                'formato,esdetalle,vista,variable',  
                'id_docmodelo='.$bd->sqlvalue_inyeccion($xx,true)   );
           
            $editor1 = $Aexiste['formato'] ;
            
            //---- ES DETALLE

            
            $detalle_datos    =  $Aexiste['esdetalle'];
            $sql_detalle      =  $Aexiste['vista'];
            $variable_detalle =  $Aexiste['variable'];
            $cabecera         =  $editor1 ;

            $sql                = "SELECT lower(funcionario) funcionario,cedula, tipo
                                    FROM  flow.view_proceso_doc_user
                                    where inicio = 'S' and 
                                          idcaso= ".$bd->sqlvalue_inyeccion($idcaso, true) .' order by tipo desc';

            $stmtUser           = $bd->ejecutar($sql);

            
            
 

                // informacion de tramite  
                $ay                 = $bd->query_array('flow.view_proceso_caso',  '*',  'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true));
                $idprov             =  $ay['idprov'];
                $modulo_sistema     =  $ay['modulo_sistema'];

                $xyy                = $bd->query_array('view_nomina_user','lower(cargo) as cargo,inicial,adicional', 'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true));
                $cargo_solicita1    = '<b>'.strtoupper($xyy['cargo']).'</b>';

                $inicial            =  trim($xyy['inicial']).' ' ;
                $nombre_solicita    =  $inicial .' '.strtolower($ay['nombre_solicita']);
                $cabeceraUs         = '';
                $cabeceraPa         = ''; 
                

                $tabulacions2       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $tabulacions3       = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';


                $tipo_documento     = 0;

                if ( $tipo == 'Memo'){
                    $tipo_documento     = 1;
                }   
                
                if ( $tipo == 'Circular'){
                    $tipo_documento     = 1;
                }

                
                if (  $tipo_documento  == 1){
                       
                    $i= 1;

                    while ($xx=$bd->obtener_fila($stmtUser)){


                        $idprov      =  trim($xx['cedula']) ;
                        $xy          =   $bd->query_array('view_nomina_user','lower(cargo) as cargo,inicial,adicional', 'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) );
                        $funcionario =   ucwords(trim($xx['funcionario']))  ;
                        $inicial     =   trim($xy['inicial']).' ' ;
                        $adicional   =   trim($xy['adicional']) ;
                        $cargo       =   ucwords($xy['cargo'])  ;

                        if (  trim($xx['tipo'])  == 'S'){
                            if (!empty( $adicional)){
                                $adicional = ','. trim($xy['adicional']) ;
                            }  
                            if ( $i == 1 ){
                                    $cabeceraUs =  trim($cabeceraUs). $tabulacions2.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
                            } else {
                                    $cabeceraUs =  trim($cabeceraUs). $tabulacions3.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
                            }   
                         } 

                        if ( trim($xx['tipo'])  == 'C'){
                            $cabeceraPa =  $cabeceraPa. $tabulacions3.''. trim($inicial).trim($funcionario).$adicional.'<br><b>'.  $tabulacions3.trim($cargo) .'</b><br>';
                        } 

 
                        $i++;
                    }  

                     $nombre_solicita   =   ucwords($nombre_solicita );
                     $cabeceraUs        = '<b>PARA:</b>'.$cabeceraUs;

                     if ( !empty($cabeceraPa)){
                              $cabeceraUs =  $cabeceraUs.'<b>CC:</b>'.$cabeceraPa;
                     }  
                     $cabeceraUs = $cabeceraUs.'<br><b>ASUNTO:</b>'.$tabulacions2.$asunto.'<br>';
                    $cabecera    =  str_replace ('#MEMO', $cabeceraUs , $cabecera);

                }
                ///-------------------------------------------
                $sql = 'SELECT  variable, valor,    variable_sis
                        FROM flow.view_proceso_caso_var
                        where idcaso= '.$bd->sqlvalue_inyeccion($idcaso, true).'  and
                              idproceso='.$bd->sqlvalue_inyeccion($idproceso, true).' and valor is not null';
                
                
                $stmtD = $bd->ejecutar($sql);
                while ($x=$bd->obtener_fila($stmtD)){
                    $cabecera =  str_replace (trim($x['variable_sis']), trim($x['valor']) , $cabecera);
                }
        
     
                 $cabecera =  str_replace ('#CASO', trim($ay['caso']) , $cabecera);
                 $cabecera =  str_replace ('#FECHA_PROCESO',   $ay['fecha']  , $cabecera);
                 $cabecera =  str_replace ('#TRAMITE',   $idcaso  , $cabecera);
                 
                 $SOLICITA    = ucwords($nombre_solicita).'<br>'. $cargo_solicita1  ;
                 $cabecera    =  str_replace ('#SOLICITA',   $SOLICITA , $cabecera);

                 $sesion 	 =  trim($_SESSION['email']);
                 $datos      =  $bd->__user($sesion);
                 $elabora    =  substr($datos['apellido'],0,1).'/'.substr($datos['nombre'],0,1).'.';
                 $elaborac    = 'Elaborador por: '.trim($datos['apellido']).' '.trim($datos['nombre']).'/'.trim($datos['cargo']);
                 
                 $cabecera   =  str_replace ('#ELABORA',   $elabora   , $cabecera);
                
                 
                 
                 $cabecera =  str_replace ('#COMPLETO_DOC', $elaborac , $cabecera);
                
                 $tipo_db       = $bd->retorna_tipo();

                 if ( $detalle_datos == 'S'){
                     $cabecera_sql  =  str_replace ('#CASO', $idcaso , $sql_detalle);
                     $resultado     = $bd->ejecutar($cabecera_sql);
                     $sql_resultado =  $obj->grid->KP_GRID_EXCEL($resultado,$tipo_db);
                     $cabecera =  str_replace ($variable_detalle,   $sql_resultado  , $cabecera);
                 }
                 
                 //--------------------------------------
                 $sql           = "SELECT  funcionario,cedula
                                    FROM flow.view_proceso_doc_user
                                    where tipo = 'N' and idcaso= ".$bd->sqlvalue_inyeccion($idcaso, true) ;
                 
                 $stmtUsercc     = $bd->ejecutar($sql);

                 $cabeceraUs     = '';
                 
                 while ($xxx=$bd->obtener_fila($stmtUsercc)){

                     $idprov      =  $xxx['cedula'] ;
                     
                     $funcionario =  $xxx['funcionario'] ;
                     
                     $xy          = $bd->query_array('view_nomina_user',   // TABLA
                                                    'cargo',                        // CAMPOS
                                                    'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) // CONDICION
                                                    );
                     $cabeceraUs =  '<b>'.$funcionario.'</b><br>'. $xy['cargo'].'<br>'.$cabeceraUs;

                 }
                 
                  $cabecera =  str_replace ('#COPIA', $cabeceraUs , $cabecera);
                 
                
               
                  
          

            if (  $modulo_sistema == 'C'){

             
                $cabecera_sql = 'SELECT   tipo as documento, detalle as observacion,   estado as valido 
                                FROM co_control
                                where idcaso= '.$bd->sqlvalue_inyeccion($idcaso, true);
        

                $resultado = $bd->ejecutar($cabecera_sql);
                     
                $sql_resultado =  $obj->grid->KP_GRID_EXCEL_doc($resultado,$tipo_db);
                
                $cabecera =  str_replace ('#CONTROLPREVIO',   $sql_resultado  , $cabecera);

            }
 

           
            
            echo json_encode(    array("a"=> $cabecera  ),JSON_INVALID_UTF8_IGNORE     );
 
 

?>
 
  