<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
 
    $bd	   =	new Db ;
    
 
    $sesion 	 =  trim($_SESSION['email']);
   
    $hoy 	     =     date("Y-m-d"); 
    $dia 	     =     date("d"); 
    $mes 	     =     date("m"); 
    $anio 	     =     date("Y"); 
    
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    
    $usuario 	 =  $_SESSION['usuario'];
    
 
    $contenido =  $_POST['editor1'] ;
    
    
    $asunto     = trim($_POST["asunto"]);
 
    $para       = $_POST["para"];
    
    $id         = $_POST["codigoProceso"];
    
    $documento  = $_POST["documento"];
    
    $tipoDoc  = $_POST["tipoDoc"];
    
    $secuencia_dato  = $_POST["secuencia_dato"];
    
    $Aexiste = $bd->query_array('flow.wk_proceso_casodoc',
                                'count(*) as nn,max(idcasodoc) as idcasodoc',
                                'idproceso     ='.$bd->sqlvalue_inyeccion($_POST['codigoProceso'],true).' and
                                 idcaso       ='.$bd->sqlvalue_inyeccion($_POST['casoid'],true).' and
                                 idproceso_docu='.$bd->sqlvalue_inyeccion($_POST['codigoDocId'],true)
        );
    
    $idcaso = $_POST['casoid'];
    
    $Tabla = array(
        array( campo => 'idcasodoc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $_POST["codigoProceso"], key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S',  valor => $sesion, key => 'N'),
        array( campo => 'idproceso_docu',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $_POST["codigoDocId"], key => 'N'),
        array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $_POST['casoid'], key => 'N'),
        array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $documento, key => 'N'),
        array( campo => 'asunto',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $_POST["asunto"], key => 'N'),
        array( campo => 'tipodoc',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $_POST["tipoDoc"], key => 'N'),
        array( campo => 'para',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $_POST["para"], key => 'N'),
        array( campo => 'de',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $usuario, key => 'N'),
        array( campo => 'editor',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor =>$contenido, key => 'N'),
        array( campo => 'fecha',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
        array( campo => 'dia',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$dia, key => 'N'),
        array( campo => 'mes',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>$mes, key => 'N'),
        array( campo => 'anio',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
        array( campo => 'secuencia',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor =>$secuencia_dato, key => 'N')
    );
    
    $result_Doc = 'Informe requiere informacion '.$id ;  
    
    $len = strlen($asunto);
    
    if ($len > 10 ){
      
        
        if ($para > 0 ){
            
            if ($Aexiste["nn"] == 0){
                
                $id = $bd->_InsertSQL('flow.wk_proceso_casodoc',$Tabla,'flow.wk_proceso_casodoc_idcasodoc_seq'); 
                
                actualiza_secuencia($bd	,$sesion,$secuencia_dato,$tipoDoc,$idcaso);
                
                $result_Doc = 'Informe Nuevo Guardado Exitosamente '.$id;  
            }
            else{
                $id = $Aexiste["idcasodoc"];
                
                $bd->_UpdateSQL('flow.wk_proceso_casodoc',$Tabla,$id); 
                
                // actualiza_secuencia($bd	,$sesion,$secuencia_dato,$tipoDoc);
                
                $sql = "UPDATE flow.wk_proceso_casodoc
			            SET  editor=".$bd->sqlvalue_inyeccion($contenido, true)."
			          WHERE idcasodoc =".$bd->sqlvalue_inyeccion($id, true);
                
                
                $bd->ejecutar($sql);
                
                $result_Doc = 'Informe Editado Guardado por Documento '.$id;  
            }
        }
    }else{
        $result_Doc = 'Informe requiere del asunto '.$id;  
    }
    
    
    echo $result_Doc;
//--------------------------------
    function actualiza_secuencia($bd	,$sesion,$secuencia_dato,$tipoDoc,$idcaso){
        
        /*
        $AResultado['oficio']      = $x['oficio'];
        $AResultado['memo']        = $x['memo'];
        $AResultado['notifica']    = $x['notifica'];
        $AResultado['informe']     = $x['informe'];
        $AResultado['circular']    = $x['circular'];
        */
        
        $caso_array = $bd->__tramite( $idcaso );
        
        $documento_array = $bd->__user_tthh( $caso_array['email_solicita'] );
        
        
        if (trim($tipoDoc) =='Informe'){
             $sql = "UPDATE nom_departamento
			            SET  informe=".$bd->sqlvalue_inyeccion($secuencia_dato+1, true)."
			          WHERE id_departamento =".$bd->sqlvalue_inyeccion($documento_array["id_departamento"], true);
            
            $bd->ejecutar($sql);
         } 
        
         if (trim($tipoDoc) =='Memo'){
             $sql = "UPDATE nom_departamento
			            SET  memo=".$bd->sqlvalue_inyeccion($secuencia_dato+1, true)."
			          WHERE id_departamento =".$bd->sqlvalue_inyeccion($documento_array["id_departamento"], true);
             
             $bd->ejecutar($sql);
         } 
         
         if (trim($tipoDoc) =='Oficio'){
             $sql = "UPDATE nom_departamento
			            SET  oficio=".$bd->sqlvalue_inyeccion($secuencia_dato+1, true)."
			          WHERE id_departamento =".$bd->sqlvalue_inyeccion($documento_array["id_departamento"], true);
             
             $bd->ejecutar($sql);
         } 
         
         if (trim($tipoDoc) =='Notificacion'){
             $sql = "UPDATE nom_departamento
			            SET  notifica=".$bd->sqlvalue_inyeccion($secuencia_dato+1, true)."
			          WHERE id_departamento =".$bd->sqlvalue_inyeccion($documento_array["id_departamento"], true);
             
             $bd->ejecutar($sql);
         } 
         
         if (trim($tipoDoc) =='Circular'){
             $sql = "UPDATE nom_departamento
			            SET  circular=".$bd->sqlvalue_inyeccion($secuencia_dato+1, true)."
			          WHERE id_departamento =".$bd->sqlvalue_inyeccion($documento_array["id_departamento"], true);
             
             $bd->ejecutar($sql);
         } 
         
  }
?>
 
  