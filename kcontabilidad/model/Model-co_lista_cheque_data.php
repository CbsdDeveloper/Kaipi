<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   = new Db ;

$registro    = $_SESSION['ruc_registro'];

$sesion 	 =  $_SESSION['email'];

$hoy 	     =   date("Y-m-d");

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_concilia	 =	$_GET["id_concilia"];
 
$estado	     =	$_GET["estado"];


$Aconciliacion = $bd->query_array('co_concilia',
    'anio, mes,   estado, cuenta',
    'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
    );

            if ( trim($estado) == 'digitado') {
                
                
                $sql = "SELECT id_asiento_aux, fecha,cheque,documento, razon,debe, haber ,bandera
                FROM view_bancos
                where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
                        cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
                        tipo   = 'cheque' and
                        haber > 0 and
                        bandera = 0 and 
                        cab_codigo is null and 
                        anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
                        mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)."
                        order by fecha asc";	
                
                
                $stmt = $bd->ejecutar($sql);
                
                while ($x=$bd->obtener_fila($stmt)){
                    
                    $idaux = $x['id_asiento_aux'];
                    
                    $Dato = $bd->query_array('view_aux',
                        ' id_asiento, idprov, razon,cheque,  debe, haber,  id_asiento_aux, fecha,  detalle',
                        'id_asiento_aux='.$bd->sqlvalue_inyeccion($idaux,true)
                        );
                    
                     $detalle = trim($Dato['razon']).' '.trim($Dato['detalle']);
                    
                     $ATabla = array(
                         array( campo => 'id_conciliad',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                         array( campo => 'id_concilia',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id_concilia, key => 'N'),
                         array( campo => 'id_asiento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>  $Dato['id_asiento'], key => 'N'),
                         array( campo => 'id_asiento_aux',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $idaux, key => 'N'),
                         array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'cheque', key => 'N'),
                         array( campo => 'registro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $registro, key => 'N'),
                         array( campo => 'documento',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $Dato['cheque'], key => 'N'),
                         array( campo => 'detalle',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $detalle, key => 'N'),
                         array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
                         array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $hoy, key => 'N'),
                         array( campo => 'debe',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $Dato['debe'], key => 'N'),
                         array( campo => 'haber',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => $Dato['haber'], key => 'N'),
                         array( campo => 'fecha',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $Dato['fecha'], key => 'N')
                     );
                     
                     $bd->_InsertSQL('co_conciliad',$ATabla,'co_conciliad_id_conciliad_seq');
                     
                     
                     $sql = "update co_asiento_aux
                                        set cab_codigo = 1 where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true);
                     
                     $bd->ejecutar($sql);
                     
                    
                }
                 /* 
                        $sql = 'delete from co_conciliad
                                     where id_asiento_aux='.$bd->sqlvalue_inyeccion($idaux, true). ' and
                                           id_concilia='.$bd->sqlvalue_inyeccion($id_concilia, true);
                        
                        $bd->ejecutar($sql);
                        
             */
    
            }


//----------------

  $a = $bd->query_array('co_conciliad','sum(haber) as egreso',
                'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                                         tipo = ".$bd->sqlvalue_inyeccion('cheque',true)
                );
            
  echo '<script>'.'$("#cheques").val( '.$a['egreso'].')'.'</script>';

$Mov_cheque = '<h6>Cheques girados y no cobrados</h6>';

$tipo 		    = $bd->retorna_tipo();

$sql = 'SELECT  id_asiento as "Asiento",
                                documento as "Documento",
                                detalle as "Detalle",
                                debe as "Ingreso",
                                haber as "Egreso"
                        FROM co_conciliad
                        where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                              tipo = '. $bd->sqlvalue_inyeccion('cheque' , true).' and
                              registro = '. $bd->sqlvalue_inyeccion($registro , true);


$resultado  = $bd->ejecutar($sql);

echo $Mov_cheque;

$obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');

$formulario = '';
$obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');




?>
 
  