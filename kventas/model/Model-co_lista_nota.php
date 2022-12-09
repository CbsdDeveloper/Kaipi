<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   = new Db ;

$registro= $_SESSION['ruc_registro'];
$sesion 	 =  $_SESSION['email'];
$hoy 	     =   date("Y-m-d");  

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_concilia	=	$_POST["id_concilia"];
$transaccion	=	$_POST["transaccion"];
$fecha	         =	$_POST["fecha_nota"];
$detalle	       =	$_POST["detalle"];
$monto	         =	$_POST["monto"];
$doc_nota	      =	$_POST["doc_nota"];


$bandera	=	$_POST["bandera"];

 


$lon = strlen(trim($detalle));


$EstadoTramite = $bd->query_array('co_concilia', 'estado', 'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true) );

if ( trim($EstadoTramite["estado"]) == 'digitado') {

        if ( $bandera == 'S'){
            if ( $monto > 0 ){
                if ($lon > 5)  {
                    
                    if (trim($transaccion) == 'credito'){
                        $debe   = $monto;
                        $haber  = '0';
                    }else{
                        $debe   = '0';
                        $haber  = $monto;
                        
                    }
                    
            
                    
                    $ATabla = array(
                        array( campo => 'id_conciliad',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                        array( campo => 'id_concilia',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id_concilia, key => 'N'),
                        array( campo => 'id_asiento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>  '0', key => 'N'),
                        array( campo => 'id_asiento_aux',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '0', key => 'N'),
                        array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $transaccion, key => 'N'),
                        array( campo => 'registro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $registro, key => 'N'),
                        array( campo => 'documento',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $doc_nota, key => 'N'),
                        array( campo => 'detalle',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $detalle, key => 'N'),
                        array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
                        array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $hoy, key => 'N'),
                        array( campo => 'debe',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $debe, key => 'N'),
                        array( campo => 'haber',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => $haber, key => 'N'),
                        array( campo => 'fecha',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $fecha, key => 'N')
                    );
                    
                    $bd->_InsertSQL('co_conciliad',$ATabla,'co_conciliad_id_conciliad_seq');
                }
             }
             //--- totales
              if (trim($transaccion) == 'credito'){
                 
                 $a = $bd->query_array('co_conciliad','sum(debe) as ingreso',
                     'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                       tipo = ".$bd->sqlvalue_inyeccion('credito',true)
                     );
                 
                  echo '<script>'.'$("#notacredito").val( '.$a['ingreso'].')'.'</script>';
                 
              }else{
                 
                 $a = $bd->query_array('co_conciliad','sum(haber) as egreso',
                     'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                       tipo = ".$bd->sqlvalue_inyeccion('debito',true)
                     );
                 
                 echo '<script>'.'$("#notadebito").val( '.$a['egreso'].')'.'</script>';
                 
             }
             
        }
        //------------
        if ( $bandera == 'X'){
            
            $id_conciliad	=	$_POST["codigo"];
            
            $sql = 'delete from co_conciliad where id_conciliad='.$bd->sqlvalue_inyeccion($id_conciliad, true) ;
            
             
            $bd->ejecutar($sql);
            
            //---------------------------------
            $a = $bd->query_array('co_conciliad','sum(debe) as ingreso',
                'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                       tipo = ".$bd->sqlvalue_inyeccion('credito',true)
                );
            
             echo '<script>'.'$("#notacredito").val( '.$a['ingreso'].')'.'</script>';
            //---------------------------------
             $a = $bd->query_array('co_conciliad','sum(haber) as egreso',
                 'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                       tipo = ".$bd->sqlvalue_inyeccion('debito',true)
                 );
             
             echo '<script>'.'$("#notadebito").val( '.$a['egreso'].')'.'</script>';
            
        }
        
}
     
 
        $Mov_cheque = '<h6>Notas de Credito</h6>';
 
         
        $tipo 		    = $bd->retorna_tipo();
    
       
      
                $sql = 'SELECT  fecha as "Fecha",
                                        documento as "Documento",
                                        detalle as "Detalle",
                                        debe as "Ingreso",
                                        haber as "Egreso",id_conciliad
                                FROM co_conciliad
                                where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                                      tipo = '. $bd->sqlvalue_inyeccion('credito' , true).' and
                                      registro = '. $bd->sqlvalue_inyeccion($registro , true);
                
                
                $resultado  = $bd->ejecutar($sql);
                 echo $Mov_cheque;
                
                $obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');
                
                $obj->grid->KP_GRID_NEW($resultado,$tipo,'S','','del','id_conciliad');
                
                $Mov_cheque = '<h6>Notas de Debito</h6>';
                
                 echo $Mov_cheque;
                 
            
            $sql = 'SELECT  fecha as "Fecha",
                                        documento as "Documento",
                                        detalle as "Detalle",
                                        debe as "Ingreso",
                                        haber as "Egreso",id_conciliad
                                FROM co_conciliad
                                where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                                      tipo = '. $bd->sqlvalue_inyeccion('debito' , true).' and
                                      registro = '. $bd->sqlvalue_inyeccion($registro , true);
            
            
            $resultado  = $bd->ejecutar($sql);
            
           
            
            $obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');
            
            
            $obj->grid->KP_GRID_NEW($resultado,$tipo,'S','','del','id_conciliad');
     
    
 
 

?>
 
  