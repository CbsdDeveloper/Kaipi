<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;

$bd	   = new Db ;

$registro    = $_SESSION['ruc_registro'];

$sesion 	 =  $_SESSION['email'];

$hoy 	     =   date("Y-m-d");

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_concilia	 =	$_GET["id_concilia"];

$estado	         =	$_GET["estado"];


$Aconciliacion = $bd->query_array('co_concilia',
    'anio, mes,   estado, cuenta',
    'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
    );

            if ( trim($estado) == 'digitado') {
                
                
                   
                $sql1 = "select *
                    FROM view_bancos_concilia
                    where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
                    cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
                    tipo    <> 'cheque' and
                    concilia = 'N' and
                    anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
                    mes    <= ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)  ;
    
                
              
                
                $stmt = $bd->ejecutar($sql1);
                
                while ($x=$bd->obtener_fila($stmt)){
                    
                     $idaux = $x['id_asientod'];
                     
                     $detalle = trim($x['razon']).' '.substr(trim($x['detalle']),1,150);
                     
                     $documento = $x['documento_pago'];
                     if (empty(trim($x['documento_pago']))){
                         $documento =  $x['comprobante'];
                     }
                    
                     $ATabla = array(
                         array( campo => 'id_conciliad',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                         array( campo => 'id_concilia',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id_concilia, key => 'N'),
                         array( campo => 'id_asiento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>  $x['id_asiento'], key => 'N'),
                         array( campo => 'id_asiento_aux',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $idaux, key => 'N'),
                         array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'deposito', key => 'N'),
                         array( campo => 'registro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $registro, key => 'N'),
                         array( campo => 'documento',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $documento, key => 'N'),
                         array( campo => 'detalle',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $detalle, key => 'N'),
                         array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
                         array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $hoy, key => 'N'),
                         array( campo => 'debe',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $x['debe'], key => 'N'),
                         array( campo => 'haber',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => $x['haber'], key => 'N'),
                         array( campo => 'fecha',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $x['fecha'], key => 'N')
                     );
                     
                      
                           
                     $ys = $bd->query_array('co_conciliad',
                         'count(*) as numero',
                         'id_asiento='.$bd->sqlvalue_inyeccion( $x['id_asiento'],true). ' and
                          id_asiento_aux ='.$bd->sqlvalue_inyeccion($idaux,true)
                         );
                     
                    
                     
                     if ( $ys['numero'] > 0 ){
                         
                         $Mov_cheque  = '';
                         
                     }else {
                         
                         $bd->_InsertSQL('co_conciliad',$ATabla,'co_conciliad_id_conciliad_seq');
                         
                     }
                     
                     
                }
               
    
            }


//----------------

  $a = $bd->query_array('co_conciliad',
                        'sum(haber) as egreso',
                        'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                         tipo = ".$bd->sqlvalue_inyeccion('deposito',true)
                );
            
  echo '<script>'.'$("#depositos").val( '.$a['egreso'].')'.'</script>';

$Mov_cheque = '<h6>Depositos y/o Trasferencias</h6>';

$tipo 		    = $bd->retorna_tipo();

$sql = 'SELECT  id_asiento_aux as "Asiento",
                                documento as "Documento",
                                detalle as "Detalle",
                                debe as "Ingreso",
                                haber as "Egreso"
                        FROM co_conciliad
                        where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                              tipo = '. $bd->sqlvalue_inyeccion('deposito' , true).' and
                              registro = '. $bd->sqlvalue_inyeccion($registro , true);


$resultado  = $bd->ejecutar($sql);

echo $Mov_cheque;

$obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');

$formulario = 'Asiento';

//$resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab

$obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'S','elimina','','','');




?>
 
  