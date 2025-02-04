<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$accion = $_GET["estado"];




if ( $accion == 'N'){
    
    $id_bien_dep = $_GET["id_bien_dep"];
    $cuenta      = trim($_GET["cuenta"]);
     
  //  $fecha_inicio     = $_GET["fecha"] ;
    $fecha_fin   =  $_GET["fecha2"] ;
    
    $anio   =  $_GET["anio"] ;
    
    $tipo   =  $_GET["tipo"] ;
    
    $mesmenos =  date("Y-m-d",strtotime($fecha_fin."- 1 month"));
   
   
    
 
    if ( trim($tipo) == 'A'){
        $sql = "SELECT  id_bien ,fecha_adquisicion, vida_util ,valor_residual ,costo_adquisicion ,
        estado, anio_adquisicion , anio,tiempo_anio , tiempo_dia
        FROM activo.view_bienes
                where  tipo_bien = 'BLD' and 
                       cuenta = ".$bd->sqlvalue_inyeccion($cuenta,true)." and
                       uso <>".$bd->sqlvalue_inyeccion('Baja',true) . ' and
                       anio_adquisicion <= '.$bd->sqlvalue_inyeccion($anio,true);
        
      
    }else {
        
        $sql = "SELECT  id_bien ,fecha_adquisicion, vida_util ,valor_residual ,costo_adquisicion ,
        estado, anio_adquisicion , anio,tiempo_anio , tiempo_dia
        FROM activo.view_bienes
                where  tipo_bien = 'BLD' and
                       cuenta = ".$bd->sqlvalue_inyeccion($cuenta,true)." and
                       uso <>".$bd->sqlvalue_inyeccion('Baja',true) . " and
                       fecha_adquisicion <= ".$bd->sqlvalue_inyeccion($mesmenos,true) ;
        
    }
  
   
    
    $resultado1    =  $bd->ejecutar($sql);
    
    while($row=pg_fetch_assoc ($resultado1)) {
        
 
        
        $fecha                  = $row["fecha_adquisicion"] ;
        $costo_adquisicion      = $row["costo_adquisicion"] ;
        $valor_residual         = $row["valor_residual"] ;
        $vida_util              = $row["vida_util"] ;
        
        
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

      /*
         echo  'Costo='.$costo_adquisicion.'<br>valor_residual='.$valor_residual.'<br>CDP_parcial='.$CDP_parcial.
               '<br>CDP='.$CDP.' <br>dias='.$dias.'('.$dias_var.')'.'<br>vida util='.$vida_util.'<br>diferencia='.$diferencia.'<br><br>';
     */
         
       // $valida = $valor_residual - $diferencia;
        
        
        $sesion 	 =     trim($_SESSION['email']);
        
        $hoy 	     =     date("Y-m-d");   
        
        $ATabla = array(
            array( campo => 'id_bien_ddep',tipo => 'NUMBER',id => '0',add => 'N', edit => 'S', valor => '-', key => 'S'),
            array( campo => 'id_bien_dep',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id_bien_dep, key => 'N'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $row["id_bien"] , key => 'N'),
            array( campo => 'vidautil',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor =>$vida_util, key => 'N'),
            array( campo => 'costo',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $costo_adquisicion, key => 'N'),
            array( campo => 'vresidual',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor =>$valor_residual, key => 'N'),
            array( campo => 'anio_bien',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>$row["anio_adquisicion"], key => 'N'),
            array( campo => 'anio_actual',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
            array( campo => 'cuotadp',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor =>$CDP, key => 'N'),
            array( campo => 'acumulado',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $dias, key => 'N'),
            array( campo => 'diferencia',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $diferencia, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => $hoy, key => 'N')
        );
        
        $tabla 	  	  = 'activo.ac_bienes_ddep';
        $secuencia 	     = 'activo.ac_bienes_ddep_id_bien_ddep_seq';
        
        
        if ( $diferencia < 0 ) {
            
            $sql1 = "update activo.ac_bienes
                                    set movimiento = ".$bd->sqlvalue_inyeccion(2, true)."
                                    where id_bien=".$bd->sqlvalue_inyeccion( $row["id_bien"], true);
            
             $bd->ejecutar($sql1);
            
        }else  {
             
            
            $bd->_InsertSQL($tabla,$ATabla, $secuencia  );
            
              /*
        
        $sql1 = "update activo.ac_bienes
        set movimiento = ".$bd->sqlvalue_inyeccion(1, true).",
            valor_depreciacion= ".$bd->sqlvalue_inyeccion($CDP, true).",
            anio_depre= ".$bd->sqlvalue_inyeccion($anio, true).",
            valor_contable= ".$bd->sqlvalue_inyeccion($diferencia, true).'
        where id_bien='.$bd->sqlvalue_inyeccion( $row["id_bien"], true);
*/
            
            $sql1 = "update activo.ac_bienes
                                    set movimiento = ".$bd->sqlvalue_inyeccion(1, true).",
                                        valor_depreciacion= ".$bd->sqlvalue_inyeccion($CDP, true).",
                                        anio_depre= ".$bd->sqlvalue_inyeccion($anio, true).",
                                        valor_contable= ".$bd->sqlvalue_inyeccion($diferencia, true).'
                                    where id_bien='.$bd->sqlvalue_inyeccion( $row["id_bien"], true);
            
            $bd->ejecutar($sql1);
            
          
            
        }
          
    }
    echo 'DATOS PROCESADOS...';
}else {
          
echo 'TRANSACCION YA GENERADA...';
                
}
 


?>
 
  