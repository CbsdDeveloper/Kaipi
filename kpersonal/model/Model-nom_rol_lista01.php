<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;
 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

         
         
        $id_rol             = $_GET["id_rol"];
        $regimen            = $_GET["regimen"];
     //   $programa           = $_GET["programa"];
 
    
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        titulo($bd,$id_rol,$regimen);
        
        echo '</div> ';
        
       
       
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
        
        
        $sql1 = "SELECT  regimen
                          from view_rol_impresion
                          where id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).' and
                                regimen='.$bd->sqlvalue_inyeccion($regimen ,true).'
                          group by regimen
                          order by regimen';
        
        
        $stmt1 = $bd->ejecutar($sql1);
 
        while ($xx=$bd->obtener_fila($stmt1)){
                 
                K_consulta_programa( $bd,$obj,$id_rol,$header,$regimen );
            }
            
            echo '</div>';
            
    firmas( $bd );
  //-----------------------------------------------------------------------
  
    function K_consulta_programa($bd,$obj,$id_rol,$programa ,$regimen){
            
            
        
        echo '<table id ="rolp" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 11px;table-layout: auto"> 
               <thead><tr>
                <th width="5%">Nro.</th>
                <th width="5%">Programa.</th>
                <th width="5%" >Identificacion</th>
                <th width="15%">Empleado</th>';
 
                //------------------ pone ingresos  -----------------------------------------------------//
                $sql = "SELECT  nombre 
                          from view_rol_impresion
                          where tipo = 'Ingresos' and 
                                id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).' and 
                                regimen='.$bd->sqlvalue_inyeccion($regimen ,true).'
                          group by nombre
                          order by nombre desc';
    
             
                 $stmt = $bd->ejecutar($sql);
                /*Realizamos un bucle para ir obteniendo los resultados*/
                $ncolumnai = 1;
                
                while ($x=$bd->obtener_fila($stmt)){
                    $header = trim($x['nombre']);
                    echo '<th>'.$header.'</th>';
                    $datos_ingreso[ $ncolumnai ] = $x['nombre'];
                    $ncolumnai++;
                }
                
                echo '<th>Total Ingresos</th>';
        
                //---------------- pone descuentos  -----------------------------------------------------//
                $sql = "SELECT  nombre 
                        from view_rol_impresion
                          where tipo = 'Descuentos' and 
                                id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).' and   
                                regimen='.$bd->sqlvalue_inyeccion($regimen ,true).'
                          group by  nombre
                          order by nombre desc';
                
                /*Ejecutamos la query*/
                $stmt = $bd->ejecutar($sql);
                /*Realizamos un bucle para ir obteniendo los resultados*/
                $ncolumnad = 1;
                
                while ($x=$bd->obtener_fila($stmt)){
                    $header = trim($x['nombre']);
                    echo '<th>'.$header.'</th>';
                    $datos_descuento[ $ncolumnad ] = $x['nombre'];
                    $ncolumnad++;
                }
                
                echo '<th>Total Descuentos</th>';
                echo '<th>A pagar</th>';
        
                echo "</tr>
                       </thead>
                        <tbody>";
                
                    
                //----------- pone empleados  -----------------------------------------------------//
             
                
                         $sql1 = "SELECT idprov, empleado,programa
                         FROM view_rol_impresion
                         where regimen=".$bd->sqlvalue_inyeccion($regimen ,true)." and 
                               id_rol =".$bd->sqlvalue_inyeccion($id_rol ,true). ' 
                         group by  empleado,idprov,programa
                        order by programa,empleado';
               
          
 
                $stmt = $bd->ejecutar($sql1);
        
                $id = 1;
                
                    while ($x=$bd->obtener_fila($stmt)){
                        echo "<tr>";
                        $idprov = trim($x['idprov']);
                        $empleado = trim($x['empleado']);
                        $programa = trim($x['programa']);
                        echo '<td>'.$id.'</td>';
                        echo '<td>'.$programa.'</td>';
                        echo '<td>'.$idprov.'</td>';
                        echo '<td>'.$empleado.'</td>';
                      
                        $ntotal = K_consulta($bd,$obj,$id_rol,$datos_ingreso,$idprov,'I',$ncolumnai);
                        echo '<td align="right">'.number_format($ntotal,2).'</td>';
                     
                        $dtotal = K_consulta($bd,$obj,$id_rol,$datos_descuento,$idprov,'E',$ncolumnad);
                        echo '<td align="right">'.number_format($dtotal,2).'</td>';
                      
                        $pago = $ntotal - $dtotal ;
                        echo '<td align="right">'.number_format($pago,2).'</td>';
                        
                        $id++;
                        echo "</tr>";
                    }
        
                    echo "<tr>";
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    
                    echo '<td>RESUMEN</td>';
                    $ntotal   = K_consulta_total($bd,$obj,$id_rol,$datos_ingreso,$programa,'I',$ncolumnai,$regimen);
                    $ningresot =  $ntotal;
                    $ntotal =  number_format($ntotal,2) ;
                    
                    
                    echo '<td align="right">'.$ntotal.'</td>';
                    $dtotal = K_consulta_total($bd,$obj,$id_rol,$datos_descuento,$programa,'E',$ncolumnad,$regimen);
                    $dtotal_de= $dtotal;
                    $dtotal = number_format($dtotal,2) ;
                    
                    echo '<td align="right">'.$dtotal.'</td>';
                    $pago = $ningresot - $dtotal_de ;
                    $pago = number_format($pago,2) ;
                    echo '<td align="right">'.$pago.'</td>';
                    
                    echo "</tr>";
        echo "</tbody></table>";
        
        
       
    }
//------------------------------------------------------------------------------------
function K_consulta($bd,$obj,$id_rol,$datos_arreglo,$idprov,$tipo,$numero_campos ){
 
            $ntotal = 0;
            
            for ($i = 1; $i<= $numero_campos - 1  ; $i++){
                
                $id_config = $datos_arreglo[$i];
                
                if ($tipo == 'I'){
                    $cadena = 'ingreso as total ';
                }
                else{
                    $cadena = 'descuento as total ';
                }
                      
                $sql = 'SELECT '.$cadena.'
                          from view_rol_impresion
                          where idprov='.$bd->sqlvalue_inyeccion($idprov,true).' and
                                nombre = '.$bd->sqlvalue_inyeccion($id_config,true).' and
                                id_rol ='.$bd->sqlvalue_inyeccion($id_rol,true);
                        
                        $resultado = $bd->ejecutar($sql);
                        $total = $bd->obtener_array( $resultado);
                        echo '<td align="right">'.$total['total'].'</td>';
                        $ntotal = $ntotal + $total['total'];
            }
            return $ntotal;
            
        }	
        
        //------------------------------------------------------------------------------------
        function K_consulta_total($bd,$obj,$id_rol,$datos_arreglo,$programa,$tipo,$numero_campos,$regimen ){
            
            $ntotal = 0;
            
            for ($i = 1; $i<= $numero_campos - 1  ; $i++){
                
                $id_config = $datos_arreglo[$i];
                
                if ($tipo == 'I'){
                    $cadena = 'sum(ingreso) as total ';
                }
                else{
                    $cadena = 'sum(descuento) as total ';
                }
                
                $sql = 'SELECT '.$cadena.'
                          from view_rol_impresion
                          where  nombre = '.$bd->sqlvalue_inyeccion($id_config,true).' and
                                 regimen = '.$bd->sqlvalue_inyeccion($regimen,true).' and
                                id_rol ='.$bd->sqlvalue_inyeccion($id_rol,true);
                
                
                
                $resultado = $bd->ejecutar($sql);
                $total = $bd->obtener_array( $resultado);
                echo '<td align="right">'.$total['total'].'</td>';
                $ntotal = $ntotal + $total['total'];
            }
            return $ntotal;
            
        }	
//-----------------------------------------------------------------------------------
        function titulo($bd,$id_rol,$regimen){
            
            
            $AUnidad = $bd->query_array('nom_rol_pago','mes, anio, registro, estado, fecha, novedad, sesion', 
                                        'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true)
                );
            
 
            
            $hoy 	     = '';//  date("Y-m-d");
            
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
                  <td> '.$hoy .'<br>
                     USUARIO '.$login.' <br>
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