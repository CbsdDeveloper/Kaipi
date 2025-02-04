<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id_rol          =   $_GET['id_rol'];
$accion          =   trim($_GET['codigo']);
$id_config1      =   $_GET['id_config1'];
$ruc             =   trim($_SESSION['ruc_registro']);


$rol = $bd->query_array('view_nom_accion', 
    'id_accion,fecha,fecha_rige,motivo, idprov, razon,p_cargo ,sueldo,p_sueldo',
    'id_accion='.$bd->sqlvalue_inyeccion($accion,true)
    );

   
$idprov = trim($rol['idprov']);
$motivo = trim($rol['motivo']);

$sueldo   = trim($rol['sueldo']);
$p_sueldo = trim($rol['p_sueldo']);



$rol_tipo = $bd->query_array('nom_accion_lista', 
    'nombre,  afecta, monto',
    'nombre='.$bd->sqlvalue_inyeccion($motivo,true)
    );


    $monto_afecta = $rol_tipo['monto'];


    if ( $motivo == 'ENCARGO'){

        $ingreso = $p_sueldo - $sueldo;

    }else{

        if (   $monto_afecta  > 0 ){

            $p1 =  ($monto_afecta /100);

            $ingreso = $p_sueldo * $p1;

        }

    }
    
    
$rol              = $bd->query_array('nom_rol_pago', 'id_periodo, mes, anio, registro', 'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true));

$rol_view         = $bd->query_array('view_nomina_rol', 'regimen,programa,sueldo,id_departamento,id_cargo,sueldo,fecha','idprov='.$bd->sqlvalue_inyeccion($idprov,true));


///------------ verifica datos -----------------------/

$sql_existe = "select id_rold
from nom_rol_pagod
where id_rol="	   .$bd->sqlvalue_inyeccion($id_rol ,true)." and
      id_periodo= ".$bd->sqlvalue_inyeccion($rol["id_periodo"] ,true)." and
      idprov= "	   .$bd->sqlvalue_inyeccion(trim($idprov),true)." and
      id_config =" .$bd->sqlvalue_inyeccion( $id_config1 ,true);


      $resultado21 = $bd->ejecutar($sql_existe);

      $rol_valida = $bd->obtener_array( $resultado21);    

      $descuento  = 0;


      $resultado = 'NO se actualizo....('.$idprov.')';


      if ( $rol_valida['id_rold']  > 0 )      {    

          $id_rold = $rol_valida['id_rold'] ;

          $sql = 'update nom_rol_pagod
                    set ingreso = '.$bd->sqlvalue_inyeccion($ingreso ,true).'
                    where id_rold = '.$bd->sqlvalue_inyeccion($id_rold ,true);


                if (  $ingreso  > 0 )     {       

                $bd->ejecutar($sql);

                $resultado = 'Registro actualizado....('.$idprov.')';
            
                }
         }
        else{

              $dias = 30;

                $sql = "INSERT INTO nom_rol_pagod(
                    id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                    sueldo, id_departamento, id_cargo, regimen,dias,programa,fecha)
                VALUES (".
                $bd->sqlvalue_inyeccion($id_rol , true).",".
                $bd->sqlvalue_inyeccion($rol["id_periodo"], true).",".
                $bd->sqlvalue_inyeccion($idprov, true).",".
                $bd->sqlvalue_inyeccion($id_config1, true).",".
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

                  if (  $ingreso  > 0 )     {       

                    $bd->ejecutar($sql);

                    $resultado = 'Registro actualizado....('.$idprov.')';
                    
               }
 
      }
    

      echo $resultado ;
 


?>