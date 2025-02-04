<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/

$obj                = 	new objects;
$bd	                =	new Db;
$id_rol             = $_GET["id_rol"];
$regimen            = $_GET["regimen"];


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

         
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
                <th width="15%">Identificacion</th>
                <th width="40%">Funcionario</th>
                <th width="10%">Programa</th>
                <th width="10%">Ingreso</th>
                <th width="10%">Descuento</th>
                <th width="10%">A pagar</th> 
              </tr> </thead> <tbody>';
 
                //------------------ pone ingresos  -----------------------------------------------------//
                $sql = "SELECT idprov,empleado,unidad,programa, sum(ingreso) ingreso,sum(descuento) descuento, sum(ingreso) -sum(descuento) as apagar 
                        from view_rol_impresion 
                        where id_rol= ".$bd->sqlvalue_inyeccion($id_rol ,true)." and 
                              regimen =".$bd->sqlvalue_inyeccion($regimen ,true)."
                        group by idprov,empleado,unidad,programa
                        order by empleado";
 
 
                 $stmt = $bd->ejecutar($sql);
                 $id = 1;
                
                 $total1 = 0;
                 $total2 = 0;
                 $total3 = 0;
                 
                 
                while ($x=$bd->obtener_fila($stmt)){
                    echo "<tr>";
                    $idprov   = trim($x['idprov']);
                    $empleado = trim($x['empleado']);
                    $programa = trim($x['programa']);
                     
                    $itotal    = $x['ingreso'];
                    $dtotal    = $x['descuento'];
                    $total     = $x['apagar'];
                    
                    echo '<td>'.$id.'</td>';
                    echo '<td>'.$idprov.'</td>';
                    echo '<td>'.$empleado.'</td>';
                    echo '<td>'.$programa.'</td>';
                    
                    echo '<td align="right">'.$itotal.'</td>';
                    echo '<td align="right">'.$dtotal.'</td>';
                    echo '<td align="right">'.$total.'</td>';
                    $id++;
                    echo "</tr>";
                    
                    $total1 = $itotal + $total1;
                    $total2 = $dtotal + $total2;
                    $total3 = $total  + $total3;
                }
                
                echo "<tr>";
                echo '<td>  </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                
                echo '<td align="right"><b>'.number_format($total1,2).'</b></td>';
                echo '<td align="right"><b>'.number_format($total2,2).'</b></td>';
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
    
            $codigo_reporte = 'TH-PN';

            $reporte_pie   = $bd->query_array('par_reporte', 
                                             'pie', 
                                             'referencia='.$bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true)  
            );
   
           $pie_contenido = $reporte_pie["pie"];

           $a10 = $bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(10,true));
           $pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
           $pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
           
           $a10 = $bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(12,true));
           $pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
           $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);

           $a10 = $bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(17,true));
           $pie_contenido = str_replace('#TALENTOHUMANO',trim($a10['carpeta']), $pie_contenido);
           $pie_contenido = str_replace('#CARGO_TALENTOHUMANO',trim($a10['carpetasub']), $pie_contenido);

           $a10 = $bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(18,true));
           $pie_contenido = str_replace('#ANALISTA1_TTHH',trim($a10['carpeta']), $pie_contenido);
           $pie_contenido = str_replace('#CARGO_ANALISTA1_TTHH',trim($a10['carpetasub']), $pie_contenido);

       
      

           
            echo $pie_contenido ;
            
            
           
        }
//-----------------------------------------------------------------------------------
?>