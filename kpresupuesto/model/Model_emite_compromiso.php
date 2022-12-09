<?php
session_start( );

require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
require 'Model_saldos.php';  

$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$saldos_p     = 	new saldo_presupuesto(  $obj,  $bd);

$idtramite          = $_GET['idtramite'];

$fcertifica         = $_GET['fcompromiso'];

$anio 	      =     $_SESSION['anio'];
 
$ruc                =$_SESSION['ruc_registro'];
 

$trozos      =      explode("-", $fcertifica,3);

$anio1  = $trozos[0];


$x = $bd->query_array('presupuesto.pre_tramite_temp',
                      'count(*) as nn', 
                      'id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true). ' and 
                       estado ='.$bd->sqlvalue_inyeccion('N',true)
    );


$sql1 = "SELECT   id_tramite,  partida, certificado ,coalesce(compromiso,0) as compromiso
         FROM presupuesto.pre_tramite_det
        where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;

///---------------------------------------------------
    
    $stmt1_valida = $bd->ejecutar($sql1);
    
    $bandera = 0;
    
 
    
    while ($fila1=$bd->obtener_fila($stmt1_valida)){
        
        $mmonto_compromiso =   $fila1['compromiso'] ;
        
        if ( $mmonto_compromiso  < 0){
            $bandera = 1;
        }
        
    }



        if ( $anio1 == $anio ) {
         
                    $compro = _comprobante($bd,$anio,$ruc );
                    
                    if ( $x['nn'] > 0  ){
                        
                        $valor_dato = compromiso_parcial( $bd,$idtramite,$fcertifica,$anio,$compro,$ruc);
                        $saldos_p->_saldo_gasto($anio);
                        
                    }else{
                        
                        if ( $bandera == 0 ) {
                        
                                $valor_dato = compromiso( $bd,$idtramite,$fcertifica,$anio);
                                $saldos_p->_saldo_gasto($anio);
                        }else {
                            
                            $valor_dato = '1';
                            
                        }
                        
                    }
     }else 
    {
    
        $valor_dato = '0';
    
    }

    echo $valor_dato;
          
//-------------------
//-------------------
//-------------------------------------------------------------------------------------
function compromiso_parcial($bd,$idtramite,$fcertifica,$anio,$compro,$ruc ){
         
    
    $sql1 = "UPDATE presupuesto.pre_tramite
                SET  idprov= ".$bd->sqlvalue_inyeccion(trim(''),true) ."
              WHERE id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
    
    $bd->ejecutar($sql1);
    
    //-- certificacion 
    $x = $bd->query_array('presupuesto.pre_tramite',
        'id_tramite, fecha, registro, anio, mes, detalle, observacion, sesion, sesion_asigna, creacion , comprobante, estado, tipo, documento, id_departamento, idprov, planificado, id_asiento_ref, marca,solicita, nro_memo, asunto, fcertifica, fcompromiso, fdevenga, cur',
        'id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true) 
        );
    
     
    $ATabla = array(
        array( campo => 'id_tramite',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'Y'),
        array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => $x['fecha'], key => 'N'),
        array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $x['registro'], key => 'N'),
        array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $x['anio'], key => 'N'),
        array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $x['mes'], key => 'N'),
        array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $x['detalle'], key => 'N'),
        array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $x['observacion'], key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $x['sesion'], key => 'N'),
        array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$x['sesion_asigna'], key => 'N'),
        array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $x['creacion'], key => 'N'),
        array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $compro, key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '5', key => 'N'),
        array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $x['tipo'], key => 'N'),
        array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $x['documento'], key => 'N'),
        array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => $x['id_departamento'], key => 'N'),
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => $x['idprov'], key => 'N'),
        array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor =>$x['planificado'], key => 'N'),
        array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => $x['id_asiento_ref'], key => 'N'),
        array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor =>$x['marca'], key => 'N'),
        array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor =>$x['solicita'], key => 'N'),
        array( campo => 'nro_memo',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => $x['nro_memo'], key => 'N'),
        array( campo => 'asunto',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor =>$x['asunto'], key => 'N'),
        array( campo => 'fcertifica',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor => $x['fcertifica'], key => 'N'),
        array( campo => 'fcompromiso',tipo => 'DATE',id => '23',add => 'S', edit => 'S', valor =>$fcertifica, key => 'N'),
        array( campo => 'fdevenga',tipo => 'DATE',id => '24',add => 'S', edit => 'S', valor => $x['fdevenga'], key => 'N'),
        array( campo => 'cur',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => $x['cur'], key => 'N'),
    );
    
    $id = $bd->_InsertSQL('presupuesto.pre_tramite',$ATabla,'presupuesto.pre_tramite_id_tramite_seq');
    
    //------------------ parcial //-------------------------------
    //---------------------------------------------------------------------
    $sql1 = "SELECT   id_tramite_temp, id_tramite, id_tramite_det, partida, monto, iva, sesion, estado
         FROM presupuesto.pre_tramite_temp
        where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true). ' and estado = '.$bd->sqlvalue_inyeccion('N',true) ;
    
    $stmt1_valida = $bd->ejecutar($sql1);
    
    while ($fila1=$bd->obtener_fila($stmt1_valida)){
        
        $monto = $fila1['monto'] - $fila1['iva'];
     
        $saldo =  $fila1['monto'] ;
        
        $fecha =  date("Y-m-d");  
        
        $id_tramite_det = $fila1['id_tramite_det'] ;
        
        $id_tramite_temp = $fila1['id_tramite_temp'] ;
        
        $ATablad = array(
            array( campo => 'id_tramite_det',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id, key => 'N'),
            array( campo => 'partida',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $fila1['partida'], key => 'N'),
            array( campo => 'saldo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $fila1['iva'], key => 'N'),
            array( campo => 'base',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $monto, key => 'N'),
            array( campo => 'certificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>  $fila1['monto'] , key => 'N'),
            array( campo => 'compromiso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor =>  $fila1['monto'] , key => 'N'),
            array( campo => 'devengado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor =>  $fila1['sesion'], key => 'N'),
            array( campo => 'fsesion',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $ruc, key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $anio, key => 'N'),
            array( campo => 'pagado',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '0', key => 'N'),
        );
         
      
        $bd->_InsertSQL('presupuesto.pre_tramite_det',$ATablad,'presupuesto.pre_tramite_det_id_tramite_det_seq');
        
        //--------------------------------------------------------
        
        $sqlEdit = "UPDATE presupuesto.pre_tramite_det
                               SET 	certificado= certificado-".$bd->sqlvalue_inyeccion($saldo, true).",
                                    base= base -".$bd->sqlvalue_inyeccion($monto, true).",
                                    iva= iva -".$bd->sqlvalue_inyeccion($fila1['iva'], true)."
                             where id_tramite_det = ".$bd->sqlvalue_inyeccion($id_tramite_det,true) ;
        
        
        $bd->ejecutar($sqlEdit);
        
        $sqlEdit = "UPDATE presupuesto.pre_tramite_temp
                               SET 	id_tramiteo= ".$bd->sqlvalue_inyeccion( $id , true).",
                                    estado= ".$bd->sqlvalue_inyeccion('S', true)."
                             where estado = ".$bd->sqlvalue_inyeccion('N',true)." and 
                                  id_tramite_temp = ".$bd->sqlvalue_inyeccion($id_tramite_temp,true) ;
        
        
        $bd->ejecutar($sqlEdit);
    }
    
}
//-------------------
function compromiso( $bd,$idtramite,$fcertifica,$anio){
        


         //-----------------------------------------------------
         
         
         $sql1 = "SELECT   id_tramite,  partida, certificado ,coalesce(compromiso,0) as compromiso
         FROM presupuesto.pre_tramite_det
        where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
             
             $stmt1 = $bd->ejecutar($sql1);
             
             
             while ($fila=$bd->obtener_fila($stmt1)){
                 
                 $partida = trim($fila['partida']);
                 
                 
                 $sqlEditPre = "UPDATE presupuesto.pre_gestion
                           SET certificado = certificado - ".$bd->sqlvalue_inyeccion($fila['certificado'],true).",
                               compromiso = compromiso + ".$bd->sqlvalue_inyeccion($fila['compromiso'],true)."
                    where partida = ".$bd->sqlvalue_inyeccion(trim($partida),true). ' and  anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
                 
                 $bd->ejecutar($sqlEditPre);
                 
             }
             
             //-- ----------------------------------
             $fecha			        = $bd->fecha($fcertifica);
             
             $sqlEdit = "UPDATE presupuesto.pre_tramite
                               SET 	estado=".$bd->sqlvalue_inyeccion('5', true).",
                                    fcompromiso= ".$fecha."
                             where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
             
             
             $bd->ejecutar($sqlEdit);
             
             $imprime = $fcertifica;
             
       
         
       return $imprime;
         
     }
 //------------------------
  function _comprobante($bd,$anio,$ruc ){


    $sql = "SELECT   count(*) as secuencia,max(comprobante) as nn
    FROM presupuesto.pre_tramite
    where estado in ('2','3','4','5','6')  and 
          anio = ".$bd->sqlvalue_inyeccion($anio   ,true);


    $parametros 			= $bd->ejecutar($sql);
    $secuencia 				= $bd->obtener_array($parametros);
 
    $ss = explode('-', $secuencia['nn'] );

    $dato = $ss[0];

    $int = (int)$dato;

    $contador = $int + 1;

    $input = str_pad($contador, 5, "0", STR_PAD_LEFT).'-'.$anio;

  
     
     return $input;
     }
   
     
?>
