<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$ruc_registro     =  $_SESSION['ruc_registro'];
$fanio            =  $_GET['fanio'];

$cuenta01            =  trim($_GET['cuenta1']);
$cuenta_x            =  trim($_GET['cuenta0']);
$sesion 	         =  trim($_SESSION['email']);
 



$sql = "select count(*) as nn, max(id_asiento) as id_asiento
             from co_asiento
            where tipo    = ".$bd->sqlvalue_inyeccion('T' ,true)." and
                  registro=".$bd->sqlvalue_inyeccion($ruc_registro ,true)." and
                  anio    =".$bd->sqlvalue_inyeccion($fanio ,true);

$resultado1 = $bd->ejecutar($sql);
$x          = $bd->obtener_array( $resultado1);
$id_asiento = $x['id_asiento'] ;

$tipo_cuenta = substr($cuenta01, 0,1); 

$xc = $bd->query_array('co_asientod',   // TABLA
    'max(id_asientod) as id_asientod ,sum(debe) as debe, sum(haber) as haber',                        // CAMPOS
    'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) .' and 
        cuenta ='.$bd->sqlvalue_inyeccion($cuenta_x,true)
    );

$id_asientod = $xc['id_asientod'] ;



 
$xxx = $bd->query_array('co_asientod_ini',   // TABLA
    'count(*) as ya',                        // CAMPOS
    'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) .' and
        cuenta ='.$bd->sqlvalue_inyeccion($cuenta01,true)
    );


if ( $xxx ['ya']  > 0 ){
   
    $data = 'CUENTA YA GENERADA ENLACE '.$fanio.' - '.$cuenta01;
    
}else{
    
    agregar($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$id_asientod,$cuenta01,$cuenta_x,$tipo_cuenta);
    
    
    $data = 'AUXILIARES YA INGRESADOS Y ACTUALIZADOS '.$fanio.' - '.$cuenta01;
    
}

 


echo $data;
//-------------------------
//-------------------------
//-------------------------
function agregar($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$id_asientod,$cuenta01,$cuenta_x,$tipo_cuenta){
    
   
    $estado_periodo = $bd->query_array('co_asiento',
        'mes,anio,id_periodo,estado,fecha',
        'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) 
        );
    
    $anio1 = $fanio - 1 ;
      
    
    if ( $tipo_cuenta == '2'){
       
        $sql_det = "select cuenta,  idprov, sum(debe) as debe,sum(haber) as haber,sum(haber) - sum(debe) as saldo
        FROM public.view_aux
        where anio = ".$bd->sqlvalue_inyeccion($anio1, true)." and  cuenta = ".$bd->sqlvalue_inyeccion($cuenta01, true)."
        group by cuenta ,idprov
        having sum(haber) - sum(debe) > 0
        order by cuenta,  idprov";
         
     }else{
      
         $sql_det = "select cuenta,  idprov, sum(debe) as debe,sum(haber) as haber,sum(debe) - sum(haber) as saldo
        FROM public.view_aux
        where anio = ".$bd->sqlvalue_inyeccion($anio1, true)." and  cuenta = ".$bd->sqlvalue_inyeccion($cuenta01, true)."
        group by cuenta ,idprov
        having sum(debe) - sum(haber) > 0
        order by cuenta,  idprov";
    }
    
    
  
        
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        
        
        $idprov = $x["idprov"];
        
        if ( $tipo_cuenta == '1'){
            $debe  = $x["saldo"];
            $haber = 0;
        }else{
            $debe  = 0;
            $haber = $x["saldo"];
        }
        
        $total = $debe + $haber ;
        
        $dato = strlen($idprov);
        
        //------------------------------------------------------------
        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, fecha,fechap,cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, registro) VALUES (".
    		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
    		              									  $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
    		              									  $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
    		              									  $bd->sqlvalue_inyeccion($cuenta_x , true).",".
    		              									  $bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $bd->sqlvalue_inyeccion($total , true).",".
    		              									  $bd->sqlvalue_inyeccion($estado_periodo["id_periodo"], true).",".
    		              									  $bd->sqlvalue_inyeccion($fanio, true).",".
    		              									  $bd->sqlvalue_inyeccion($estado_periodo["mes"] , true).",".
    		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
    		              									  $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
    		              									  $bd->sqlvalue_inyeccion( $ruc_registro , true).")";
    		              									  
    		              									  if ( $total > 0 )     {
    		              									      if ($dato > 6 ){
    		              									          $bd->ejecutar($sql);
    		              									      }
    		              									      
    		              									  }
        
    }
      
 
    //---------------------------
    $sql1 = "INSERT INTO co_asientod_ini (id_asiento, cuenta, debe, haber, anio ) VALUES (".
    		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $bd->sqlvalue_inyeccion(trim($cuenta01) , true).",".
    		              									  $bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $bd->sqlvalue_inyeccion( $fanio , true).")";
    		              									  
    		              									 
    		 $bd->ejecutar($sql1);
										        
}
   
 
//----------------------------------
 
 
?>