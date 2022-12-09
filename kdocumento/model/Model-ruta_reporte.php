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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
 
        
    }
    
    
    //---------------------------------
    function Grilla_periodo( $ffecha1,$ffecha2,$fmodulo,$vunidad,$vproceso){
        
        
        
        $this->GrillaGasto_periodo_uno( $ffecha1,$ffecha2,$fmodulo,$vunidad,$vproceso);
        
        
        
        
    }
    //--------------------------------------------------
    function GrillaGasto_periodo_uno( $ffecha1,$ffecha2,$fmodulo,$vunidad,$vproceso){
        
        //  $this->anio
        
        $tipo 		    = $this->bd->retorna_tipo();
        
        
        $fecha  = 'fecha ';
        
        
        if ( trim($fmodulo) == '-'){
            $programa_where = '';
        }else{
            $programa_where = '   estado ='. $this->bd->sqlvalue_inyeccion(trim($fmodulo) , true) .' and ';
        }
        
        if ( $vunidad == '0'){
            $fuente_where = '';
        }else{
            $fuente_where = '   id_departamento_caso ='. $this->bd->sqlvalue_inyeccion($vunidad , true) .' and ';
        }
        
        if ( $vproceso > '0'){
            $proceso_where = '   idproceso ='. $this->bd->sqlvalue_inyeccion($vproceso , true) .' and ';
        }else{
            $proceso_where = ' ';
        }
        
        
        //---fecha,fcompromiso, fcertifica, fdevenga $vproceso
        
        $vactividad_where = $fecha.' between   '. $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.$this->bd->sqlvalue_inyeccion($ffecha2 , true);
        
  
        
        $sql = 'SELECT  idcaso,  fecha,
                        departamento_caso as unidad,
                        nombre_solicita, 
                        estado, 
                        proceso,caso, 
                        ambito, tarea,  dias_trascurrido,unidad_siguiente ,hora_entrada ,unidad_actual
            FROM flow.view_proceso_caso
            where '.
            $programa_where.$proceso_where.
            $fuente_where.$vactividad_where.'  order by 2';
            
            
            
            $_SESSION['sql_activo'] = $sql;
            
            
            $resultado  = $this->bd->ejecutar($sql);
            
            echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
            
            $this->titulo('GESTION TRAMITES INSTITUCIONALESS',$ffecha1,$ffecha2);
            
            echo '</div> ';
            
            echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;font-size: 11px"> ';
            
            $this->grilla($resultado,$tipo,"G","jtabla_gasto");
            
            echo '</div> ';
            
            //    $this->firmas( );
            
            
            
            
            
    }
    //------------------------------------------------------
    
    //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
    
    function grilla($resultado,$tipo,$presupuesto,$nombre)  {
        
        $k = 0;
        
      
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
        echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad Solicita</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Solicita</th>';
        echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad Recepcion</th>';
        echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Proceso</th>';
        echo '<th width="25%" bgcolor="#167cd8" style="color: #F4F4F4">Caso</th>';
        echo '<th width="20%" bgcolor="#167cd8" style="color: #F4F4F4">Firma</th>';
        
        echo '</tr></thead><tbody>';
        
       

        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            
 
            
            
            if ( $row['estado'] == '1' ){
                $x = $this->bd->query_array('nom_departamento',   // TABLA
                    'nombre',                        // CAMPOS
                    'id_departamento='.$this->bd->sqlvalue_inyeccion($row['unidad_siguiente'],true) // CONDICION
                    );
                
            }else{
                $x = $this->bd->query_array('nom_departamento',   // TABLA
                    'nombre',                        // CAMPOS
                    'id_departamento='.$this->bd->sqlvalue_inyeccion($row['unidad_actual'],true) // CONDICION
                    );
                
            }
            
          
            $evento = 'CargaDatos('.$row['idcaso'].')';
            
            $referencia = ' href="#" onClick="'.$evento.'" data-toggle="modal" data-target="#myModalProducto" ';
            
            echo "<td><a ".$referencia." >".trim($row['idcaso']).'</a></td>';
            echo "<td>".trim($row['fecha']).'</td>';
            echo "<td>".trim($row['unidad']).'</td>';
            echo "<td>".trim($row['nombre_solicita']).'</td>';
            echo "<td>".trim($x['nombre']).'</td>';
            echo "<td>".trim($row['proceso']).'</td>';
            echo "<td>".trim($row['caso']).'</td>';
            echo "<td>*</td>";
            
            
            $k++;
            echo "</tr>";
            
        }
        
        
        echo "</tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    
    
    //--------------------------------------------------
    function titulo($tipo_presupuesto,$ffecha1,$ffecha2){
        
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
        $imagen ='';
        
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                         <br>
                        <b>HOJA DE RUTA DE TRAMITES PERIODO '.$ffecha1.' AL '.$ffecha2.'  </b><br>
                         </b></td>
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
if (isset($_GET["fmodulo"]))	{
    
    
    
    $ffecha1	=   $_GET["ffecha1"];
    $ffecha2	=   $_GET["ffecha2"];
    $fmodulo    =   $_GET["fmodulo"];
    $vunidad    =   $_GET["vunidad"];
    
    $vproceso    =   $_GET["vproceso"];
    
    
    
    
    $gestion->Grilla_periodo( $ffecha1,$ffecha2,$fmodulo,$vunidad,$vproceso);
    
    
    
}
?>

 