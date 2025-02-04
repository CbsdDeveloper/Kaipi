<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 

 
$id_acta = $_GET["id_acta"];
    
      
  //  $fecha_inicio     = $_GET["fecha"] ;
    $fecha_fin   =  $_GET["fecha"] ;
    
    $perido = explode('-',$fecha_fin);
    
    $anio   =  $perido[0] ;
    
     
    //$mesmenos =  date("Y-m-d",strtotime($fecha_fin."- 1 month"));
   
   $sql_vida = 'update activo.ac_bienes  set valor_residual = (costo_adquisicion  * 0.1)  where 1 = 1';
   
   $bd->ejecutar($sql_vida);
   
 
   $sql = " SELECT  a.id_bien ,
         		 b.fecha_adquisicion, b.vida_util ,b.valor_residual ,b.costo_adquisicion ,
                b.estado, b.anio_adquisicion , b.anio,b.tiempo_anio , b.tiempo_dia
        FROM activo.ac_movimiento_det a, activo.view_bienes b
        where a.id_acta = ".$bd->sqlvalue_inyeccion($id_acta,true)." and 
        	  a.id_bien =  b.id_bien and
        	  b.tipo_bien = 'BLD'";
        	  
    
    $resultado1    =  $bd->ejecutar($sql);
    
    while($row=pg_fetch_assoc ($resultado1)) {
        
 
        $fecha                  = $row["fecha_adquisicion"] ;
        $costo_adquisicion      = $row["costo_adquisicion"] ;
        $valor_residual         = $row["valor_residual"] ;
        $vida_util              = $row["vida_util"] ;
        
      //  $valor_residual = 0;
        
        $dias = (strtotime($fecha_fin)-strtotime($fecha))/86400;
        $dias = abs($dias); 
        $dias = floor($dias);
        
 
        $CDP_parcial     = ($costo_adquisicion - $valor_residual) / $vida_util;
        
        $dias_var        = round($dias/365,2);
        
        $CDP             =  round($CDP_parcial * $dias_var,2);
        
        $costo_residual  = $costo_adquisicion - $valor_residual ;
        
        $diferencia      = $costo_residual - $CDP;
        
 
        if ( $diferencia < 0 ){
            
            $diferencia      = $valor_residual;
            $dias_var        =  1;
            $CDP             =  $costo_residual;
            
         }
           
            $sql1 = "update activo.ac_bienes
                                    set movimiento = ".$bd->sqlvalue_inyeccion(1, true).",
                                        valor_depreciacion= ".$bd->sqlvalue_inyeccion($CDP, true).",
                                        anio_depre= ".$bd->sqlvalue_inyeccion($anio, true).",
                                        valor_contable= ".$bd->sqlvalue_inyeccion($diferencia, true).'
                                    where id_bien='.$bd->sqlvalue_inyeccion( $row["id_bien"], true);
            
            $bd->ejecutar($sql1);
            
          
      //      echo  'Costo='.$costo_adquisicion.'<br>valor_residual='.$valor_residual.'<br>CDP='.$CDP.' <br>dias='.$dias.'<br>vida util='.$vida_util.'<br>diferencia='.$diferencia.'<br><br>';
        
    }
    echo 'DATOS PROCESADOS...';
 
 


?>
 
  