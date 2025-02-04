<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
 
    $sesion 	 =  trim($_SESSION['email']);
  
   $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
   $accion                 =  trim($_GET['accion']) ;
   $codigo                 =  trim($_GET["codigo"]);
   $documento              =  trim($_GET["documento"]);
   $secuencia              =  trim($_GET["secuencia"]);

   $cod_doc_ca             =  trim($_GET["cod_doc_ca"]);
 


   $xxx = $bd->query_array('flow.view_proceso_doc ',    
                            '*',                        
                           "idcasodoc = ".$bd->sqlvalue_inyeccion( $cod_doc_ca,true)  
    );



    $idcasodoc        = $xxx["idcasodoc"];
    $id_departamento  = $xxx["id_departamento"];
    $tipo             = trim($xxx["tipodoc"]);

 
    if (  $accion   == '1'){
     
        $sqlima  = "update flow.wk_proceso_casodoc
                       set uso = 'A'
                    where idcasodoc = ".$bd->sqlvalue_inyeccion($idcasodoc,true);

            $bd->ejecutar($sqlima);

 
            echo 'Documento Anulado...'.$codigo ;

    }    

    if (  $accion   == '2'){
     
        if (  $secuencia  > 0  ) {
         
                    if (trim($tipo) =='Informe'){
                        $tipo_secuencia = 'informe';
                    }
                    
                    if (trim($tipo) =='Memo'){
                        $tipo_secuencia = 'memo';
                    }
                    
                    if (trim($tipo) =='Notificacion'){
                        $tipo_secuencia = 'notifica';
                    }
                    
                    if (trim($tipo) =='Circular'){
                        $tipo_secuencia = 'circular';
                    }
                    
                    if (trim($tipo) =='Oficio'){
                        $tipo_secuencia = 'oficio';
                    }
                    $sqlima  = "update nom_departamento
                    set ".$tipo_secuencia." =".$bd->sqlvalue_inyeccion($secuencia,true)."
                  where id_departamento = ".$bd->sqlvalue_inyeccion($id_departamento,true);

                $bd->ejecutar($sqlima);

                echo 'Secuencia generada...'.$secuencia.' su codigo de documento esta seleccionado...';

        }  
    }  
 
    if (  $accion   == '3'){
     
        if (  $secuencia  > 0  ) {
                $sqlima  = "update flow.wk_proceso_casodoc
                            set documento = ".$bd->sqlvalue_inyeccion($documento,true).",
                                secuencia = ".$bd->sqlvalue_inyeccion($secuencia,true)."
                            where idcasodoc = ".$bd->sqlvalue_inyeccion( $idcasodoc  ,true);

                    $bd->ejecutar($sqlima);

                    

                    echo 'Secuencia generada...'.$secuencia.' su codigo de documento esta seleccionado...'. $codigo ;
        }      
    }    
   
?>
 
  