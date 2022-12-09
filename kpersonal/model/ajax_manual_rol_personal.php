<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id_rol          = $_GET['id_rol'];
$monto           = $_GET['valor'];
$idprov          = trim($_GET['idprov']);
$id_config_reg   = $_GET['id_config_reg'];
$accion          = trim($_GET['accion']);
$id_rold         = $_GET['id_rold'];
 

$ruc =   trim($_SESSION['ruc_registro']);

$rol              = $bd->query_array('nom_rol_pago', 'id_periodo, mes, anio, registro', 'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true));

$rol_view         = $bd->query_array('view_nomina_rol', 'regimen,programa,sueldo,id_departamento,id_cargo,sueldo,fecha','idprov='.$bd->sqlvalue_inyeccion($idprov,true));

$variable_formula = $bd->query_array('view_nomina_rol_reg','estructura, formula, monto, variable ,tipoformula,tipo_config','id_config_reg='.$bd->sqlvalue_inyeccion($id_config_reg,true));
  

if ( trim( $variable_formula['tipo_config'] ) == 'I' ){   
    $ingreso   = $monto ;
    $descuento = '0.00';
}else{   
    $ingreso   = '0.00';
    $descuento = $monto ;
}


$dias = 30;

 
$sql_existe = "select id_rold
from nom_rol_pagod
where id_rol="	   .$bd->sqlvalue_inyeccion($id_rol ,true)." and
      id_periodo= ".$bd->sqlvalue_inyeccion($rol["id_periodo"] ,true)." and
      idprov= "	   .$bd->sqlvalue_inyeccion(trim($idprov),true)." and
      id_config =" .$bd->sqlvalue_inyeccion( $id_config_reg ,true);


      

      $resultado21 = $bd->ejecutar($sql_existe);
      $rol_valida = $bd->obtener_array( $resultado21);    


if ( $rol_valida['id_rold']  > 0 )      {    

    $accion  = 'editar';
    $id_rold = $rol_valida['id_rold'] ;
}

 
 
if ( $accion == 'add'){   

                $sql = "INSERT INTO nom_rol_pagod(
                    id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                    sueldo, id_departamento, id_cargo, regimen,dias,programa,fecha)
                VALUES (".
                $bd->sqlvalue_inyeccion($id_rol , true).",".
                $bd->sqlvalue_inyeccion($rol["id_periodo"], true).",".
                $bd->sqlvalue_inyeccion($idprov, true).",".
                $bd->sqlvalue_inyeccion($id_config_reg, true).",".
                $bd->sqlvalue_inyeccion($ingreso, true).",".
                $bd->sqlvalue_inyeccion($descuento, true).",".
                $bd->sqlvalue_inyeccion( $ruc , true).",".
                $bd->sqlvalue_inyeccion($rol["anio"], true).",".
                $bd->sqlvalue_inyeccion($rol["mes"], true).",".
                $bd->sqlvalue_inyeccion($rol_view['sueldo'], true).",".
                $bd->sqlvalue_inyeccion($rol_view['id_departamento'], true).",".
                $bd->sqlvalue_inyeccion($rol_view['id_cargo'], true).",".
                $bd->sqlvalue_inyeccion($rol_view['regimen'], true).",".
                $bd->sqlvalue_inyeccion($dias, true).",".
                $bd->sqlvalue_inyeccion($rol_view['programa'], true).",".
                $bd->sqlvalue_inyeccion($rol_view['fecha'], true).")";

                $bd->ejecutar($sql);

                echo 'Registro agregado....('.$idprov.')';
}else{   

    $sql = 'update nom_rol_pagod
            set ingreso = '.$bd->sqlvalue_inyeccion($ingreso ,true).',
                descuento = '.$bd->sqlvalue_inyeccion($descuento ,true).'
            where id_rold = '.$bd->sqlvalue_inyeccion($id_rold ,true);

 
            $bd->ejecutar($sql);

            echo 'Registro actualizado....('.$idprov.')';
}
  
    
 


?>