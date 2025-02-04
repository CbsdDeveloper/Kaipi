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
    
 
    //--------------------------------------------------
    function GrillaGasto_periodo_uno(  $ccedula,$cadena,$ccaso){
        
        //  $this->anio
        
        $tipo 		    = $this->bd->retorna_tipo();
        
        
        $len            = strlen($ccedula);
        $len1            = strlen($cadena);
        
        $solicita_where = '';
        $ruc_where      = '';
        $cadena         =  strtoupper($cadena).'%';
        
        if ($len >= 3 ){
            $solicita_where = '';
            $ruc_where      = 'id_tramite > 0 and idprov ='. $this->bd->sqlvalue_inyeccion(trim($ccedula) , true)  ;
        }else{
            $ruc_where      = '';
            if ( $len1  >= 6){
                $solicita_where =  'id_tramite > 0 and proveedor like'. $this->bd->sqlvalue_inyeccion(trim($cadena) , true)  ;
            }else{
                $solicita_where =  'id_tramite > 0 and proveedor ='. $this->bd->sqlvalue_inyeccion(trim($cadena) , true)  ;
            }
        }
         
        if ($ccaso > 0 ){
        
            $solicita_where = '';
            $ruc_where      = ' id_tramite ='. $this->bd->sqlvalue_inyeccion($ccaso , true)  ;
            
            $x = $this->bd->query_array('presupuesto.view_pre_tramite',   // TABLA
                'id_tramite ,proveedor, direccion, telefono, correo, movil,unidad,idprov',                        // CAMPOS
                'id_tramite='.$this->bd->sqlvalue_inyeccion($ccaso,true) // CONDICION
                );
            
            
            echo '<h4>';
            echo  '<b>'.$x['proveedor'].'</b><br>';
            echo  $x['idprov'].'<br>';
            echo  $x['direccion'].'<br>';
            echo  $x['telefono'].'<br>';
            
            echo '</h4>';
            
            
        }else{
            $x = $this->bd->query_array('par_ciu',   // TABLA
                ' *',                        // CAMPOS
                'idprov='.$this->bd->sqlvalue_inyeccion($ccedula,true) // CONDICION
                );
            
            echo '<h4>';
            echo  '<b>'.$x['razon'].'</b><br>';
            echo  $x['idprov'].'<br>';
            echo  $x['direccion'].'<br>';
            echo  $x['telefono'].'<br>';
            
            echo '</h4>';
        }
      
        
        //---fecha,fcompromiso, fcertifica, fdevenga $vproceso
        
        $vactividad_where = $solicita_where.$ruc_where  ;
        
  
        
        $sql = 'SELECT  *
            FROM view_asientos
            where '.$vactividad_where.'  order by 1 desc';
            
            
            
            $_SESSION['sql_activo'] = $sql;
            
            
            $resultado  = $this->bd->ejecutar($sql);
 
            echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;font-size: 12px"> ';
            
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
        
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Tramite</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Asiento</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Comprobante</th>';
        echo '<th width="60%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Monto</th>';
         
        echo '</tr></thead><tbody>';
        
       

        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            
 
            $x = $this->bd->query_array('view_asientocxp_aux',   // TABLA
                'sum(apagar) as pagar',                        // CAMPOS
                'id_asiento='.$this->bd->sqlvalue_inyeccion($row['id_asiento'],true)  . ' and 
                idprov='.$this->bd->sqlvalue_inyeccion(trim($row['idprov']),true) 
                );
            
                   
            
            
            $evento = 'CargaDatos('.$row['id_tramite'].')';
            
            $referencia = ' href="#" onClick="'.$evento.'" data-toggle="modal" data-target="#myModalProducto" ';
            
            echo "<td><a ".$referencia." ><b>".trim($row['id_tramite']).'</b></a></td>';
            echo "<td>".trim($row['fecha']).'</td>';
            echo "<td>".trim($row['id_asiento']).'</td>';
            echo "<td>".trim($row['comprobante']).'</td>';
            echo "<td>".trim($row['detalle']).'</td>';
            echo '<td align="right">'.number_format($x['pagar'],2).'</td>';
            
            
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
                        <b>GESTION TRAMITES POR PERIODO '.$ffecha1.' AL '.$ffecha2.'  </b><br>
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
if (isset($_GET["accion"]))	{
    
 
    
    $cadena	    =   $_GET["cadena"];
    $ccedula	=   $_GET["ccedula"];
    $ccaso	    =   $_GET["ccaso"];
    
    
    $gestion->GrillaGasto_periodo_uno( $ccedula,$cadena,$ccaso);
    
    
    
}
?>

 