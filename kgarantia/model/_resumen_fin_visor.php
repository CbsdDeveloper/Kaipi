 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	        =   new Db ;
 	$obj        = 	new objects;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $mes = trim($_GET['mes']);
    
      
    
    $tipo 		 = $bd->retorna_tipo();
    
   
    $formulario  = '';
    $action      = '';
    
    $sql ="SELECT  id_asiento || ' ' as asiento ,fecha,
                                id_tramite  || ' ' as tramite,
                                asiento_detalle as detalle,
                                partida || ' ' as partida,
                                item || ' ' as item,
                                debe as total
                            FROM  view_diario_conta
                            where periodo = ".$bd->sqlvalue_inyeccion($mes, true)." and 
                                  partida_enlace= ".$bd->sqlvalue_inyeccion('gasto', true)." and 
                                  item in ('530803',  '730803') 
                             order by fecha ";
    
 
        
    $resultado   = $bd->ejecutar($sql);
        
        $destino = 'DETALLE DE MOVIMIENTO FINANCIEROS';
        
        $obj->grid->KP_sumatoria(7,"total","", "","");
        
    
        
        $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$mes.'<br>'.$destino.' </h6> </b>';
        
        echo $ViewForm;
        
        $obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
 
   
    
?>