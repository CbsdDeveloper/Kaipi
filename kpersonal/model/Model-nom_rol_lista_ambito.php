<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;
 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

         
         
        $id_rol             = $_GET["id_rol"];
        //$regimen            = $_GET["regimen"];
        $ambito             = $_GET["depa"];
 
    
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        titulo($bd,$id_rol,$ambito);
        
        echo '</div> ';
        
       
       
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
        
        
        $sql1 = "SELECT  unidad,id_departamento 
                          from view_rol_impresion
                          where id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).' and 
                                ambito='.$bd->sqlvalue_inyeccion($ambito ,true).'   
                          group by unidad,id_departamento 
                          order by unidad';
        
        
        $stmt1 = $bd->ejecutar($sql1);
 
        while ($xx=$bd->obtener_fila($stmt1)){
                
                $header          = trim($xx['unidad']);
               
                $id_departamento = $xx['id_departamento'];
                
                echo '<h6><b>'.$header.'</b></h6>';
                
                K_consulta_programa( $bd,$obj,$id_rol,$header,$id_departamento );
            }
            
            echo '</div>';
            
        /*    $sql = 'SELECT b.detalle as "Programa", 
                  		 sum(a.ingreso) as "Ingreso", 
                  		 sum(a.descuento) as "Descuento",
                  		 (sum(a.ingreso)  - sum(a.descuento)) as "Apagar"
                 from view_rol_impresion a, presupuesto.pre_catalogo b
                 where a.id_rol=  '.$bd->sqlvalue_inyeccion($id_rol,true)." and 
                       a.ambito='.$bd->sqlvalue_inyeccion($ambito ,true).'   
                       b.codigo = a.programa and b.categoria = 'programa'
                 group by a.programa   ,b.detalle";
            
            echo '<div class="col-md-6" align="center" style="padding-bottom:10;padding-top:15px"> ';
            
                    $resultado = $bd->ejecutar($sql);
                    
                    $tipo = $bd->retorna_tipo();
                    
                    $obj->grid->KP_sumatoria(2,"Ingreso","Descuento", "Apagar","");
                    
                    $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  
            
            echo '</div> ';
            */

    
    firmas( $bd );
  //-----------------------------------------------------------------------
  
    function K_consulta_programa($bd,$obj,$id_rol,$unidad,$id_departamento){
            
            
        
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
                                id_departamento ='.$bd->sqlvalue_inyeccion($id_departamento ,true).'
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
                                id_departamento ='.$bd->sqlvalue_inyeccion($id_departamento ,true).'
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
                $sql1 = "SELECT idprov, empleado,unidad
                          FROM view_rol_impresion
                          where id_rol =".$bd->sqlvalue_inyeccion($id_rol ,true).' and 
                                id_departamento = '.$bd->sqlvalue_inyeccion($id_departamento ,true).' 
                          group by  empleado,idprov,unidad
                         order by unidad,empleado';
                
          
 
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
                        echo '<td align="right">'.$ntotal.'</td>';
                     
                        $dtotal = K_consulta($bd,$obj,$id_rol,$datos_descuento,$idprov,'E',$ncolumnad);
                        echo '<td align="right">'.$dtotal.'</td>';
                      
                        $pago = $ntotal - $dtotal ;
                        echo '<td align="right">'.$pago.'</td>';
                        
                        $id++;
                        echo "</tr>";
                    }
        
                    echo "<tr>";
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    
                    echo '<td>RESUMEN</td>';
                    $ntotal   = K_consulta_total($bd,$obj,$id_rol,$datos_ingreso,$programa,'I',$ncolumnai,$id_departamento);
                    $ningresot =  $ntotal;
                    $ntotal =  number_format($ntotal,2) ;
                    
                    
                    echo '<td align="right">'.$ntotal.'</td>';
                    $dtotal = K_consulta_total($bd,$obj,$id_rol,$datos_descuento,$programa,'E',$ncolumnad,$id_departamento);
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
        function K_consulta_total($bd,$obj,$id_rol,$datos_arreglo,$programa,$tipo,$numero_campos,$id_departamento ){
            
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
                                 id_departamento = '.$bd->sqlvalue_inyeccion($id_departamento,true).' and
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
            
            
 
 
            
            $hoy 	     =  date("Y-m-d");
            
            $login     =  trim($_SESSION['login']);
            
            
            
            $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
            
            echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>TALENTO HUMANO  <br>[ '.$regimen.' ]<br></b>
                        <b>RESUMEN  PERSONAL DE PROYECTOS </b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$hoy .'<br>
                     USUARIO '.$login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
            
        }
        
   //---------------------------------------------------     
        function firmas( $bd ){
    
            $a11 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(17,true));
            
            $a12 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(18,true));
            
            $a13 = $bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(19,true));
            
           
            $datos["g10"] = $a11["carpeta"];
            $datos["g11"] = $a11["carpetasub"];
            
            
            $datos["f10"] = $a12["carpeta"];
            $datos["f11"] = $a12["carpetasub"];
            
            
            $datos["c10"] = $a13["carpeta"];
            $datos["c11"] = $a13["carpetasub"]; 
            
            echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
            
            echo '<table width="101%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="33%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="33%" style="text-align: center">&nbsp;</td>
			<td width="33%" style="text-align: center">&nbsp;</td>	
        	</tr>
        	<tr>
        	<td style="text-align: center">'.$datos["g10"] .'</td>
        	<td style="text-align: center">'.$datos["f10"] .'</td>
			<td style="text-align: center">'.$datos["c10"] .'</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'.$datos["g11"].'</td>
        	  <td style="text-align: center">'.$datos["f11"].'</td>
			   <td style="text-align: center">'.$datos["c11"] .' </td>	
      	  </tr>
        	</tbody>
        	</table>';
            
            echo '</div> ';
            
            
           
        }
//-----------------------------------------------------------------------------------
?>