<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   = new Db ;
$registro= $_SESSION['ruc_registro'];
$sesion 	 =  $_SESSION['email'];
$hoy 	     =   date("Y-m-d");  

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_concilia	=	$_GET["id_concilia"];
$idaux	=	$_GET["idaux"];
$estado	=	$_GET["estado"];
$bandera	=	$_GET["bandera"];
 

$EstadoTramite = $bd->query_array('co_concilia', 'estado', 'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true) );

if ( trim($EstadoTramite["estado"]) == 'digitado') {
          
if ($bandera == 'S'){
    
    if ($estado == 'S'){
              
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
                array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'deposito', key => 'N'),
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
                    set bandera = 1, tipo='deposito'  
                   where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true);
    		              									      
    		$bd->ejecutar($sql);
            
    }else{
        
        $sql = 'delete from co_conciliad 
                 where id_asiento_aux='.$bd->sqlvalue_inyeccion($idaux, true). ' and 
                       id_concilia='.$bd->sqlvalue_inyeccion($id_concilia, true);
        
        $bd->ejecutar($sql); 
        
        $sql = "update co_asiento_aux
                    set bandera = 0, tipo='deposito' 
                    where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true);
        
        $bd->ejecutar($sql);
    }
    
 
        
        $a = $bd->query_array('co_conciliad','sum(debe) as ingreso',
                                    'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                                     tipo = ".$bd->sqlvalue_inyeccion('deposito',true)
            );
        
        ;
        
        
        echo '<script>'.'$("#depositos").val( '.$a['ingreso'].')'.'</script>';
     
    }
}

   $Mov_Desposito = '<h6>Depositos en transito y trasferencias</h6>';
 
        $tipo 		    = $bd->retorna_tipo();
        
        $sql = 'SELECT  id_asiento as "Asiento",
                                documento as "Documento",
                                detalle as "Detalle",
                                debe as "Ingreso",
                                haber as "Egreso"
                        FROM co_conciliad
                        where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                              tipo = '. $bd->sqlvalue_inyeccion('deposito' , true).' and
                              registro = '. $bd->sqlvalue_inyeccion($registro , true);
        
        
        $resultado  = $bd->ejecutar($sql);
        
        echo $Mov_Desposito;
        
        $obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');
        
        
        $obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');

 
 

?>
 
  