<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
 
    $sesion 	 =  trim($_SESSION['email']);
   
    $hoy 	     =     date("Y-m-d"); 
    $dia 	     =     date("d"); 
    $mes 	     =     date("m"); 
    $anio 	     =     date("Y"); 
    
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $usuario 	     =  trim($_SESSION['usuario']);
    $contenido       =  trim($_POST['editor1']) ;
    $asunto          =  trim($_POST["asunto"]);
    
    $idproceso       =  21;  
    $documento       =  $_POST["documento"];
    $tipoDoc         =  $_POST["tipo"];
    $idcasodoc       =  $_POST["id"];

    $uso             =  'I';
    $accion_doc      =  trim($_POST['accion_doc']);


    if ( trim($_POST["tipo"]) == '-'){
        $tipoDoc   = 'Memo';
    }

    if ( trim(empty($_POST["tipo"]))){
        $tipoDoc   = 'Memo';
    }


    $secuencia_dato  =  $_POST["secuencia_dato"];
    $idcaso          =  $_POST['idcaso'];
    
    $idcaso_add      =  $_POST['casoid'];
    
    if ($_POST['casoid'] > 0 ) {
        $idcaso      =   $idcaso_add  ;
    }
  

    if (  $accion_doc  == 'add'){
        $idcaso      =  $_POST['casoid'];
    }
    
    // BUSCA TRAMITE PERSONAL DEL DOCUMENTO...
    
    $Aexiste = $bd->query_array('flow.wk_proceso_casodoc',
                                        'count(*) as nn,max(idcasodoc) as idcasodoc',
                                        'idcaso ='.$bd->sqlvalue_inyeccion($idcaso,true)." and 
                                         uso = 'I' and 
                                         documento=".$bd->sqlvalue_inyeccion($documento,true)
    );

     $AexistePara = $bd->query_array('flow.view_proceso_doc_user',
                'idusuario',
                'idcaso       ='.$bd->sqlvalue_inyeccion($idcaso,true)." and  tipo = 'S' limit 1" 
     );
                
            $para       =  $AexistePara["idusuario"];
            $len        =  strlen($asunto);
            
            $result_Doc = 'Informe requiere informacion ';  

            $Tabla      = array(
                            array( campo => 'idcasodoc',     tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                            array( campo => 'idproceso',     tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor =>  $idproceso, key => 'N'),
                            array( campo => 'sesion',        tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S',  valor => $sesion, key => 'N'),
                            array( campo => 'idproceso_docu',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '0', key => 'N'),
                            array( campo => 'idcaso',        tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>  $idcaso, key => 'N'),
                            array( campo => 'documento',     tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => $documento, key => 'N'),
                            array( campo => 'asunto',        tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $_POST["asunto"], key => 'N'),
                            array( campo => 'tipodoc',       tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => $tipoDoc, key => 'N'),
                            array( campo => 'para',          tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor =>$para, key => 'N'),
                            array( campo => 'de',            tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $usuario, key => 'N'),
                            array( campo => 'editor',        tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor =>$contenido, key => 'N'),
                            array( campo => 'fecha',         tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
                            array( campo => 'dia',           tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$dia, key => 'N'),
                            array( campo => 'mes',           tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>$mes, key => 'N'),
                            array( campo => 'anio',          tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
                            array( campo => 'secuencia',     tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor =>$secuencia_dato, key => 'N'),
                            array( campo => 'uso',           tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor =>$uso, key => 'N'),
                            array( campo => 'bandera',       tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'N', valor =>$_SESSION['pide_secuencia'], key => 'N')
                        );
     
/*
             agregar informacion del documento
*/
            if ( trim($accion_doc) == 'add') {

                $idcasodoc       =  trim($_POST["idcasodoc"]);
  
                if ($len > 5 ){

                    if ($para > 0 ){

                            if ($idcasodoc > 0 ){
                    
                                  
                                
                                    $result_Doc = 'Informe Editado Documento Activo-'.$idcasodoc;  

                                    $bd->_UpdateSQL('flow.wk_proceso_casodoc',$Tabla,$idcasodoc); 

                                    $variable = "'times new roman',";
                                    $cabecera =  str_replace ( $variable, ' '  ,  $contenido   );
                                    $cabecera =  str_replace ('12pt',  '11pt', $cabecera);
                                     
                                    $sql = "UPDATE flow.wk_proceso_casodoc
                                            SET  editor= "."'".trim($cabecera)."'" ."
                                            WHERE idcasodoc =".$bd->sqlvalue_inyeccion($idcasodoc, true);

                                
                                    
                                    $bd->ejecutar($sql);

                                    $sql       = "DELETE 
                                                    FROM flow.wk_doc_user_temp
                                                    WHERE documento <> ".$bd->sqlvalue_inyeccion(trim($documento), true)." and   
                                                          bandera = ".$bd->sqlvalue_inyeccion('0', true);
                        
                               
                                   $bd->ejecutar($sql);
                                   
                                   echo  $result_Doc;

                            }
                            else{
                        
                                $idcasodoc = $bd->_InsertSQL('flow.wk_proceso_casodoc',$Tabla,'flow.wk_proceso_casodoc_idcasodoc_seq'); 
 
                                $result_Doc = 'Informe Nuevo Guardado Exitosamente-'.$idcasodoc;  

                            
                                $sql       = "DELETE
                                                    FROM flow.wk_doc_user_temp
                                                    WHERE documento <> ".$bd->sqlvalue_inyeccion(trim($documento), true)." and
                                                          bandera = ".$bd->sqlvalue_inyeccion('0', true);
                                
                                $bd->ejecutar($sql);
        
                                echo  $result_Doc;
                            }
                    }    
                }  
            }    
/** 
 * Editar documento asignao
*/
        if ( trim($accion_doc) == 'edit') {     

            $idcasodoc       =  trim($_POST["idcasodoc"]);
 
                    if ($len > 5 ){ 
                                    if ($idcasodoc > 0 ){
                                                    
                                        $result_Doc = 'Informe Editado Documento Activo-'.$idcasodoc;  
            
                                        $bd->_UpdateSQL('flow.wk_proceso_casodoc',$Tabla,$idcasodoc); 
            
                                        $variable = "'times new roman',";
                                        $cabecera =  str_replace ( $variable, ' '  ,  $contenido   );
                                        $cabecera =  str_replace ('12pt',  '11pt', $cabecera);
                                        
                                        $sql = "UPDATE flow.wk_proceso_casodoc
                                                SET  editor= "."'".trim($cabecera)."'" ."
                                                WHERE idcasodoc =".$bd->sqlvalue_inyeccion($idcasodoc, true);
            
                                        $bd->ejecutar($sql);
            
                                        $sql       = "DELETE 
                                                        FROM flow.wk_doc_user_temp
                                                      WHERE documento <> ".$bd->sqlvalue_inyeccion(trim($documento), true)." and 
                                                            bandera = ".$bd->sqlvalue_inyeccion('0', true);
            
                                    $bd->ejecutar($sql);
                                    
                                    echo  $result_Doc;
            
                                }
                    }   
    } 
/*
 * Bloquear documento asignao
*/
           $accion   =  trim($_POST['accion']);

            if ( trim($accion) == 'seguro') {
             
                    $idcaso1          = $_POST['idcaso'];
                    $id               = $_POST['id'];
                    $result_Doc       = 'INFORMACION ACTUALIZADA CON EXITO-'.$id;  
         
                                $Aexiste = $bd->query_array('flow.wk_proceso_casodoc',
                                    '*',
                                    'idcaso       ='.$bd->sqlvalue_inyeccion($idcaso,true).' and
                                    idcasodoc='.$bd->sqlvalue_inyeccion($id,true)
                                    );
      
                                     $sql = "UPDATE flow.wk_proceso_casodoc  
                                               SET envia= ".$bd->sqlvalue_inyeccion(1, true)." , 
                                                   bandera = 'S'
                                             WHERE envia = ".$bd->sqlvalue_inyeccion(0, true)." and 
                                                   idcasodoc =".$bd->sqlvalue_inyeccion($id, true);

                                    $bd->ejecutar($sql);
                                   
                                    actualiza_secuencia($bd	,$sesion,$Aexiste["secuencia"],$Aexiste["tipodoc"] ,$idcaso1);
                                   
                                    echo  $result_Doc;
              }
 /*
   Bloquear documento asignao
 */

    if (  trim($accion) == 'eliminar') {
            
        $idcaso1          = $_POST['idcaso'];
        $id               = $_POST['id'];
        
        $result_Doc = 'INFORMACION ACTUALIZADA CON EXITO-'.$id ;
         
        $Aexiste = $bd->query_array('flow.wk_proceso_casodoc',
            '*',
            'idcaso       ='.$bd->sqlvalue_inyeccion($idcaso,true).' and
                             idcasodoc='.$bd->sqlvalue_inyeccion($id,true)
            );
        
        if ($Aexiste["envia"] == 0 ){
            
            $sql = "DELETE FROM flow.wk_proceso_casodoc
                                          WHERE idcasodoc =".$bd->sqlvalue_inyeccion($id, true);
            $bd->ejecutar($sql);
             
            echo  $result_Doc;
        }
        
    }          
// ACTUALIZA SECUENCIAS
  function actualiza_secuencia($bd	,$sesion,$secuencia_dato,$tipoDoc,$idcaso){
 
         
            $sql  = "update flow.wk_doc_user_temp
                        set bandera =".$bd->sqlvalue_inyeccion(1,true)."
                         where   secuencia = ".$bd->sqlvalue_inyeccion($secuencia_dato,true)." and 
                                 bandera = ".$bd->sqlvalue_inyeccion(0,true)." and 
                                 idcaso = ".$bd->sqlvalue_inyeccion($idcaso,true);

          
            $bd->ejecutar($sql);
  
     
  }
  
  // ACTUALIZA SECUENCIAS FIRMAS
  function actualiza_secuencia_firma($bd	,$acceso1 ){
 

    $len         =  strlen($acceso1);
    $sesion 	 =  trim($_SESSION['email']);

    if ( $len > 5 )  {

        $sql = 'UPDATE par_usuario 
            SET  acceso1='.$bd->sqlvalue_inyeccion(base64_encode(trim($acceso1)), true).' 
            WHERE email='. $bd->sqlvalue_inyeccion(trim($sesion), true);
 
                                    
           $bd->ejecutar($sql);
        }
       
}

?>