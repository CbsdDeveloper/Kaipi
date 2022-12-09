<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
 
	$bd	   = new Db ;
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    
    
 
    
    $d_id_asiento     =	$_POST["d_id_asiento"];
    $d_id_asientod =	$_POST["d_id_asientod"];
    $d_cuenta   =	$_POST["d_cuenta"];
    $d_haber       = 	$_POST["d_haber"];
    $d_parcial      = 	$_POST["d_parcial"];
 
 
       
     $result_cxcpago = '<b>Informacion ya generada'.'</b>';
     
     if ( $d_haber > $d_parcial ){
         
         $id= agregar($d_id_asiento,
                      $d_id_asientod,
             $d_cuenta,
             $d_haber,$d_parcial,$bd);
         
         $result_cxcpago = '<b>TRANSACCION REALIZADA CON EXITO Asiento : ' .$id.'</b>';
         
     
     }
     
  
     
    
     echo $result_cxcpago ;
 //--------------------------------------------------------------------------
 //--------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------
     function agregar( $d_id_asiento,
         $d_id_asientod,
         $d_cuenta,
         $d_haber,$d_parcial,$bd
        ){
            
           
            agregarDetalle($d_id_asiento,
                $d_id_asientod,
                $d_cuenta,
                $d_haber,$d_parcial,$bd);
			 
 
            $total_haber = $d_haber - $d_parcial;
			 
            edita_asiento( $d_id_asiento,
                $d_id_asientod,
                $d_cuenta,
                $total_haber,$bd);
			 
			 	
	 
			 
			 
			 return 1;
     }
     //--------------
     function edita_asiento( $d_id_asiento,
         $d_id_asientod,
         $d_cuenta,
         $total_haber,$bd){
       
         $sqlA = "UPDATE co_asientod
					SET  haber  =".$bd->sqlvalue_inyeccion($total_haber, true)."
					WHERE id_asiento   =".$bd->sqlvalue_inyeccion($d_id_asiento, true). " and 
                          id_asientod  =".$bd->sqlvalue_inyeccion($d_id_asientod, true) ;
                                        
         $bd->ejecutar($sqlA);
          
         $sql = "UPDATE co_asiento_aux
            	    SET 	haber      =".$bd->sqlvalue_inyeccion($total_haber, true)."
             	  WHERE id_asiento   =".$bd->sqlvalue_inyeccion($d_id_asiento, true). ' and
                        id_asientod       ='.$bd->sqlvalue_inyeccion($d_id_asientod, true);
         
         $bd->ejecutar($sql);
         
         
     }	
     
     //------------------------------------------
     function agregarDetalle( $d_id_asiento,
         $d_id_asientod,
         $d_cuenta,
         $d_haber,$d_parcial,$bd){
         
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
         $sql = "SELECT  *
                FROM co_asientod
                where id_asientod = ".$bd->sqlvalue_inyeccion($d_id_asientod,true);  
             
             $stmt = $bd->ejecutar($sql);
             
             while ($x=$bd->obtener_fila($stmt)){
     
                     $cuenta = trim($x['cuenta']) ;
                     $partida= trim($x['partida']);
                     
                     $sql = "INSERT INTO co_asientod(
        								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
        								sesion, creacion, principal,partida,item,programa,registro)
        								VALUES (".
        								$bd->sqlvalue_inyeccion($d_id_asiento , true).",".
        								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
        								$bd->sqlvalue_inyeccion( 'S', true).",".
        								$bd->sqlvalue_inyeccion(0, true).",".
        								$bd->sqlvalue_inyeccion($d_parcial, true).",".
        								$bd->sqlvalue_inyeccion( $x['id_periodo'], true).",".
        								$bd->sqlvalue_inyeccion( $x['anio'], true).",".
        								$bd->sqlvalue_inyeccion( $x['mes'], true).",".
        								$bd->sqlvalue_inyeccion($sesion , true).",".
        								$hoy.",".
        								$bd->sqlvalue_inyeccion( 'N', true).",".
        								$bd->sqlvalue_inyeccion( $partida, true).",".
        								$bd->sqlvalue_inyeccion( trim($x['item']), true).",".
        								$bd->sqlvalue_inyeccion( trim($x['programa']), true).",".
        								$bd->sqlvalue_inyeccion( $ruc, true).")";
        								
        								$bd->ejecutar($sql);
        			
        			  $id_asientod =  $bd->ultima_secuencia('co_asientod');
  			  
        			  K_aux($id_asientod,$d_id_asiento,$d_id_asientod,$d_parcial,$bd);
             }
								
  
     }
     //-------------------------------------------------------------
     function K_aux($id_asientod,$d_id_asiento,$d_id_asientod,$d_parcial,$bd){
      
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
       
         $x = $bd->query_array('co_asiento_aux',   // TABLA
             '*',                        // CAMPOS
             'id_asientod='.$bd->sqlvalue_inyeccion($d_id_asientod,true) // CONDICION
             );
         
        
             
             $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
		              									  anio, mes, sesion,tipo,pago, creacion,id_asiento_ref, registro) VALUES (".
		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
		              									  $bd->sqlvalue_inyeccion($d_id_asiento, true).",".
		              									  $bd->sqlvalue_inyeccion(trim( $x['idprov']) , true).",".
		              									  $bd->sqlvalue_inyeccion(trim( $x['cuenta']) , true).",".
		              									  $bd->sqlvalue_inyeccion('0.00' , true).",".
		              									  $bd->sqlvalue_inyeccion($d_parcial , true).",".
		              									  $bd->sqlvalue_inyeccion(0 , true).",".
		              									  $bd->sqlvalue_inyeccion($x['id_periodo'], true).",".
		              									  $bd->sqlvalue_inyeccion($x['anio'], true).",".
		              									  $bd->sqlvalue_inyeccion($x['mes'] , true).",".
		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
		              									  $bd->sqlvalue_inyeccion($x['tipo']	, true).",".
		              									  $bd->sqlvalue_inyeccion($x['pago'] 	, true).",".
		              									  $hoy.",".
		              									  $bd->sqlvalue_inyeccion($x['id_asiento_ref'] 	, true).",".
		              									  $bd->sqlvalue_inyeccion( $ruc  , true).")";
		              									  
		              									  $bd->ejecutar($sql);
		              									  
       
     }
 //------------------------------------------------------------------
    
 //-------------------------
     function _actualiza_aux($id,$idprov,$comprobante,$detalle,$bd){
         
         
         $sql = "UPDATE co_asiento_aux
            							    SET 	detalle      =".$bd->sqlvalue_inyeccion(trim($detalle), true).",
                                                    comprobante  =".$bd->sqlvalue_inyeccion($comprobante, true)."
             							      WHERE id_asiento   =".$bd->sqlvalue_inyeccion($id, true). ' and
                                                    idprov       ='.$bd->sqlvalue_inyeccion(trim($idprov), true);
         
         $bd->ejecutar($sql);
         
         
     }
     
     //-----------------------------
 
?>
 
  