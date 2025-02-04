<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

include('../../reportes/phpqrcode/qrlib.php');

class proceso{
    
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
       
        $this->obj       = 	new objects;
        $this->bd	     =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- BUSQUEDA DE PERIODO DE MOVIMIENTOS
    
    function grilla(  $periodo,$periodo1 ,$id ){
        
        
        $tipo 		 = $this->bd->retorna_tipo();
        $formulario  = '';
        $action      = '';
        
        if ( $id == '1'){
            
            $destino = 'DETALLE DE MOVIMIENTO DE CONSUMOS POR MES';
            $this->obj->grid->KP_sumatoria(7,"galones","total", "","");
            
            $sql         = $this->_sql_detalle_mes( $periodo,$periodo1 );
            $resultado   = $this->bd->ejecutar($sql);
            
            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
            
        }
       
        if ( $id == '2'){
            
            $destino = 'DETALLE DE MOVIMIENTO POR VEHICULO';
            
            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
            
            echo $ViewForm;
            $sql         = $this->_sql_vehiculo_mes( $periodo,$periodo1 );
            
            
         
        }

        if ( $id == '6'){
            
            $destino = 'DETALLE DE MOVIMIENTO POR VEHICULO';
            
            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
            
            echo $ViewForm;
            $sql         = $this->_sql_vehiculo_mes_analisis( $periodo,$periodo1 );
            
            
         
        }

        if ( $id == '5'){
            
            $destino = 'DETALLE DE MOVIMIENTO POR USO INTERNO';
            
            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
            
            echo $ViewForm;
            $sql         = $this->_sql_vehiculo_mes_in( $periodo,$periodo1 );
            
            
         
        }
        
       
        if ( $id == '3'){
            
                            $destino = 'DETALLE DE MOVIMIENTO POR COMBUSTIBLE';
                            
                            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
                            
                            echo $ViewForm;
                            $sql         = $this->_sql_combustible_mes( $periodo,$periodo1 );
                            
                            
                            $sql1 ="SELECT   
                            a.tipo_comb as tipo, 
                            a.costo,
                            sum(a.cantidad) as galones,
                            sum(a.total_consumo) as total_consumo
                        FROM  adm.view_comb_vehi a
                        where  a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."
                        group by a.tipo_comb,a.costo order by a.tipo_comb ";
                    
                     
                        echo ' <div class="col-md-7" > ';

                        echo '<table id="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">';
                                echo '<thead><tr>
                                <th width="50%">Tipo</th>
                                <th width="10%">Costo</th>
                                <th width="10%" align="right">Galones</th>
                                <th width="10%" align="right">Total</th>
                                <th width="10%" align="right">IVA</th>
                                <th width="10%" align="right">Total IVA</th>
                                </tr></thead>';
                    
                                $stmt_lista_datos = $this->bd->ejecutar($sql1);

                                $c1 = 0;
                                $c2 = 0;
                                $c3 = 0;
                                $c4 = 0;
                    
                                while ($fetch_dato=$this->bd->obtener_fila($stmt_lista_datos)){
                                
                                
                                    $costo = $fetch_dato['total_consumo'] ;  
                    
                    
                                    $iva       = $fetch_dato['total_consumo']  * (12/ 100);
                                    $total_iva = $fetch_dato['total_consumo'] +   round($iva,6);
                                    
                    
                                    echo "<tr>";
                                    echo "<td>".$fetch_dato['tipo']."</td>";
                                    echo "<td>".$fetch_dato['costo']."</td>";
                                    echo "<td  align='right'>".number_format($fetch_dato['galones'],6)."</td>";
                                    echo "<td  align='right'>".number_format($fetch_dato['total_consumo'],6)."</td>";
                                    echo "<td  align='right'>".number_format( $iva,4)."</td>";
                                    echo "<td  align='right'>".number_format($total_iva ,4)."</td>";
                                    echo "</tr>";
                                    $i++;

                                    $c1 = $fetch_dato['galones'] +  $c1;
                                    $c2 = $fetch_dato['total_consumo'] + $c2;
                                    $c3 = $iva + $c3;
                                    $c4 = $total_iva + $c4;

                                }

                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td  align='right'><b>".number_format($c1,6)."</b></td>";
                                echo "<td  align='right'><b>".number_format($c2,6)."</b></td>";
                                echo "<td  align='right'><b>".number_format( $c3,4)."</b></td>";
                                echo "<td  align='right'><b>".number_format($c4 ,4)."</b></td>";
                                echo "</tr>";

                    
                                echo "</table>";

                                echo ' </div> ';
            
        }
        
        
        if ( $id == '4'){
            
            $destino = 'DETALLE DE MOVIMIENTO POR COMBUSTIBLE POR MES';
            
            $ViewForm    = ' <h5><b>CONSUMO DE COMBUSTIBLES </h5><h6> <br>Periodo  '.$periodo.'<br>'.$destino.' </h6> </b>';
            
            echo $ViewForm;
            
            $sql         = $this->_sql_resumen_mes( $periodo,$periodo1);
            
             $resultado  = $this->bd->ejecutar($sql);
            
             
            $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
            
        }
        
      
        echo ' <div class="col-md-12" > ';
        
        $this->firmas();

        echo ' </div> ';
    }
    //-------------------------------------------
    function _sql_resumen_mes( $periodo,$periodo1){
        
        $array_fecha = explode('-',$periodo);

        $anio = $array_fecha[0];

        $detalleMes = "CASE WHEN mes='1' THEN '01. ENERO' WHEN
                                   mes='2' THEN '02. FEBRERO' WHEN
                                   mes='3' THEN '03. MARZO' WHEN
                                   mes='4' THEN '04. ABRIL' WHEN
                                   mes='5' THEN '05. MAYO' WHEN
                                   mes='6' THEN '06. JUNIO' WHEN
                                   mes='7' THEN '07. JULIO' WHEN
                                   mes='8' THEN '08. AGOSTO' WHEN
                                   mes='9' THEN '09. SEPTIEMBRE' WHEN
                                   mes='10' THEN '10. OCTUBRE' WHEN
                                   mes='11' THEN '11. NOVIEMBRE' ELSE '12. DICIEMBRE' END ";
        
        
        $anio = date('Y');
        
        $sql ="SELECT ".$detalleMes." as mes,
                          count(*) || ' ' as transaccion,
                          sum(cantidad) as galones,
                          sum(total_consumo) as total
                    FROM  adm.view_comb_vehi 
                    where anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."
                     group by  mes
                     order by mes ";
    
                    
        return $sql;
        
    }
    ///------------------------------------------
    function _sql_detalle_mes( $periodo,$periodo1){
        
        
 
                $sql ="SELECT   a.fecha , 
                                a.detalle,
                                a.placa_ve  || ' ' as placa,   
                                a.referencia || ' ' as comprobante, 
                                a.tipo_comb as tipo, 
                                a.u_km as  Km ,
                                a.cantidad as galones,   
                                a.total_consumo as total
                            FROM  adm.view_comb_vehi a
                            where  a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."
                             order by a.fecha ";
         
    
        
        return $sql;
        
    }
    //------------
    function _sql_vehiculo_mes( $periodo, $periodo1){
        
       
            
            $sql ="SELECT  a.id_bien, a.detalle,a.placa_ve  
                    FROM adm.view_comb_vehi a 
                    where a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)." and 
                          a.uso = 'S'
                    group by a.id_bien, a.detalle,a.placa_ve 
                    order by 2 desc ";
 
        
        
        $stmt_lista = $this->bd->ejecutar($sql);
        
        
        echo '<div class="col-md-12"> ';
        
        while ($x=$this->bd->obtener_fila($stmt_lista)){
            
            $cuenta   = trim($x['id_bien']);
            $detalle  = trim($x['detalle']);
            $placa_ve = trim($x['placa_ve']);
            
            
            $etiqueta = $detalle.' '.$placa_ve;
            
            echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
            
            $this->_movimiento_combustible($cuenta,$periodo, $periodo1);
            
        }
        
        echo '</div> ';
    }
    //---------------------
    function _sql_vehiculo_mes_analisis( $periodo, $periodo1){
        
       
            
        $sql ="SELECT  a.id_bien, a.detalle,a.placa_ve  
                FROM adm.view_comb_vehi a 
                where  a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and 
                      ".$this->bd->sqlvalue_inyeccion($periodo1, true)."   and 
                      a.uso = 'S'
                group by a.id_bien, a.detalle,a.placa_ve 
                order by 2 desc ";

    
    
    $stmt_lista = $this->bd->ejecutar($sql);
    
    
    echo '<div class="col-md-12"> ';
    
    while ($x=$this->bd->obtener_fila($stmt_lista)){
        
        $cuenta   = trim($x['id_bien']);
        $detalle  = trim($x['detalle']);
        $placa_ve = trim($x['placa_ve']);
        
        
        $etiqueta = $detalle.' '.$placa_ve;
        
        echo ' <ul class="list-group">
                <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
               </ul>';
        
        $this->_movimiento_combustible_analisis($cuenta,$periodo, $periodo1);
        
    }
    
    echo '</div> ';
}
    //------------------
    function _sql_vehiculo_mes_in( $periodo,$periodo1){
        
       
            
        $sql ="SELECT  a.id_bien, a.detalle,a.placa_ve  
                FROM adm.view_comb_vehi a 
                where a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)." and 
                      a.uso = 'N'
                group by a.id_bien, a.detalle,a.placa_ve 
                order by 2 desc ";

    
    
    $stmt_lista = $this->bd->ejecutar($sql);
    
    
    echo '<div class="col-md-12"> ';
    
    while ($x=$this->bd->obtener_fila($stmt_lista)){
        
        $cuenta   = trim($x['id_bien']);
        $detalle  = trim($x['detalle']);
        $placa_ve = trim($x['placa_ve']);
        
        
        $etiqueta = $detalle.' '.$placa_ve;
        
        echo ' <ul class="list-group">
                <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
               </ul>';
        
        $this->_movimiento_combustible_in($cuenta,$periodo,$periodo1);
        
    }
    
    echo '</div> ';
}   
    //----------------------------------------------
    function _movimiento_combustible_det( $cuenta,$periodo ,$periodo1){
        
        $tipo 		 = $this->bd->retorna_tipo();
        $formulario  = '';
        $action      = '';
        
        $sql1 ="SELECT   a.fecha ,
                                a.detalle || ' ' || a.placa_ve   as detalle,
                                a.referencia || ' ' as comprobante,
                                a.ubicacion_salida as Motivo,
                                a.tipo_comb as tipo,
                                a.u_km_inicio as  Km ,
                                a.cantidad as galones,
                                a.total_consumo as total
                            FROM  adm.view_comb_vehi a
                            where  a.tipo_comb =".$this->bd->sqlvalue_inyeccion($cuenta, true)."  and
                                   a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."  
                             order by a.fecha ";
        
        
        
        $stmt_detalle  = $this->bd->ejecutar($sql1);
        
        $this->obj->grid->KP_sumatoria(7,"galones","total", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt_detalle,$tipo,'Id',$formulario,'S','',$action,'','');
        


     
     }
    //----------------------
    function _sql_combustible_mes( $periodo,$periodo1){
        
        
        $sql ="SELECT  a.tipo_comb
                    FROM adm.view_comb_vehi a
                    where a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."  
                    group by a.tipo_comb
                    order by 1 desc ";
        
        
        
        $stmt_lista = $this->bd->ejecutar($sql);
        
        
        echo '<div class="col-md-12"> ';
        
        while ($x=$this->bd->obtener_fila($stmt_lista)){
            
            $cuenta   = trim($x['tipo_comb']);
            $detalle  = trim($x['tipo_comb']);
             
            
            $etiqueta = $detalle;
            
            echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
            
            $this->_movimiento_combustible_det($cuenta,$periodo,$periodo1);
            
        }
        
        echo '</div> ';
        
        
        
        
    }
    //----------------------------
    function _movimiento_combustible_analisis(  $cuenta,$periodo,$periodo1){
        
        $tipo 		 = $this->bd->retorna_tipo();
        $formulario  = '';
        $action      = '';
        
        $sql1 ="SELECT   a.fecha , 
                                a.detalle as vehiculo,
                                a.placa_ve  || ' ' as placa,   
                                a.referencia || ' ' as comprobante, 
                                a.ubicacion_salida,
                                a.tipo_comb as tipo, 
                                a.u_km_inicio as  km ,
                                a.cantidad as galones,   
                                a.total_consumo as total,
                                a.costo,a.hora_in
                            FROM  adm.view_comb_vehi a
                            where  a.id_bien =".$this->bd->sqlvalue_inyeccion($cuenta, true)."  and
                                   a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."  
                             order by a.fecha DESC,a.referencia DESC";

 
        
        $stmt_detalle  = $this->bd->ejecutar($sql1);


   
        echo '<table id="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">';
            echo '<thead><tr>
            <th width="5%">Fecha</th>
            <th width="20%">Vehiculo</th>
            <th width="5%">Placa</th>
            <th width="5%">Comprobante</th>
            <th width="20%">Salida</th>
            <th width="5%">Tipo</th>
            <th width="5%">Hora</th>
            <th width="5%" align="right">Galones</th>
            <th width="5%" align="right">Unitario</th>
            <th width="5%" align="right">Total</th>
            <th width="5%" align="right">IVA</th>
            <th width="5%" align="right">Total IVA</th>
            <th width="5%" align="right">Km</th>
            <th width="5%" align="right">Consumo</th>
            </tr></thead>';
                    
            $consumo         = 0;
            $consumo_inicial = 0;
            $i               = 1;

            $total_consumo  = 0;
            $total_km       = 0;
            

            while ($fetch_dato=$this->bd->obtener_fila($stmt_detalle)){
                

                if ( $i == 1){
                    $consumo_inicial = $fetch_dato['km'];
                    $consumo         = 0;
                } else  
                {
                    $consumo         =  $consumo_inicial - $fetch_dato['km'] ;     
                    $consumo_inicial = $fetch_dato['km'];
                }
              
                $costo = $fetch_dato['costo'] ;  


                $iva       = $fetch_dato['total']  * (12/ 100);
                $total_iva = $fetch_dato['total'] +   round($iva,2);
                

                echo "<tr>";
			    echo "<td>".$fetch_dato['fecha']."</td>";
			    echo "<td><b>".$fetch_dato['vehiculo']."</b></td>";
			    echo "<td>".$fetch_dato['placa']."</td>";
                echo "<td>".$fetch_dato['comprobante']."</td>";
                
                echo "<td>".$fetch_dato['ubicacion_salida']."</td>";

                echo "<td>".$fetch_dato['tipo']."</td>";
                echo "<td>".$fetch_dato['hora_in']."</td>";
                echo "<td  align='right'>".number_format($fetch_dato['galones'],4)."</td>";
                echo "<td  align='right'>".number_format($costo,4)."</td>";
                echo "<td  align='right'>".number_format($fetch_dato['total'],4)."</td>";
             
                echo "<td  align='right'>".number_format($iva,2)."</td>";
                echo "<td  align='right'>".number_format($total_iva,4)."</td>";

                echo "<td  align='right'>".number_format($fetch_dato['km'],2)."</td>";
                echo "<td  align='right'>".number_format($consumo,2)."</td>";
                echo "</tr>";
                $i++;

                $total_consumo  =  $total_consumo + $consumo;
                $total_km       =  $total_km + $fetch_dato['km'];

            }

            echo "<tr>";
            echo "<td> </td>";
            echo "<td> </td>";
            echo "<td> </td>";
            echo "<td> </td>";
            
            echo "<td> </td>";

            echo "<td> </td>";
            echo "<td> </td>";
            echo "<td> </td>";
            echo "<td> </td>";
            echo "<td> </td>";
         
            echo "<td> </td>";
            echo "<td> </td>";

            echo "<td  align='right'>".number_format($total_km,2)."</td>";
            echo "<td  align='right'>".number_format($total_consumo,2)."</td>";
            echo "</tr>";
           
          
			echo "</table>";
    }
    //----------------------------
    function _movimiento_combustible(  $cuenta,$periodo,$periodo1){
        
        $tipo 		 = $this->bd->retorna_tipo();
        $formulario  = '';
        $action      = '';
        
        $sql1 ="SELECT   a.fecha , 
                                a.detalle as vehiculo,
                                a.placa_ve  || ' ' as placa,   
                                a.referencia || ' ' as comprobante, 
                                a.ubicacion_salida as salida, 
                                a.ubicacion_llegada as llegada, 
                                a.tipo_comb as tipo, 
                                a.u_km_inicio as  Km ,
                                a.cantidad as galones,   
                                a.total_consumo as total
                            FROM  adm.view_comb_vehi a
                            where  a.id_bien =".$this->bd->sqlvalue_inyeccion($cuenta, true)."  and
                                   a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."  
                             order by a.fecha DESC,a.referencia DESC";

 
        
        $stmt_detalle  = $this->bd->ejecutar($sql1);
   
        $this->obj->grid->KP_sumatoria(9,"galones","total", "","");
         
        $this->obj->grid->KP_GRID_CTA_query($stmt_detalle,$tipo,'Id',$formulario,'S','',$action,'','');
        
         
     
        
    }
    //--------------------
    function _movimiento_combustible_in(  $cuenta,$periodo,$periodo1){
        
        $tipo 		 = $this->bd->retorna_tipo();
        $formulario  = '';
        $action      = '';
        
        $sql1 ="SELECT   a.fecha , 
                                a.detalle as Detalle,
                                a.referencia || ' ' as comprobante, 
                                a.ubicacion_salida as motivo, 
                                a.tipo_comb as tipo, 
                                a.u_km_inicio as  Km ,
                                a.cantidad as galones,   
                                a.total_consumo as total,
                                round(a.iva,2) as iva,
                                a.total_consumo +  round(a.iva,2) as total_iva
                            FROM  adm.view_comb_vehi a
                            where  a.id_bien =".$this->bd->sqlvalue_inyeccion($cuenta, true)."  and
                                   a.fecha between ".$this->bd->sqlvalue_inyeccion($periodo, true)." and ".$this->bd->sqlvalue_inyeccion($periodo1, true)."  and
                                   a.uso = 'N'
                             order by a.fecha DESC, a.referencia DESC";

 
        
        $stmt_detalle  = $this->bd->ejecutar($sql1);
   
        $this->obj->grid->KP_sumatoria(7,"galones","total", "iva","total_iva");
         
        $this->obj->grid->KP_GRID_CTA_query($stmt_detalle,$tipo,'Id',$formulario,'S','',$action,'','');
        
         
     
        
    }
    //---------------
    function firmas( ){
     
        
        echo '<div class="col-md-3" align="left"  style="padding-bottom:10;padding-top:10px"> ';
            
                echo 'Elaborado<br>'.trim($_SESSION['email']).'<br> ';
                $this->QR_DocumentoDoc(  );
                echo '<img src="../model/logo_qr.png" width="100" height="100"/>';
       
        echo '</div> ';
        
    }
    
    function QR_DocumentoDoc(  ){
        
        $codigo     ='0';
        $name       = $_SESSION['razon'] ;
        $sesion     = trim($_SESSION['email']);
        
        $datos = $this->bd->query_array('par_usuario',
            'completo',
            'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
            );
        
        $nombre     =  $datos['completo'];
        $year       = date('Y');
        $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
        $elaborador = base64_encode($codigo);
        
        $hoy = date("Y-m-d H:i:s");
        
        // we building raw data
        $codeContents .= 'GENERADO POR:'.$nombre."\n";
        $codeContents .= 'FECHA: '.$hoy."\n";
        $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
        $codeContents .= 'INSTITUCION :'.$name."\n";
        $codeContents .= '2.4.0'."\n";
        
        //$tempDir = EXAMPLE_TMP_SERVERPATH;
        
        QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
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
if (isset($_GET["id"]))	{
    
 
    $periodo               =     $_GET["mes"];
     
    $periodo1              =     $_GET["mes1"];

    $id                    =     $_GET["id"];
 
    
    $gestion->grilla( $periodo,$periodo1 ,$id);
    
    
}



?>
 
  