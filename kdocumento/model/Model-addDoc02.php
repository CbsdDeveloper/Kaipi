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
    
    
    $para        =  trim($_POST['para']) ;
    $usuario 	 =  trim($_SESSION['usuario']);
    $deusuario   = $_POST["de"];
    
    $contenido   =  $_POST['editor1'] ;
    $asunto      =  trim($_POST["asunto"]);
    $idproceso   =  21; 
    
    $documento       = trim($_POST["documento"]);
    $docpone         = trim($_POST["docpone"]);
    $tipoDoc         = $_POST["tipo"];
    $secuencia_dato  = $_POST["secuencia_dato"];
    $idcaso          = $_POST['idcaso'];

    $id              = trim($_POST["idcasodoc"]);
    $idcasodoc       = trim($_POST["idcasodoc"]);

    $accion          = $_POST['accion'];
 
    $len1 = strlen($documento);

    if ( $len1 > 5  ){
        
    }else{
        $documento = $docpone ;
    }
    //-------------------------------------------------------------------------------------------
    $AexistePara   = $bd->query_array('view_nomina_user','*',  "email = ".$bd->sqlvalue_inyeccion($para ,true) );
    $para          = $AexistePara["idusuario"];
    
     $AexisteDe    = $bd->query_array('view_nomina_user','*', "email = ".$bd->sqlvalue_inyeccion($deusuario ,true) );
     $usuario      = $AexisteDe["idusuario"];
 
    
    $Tabla = array(
        array( campo => 'idcasodoc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor =>  $idproceso, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N',  valor => $sesion, key => 'N'),
        array( campo => 'idproceso_docu',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '2', key => 'N'),
        array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => $idcaso , key => 'N'),
        array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => $documento, key => 'N'),
        array( campo => 'asunto',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $_POST["asunto"], key => 'N'),
        array( campo => 'tipodoc',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $tipoDoc, key => 'N'),
        array( campo => 'para',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor =>$para, key => 'N'),
        array( campo => 'de',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $usuario, key => 'N'),
        array( campo => 'editor',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor =>$contenido, key => 'N'),
        array( campo => 'fecha',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
        array( campo => 'dia',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$dia, key => 'N'),
        array( campo => 'mes',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>$mes, key => 'N'),
        array( campo => 'anio',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
        array( campo => 'secuencia',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor =>$secuencia_dato, key => 'N'),
        array( campo => 'uso',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor =>'S', key => 'N')
    );
    
            $result_Doc = 'Informe requiere informacion '.$idcaso ;  
            
            $len = strlen($asunto);
        
             if ( $accion == 'edit'){
                 
                 $Aexiste = $bd->query_array('flow.wk_proceso_casodoc',
                     'count(*) as nn,max(idcasodoc) as idcasodoc',
                     'idcaso ='.$bd->sqlvalue_inyeccion($idcaso,true)." and
                                         uso = 'S' and
                                         documento=".$bd->sqlvalue_inyeccion($documento,true)
                     );
                 
                 if ( $Aexiste['nn'] > 0 ){
                     $para = 3;
                 }else{
                     $accion = 'add';
                 }
              
                
            }

  
            if ($len > 5 ){
                
                 if ($para > 0 ){
                     if ( trim($accion) == 'add'){
        
                                $idcasodoc = $bd->_InsertSQL('flow.wk_proceso_casodoc',$Tabla,'flow.wk_proceso_casodoc_idcasodoc_seq');
                               
                                 $sql = "UPDATE flow.wk_proceso_casodoc
                                            SET  editor= "."'".trim($contenido)."'" ."
                                        WHERE idcasodoc =".$bd->sqlvalue_inyeccion($idcasodoc, true);
                                 
                                $bd->ejecutar($sql);
                                
                                $result_Doc = 'Informe Editado Guardado por Documento -'.$idcasodoc;
                    }     
                    if (  trim($accion) == 'edit'){
                           
                                $bd->_UpdateSQL('flow.wk_proceso_casodoc',$Tabla,$idcasodoc);
                              
                                $sql = "UPDATE flow.wk_proceso_casodoc
                                           SET  editor= "."'".trim($contenido)."'" ."
                                      WHERE idcasodoc =".$bd->sqlvalue_inyeccion($idcasodoc, true);
                                 
                                $bd->ejecutar($sql);
                                
                                $result_Doc = 'Informe Editado Guardado por Documento-'.$idcasodoc;
                         
                    }
                 }
            }else{
                $result_Doc = 'Informe requiere del asunto-'.$id;  
            }
    
    
    echo $result_Doc ;
 
//--------------------------------
function actualiza_secuencia($bd	,$sesion,$secuencia_dato,$tipoDoc,$idcaso){
        
 
        $sql  = "update flow.wk_doc_user_temp
                    set bandera =".$bd->sqlvalue_inyeccion(1,true)."
                     where   secuencia = ".$bd->sqlvalue_inyeccion($secuencia_dato,true)." and 
                             bandera = ".$bd->sqlvalue_inyeccion(0,true)." and 
                             idcaso = ".$bd->sqlvalue_inyeccion($idcaso,true);

      
        $bd->ejecutar($sql);

 
}
?>