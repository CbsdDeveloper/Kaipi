<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/

$obj                = 	new objects;
$bd	                =	new Db;
$id_rol             = $_GET["id_rol"];
$regimen            = $_GET["regimen"];


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

         
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        titulo($bd,$id_rol,$regimen);
        
        echo '</div> ';
        
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
                
               K_consulta_programa( $bd,$obj,$id_rol,$regimen );
            
        echo '</div>';
 
    
    firmas( $bd );
  //-----------------------------------------------------------------------
  
    function K_consulta_programa($bd,$obj,$id_rol,$regimen){
            
            
        
        echo '<table id ="rolp" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 11px;table-layout: auto"> 
               <thead><tr>
                <th width="5%">Nro.</th>
                <th width="10%">Identificacion</th>
                <th width="30%">Funcionario</th>
                <th width="10%">Cod.Banco</th>
                <th width="25%">Banco</th>
                <th width="10%">Tipo Cuenta</th>
                <th width="10%">Nro. Cuenta</th>
                <th width="10%">A pagar</th> 
              </tr> </thead> <tbody>';
 
                //------------------ pone ingresos  -----------------------------------------------------//
                $sql = "SELECT idprov,empleado,unidad,programa, sum(ingreso) ingreso,sum(descuento) descuento, sum(ingreso) -sum(descuento) as apagar 
                        from view_rol_impresion 
                        where id_rol= ".$bd->sqlvalue_inyeccion($id_rol ,true)." and 
                              regimen =".$bd->sqlvalue_inyeccion($regimen ,true)."
                        group by idprov,empleado,unidad,programa
                        order by empleado";
 
 
                 $stmt   = $bd->ejecutar($sql);
                 $id     = 1;
                 $total3 = 0;
                 
                 
                while ($x=$bd->obtener_fila($stmt)){
                    echo "<tr>";
                    $idprov   = trim($x['idprov']);
                    $empleado = trim($x['empleado']);
                    $total    = $x['apagar'];
                    
                    $xxx      = $bd->query_array('view_nomina_banco',  
                        'banco, codigo_banco, tipo_cuenta,nro_banco',                        
                        'identificacion='.$bd->sqlvalue_inyeccion($idprov,true) 
                        );
                       
                    echo '<td>'.$id.'</td>';
                    echo '<td>'.$idprov.'</td>';
                    echo '<td>'.$empleado.'</td>';
                    echo '<td>'.trim($xxx['nro_banco']).'</td>';
                    echo '<td>'.trim($xxx['banco']).'</td>';
                    echo '<td>'.trim($xxx['tipo_cuenta']).'</td>';
                    echo '<td>'.trim($xxx['codigo_banco']).'</td>';
                 
                    echo '<td align="right">'.$total.'</td>';
                    $id++;
                    echo "</tr>";
                    
                
                    $total3 = $total  + $total3;
                }
                
                echo "<tr>";
                echo '<td>  </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td align="right"><b>'.number_format($total3,2).'</b></td>';
                echo "</tr>";
                
        echo "</tbody></table>";
        
     
       
    }
//-----------------------------------------------------------------------------------
        function titulo($bd,$id_rol,$regimen){
             
            $AUnidad = $bd->query_array('nom_rol_pago','mes, anio, registro, estado, fecha, novedad, sesion', 
                                        'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true)
                );
            
            $login     =  trim($_SESSION['login']);
            
            $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
            
            echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>TALENTO HUMANO  <br>[ '.$regimen.' ]<br></b>
                        <b>RESUMEN  '.strtoupper($AUnidad['novedad']).'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td> USUARIO '.$login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
            
        }
        
   //---------------------------------------------------     
        function firmas( $bd ){
    
            $a11 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(17,true));
            
            $a12 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(18,true));
            
            $a13 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(19,true));
            
            $a14 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(14,true));
            
           
            $datos["g10"] = $a11["carpeta"];
            $datos["g11"] = $a11["carpetasub"];
            
            
            $datos["f10"] = $a12["carpeta"];
            $datos["f11"] = $a12["carpetasub"];
            
            
            $datos["c10"] = $a13["carpeta"];
            $datos["c11"] = $a13["carpetasub"]; 
            
            
            $datos["d10"] = $a14["carpeta"];
            $datos["d11"] = $a14["carpetasub"];
            
            
            echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
           
            echo '<table width="101%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="25%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="25%" style="text-align: center">&nbsp;</td>
			<td width="25%" style="text-align: center">&nbsp;</td>
            <td width="25%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: center"> Revisado y Aprobado por </td>
        	<td style="text-align: center">Elaborado </td>
			<td style="text-align: center"> </td>
            <td style="text-align: center">'.''.'</td>
        	</tr>
        	<tr>
        	   <td style="text-align: center">Jefe de Talento Humano</td>
        	   <td style="text-align: center">Analista Talento Humano</td>
			   <td style="text-align: center"></td>
               <td style="text-align: center">'.'' .' </td>
      	  </tr>
        	</tbody>
        	</table>';
            
            
    /*
            echo '<table width="101%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="25%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="25%" style="text-align: center">&nbsp;</td>
			<td width="25%" style="text-align: center">&nbsp;</td>	
            <td width="25%" style="text-align: center">&nbsp;</td>	
        	</tr>
        	<tr>
        	<td style="text-align: center">'.$datos["g10"] .'</td>
        	<td style="text-align: center">'.$datos["f10"] .'</td>
			<td style="text-align: center">'.$datos["c10"] .'</td>
            <td style="text-align: center">'.''.'</td>
        	</tr>
        	<tr>
        	   <td style="text-align: center">'.$datos["g11"].'</td>
        	   <td style="text-align: center">'.$datos["f11"].'</td>
			   <td style="text-align: center">'.$datos["c11"] .' </td>	
               <td style="text-align: center">'.'' .' </td>	
      	  </tr>
        	</tbody>
        	</table>';
           
            */
           
            echo '</div> ';
            
            
           
        }
//-----------------------------------------------------------------------------------
?>