<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	     =  new Db ;
$obj     = 	new objects;
 


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$anio	    =	$_GET["anio"];
$accion     = 	$_GET["accion"];
$registro   =   trim($_SESSION['ruc_registro']);

$hoy 	    =   date("Y-m-d");    	 
$result     =   'Seleccione informacion';

//--- creacion de periodo contable
if ( $accion == 1){
    $result=  crear_periodo_contable($bd ,$obj ,$anio ,$registro,$hoy);
}

if ( $accion == 11){
    $result=  crear_secuencias_contable($bd ,$obj ,$anio ,$registro,$hoy);
}


//--- creacion de periodo contable
if ( $accion == 2){
    $result=  crear_plan_contable($bd ,$obj ,$anio ,$registro,$hoy);
}


//--- creacion de periodo contable
if ( $accion == 22){
    $result=  valida_cuentas($bd ,$obj ,$anio ,$registro,$hoy);
}

//--- creacion de periodo contable
if ( $accion == 3){
    $result=  crear_periodo_presupuesto($bd ,$obj ,$anio ,$registro,$hoy);
}


//--- creacion presupuesto ingreso
if ( $accion == 4){
    $result=  ingreso_presupuesto($bd ,$obj ,$anio ,'I',$registro,$hoy);
}

//--- creacion presupuesto ingreso
if ( $accion == 5){
    $result=  ingreso_presupuesto($bd ,$obj ,$anio,'G' ,$registro,$hoy);
}


echo $result;

//-------------------------------------------------------------
function ingreso_presupuesto($bd ,$obj ,$anio ,$tipo,$registro,$hoy){
    
    
 
    
    $sql  = "SELECT * FROM  presupuesto.pre_gestion
             WHERE  anio = ".$bd->sqlvalue_inyeccion($anio - 1,true). ' and 
                    tipo='.$bd->sqlvalue_inyeccion($tipo,true);
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $cuenta = trim($x['partida']);
        
        $valida = verifica($bd, $cuenta ,$tipo,$registro,$anio);
        
        $ATabla = array(
            array( campo => 'partida',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => trim($x['partida']),   filtro => 'N',   key => 'S'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $tipo, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>trim($x['detalle']), key => 'N'),
            array( campo => 'clasificador',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>trim($x['clasificador']), key => 'N'),
            array( campo => 'fuente',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => trim($x['fuente']), key => 'N'),
            array( campo => 'activo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => trim($x['activo']), key => 'N'),
            array( campo => 'funcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor =>trim($x['funcion']), key => 'N'),
            array( campo => 'actividad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>trim($x['actividad']), key => 'N'),
            array( campo => 'titulo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>trim($x['titulo']), key => 'N'),
            array( campo => 'grupo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => trim($x['grupo']), key => 'N'),
            array( campo => 'subgrupo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => trim($x['subgrupo']), key => 'N'),
            array( campo => 'item',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => trim($x['item']), key => 'N'),
            array( campo => 'subitem',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => trim($x['subitem']), key => 'N'),
            array( campo => 'orientador',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>trim($x['orientador']), key => 'N'),
            array( campo => 'proforma',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'inicial',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'aumento',tipo => 'NUMBER',id => '16',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'disminuye',tipo => 'NUMBER',id => '17',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'codificado',tipo => 'NUMBER',id => '18',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'certificado',tipo => 'NUMBER',id => '19',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'compromiso',tipo => 'NUMBER',id => '20',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'devengado',tipo => 'NUMBER',id => '21',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'pagado',tipo => 'NUMBER',id => '22',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'disponible',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => $anio , key => 'N'),
            array( campo => 'proyecto',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor =>trim($x['proyecto']), key => 'N'),
            array( campo => 'competencia',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor =>trim($x['competencia']), key => 'N')
        );
        
        $tabla 	  		    = 'presupuesto.pre_gestion';
  
        if ( $valida == 0 ){
            $bd->_InsertSQL($tabla,$ATabla,'NO');
        }
        else {
            $bd->_UpdateSQL($tabla,$ATabla,$cuenta);
        }
    }
    
    
    $resultadoCta = 'Plan de cuentas cargado correctamente '.$anio;
    
    echo $resultadoCta;
    
}
//-----------------------------------------------------------
function crear_periodo_presupuesto($bd ,$obj ,$anio,$registro,$hoy ){
    
    
     $sesion 	        = trim($_SESSION['email']);
    
     $fecha_registro	=  date("Y-m-d");
     
     $fecha			    =  $bd->fecha($fecha_registro);
        
      $x = $bd->query_array('presupuesto.pre_periodo',
        'count(*) as nn',
        'anio='.$bd->sqlvalue_inyeccion($anio,true).' and
        registro='.$bd->sqlvalue_inyeccion($registro,true)
        );
    
    
        if ( $x['nn']  > 0 ){
            $result = ' Periodo ya generado '.$anio;
        }else{
 
            $detalle = 'Periodo Presupuestario '.$anio.'  - Proforma';
            
            $sql = "INSERT INTO presupuesto.pre_periodo (  creacion,anio, sesion, sesionm, modificacion, estado, registro, detalle)
										        VALUES (".$fecha.",".
										        $bd->sqlvalue_inyeccion($anio, true).",".
										        $bd->sqlvalue_inyeccion( $sesion, true).",".
										        $bd->sqlvalue_inyeccion( $sesion, true).",".
										        $fecha.",".
										        $bd->sqlvalue_inyeccion('proforma', true).",".
										        $bd->sqlvalue_inyeccion( $registro, true).",".
										        $bd->sqlvalue_inyeccion($detalle, true).")";
 										        
										        $bd->ejecutar($sql);
										      
             
             $result = ' Periodo ya generado con exito '.$anio;
            
         
       }
        return $result;
}
//----------------------------------------
function crear_secuencias_contable($bd ,$obj ,$anio,$registro,$hoy ){
    
    
    $tabla 	  		    = 'co_periodo';
    $sesion 	        = trim($_SESSION['email']);
    
    $anio_copiar = $anio - 1;

    $x = $bd->query_array('co_secuencias',    
                            'count(*) as nn',                        
                            'anio='.$bd->sqlvalue_inyeccion($anio,true) 
    );


    if (  $x['nn'] > 0  ){
        echo 'PERIODO '.$id. ' YA GENERADO... ';
    }else{

        $sql ="INSERT INTO public.co_secuencias (detalle, secuencia, estado, anio, tipo, tanio)  
               SELECT  detalle, 0 as secuencia, estado, anio + 1, tipo, tanio 
                FROM   co_secuencias 
                WHERE  anio= ".$bd->sqlvalue_inyeccion($anio_copiar , true);

     
 
        $bd->ejecutar($sql);

        echo 'PERIODO '.$id. '   GENERADO CON EXITO... ';
       

    }

    return $result;
}
//-----------------------------------------------------------
function crear_periodo_contable($bd ,$obj ,$anio,$registro,$hoy ){
    
    
    $tabla 	  		    = 'co_periodo';
    $sesion 	        = trim($_SESSION['email']);
    
    for ($i = 1; $i <= 12; $i++) {
        
        
        $x = $bd->query_array('co_periodo',
            'count(*) as nn',
            'registro='.$bd->sqlvalue_inyeccion($registro,true) . ' and '.
            'anio='.$bd->sqlvalue_inyeccion($anio,true) . ' and '.
            'mes='.$bd->sqlvalue_inyeccion($i,true)
            );
        
        if ( $x['nn']  > 0 ){
            $result = ' Periodo ya generado '.$anio;
        }else{
            
            $mesc = $obj->var->_mes($i);
            
            $ATabla = array(
                array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                array( campo => 'mes',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => $i,   filtro => 'N',   key => 'N'),
                array( campo => 'anio',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $anio,   filtro => 'N',   key => 'N'),
                array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
                array( campo => 'creacion',   tipo => 'DATE',   id => '4',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
                array( campo => 'sesionm',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
                array( campo => 'modificacion',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
                array( campo => 'mesc',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => $mesc,   filtro => 'N',   key => 'N'),
                array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'abierto',   filtro => 'N',   key => 'N'),
                array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => $registro,   filtro => 'N',   key => 'N'),
            );
            
            $bd->_InsertSQL($tabla,$ATabla,'-');
            
            $result = ' Periodo ya generado con exito '.$anio;
            
        }
    }
    return $result;
}
//----------------------------------------
function crear_plan_contable($bd ,$obj ,$anio ,$registro,$hoy){
    
    
    
    $sql = "SELECT * FROM  co_plan_ctas
             WHERE registro = ".$bd->sqlvalue_inyeccion($registro,true). ' and
                   anio = '.$bd->sqlvalue_inyeccion($anio - 1,true);
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $cuenta = trim($x['cuenta']);
        
        $valida = verifica($bd,$cuenta ,$registro,$anio);
        
        $ATabla = array(
            array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor =>  trim($x['cuenta']),   filtro => 'N',   key => 'S'),
            array( campo => 'cuentas',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => trim($x['cuentas']),   filtro => 'N',   key => 'N'),
            array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => trim($x['detalle']),   filtro => 'N',   key => 'N'),
            array( campo => 'nivel',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor =>trim($x['nivel']),   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor =>trim($x['tipo']),   filtro => 'N',   key => 'N'),
            array( campo => 'univel',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor =>trim($x['univel']),   filtro => 'N',   key => 'N'),
            array( campo => 'aux',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor =>trim($x['aux']),   filtro => 'N',   key => 'N'),
            array( campo => 'tipo_cuenta',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor =>trim($x['tipo_cuenta']),   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => trim($x['estado']),   filtro => 'N',   key => 'N'),
            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => $registro,   filtro => 'N',   key => 'N'),
            array( campo => 'debe',   tipo => 'numeric',   id => '10',  add => 'N',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'haber',   tipo => 'numeric',   id => '11',  add => 'N',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'saldo',   tipo => 'numeric',   id => '12',  add => 'N',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'impresion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor =>trim($x['impresion']),   filtro => 'N',   key => 'N'),
            array( campo => 'documento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'comprobante',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'N',   valor => trim($x['idprov']),   filtro => 'N',   key => 'N'),
            array( campo => 'debito',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'S',   valor =>trim($x['debito']),   filtro => 'N',   key => 'N'),
            array( campo => 'credito',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => trim($x['credito']),   filtro => 'N',   key => 'N'),
            array( campo => 'partida_enlace',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor =>trim($x['partida_enlace']),   filtro => 'N',   key => 'N'),
            array( campo => 'deudor_acreedor',   tipo => 'VARCHAR2',   id => '20',  add => 'S',   edit => 'S',   valor =>trim($x['deudor_acreedor']),   filtro => 'N',   key => 'N'),
            array( campo => 'anio',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => $anio   ,   filtro => 'N',   key => 'N')
        );
        
         $tabla 	  		    = 'co_plan_ctas';
        
        
        if ( $valida == 0 ){
             $bd->_InsertSQL($tabla,$ATabla,'NO');
        }
        else {
             $bd->_UpdateSQL($tabla,$ATabla,$cuenta);
        }
    }
     
    
    $resultadoCta = 'Plan de cuentas cargado correctamente '.$anio;
    
    echo $resultadoCta;
    
}

//--------------------------------------------------------------------------------


//--------------------------------------------------------------------------------
//--- eliminar de registros
//--------------------------------------------------------------------------------
function verifica($bd, $id ,$ruc,$anio){
    
    $sql = "SELECT count(*) as nro_registros
	       FROM co_plan_ctas
           where cuenta = ".$bd->sqlvalue_inyeccion(trim($id) ,true).' and
                 anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and
				 registro='.$bd->sqlvalue_inyeccion($ruc, true);
    
    $valida = 0;
    
    $resultado = $bd->ejecutar($sql);
    
    $datos_valida = $bd->obtener_array( $resultado);
    
    if ($datos_valida['nro_registros'] == 0){
         $valida = 0;
     }else{
        $valida = 1;
    }
     
     return $valida;
    
    
}
//--------------------------------------------------------------------------------
//--- eliminar de registros
//--------------------------------------------------------------------------------
function verifica_presupuesto($bd, $id ,$tipo,$ruc,$anio){
    
    $sql = "SELECT count(*) as nro_registros
	       FROM presupuesto.pre_gestion
           where partida = ".$bd->sqlvalue_inyeccion(trim($id) ,true).' and
                 tipo = '.$bd->sqlvalue_inyeccion(trim($tipo) ,true).'
                 anio = '.$bd->sqlvalue_inyeccion($anio ,true) ;
    
    $valida = 0;
    
    $resultado = $bd->ejecutar($sql);
    
    $datos_valida = $bd->obtener_array( $resultado);
    
    if ($datos_valida['nro_registros'] == 0){
        $valida = 0;
    }else{
        $valida = 1;
    }
    
    return $valida;
    
    
}

//---------
function valida_cuentas($bd, $id ,$tipo,$ruc,$anio){
    
    $sql = "update co_plan_ctas set partida_enlace = '-' where cuenta like '113%'";
    
 
     $bd->ejecutar($sql);
     

     $sql = "update co_plan_ctas set partida_enlace = '-' where cuenta like '213%'";
    
 
     $bd->ejecutar($sql);
    

     echo 'Cuentas actualizadas';
    
}
?>