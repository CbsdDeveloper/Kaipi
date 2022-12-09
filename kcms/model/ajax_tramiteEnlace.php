<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   =	new Db;
$obj     = 	new objects;
 
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $id_tramite     = $_GET['id_tramite'];
    $id_movimiento  = $_GET['id_movimiento'];  
 
    $formulario     = '';
    $action         = 'visor';
    
 
    if ((isset($_GET['id_tramite'])) && (isset($_GET['id_movimiento']))){
      
        echo '<h5><b>MOVIMIENTO DE INGRESO A BODEGA [ '.$id_movimiento.' ] </b></h5>';
        
        $cadena = " || ' ' "; 
        $sql ="select cuenta_inv ".$cadena." as Cuenta,
                      detalle_cuenta as Detalle,
                      clasificador ".$cadena." as clasificador, 
                      sum(total) as total
                from view_movimiento_det_cta
                where id_movimiento= ".$bd->sqlvalue_inyeccion($id_movimiento, true)." 
                group by cuenta_inv,detalle_cuenta,clasificador";
        
   
      
        $tipo 		= $bd->retorna_tipo();
        $resultado  = $bd->ejecutar($sql);
        
        $obj->grid->KP_sumatoria(4,"total","", "","");
        
        $obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
        
        
        echo '<h5><b>TRAMITE DE ADQUISICION - PRESUPUESTO [ '.$id_tramite.' ] </b></h5>';
        
        
        $cadena = " || ' ' ";
        
        $sql ="select partida ".$cadena." as partida,
                      detalle ,
                      clasificador ".$cadena." as clasificador,
                      certificado
                 from presupuesto.view_dettramites
                where id_tramite= ".$bd->sqlvalue_inyeccion($id_tramite, true);
        
     
        
        $tipo 		= $bd->retorna_tipo();
        $resultado  = $bd->ejecutar($sql);
        
        $obj->grid->KP_sumatoria(4,"certificado","", "","");
        
        $obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
            
   	}   
 
  ?> 
								
 
 
 