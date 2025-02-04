<?php
session_start();

include ('../../kconfig/Db.class.php');
include ('../../kconfig/Obj.conf.php');

$obj   = 	new objects;

$bd	   =	    new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$anio       =  $_SESSION['anio'];
 
$sql = "select cuenta,detalle,debe,haber ,impresion ,nivel
         from co_resumensaldos
        where anio = ".$bd->sqlvalue_inyeccion($anio,true)." and impresion = '0' and  
        nivel between 4 and 6 
        order by cuenta";
 
$resultado  = $bd->ejecutar($sql);

 
  echo '<table id ="tabla_bal"   class="display table table-condensed table-hover datatable" width="100%"  style="font-size: 12px;">';
	        echo '  <thead> 
                <tr>
                  <th width="20%">Cuenta</th>
                  <th width="5%">Nivel</th>
                  <th width="45%">Detalle</th>
                  <th width="10%">Matriz</th>
                  <th width="10%">Debe</th>
                  <th width="10%">Haber</th>
                </tr> </thead>';

                while ($x=$bd->obtener_fila($resultado)){
       
                    $cuenta =  "'".trim($x['cuenta'])."'";
 
                    echo "<tr>";
                    echo "<td>".trim($x['cuenta'])."</td>";
                    
                    echo "<td>".trim($x['nivel'])."</td>";

                    echo "<td>".trim($x['detalle'])."</td>";
                    echo "<td><input type='checkbox' onclick=".'"myFunction('.trim($cuenta).',this)"' ." ></td>";
                    echo "<td><b>".number_format($x['debe'],2)."</b></td>";
                    echo "<td><b>".number_format($x['haber'],2)."</b></td>";

                    echo "</tr>";
                }

                echo "</table>";

?>