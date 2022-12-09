<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kpresupuesto/model/Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

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
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
    }
    
    
    //---------------------------------
    function GrillaGasto_periodo( $ffecha1,$ffecha2,$fmodulo,$vunidad,$tipo){
        
        
    
        $this->revisa_fechas( );
        
        if ( $tipo == 'detalle'){
            
            $this->GrillaGasto_periodo_dos( $ffecha1,$ffecha2,$fmodulo,$vunidad);
            
        }else{
            
            $this->GrillaGasto_periodo_uno( $ffecha1,$ffecha2,$fmodulo,$vunidad);
            
        }
           
        
 
        
        
        
    }
    //--------------------------------------------------
    function GrillaGasto_periodo_uno( $ffecha1,$ffecha2,$fmodulo,$vunidad){
        
      //  $this->anio 
        
        $tipo 		    = $this->bd->retorna_tipo();
         
        
        $fecha  = 'fecha ';
      
        
        if ( trim($fmodulo) == '-'){
            
            $programa_where = '';
            
        }else{
            
            $programa_where = ' and estado ='. $this->bd->sqlvalue_inyeccion(trim($fmodulo) , true) ;
            
            if ($fmodulo== '2'){
                $fecha  = 'fecha ';
            }
            if ($fmodulo== '3'){
                $fecha  = 'fcertifica ';
            }
            if ($fmodulo== '5'){
                $fecha  = 'fcompromiso ';
            }
            if ($fmodulo== '6'){
                $fecha  = 'fdevenga ';
            }
            if ($fmodulo== '0'){
                $fecha  = 'fecha ';
            }
            
        }
        
        if ( $vunidad == '-'){
            
            $fuente_where = '';
            
        }else{
            
            $fuente_where = ' and unidad ='. $this->bd->sqlvalue_inyeccion($vunidad , true) ;
            
        }
        
        //---fecha,fcompromiso, fcertifica, fdevenga
        
        $vactividad_where = $fecha.' between   '. $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.$this->bd->sqlvalue_inyeccion($ffecha2 , true);
          
  
     
        
        
        
        $sql = 'SELECT  id_tramite,'.$fecha.' as fecha, 
                        detalle,   unidad,proveedor,estado_presupuesto,id_asiento_ref,
                        estado,  documento,user_crea,user_sol,estado_presupuesto,comprobante
            FROM presupuesto.view_pre_tramite
            where anio = '. $this->bd->sqlvalue_inyeccion($this->anio  , true) . ' and '.
                  $vactividad_where.
                  $programa_where.
                  $fuente_where.'  order by 2';
              
               
                  
                  $_SESSION['sql_activo'] = $sql;
                  
                  
                  $resultado  = $this->bd->ejecutar($sql);
                  
                  echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
                  
                  $this->titulo('GESTION PRESUPUESTARIA',$ffecha1,$ffecha2);
                  
                  echo '</div> ';
                  
                  echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;font-size: 11px"> ';
                  
                  $this->grilla($resultado,$tipo,"G","jtabla_gasto",0);
                  
                  echo '</div> ';
                  
              //    $this->firmas( );
                  
                
                  
                  
                  
    }
    //-----------------------
    //--------------------------------------------------
    function GrillaGasto_periodo_dos( $ffecha1,$ffecha2,$fmodulo,$vunidad){
        
        //  $this->anio
        
        $tipo 		    = $this->bd->retorna_tipo();
        
        
        $fecha  = 'fecha ';
        
        
        if ( trim($fmodulo) == '-'){
            
            $programa_where = '';
            
        }else{
            
            $programa_where = ' and estado ='. $this->bd->sqlvalue_inyeccion(trim($fmodulo) , true) ;
            
            if ($fmodulo== '2'){
                $fecha  = 'fecha ';
            }
            if ($fmodulo== '3'){
                $fecha  = 'fcertifica ';
            }
            if ($fmodulo== '5'){
                $fecha  = 'fcompromiso ';
            }
            if ($fmodulo== '6'){
                $fecha  = 'fdevenga ';
            }
            if ($fmodulo== '0'){
                $fecha  = 'fecha ';
            }
            
        }
        
        if ( $vunidad == '-'){
            
            $fuente_where = '';
            
        }else{
            
            $fuente_where = ' and unidad ='. $this->bd->sqlvalue_inyeccion($vunidad , true) ;
            
        }
        
        //---fecha,fcompromiso, fcertifica, fdevenga
        
        $vactividad_where = $fecha.' between   '. $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.$this->bd->sqlvalue_inyeccion($ffecha2 , true);
        
        
        
        
        
        
        $sql = 'SELECT  id_tramite,'.$fecha.' as fecha,
                        detalle,   unidad,proveedor,estado_presupuesto,id_asiento_ref,
                        estado,  documento,user_crea,user_sol,estado_presupuesto,comprobante
            FROM presupuesto.view_pre_tramite
            where anio = '. $this->bd->sqlvalue_inyeccion($this->anio  , true) . ' and '.
            $vactividad_where.
            $programa_where.
            $fuente_where.'  order by 2';
            
            
            
            $_SESSION['sql_activo'] = $sql;
            
            
            $resultado  = $this->bd->ejecutar($sql);
            
            echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
            
            $this->titulo('GESTION PRESUPUESTARIA',$ffecha1,$ffecha2);
            
            echo '</div> ';
            
            echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;font-size: 11px"> ';
            
            $this->grilla($resultado,$tipo,"G","jtabla_gasto",1);
            
            echo '</div> ';
            
            //    $this->firmas( );
            
            
            
            
            
    }
    //------------------------------------------------------
    function revisa_fechas( ){
        
             
                  
        $sql = 'select id_tramite, id_asiento_ref
                from presupuesto.view_pre_tramite  
            where   anio = '. $this->bd->sqlvalue_inyeccion($this->anio , true) ." and estado = '6' and fdevenga is null ";
        
        $resultado1  = $this->bd->ejecutar($sql);
        
   
        
        while($x=pg_fetch_assoc($resultado1)) {
            
            $id_tramite     =  $x['id_tramite'] ;
            $id_asiento_ref =  $x['id_asiento_ref'] ;
            
            $AResultado = $this->bd->query_array('co_asiento','fecha', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento_ref,true));
            
            if (!empty($AResultado['fecha'] )){
                
                $sqlEditPre = "UPDATE presupuesto.pre_tramite
                             SET fdevenga  =  ".$this->bd->sqlvalue_inyeccion($AResultado['fecha'],true)."
                           where id_tramite = ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ;
                
                $this->bd->ejecutar($sqlEditPre);
                
            }
      
          
        }
                  
                  
                  
    }
    
 //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
    
 function grilla($resultado,$tipo,$presupuesto,$nombre,$tipo_d)  {
        

     
       $k = 0;
       
     
       
       echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Solicita</th>';
           echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Comprobante</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Estado</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Proveedor</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Asiento</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Monto</th>';
           
        echo '</tr></thead><tbody>';
 
                $nsuma1 = 0;
 
                
                 
                $k = 1;
                while($row=pg_fetch_assoc($resultado)) {
                    
                    echo "<tr>";
                     
                    $monto = $this->bd->query_array('presupuesto.pre_tramite_det','sum(certificado) as c1, sum(compromiso) as c2', 
                        'id_tramite='.$this->bd->sqlvalue_inyeccion($row['id_tramite'],true));
                    
                    $c1 = $monto["c1"] ;
                   
                    $evento = 'CargaDatos('.$row['id_tramite'].')';
                  
                    $referencia = ' href="#" onClick="'.$evento.'" data-toggle="modal" data-target="#myModalProducto" ';
 
                    
                    echo "<td style='color: #000'><a ".$referencia." >".trim($row['id_tramite']).'</a></td>';
                    echo "<td style='color: #000'>".trim($row['fecha']).'</td>';
                    echo "<td style='color: #000'>".trim($row['unidad']).'</td>';
                    echo "<td style='color: #000'>".trim($row['user_sol']).'</td>';
                    echo "<td style='color: #000'>".trim($row['detalle']).'</td>';
                    echo "<td style='color: #000'>".trim($row['comprobante']).'</td>';
                    echo "<td style='color: #000'>".trim($row['estado_presupuesto']).'</td>';
                    echo "<td style='color: #000'>".trim($row['proveedor']).'</td>';
                    echo "<td style='color: #000'>".trim($row['id_asiento_ref']).'</td>';
                    
                    echo "<td align='right'>".number_format($c1,2).'</td>';
                      
                    $nsuma1 = $nsuma1 + $c1;
   
                    $k++;
                    echo "</tr>";
                     
                     if ( $tipo_d == 1 ){
                         echo '<tr><td colspan="2">&nbsp;</td><td colspan="8">'.$this->deta($row['id_tramite']).'</td></tr>';
                     }
                    
                    
                }
                /// total
                
              
                
              
                echo "<tr>";
                     echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                           <td>TOTAL</td>";
                     
                     echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
                  
                
                echo "</tr></tbody></table>";
                
                pg_free_result ($resultado) ;
            
    }
    
   
    //--------------------------------------------------
    function deta($tramite){
      
        $cadena = '<table class="table table-bordered" border="0" width="80%">';
        
        $sql1 = 'SELECT  programa , partida,detalle ,clasificador,     certificado, compromiso, devengado 
                 FROM presupuesto.view_dettramites
                where id_tramite = '.$tramite.' 
                order by programa,clasificador'  ;
        
        $resultado1  = $this->bd->ejecutar($sql1);
        
        
        $cadena =  $cadena.'<tr><th width="30%" bgcolor="#eaeaea" style="color: #4a4949">Programa</th>';
        $cadena =  $cadena.'<th width="10%" bgcolor="#eaeaea" style="color: #4a4949">Partida</th>';
        $cadena =  $cadena.'<th width="30%" bgcolor="#eaeaea" style="color: #4a4949">Detalle</th>';
        $cadena =  $cadena.'<th width="5%" bgcolor="#eaeaea" style="color: #4a4949">Clasificador</th>';
        $cadena =  $cadena.'<th width="5%" bgcolor="#eaeaea" style="color: #4a4949">Certificado</th>';
          
        while($row1=pg_fetch_assoc($resultado1)) {
         
       
            
            $cadena =  $cadena."<tr><td bgcolor='#f9f5f5'>".trim($row1['programa']).'</td>';
            $cadena =  $cadena. "<td  bgcolor='#f9f5f5'>".trim($row1['partida']).'</td>';
            $cadena =  $cadena. "<td  bgcolor='#f9f5f5'>".trim($row1['detalle']).'</td>';
            $cadena =  $cadena. "<td  bgcolor='#f9f5f5'>".trim($row1['clasificador']).'</td>';
            $cadena =  $cadena. "<td  bgcolor='#f9f5f5' align='right'>".number_format($row1['certificado'],2).'</td>';
             
        };
        
        $cadena =  $cadena. "</table>";
        
        return $cadena;
        
        pg_free_result ($resultado1) ; 
    }
    //----------------------------------------------------------------------
    function titulo($tipo_presupuesto,$ffecha1,$ffecha2){
        
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
 
 
        
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
    
    $tipo    =   $_GET["tipo"];
    
    
    $gestion->GrillaGasto_periodo( $ffecha1,$ffecha2,$fmodulo,$vunidad,$tipo);
            
 
 
}
?>

 