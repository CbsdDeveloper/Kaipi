<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$idtramite          = $_GET['idtramite'];
$fcertifica         = $_GET['fcertifica'];
 
$anio 	     =      $_SESSION['anio'];
 

$trozos      =      explode("-", $fcertifica,3);

$anio1  = $trozos[0];

$sql1 = "SELECT   id_tramite,  partida, certificado 
         FROM presupuesto.pre_tramite_det
        where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;


        if ( $anio1 == $anio ) {
         
        
        $stmt1 = $bd->ejecutar($sql1);
        
         
        
        while ($fila=$bd->obtener_fila($stmt1)){
            
            $partida = trim($fila['partida']);
            
            
            $sqlEditPre = "UPDATE presupuesto.pre_gestion
                       SET certificado = certificado + ".$bd->sqlvalue_inyeccion($fila['certificado'],true).",
                           disponible  = disponible - ".$bd->sqlvalue_inyeccion($fila['certificado'],true) ." 
                where partida = ".$bd->sqlvalue_inyeccion($partida,true). ' and 
                         anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
            
            $bd->ejecutar($sqlEditPre);
         
         
            
        }
        
        //-- ----------------------------------
        
        $sql = "SELECT   count(*) as secuencia,max(comprobante) as nn
                    FROM presupuesto.pre_tramite
                    where estado in ('2','3','4','5','6')  and 
                          anio = ".$bd->sqlvalue_inyeccion($anio   ,true);
         
           
            $parametros 			= $bd->ejecutar($sql);
            $secuencia 				= $bd->obtener_array($parametros);
            $fecha			        = $bd->fecha($fcertifica);
            
            $ss = explode('-', $secuencia['nn'] );
            
            $dato = $ss[0];
            
            $int = (int)$dato;
            
            $contador = $int + 1;
                
            $input = str_pad($contador, 5, "0", STR_PAD_LEFT).'-'.$anio;
                
                
         
            
            $sqlEdit = "UPDATE presupuesto.pre_tramite
                           SET 	comprobante=".$bd->sqlvalue_inyeccion($input, true).",
        	                    estado=".$bd->sqlvalue_inyeccion('3', true).",
                                fcertifica= ".$fecha." 
                         where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
                
                
            $bd->ejecutar($sqlEdit);
            
            
            echo $input;
            
        }else{
            
            echo '0'; 
        }

   
   
?>
