<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
  
    
    private $obj;
    private $bd;
    private $set;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        $this->set     = 	new ItemsController;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    
    //--- calcula libro diario
    function GrillaIngreso( $fanio,$vfuente ,$vgrupo){
        
         $tipo 		    = $this->bd->retorna_tipo();
         
        if ( $vfuente == '-'){
            $fuente_where = '';
        }else{
            $fuente_where = ' and fuente='. $this->bd->sqlvalue_inyeccion($vfuente , true) ;
        }
        
        if ( $vgrupo == '-'){
            $vgrupo_where = '';
        }else{
            $vgrupo_where = ' and grupo='. $this->bd->sqlvalue_inyeccion($vgrupo , true) ;
        }
        
        
        
        $sql = 'SELECT partida as "Partida",   
                   detalle as "Partida Ingreso",  
            	   inicial as "Inicial", 
            	   aumento - disminuye as "Reformas", 
            	   codificado as "Codificado", 
            	   devengado as "Devengado", 
            	   pagado as "Recaudado", 
            	   (coalesce(codificado,0) - coalesce(devengado,0))  as "Saldo Devengar"

            FROM presupuesto.pre_gestion
            where tipo = '. $this->bd->sqlvalue_inyeccion('I' , true).' and 
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .$fuente_where.$vgrupo_where.'  order by partida,fuente';


   
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        $this->titulo('INGRESOS');
        
        echo '</div> ';
        
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
        
                $this->grilla_ingreso($resultado,$tipo,"I","jtabla_ingreso");
        
        echo '</div> ';
       
        
        $this->firmas( );
 
     
        
    }
    //---------------------------------
    function GrillaGasto( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion){
                         
                         
        
        $tipo 		    = $this->bd->retorna_tipo();
 
 
        
        if ( trim($funcion) == '-'){
            
            $programa_where = '';
            
        }else{
     
            $programa_where = ' and funcion ='. $this->bd->sqlvalue_inyeccion($funcion , true) ;
            
        }
        
        
        if ( $vfuente == '-'){
            
            $fuente_where = '';
            
        }else{
            
            $fuente_where = ' and fuente='. $this->bd->sqlvalue_inyeccion($vfuente , true) ;
        
        }
      
        if ( $vgrupo == '-'){
            $vgrupo_where = '';
        }else{
            $vgrupo_where = ' and grupo='. $this->bd->sqlvalue_inyeccion($vgrupo , true) ;
        }
        
        if ( $vactividad == '-'){
            $vactividad_where = '';
        }else{
            $vactividad_where = ' and actividad='. $this->bd->sqlvalue_inyeccion($vactividad , true) ;
        }
        
        
        $lon = strlen($item);
        
        if ( $lon  < 4 ){
            $item_where = '';
        }else{
            $item_where = ' and clasificador like '. $this->bd->sqlvalue_inyeccion($item , true) ;
        }
        
         
        
        $sql = 'SELECT partida as "Partida",
                   detalle as "Partida Ingreso",
            	   inicial as "Inicial",
            	   aumento - disminuye as "Reformas",
            	   codificado as "Codificado",
            	   certificado as "Certificaciones",
            	   compromiso as "Compromisos",
            	   devengado as "Devengado",
            	   pagado as "Pagado",
            	   disponible as "Disponible"
            FROM presupuesto.pre_gestion
            where tipo = '. $this->bd->sqlvalue_inyeccion('G' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .
                            $programa_where.
                            $fuente_where.
                            $vgrupo_where.
                            $vactividad_where.
                            $fuente_where.
                            $item_where.'  order by partida,fuente';
        
        
 
        
         $resultado  = $this->bd->ejecutar($sql);
        
         echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
         
         $this->titulo('GASTOS');
         
         echo '</div> ';
         
         echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
         
        $this->grilla($resultado,$tipo,"G","jtabla_gasto");
        
        echo '</div> ';
        
         
      
        
        $this->firmas( );
     
        
    }
 //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
    
 function grilla($resultado,$tipo,$presupuesto,$nombre)  {
        
 
       $numero_campos = pg_num_fields($resultado) - 1;
       $k = 0;
       
        
       echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        for ($i = 0; $i<= $numero_campos; $i++){
                    $cabecera = pg_field_name($resultado,$k) ;
      
                    echo "<th>".$cabecera.'</th>';
                    $k++;
        }
        
        echo '</tr></thead><tbody>';
 
                $nsuma1 = 0;
                $nsuma2 = 0;
                $nsuma3 = 0;
                $nsuma4 = 0;
                $nsuma5 = 0;
                $nsuma6 = 0;
                $nsuma7 = 0;
                $nsuma8 = 0;
                 
                $k = 1;
                while($row=pg_fetch_assoc($resultado)) {
                    
                    echo "<tr>";
                    
                    $i = 1;
                    
                    foreach ($row as $item){
                     /*   $n1 = $row[$this->var1];
                        $n2 = $row[$this->var2];
                        $n3 = $row[$this->var3];
                       */ 
                        if(is_numeric($item)){
                            
                            if ($i == 1)  {
                                
                                $evento = '<a href="#" onClick="Detallepartidas('."'".$item."'".','."'".$presupuesto."',".$k.')" data-toggle="modal" data-target="#myModalAux">';  
                                
                                echo "<td>".$evento.$item.'</a></td>';
                                
                            }else{
                                
                                echo "<td align='right'>".number_format($item,2).'</td>';
                                
                            }
                            
                        }else{
                            
                            echo "<td>".$item.'</td>';
                            
                        }
                        $i++;
                    }
                    
                    if ( $presupuesto == 'I'){
                        $suma = $row["Recaudado"];
                    }else{
                        $suma = $row["Pagado"];
                    }
                    
                    
                    
                    $nsuma1 = $nsuma1 + $row["Inicial"];
                    $nsuma2 = $nsuma2 + $row["Reformas"];
                    $nsuma3 = $nsuma3 + $row["Codificado"];
                    $nsuma4 = $nsuma4 + $row["Certificaciones"];
                    $nsuma5 = $nsuma5 + $row["Compromisos"];
                    $nsuma6 = $nsuma6 + $row["Devengado"];
                    $nsuma7 = $nsuma7 + $suma;
                    $nsuma8 = $nsuma8 + $row["Disponible"];
                  
 
                    $k++;
                   /*    
                             $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
                            $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
                            echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
                         */
                    echo "</tr>";
                    
                }
                /// total
          
                echo "<tr>";
                     echo "<td>TOTAL</td><td></td>";
                     echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma6,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
                 
                
                echo "</tr></tbody></table>";
                
                pg_free_result ($resultado) ;
            
    }
    
    
    function grilla_ingreso($resultado,$tipo,$presupuesto,$nombre)  {
        
        
        $numero_campos = pg_num_fields($resultado) - 1;
        $k = 0;
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        for ($i = 0; $i<= $numero_campos; $i++){
            $cabecera = pg_field_name($resultado,$k) ;
            
            echo "<th>".$cabecera.'</th>';
            $k++;
        }
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
         $nsuma6 = 0;
        $nsuma7 = 0;
        $nsuma8 = 0;
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            
            $i = 1;
            
            foreach ($row as $item){
                /*   $n1 = $row[$this->var1];
                 $n2 = $row[$this->var2];
                 $n3 = $row[$this->var3];
                 */
                if(is_numeric($item)){
                    
                    if ($i == 1)  {
                        
                        $evento = '<a href="#" onClick="Detallepartidas('."'".$item."'".','."'".$presupuesto."',".$k.')" data-toggle="modal" data-target="#myModalAux">';
                        
                        echo "<td>".$evento.$item.'</a></td>';
                        
                    }else{
                        
                        echo "<td align='right'>".number_format($item,2).'</td>';
                        
                    }
                    
                }else{
                    
                    echo "<td>".$item.'</td>';
                    
                }
                $i++;
            }
            
            if ( $presupuesto == 'I'){
                $suma = $row["Recaudado"];
            }else{
                $suma = $row["Pagado"];
            }
            
            
            
            $nsuma1 = $nsuma1 + $row["Inicial"];
            $nsuma2 = $nsuma2 + $row["Reformas"];
            $nsuma3 = $nsuma3 + $row["Codificado"];
            $nsuma6 = $nsuma6 + $row["Devengado"];
            $nsuma7 = $nsuma7 + $suma;
            $nsuma8 = $nsuma8 + $row["Saldo Devengar"];
            
            
            $k++;
            /*
             $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
             $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
             echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
             */
            echo "</tr>";
            
        }
        /// total
        
        echo "<tr>";
        echo "<td>TOTAL</td><td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma6,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    
    function titulo($tipo_presupuesto){
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
        
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>PRESUPUESTO ( PERIODO '.$this->anio.' ) </b><br>
                        <b>CEDULA PRESUPUESTARIA DE '.$tipo_presupuesto.' POR UNIDAD EJECUTORA </b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
        
    }
    
    
    function firmas( ){
        
        $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
        
        $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
        
        $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
        
        
        $datos["g10"] = $a11["carpeta"];
        $datos["g11"] = $a11["carpetasub"];
        
        
        $datos["f10"] = $a12["carpeta"];
        $datos["f11"] = $a12["carpetasub"];
        
        
        $datos["c10"] = $a14["carpeta"];
        $datos["c11"] = $a14["carpetasub"];
        
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
        
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	  <td width="33%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="33%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="33%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g10"].'</td>
        	<td style="text-align: center">'. $datos["f10"].'</td>
        	<td style="text-align: center">'. $datos["c10"].'</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g11"].'</td>
        	  <td style="text-align: center">'.$datos["f11"].'</td>
        	  <td style="text-align: center">'.$datos["c11"] .'</td>
      	  </tr>
        	<tr>
        	  <td style="text-align: center">&nbsp;</td>
        	<td style="text-align: center">&nbsp;</td>
        	<td style="text-align: center">&nbsp;</td>
        	</tr>
        	</tbody>
        	</table>';
        
        echo '</div> ';
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["tipo"]))	{
    
    
    $fanio		=   $_GET["fanio"];
    $vfuente	=   $_GET["vfuente"];
    $tipo       =   $_GET["tipo"];
    $vgrupo     =   $_GET["vgrupo"];
    
    if ( $tipo == 'I') {
        
        $gestion->GrillaIngreso( $fanio,$vfuente,$vgrupo,'I');
        
    }else{
       
      
        $vgrupo       =   $_GET["vgrupo"];
        $vactividad   =   $_GET["vactividad"];
        $item         =   $_GET["item"];
        $funcion      =   $_GET["vprograma"];
        
 
         
        $gestion->GrillaGasto( $fanio,$vfuente,$vgrupo,$vactividad,$item,'G',$funcion);
        
    }
 
}
?>
 