<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kpresupuesto/model/Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class Model_reportes_gestion{
    
  
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
    function Model_reportes_gestion( ){
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
   //---------------------
    
    
    function grilla_parcial($ffecha1,$ffecha2,$fmodulo,$vunidad,$tipo)  {
        
        
        
        $k = 0;

        $nombre = 'Idato';


        $this->titulo('Certificacion',$ffecha1,$ffecha2);
        
        $sql1 = 'SELECT  id_tramite, fecha, anio, mes, detalle, observacion,estado,comprobante,unidad,
                            sum(monto)   + avg(monto_certifica) as certifica,
                            avg(monto_certifica) as saldo_certifica ,  sum(monto) as ejecutado_certifica
        FROM presupuesto.view_pre_tramite_parcial
        where anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' 
        group by  id_tramite, fecha, anio, mes, detalle, observacion,estado,comprobante,unidad'  ;
                
        $resultado  = $this->bd->ejecutar($sql1);
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
        echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad</th>';
        echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Comprobante</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Estado</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Certificado</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Ejecutado</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Saldo</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            
      
            
            $evento     = 'VerParcial_id('.$row['id_tramite'].')';
            $referencia = ' href="#" onClick="'.$evento.'" data-toggle="modal" data-target="#myModalCertifica" ';

            $evento1     = 'VerParcial_det('.$row['id_tramite'].')';
            $referencia1 = ' href="#" onClick="'.$evento1.'" data-toggle="modal" data-target="#myModalCertifica" ';
          
            $c1 = $row['certifica'];
            $c2 = $row['ejecutado_certifica'];
            $c3 = $row['saldo_certifica'];


            if ( trim($row['estado']) == '3'){
                $estado = 'certificado';
            }
            if ( trim($row['estado']) == '5'){
                $estado = 'compromiso';
            }
            if ( trim($row['estado']) == '6'){
                $estado = 'devengado';
            }
            
            echo "<td style='color: #000'><a ".$referencia." ><b>".trim($row['id_tramite']).'</b></a></td>';
            echo "<td style='color: #000'>".trim($row['fecha']).'</td>';
            echo "<td style='color: #000'><a ".$referencia1." ><b>".trim($row['unidad']).'</b></a></td>';
            echo "<td style='color: #000'>".trim($row['detalle']).'</td>';
            echo "<td style='color: #000'>".trim($row['comprobante']).'</td>';
            echo "<td style='color: #000'>".$estado.'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='right'>".number_format($c3,2).'</td>';
            
         
            
            $nsuma1 = $nsuma1 + $c1;
            $nsuma2 = $nsuma2 + $c2;
            $nsuma3 = $nsuma3 + $c3;
            
            $k++;
            echo "</tr>";
            
            
            
        }
        /// total
        
        
        
    
        echo "<tr>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'>Resumen</td>";
        echo "<td align='right'>".number_format($nsuma1,2).'</td>';
        echo "<td align='right'>".number_format($nsuma2,2).'</td>';
        echo "<td align='right'>".number_format($nsuma3,2).'</td>';
        
        echo "</tr>";

        echo "</tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    //----------------------------------------------------------
    function grilla_parcialid($id)  {
        
        
        
        $k = 0;

        $nombre = 'IdatoD';


     echo ' <h3>DETALLE DE CERTIFICACIONES EMITIDAS </h3>';
        
        $sql2 = ' SELECT a.id_tramiteo,b.fcompromiso,b.proveedor  ,b.comprobante, b.estado_presupuesto, a.monto, b.monto_compromiso
        FROM presupuesto.view_pre_tramite_parcial a,
              presupuesto.view_pre_tramite b
        where a.id_tramite ='.$this->bd->sqlvalue_inyeccion($id ,true).'  and a.id_tramiteo = b.id_tramite';
         
                
        $resultado1  = $this->bd->ejecutar($sql2);
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
        echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Proveedor</th>';
        echo '<th width="20%" bgcolor="#167cd8" style="color: #F4F4F4">Comprobante</th>';
        echo '<th width="100%" bgcolor="#167cd8" style="color: #F4F4F4">Estado</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Parcial</th>';
        echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Compromiso</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
         
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado1)) {
            
            echo "<tr>";
            
 

            $c1 = $row['monto'];
            $c2 = $row['monto_compromiso'];
            
            echo "<td style='color: #000'><a><b>".trim($row['id_tramiteo']).'</b></a></td>';
            echo "<td style='color: #000'>".trim($row['fcompromiso']).'</td>';
            echo "<td style='color: #000'>".trim($row['proveedor']).'</td>';
            echo "<td style='color: #000'>".trim($row['comprobante']).'</td>';
            echo "<td style='color: #000'>".trim($row['estado_presupuesto']).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            
         
            
            $nsuma1 = $nsuma1 + $c1;
            $nsuma2 = $nsuma2 + $c2;
             
            $k++;
            echo "</tr>";
            
            
            
        }
        /// total
        
        
        
    
        echo "<tr>";
         echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'></td>";
        echo "<td style='color: #000'>Resumen</td>";
        echo "<td align='right'>".number_format($nsuma1,2).'</td>';
        echo "<td align='right'>".number_format($nsuma2,2).'</td>';
         
        echo "</tr>";

        echo "</tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
   //-----------------------------------------
   function grilla_parcial_det($id)  {
        
        
        
    $k = 0;

    $nombre = 'IdatoDet';


 echo ' <h3>DETALLE DE CERTIFICACIONES EMITIDAS </h3>';
    
    $sql2 = ' SELECT a.id_tramiteo,b.fcertifica ,b.fcompromiso ,b.unidad ,b.partida,b.detalle,b.clasificador , b.compromiso 
    FROM presupuesto.view_pre_tramite_parcial a,
          presupuesto.view_dettramites b
    where a.id_tramite ='.$this->bd->sqlvalue_inyeccion($id ,true).'  and a.id_tramiteo = b.id_tramite
    order by a.id_tramiteo,b.partida';
    
     
            
    $resultado1  = $this->bd->ejecutar($sql2);
    


    echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
    <thead> <tr>';
    
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha Certifica</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha Compromiso</th>';
    echo '<th width="20%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Partida</th>';
    echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
    echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Compromiso</th>';
    
    echo '</tr></thead><tbody>';
    
    $nsuma1 = 0;

     
    
    
    $k = 1;
    while($row=pg_fetch_assoc($resultado1)) {
        
        echo "<tr>";
        
 
        $c1 = $row['compromiso'];
         
        echo "<td style='color: #000'><a><b>".trim($row['id_tramiteo']).'</b></a></td>';
        echo "<td style='color: #000'>".trim($row['fcertifica']).'</td>';
        echo "<td style='color: #000'>".trim($row['fcompromiso']).'</td>';
        echo "<td style='color: #000'>".trim($row['unidad']).'</td>';
        echo "<td style='color: #000'>".trim($row['partida']).'</td>';
        echo "<td style='color: #000'>".trim($row['detalle']).'</td>';
        echo "<td align='right'>".number_format($c1,2).'</td>';
         
     
        
        $nsuma1 = $nsuma1 + $c1;
          
        $k++;
        echo "</tr>";
        
        
        
    }
    /// total
    
    
    

    echo "<tr>";
     echo "<td style='color: #000'></td>";
     echo "<td style='color: #000'></td>";
    echo "<td style='color: #000'></td>";
    echo "<td style='color: #000'></td>";
    echo "<td style='color: #000'></td>";
    echo "<td style='color: #000'>Resumen</td>";
    echo "<td align='right'>".number_format($nsuma1,2).'</td>';
      
    echo "</tr>";

    echo "</tbody></table>";
    
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
        
       
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        $imagen = '';
        
        echo '	<div class="col-md-12" style="padding: 10px"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>PRESUPUESTO ( PERIODO '.$ffecha1.' AL '.$ffecha2.' ) </b><br>
                        <b>'.$tipo_presupuesto.' POR PERIODO</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table></div>';
        
 
        
    }
    
    
    function firmas( ){
        
       

        $codigo_reporte ='PR-CP';
        
		$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true) );
	
        $pie_contenido = $reporte_pie["pie"];
    
        // NOMBRE / CARGO
        $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
        $pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
        
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
        $pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
         $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
         $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
         $pie_contenido = str_replace('#PRESUPUESTO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_PRESUPUESTO',trim($a10['carpetasub']), $pie_contenido);
            
            //------------- llama a la tabla de parametros ---------------------//
    
            $usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual
    
            $sesion   = ucwords(strtolower($usuarios['completo']));  
      
     
            $pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
            
            echo $pie_contenido ;
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_reportes_gestion;



//------ grud de datos insercion
if (isset($_GET["fmodulo"]))	{
    
 
    
    $ffecha1	=   $_GET["ffecha1"];
    $ffecha2	=   $_GET["ffecha2"];
    $fmodulo    =   $_GET["fmodulo"];
    $vunidad    =   $_GET["vunidad"];
    
    $tipo    =   $_GET["tipo"];
    
    if (  $fmodulo  == 'parcial'){

        $gestion->grilla_parcial( $ffecha1,$ffecha2,$fmodulo,$vunidad,$tipo);

    }else {

        if (  $fmodulo  == 'detalle'){
            $id    =   $_GET["id"];
            $gestion->grilla_parcialid( $id );

        }   else {
       
            if (  $fmodulo  == 'partidas'){
                $id    =   $_GET["id"];
                $gestion->grilla_parcial_det( $id );
            } else{
                 $gestion->GrillaGasto_periodo( $ffecha1,$ffecha2,$fmodulo,$vunidad,$tipo);
            }
         } 
    }
    
    
            
 
 
}
?>

 