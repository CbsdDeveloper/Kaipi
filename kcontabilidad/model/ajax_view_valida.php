<?php
session_start();

include ('../../kconfig/Db.class.php');
include ('../../kconfig/Obj.conf.php');

$obj   = 	new objects;

$bd	   =	    new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$anio       =  $_SESSION['anio'];
 
$sql = 'SELECT  *
        FROM co_asiento_val order by cuenta1';
 
$resultado  = $bd->ejecutar($sql);

 
  echo '<table id ="tabla_bal"   class="display table table-condensed table-hover datatable" width="100%"  style="font-size: 12px;">';
	        echo '  <thead> 
                <tr>
                  <th width="15%">Cuenta</th>
                  <th width="10%">Monto</th>
                  <th width="50%">Validacion</th>
                  <th width="15%">Cuenta</th>
                  <th width="10%">Monto</th>
                </tr> </thead>';

                while ($x=$bd->obtener_fila($resultado)){
  
                    
                    echo "<tr>";
                    echo "<td>".trim($x['cuenta1'])."</td>";
                    $valor1 =  proceso_datos($bd, trim($x['sql1']),trim($x['tipo1']),$anio,trim($x['cuenta1']));    
                    echo "<td><b>".number_format($valor1,2)."</b></td>";
                    $valor1 = 0;
                    
                    echo "<td>".trim($x['texto'])."</td>";
                    echo "<td>".trim($x['cuenta2'])."</td>";
                    $valor2 =  proceso_datos($bd, trim($x['sql2']),trim($x['tipo2']),$anio,trim($x['cuenta2']));    
                    echo "<td><b>".number_format($valor2,2)."</b></td>";
                    $valor2 = 0;

                    echo "</tr>";

                    
                    

                }

                echo "</table>";


//--------- proceso
function proceso_datos($bd,$sql_condicion,$tipo,$anio,$cuenta ){


    $valor1 = 0;
 
    if ( $tipo == 'D'){
        $suma1  = ' coalesce(sum(debe),0) as monto ';
        $suma11 = ' coalesce(sum(suma_debe),0) as monto ';
    } else  {
        $suma1  = ' coalesce(sum(haber),0) as monto ';
        $suma11 = ' coalesce(sum(suma_haber),0) as monto ';
    }
 
    $len = strlen($cuenta);

 
    if (  $len > 2 ) {

            if ( trim($sql_condicion) == 'like'){

                    $xxx = $bd->query_array('co_resumen_balance',   // TABLA
                    $suma1,                        // CAMPOS
                    'anio = '.$bd->sqlvalue_inyeccion($anio,true).' and 
                    cuenta like '.$bd->sqlvalue_inyeccion(trim($cuenta) .'%',true)    
                    );

                    $valor1 = $xxx['monto'];

            }elseif ( trim($sql_condicion) == 'acumula'){

                $xxx = $bd->query_array('co_resumen_balance',   // TABLA
                $suma11,                        // CAMPOS
                'anio = '.$bd->sqlvalue_inyeccion($anio,true).' and 
                cuenta like '.$bd->sqlvalue_inyeccion(trim($cuenta) .'%',true)   
            );

            $valor1 = $xxx['monto'];

            }elseif ( trim($sql_condicion) == 'in'){

                $xxx = $bd->query_array('co_resumen_balance',   // TABLA
                $suma1,                        // CAMPOS
                'anio = '.$bd->sqlvalue_inyeccion($anio,true)." and 
                trim(grupo) ||'.' || trim(subgrupo) in (".trim($cuenta) .')'  
                );

                $valor1 = $xxx['monto'];

            }
   }
 
 

    return  $valor1;

}
   

?>