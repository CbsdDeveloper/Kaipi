<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    
    
    $sql = "select sum(tiempo) as tiempo_total,tipotiempo, ( sum(tiempo) / 8) en_dias
              from flow.wk_procesoflujo
             where idproceso = ".$bd->sqlvalue_inyeccion($id,true)." and idtarea  <> 0  group by idproceso, tipotiempo";
    
    $stmt_nivel1= $bd->ejecutar($sql);
    
    $totalhora = 0;
    while ($x=$bd->obtener_fila($stmt_nivel1)){
        $totalhora = $totalhora + $x['tiempo_total'];
    }
      
    
     $ViewFormTiempo ='<div class="thumbnail">
        <a href="#">
             <img src="../../kimages/relojwk.png" alt="Lights">
            <div class="caption">
            <p align="center">Tiempo de duracion<br><span style="font-size: 25px"><b> '.$totalhora.' horas </b> </span>
            </p>
            </div>
        </a>
    </div>';
    
     echo $ViewFormTiempo ;
    
     $sql = 'SELECT
                    requisito  ,
                     obligatorio
      FROM flow.wk_proceso_requisitos
      where idproceso = '.$bd->sqlvalue_inyeccion($id ,true)    ;
     
     $tipo 		= $bd->retorna_tipo();
     
     ///--- desplaza la informacion de la gestion
     $resultado  = $bd->ejecutar($sql);
     
     $cabecera =  " Requisito, Obligatorio";
     
     $evento = '';
     
     $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
 
 

  //-----------------------------------------------
   
    
?>
