<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 


    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

    $tipo = trim($_POST['tipo']);

    
    $ruc = $_SESSION['ruc_registro'];
    
    
    
    if ( $tipo == '1') {
        
                
        $sql = "update co_reciprocas
                   set ruc1='9999999999996',
                       nombre='Ministerio de Finanzas'
                where cuenta_1= '113' and nivel_11 = '28' and ruc1=".$bd->sqlvalue_inyeccion($ruc,true);
        
        $bd->ejecutar($sql);
        //--------------
        
        $sql = "update co_reciprocas
                   set ruc1='1760013210001',
                       nombre='SERVICIO DE RENTAS INTERNAS'
                where cuenta_1= '212'  and ruc1=".$bd->sqlvalue_inyeccion($ruc,true);
        
        $bd->ejecutar($sql);
        //--------------
        
        $sql = "update co_reciprocas
                   set ruc1='1760013210001',
                       nombre='SERVICIO DE RENTAS INTERNAS'
                where cuenta_1= '213'  and ruc1=".$bd->sqlvalue_inyeccion($ruc,true);
        
        $bd->ejecutar($sql);
        
        //------------
        
        $sql = "update co_reciprocas
                   set grupo = '00',
                       subgrupo='00',
                       item='00',
                       cuenta_2 = '111' ,
                       nivel_21= '03',
                       deudor_2 =".$bd->sqlvalue_inyeccion(0,true).",
                       acreedor_2 = deudor_1
                where cuenta_1= '213' and deudor_1  <> 0 and cuenta_2 is null";
        
        $bd->ejecutar($sql);
        //--------------------
        
        $sql = "update co_reciprocas
                   set grupo = '00',
                       subgrupo='00',
                       item='00',
                       cuenta_2 = '111' , 
                       nivel_21= '03',
                       deudor_2 =".$bd->sqlvalue_inyeccion(0,true).", 
                       acreedor_2 = deudor_1
                where cuenta_1= '212' and deudor_1  <> 0 and cuenta_2 is null";
        
        $bd->ejecutar($sql);
        
        
        //-----------------------------------
        
        $sql = "update co_reciprocas
                   set grupo = '00',
                       subgrupo='00',
                       item='00',
                       cuenta_2 = '111' ,
                       nivel_21= '03',
                       deudor_2 =".$bd->sqlvalue_inyeccion(0,true).",
                       acreedor_2 = deudor_1
                where cuenta_1= '213' and deudor_1  <> 0 and cuenta_2 = '000'";
        
        $bd->ejecutar($sql);
        
        //-----------------------------------------
      
        $sql = "update co_reciprocas
                   set grupo = '00',
                       subgrupo='00',
                       item='00',
                       cuenta_2 = '111' ,
                       nivel_21= '03', nivel_22= '00'
                where cuenta_1= '212' and cuenta_2= '213'";
        
        $bd->ejecutar($sql);
        
        //------------------------------------------
        $sql = "update co_reciprocas 
                   set grupo = '00',
                       subgrupo='00',
                       item='00' 
                where cuenta_1= '213' and deudor_1 > 0";
                
        $bd->ejecutar($sql);

        //------------------------------------------

        $sql = "update co_reciprocas 
                   set grupo = '00',
                       subgrupo='00',
                       item='00' 
                where cuenta_1= '113' and acreedor_1 > 0";
                
        $bd->ejecutar($sql);


        $sql = "update co_reciprocas 
                set id_asiento_ref = asiento 
             where id_asiento_ref = 0";
             
        $bd->ejecutar($sql);

        
        $sql = "delete   FROM  co_reciprocas  where (deudor_1 + acreedor_1 +deudor_2 +acreedor_2) = 0";
        
        $bd->ejecutar($sql);
        
        
        $sql = "update co_reciprocas  set nivel_22 = '00' where  cuenta_1 = '213' and nivel_11= '56'  and cuenta_2= '213' and nivel_21 = '56'";
        
        $bd->ejecutar($sql);
        
       
        $sql = "update co_reciprocas   set cuenta_2 = '111' , nivel_21= '03' where  cuenta_1 = '213' and nivel_11= '56' and cuenta_2 = '213' and nivel_21= '56'";
        
        $bd->ejecutar($sql);
        
        $sql = "update co_reciprocas   set cuenta_2 = '111' , nivel_21= '03' where  cuenta_1 = '212' and cuenta_2 = '213' and nivel_21= '56'";
        
        $bd->ejecutar($sql);
        
        
        $sql = "update co_reciprocas  set acreedor_2 = deudor_1  where (deudor_1 + acreedor_1)  > 0 and (deudor_2 +acreedor_2) =0 and cuenta_1	= '213' and nivel_11 = '56' and deudor_1  > 0";
        
        $bd->ejecutar($sql);

        
        $sql = "update co_reciprocas  set nivel_22 = '00' where  cuenta_2 = '213'";
        
        $bd->ejecutar($sql);
        
 
        
        
        $sql1 ="select asiento,max(fecha) as fecha
									 from co_reciprocas 
									 where cuenta_1 = '113'  and id_asiento_ref = asiento 
									 group by asiento";
        
         
        $stmt1 = $bd->ejecutar($sql1);
        
        while ($x=$bd->obtener_fila($stmt1)){
            
            $asiento = $x['asiento'];
            $fecha   = $x['fecha'];
            
            $sql1 = "update co_reciprocas
                   set fecha = ".$bd->sqlvalue_inyeccion($fecha,true).",
                       fecha_pago= ".$bd->sqlvalue_inyeccion($fecha,true)."
                where cuenta_1= '113' and 
                      id_asiento_ref=".$bd->sqlvalue_inyeccion($asiento,true)."  and
                      asiento =".$bd->sqlvalue_inyeccion($asiento,true);
            
            $bd->ejecutar($sql1);
            
        }
        
        

    }    

    if ( $tipo == '2') {

        $sql = "update co_reciprocas 
                set cuenta_2 = '111',
                    nivel_21='03',
                    nivel_22='00' 
            where cuenta_1= '213' and 
                  deudor_1 > 0 and 
                  cuenta_2 = '124'";

        $bd->ejecutar($sql);
        
        
        $sql = "update co_reciprocas
                set id_asiento_ref = asiento 
            where cuenta_1= '213' and
                  acreedor_1 > 0 and
                  id_asiento_ref  <> asiento";
        
        $bd->ejecutar($sql);
        
        
        
        
        
    } 
    

 
    $data = 'DATOS ACTUALIZADOS....';
	 
        echo $data;
 	 
?>