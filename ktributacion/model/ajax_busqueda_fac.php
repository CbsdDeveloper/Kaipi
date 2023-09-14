 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = trim($_GET['comprobante']);
    
    
    $ruc       =     trim($_SESSION['ruc_registro']);
    
    $ADatos = $bd->query_array(
        'web_registro',
        '*',
        'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
        );
    
     
    $input = str_pad($txtcodigo, 9, "0", STR_PAD_LEFT);
  
    
    
   $sql = "select id_movimiento,comprobante ,estado, id_asiento ,id_asiento_ref ,tipo,fecha
    from view_inv_transaccion
    where registro =  ".$bd->sqlvalue_inyeccion($ruc,true)." and 
            comprobante = ".$bd->sqlvalue_inyeccion($input,true) ;
 
 

    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    $id_movimiento = $dataProv['id_movimiento'];
    $fecha         = $dataProv['fecha'];
    $comprobante   = trim($dataProv['comprobante']);
    
    
    $ViewFactura = '<H3><b>NO EXISTE COMPROBANTE... VERIFIQUE LA INFORMACION</b></H3>';
    
    if ( $id_movimiento > 0 ){

         $ViewFactura = '<H5><b>Presione el icono de ejecución para generar la nota de credito</b> </H5>';
         
         
         $qquery = array(
             array( campo => 'id_movimiento',   valor => $id_movimiento,  filtro => 'S',   visor => 'S'),
             array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S')
         );
         
         $datos = $bd->JqueryArrayVisorDato('view_ventas_fac',$qquery );


         $ADatos['estab'] = '001';
         
         $numdocmodificado = $ADatos['estab'].'-001-'.$datos['comprobante'];
         
         $xn = $bd->query_array(
             'doctor_vta',
             'secuencial1,cab_autorizacion,id_diario,fechaemisiondocsustento',
             'id_diario='.$bd->sqlvalue_inyeccion( $id_movimiento,true)
             );
         
         $secuencial1      = $xn['secuencial1'];
         $cab_autorizacion = $xn['cab_autorizacion'];
         $id_diario        = $xn['id_diario'];
         
         
         if ( empty($xn['fechaemisiondocsustento'])){
             $fechaemisiondocsustento = date('Y-m-d') 	;
         }else{
             $fechaemisiondocsustento = $xn['fechaemisiondocsustento']	;
         }
         
         $estab1   = '001';
         $ptoemi1 = '001';
         $coddocmodificado = '01';
         $idcliente = trim($datos['idprov']);
         
    }else {
        $id_movimiento = 0;
        $fecha         = date('Y-m-d');
        $comprobante   = '000000000';
    }
 
    
    echo json_encode( 
                    array( "a"=> $id_movimiento, 
                           "b"=> $fecha , 
                           "c"=> $comprobante , 
                           "d"=> $ViewFactura,
                        "e"=> $estab1,
                        "f"=> $ptoemi1,
                        "g"=> $coddocmodificado,
                        "h"=> $fechaemisiondocsustento,
                        "i"=> $coddocmodificado,
                        "j"=> $numdocmodificado,
                        "k"=> $secuencial1,
                        "l"=> $cab_autorizacion,
                        "m"=> $idcliente,
                        "n"=> $id_diario
                           )  
                        );
    
     
    
?>