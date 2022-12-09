<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

include('../../reportes/phpqrcode/qrlib.php');

class proceso{
    
    
    
    private $obj;
    private $bd;
    private $anio;

    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->anio       =  $_SESSION['anio'];


        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function grilla( $f1,$f2,$cajero,$id ){
        
     
        
        if ( $id == '1'){
            
            $this->titulo_reporte();
            $destino     = 'MOVIMIENTO   INGRESOS - EMISION  ';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
              
            echo $ViewForm;
            
            $this->_opcion01($f1,$f2,$cajero);
            
            $this->firmas();
        }


        if ( $id == '7'){
            
            $this->titulo_reporte();
            $destino     = 'MOVIMIENTO   INGRESOS - RECAUDACION  ';
            $ViewForm    = ' <h5><b>GESTION DE RECAUDACION </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
              
            echo $ViewForm;
            
            $this->_opcion011($f1,$f2,$cajero);
            
            $this->firmas();
        }


        
        if ( $id == '2'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN DE TRAMITES POR USUARIO';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            echo '<div class="col-md-6">';

            $this->_opcion02($f1,$f2,$cajero);

            echo '</div>';    
            
            $this->firmas();
            
        }

        if ( $id == '81'){
            

            $this->titulo_reporte();
            $destino     = 'RESUMEN DE TRAMITES POR USUARIO';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            echo '<div class="col-md-6">';
            
                $this->_opcion028($f1,$f2,$cajero);

            echo '</div>';    
            
            $this->firmas();
            
        }

        if ( $id == '82'){
            

            $this->titulo_reporte();
            $destino     = 'RESUMEN DE INGRESOS POR AÑO';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            echo '<div class="col-md-6">';
            
                $this->_opcion029($f1,$f2,$cajero);

            echo '</div>';    
            
            $this->firmas();
            
        }


        if ( $id == '83'){
            
 
             $destino     = ' ';
             $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
             echo $ViewForm;
            
            echo '<div class="col-md-12">';
            
                $this->_opcion030($f1,$f2,$cajero);

            echo '</div>';    
            
          
            
        }
        
        
        
        
        if ( $id == '3'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR ESTADOS DE TRAMITES';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion03($f1,$f2,$cajero);
            
            $this->firmas();
        }
        
        if ( $id == '4'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR DETALLE DE TRAMITES';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion04($f1,$f2,$cajero);
            
            $this->firmas();
        }
         
        
        if ( $id == '5'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR FINANCIERO EMISION';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS EMITIDOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion05($f1,$f2,$cajero);
            
            $this->firmas();
        }
        

        if ( $id == '6'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR PRESUPUESTARIO EMISION';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS EMITIDOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion06($f1,$f2,$cajero);
            
            $this->firmas();
        }
        
        if ( $id == '8'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR FACTURAS EMITIDAS';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS EMITIDOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion08($f1,$f2,$cajero);
            
            $this->firmas();
        }

    }
    ///------------------------------------------
    function _sql( $f1,$f2,$tipo,$id){
        
        $anioArray = explode('-', $f2);
        $anio      = $anioArray[0];
        
        
        if ($id == 1)  {
            
            if ( $tipo == 'I') {
                
                $sql ="SELECT id_movimiento as movimiento,
                                  fecha,
                                  comprobante,
                                  trim(detalle) detalle,
                                  id_tramite || ' ' as tramite,
                                  idprov  || ' ' as identificacion,
                                  proveedor,
                                  base12 as baseimponible,
                                  iva,
                                  base0 as tarifa0,
                                  total
                            FROM  view_inv_transaccion
                            where tipo ='".$tipo."' and
                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                  estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                             order by fecha ";
            }else {
                
                $sql ="SELECT id_movimiento as movimiento,
                                  fecha,
                                  comprobante,
                                  trim(detalle) detalle,
                                  unidad,
                                  idprov  || ' ' as identificacion,
                                  proveedor as solicita,
                                  total
                            FROM  view_inv_transaccion
                            where tipo ='".$tipo."' and
                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                  estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                             order by fecha ";
            }
            
        }
        
        if ($id == 2)  {
            
            if ( $tipo == 'I') {
                $sql ="SELECT idprov  || ' ' as identificacion,
                          proveedor,
                          count(*) || ' ' as transaccion,
                          sum(base12) as baseimponible,
                          sum(iva) as iva,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                         (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  idprov,    proveedor
                     order by proveedor ";
            }else {
                
                $sql ="SELECT unidad   ,
                              transaccion as tipo,
                           count(*) || ' ' as transaccion,
                           sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                         (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  unidad,transaccion
                     order by unidad ";
            }
            
            
        }
        
        if ($id == 3)  {
            
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
            
            
            if ( $tipo == 'I') {
                
                $sql ="SELECT ".$detalleMes." as mes,
                          count(*) || ' ' as transaccion,
                          sum(base12) as baseimponible,
                          sum(iva) as iva,
                           sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                          anio = ".$anio."
                     group by  mes
                     order by mes ";
            }else{
                $sql ="SELECT ".$detalleMes." as mes,
                          count(*) || ' ' as transaccion,
                           sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                          anio = ".$anio."
                     group by  mes
                     order by mes ";
            }
            
        }
        
        if ($id == 4)  {
            
            $tipo = 'I';
            
            $sql ="SELECT producto,
	                      sum(cantidad)  || ' ' as cantidad,
                          sum(coalesce(baseiva)) as baseimponible,
                          sum(coalesce(monto_iva,0)) as iva,
                          sum(coalesce(tarifa_cero,0)) as tarifa0
                    from view_movimiento_det_cta
                   where tipo ='".$tipo."' and
                          estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by producto order by  producto ";
            
            
            
        }
        
        
        
        
        
        if ($id == 8)  {
            
            //    $tipo = 'E';
            
            // sum(coalesce(baseiva)) + sum(coalesce(tarifa_cero)) as costo
            
            
            $sql ="SELECT producto,
                          cuenta_inv,
                          cuenta_gas,
	                      sum(cantidad)  || ' ' as cantidad,
                          sum(coalesce(total)) as costo
                     from view_inv_movimiento_det
                   where tipo ='".$tipo."' and
                          estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by producto,cuenta_inv,cuenta_gas order by  producto ";
        }
        
        
        return $sql;
        
    }
    //------------
    function _opcion01( $f1,$f2,$cajero){
        
        
        $formulario  = '';
        $action      = '';
        
        $sql = "SELECT  id_ren_movimiento || ' ' as titulo, 
                         fecha_emision as fecha,  
                        idprov  || ' ' as identificacion, 
                        razon as contribuyente,  
                        nombre_rubro as detalle,
                        estado_proceso as estado,
                        coalesce(interes,0) as interes,
                        coalesce(descuento,0) as descuento,
                        coalesce(recargo,0) as recargo,
                        coalesce(emision,0 ) as emision ,
                        coalesce(total,0 ) as total 
         FROM  rentas.view_ren_emision
        where  fecha_emision between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)." and 
               modulo  <> 'especies' and 
               sesion = ".$this->bd->sqlvalue_inyeccion( $cajero,true).'
        order by id_ren_movimiento desc ';
 

        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
         
        $_SESSION['sql_activo'] = $sql;
 
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(7,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }
    //-----------------
    function _opcion011( $f1,$f2,$cajero){
        
        
        $formulario  = '';
        $action      = '';
        
        $sql = "SELECT  id_ren_movimiento || ' ' as titulo, 
                        fechap as fecha,  
                        comprobante  || ' ' as comprobante, 
                        idprov  || ' ' as identificacion, 
                        razon as contribuyente,  
                        nombre_rubro as detalle,
                        estado_proceso as estado,
                        coalesce(interes,0) as interes,
                        coalesce(descuento,0) as descuento,
                        coalesce(recargo,0) as recargo,
                        coalesce(emision,0 ) as emision ,
                        coalesce(total,0 ) as total 
        FROM  rentas.view_ren_emision
        where  fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)." and 
               modulo  <> 'especies' and estado= 'P'
        order by id_ren_movimiento desc ";
 


        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
         
        $_SESSION['sql_activo'] = $sql;
 
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(8,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }
    //------------------
    function _opcion02( $f1,$f2,$cajero){
        
        
        $formulario  = ' ';
        $action      = ' ';
        
        $sql = "SELECT  nombre_rubro as detalle,
                        count(*) || ' '   as  nro_emisiones ,
                        sum(coalesce(interes,0)) as interes,
                        sum(coalesce(descuento,0)) as descuento,
                        sum(coalesce(recargo,0)) as recargo,
                        sum(coalesce(emision,0)) as emision,
                        sum(coalesce(total,0)) as total
        FROM  rentas.view_ren_emision
        where  fecha_emision between ".$this->bd->sqlvalue_inyeccion( $f1,true)." and ".$this->bd->sqlvalue_inyeccion($f2,true)." and
               modulo  <> 'especies'  
        group by nombre_rubro
        order by nombre_rubro desc";

         
        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        
        $_SESSION['sql_activo'] = $sql;
        
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(3,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }
   /*
   REPORITE DE PAGOS REALIZADOS POR MES
   */
    function _opcion028( $f1,$f2,$cajero){
        
        
        $formulario  = ' ';
        $action      = ' ';
        
        $sql = "SELECT  nombre_rubro as detalle,
                        count(*) || ' '   as  nro_emisiones ,
                        sum(coalesce(interes,0)) as interes,
                        sum(coalesce(descuento,0)) as descuento,
                        sum(coalesce(recargo,0)) as recargo,
                        sum(coalesce(emision,0)) as emision,
                        sum(coalesce(total,0)) as total
        FROM  rentas.view_ren_emision
        where  fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true)." and ".$this->bd->sqlvalue_inyeccion($f2,true)." and
               modulo  <> 'especies' and    estado= 'P'
        group by nombre_rubro
        order by nombre_rubro desc";

         
        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        
        $_SESSION['sql_activo'] = $sql;
        
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(3,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }

      /*
   REPORITE DE PAGOS REALIZADOS POR AÑO
   */
  function _opcion029( $f1,$f2,$cajero){
        
                  
            $sql = 'SELECT  anio ,
                        count(*)   as "Nro tramite",
                        sum(coalesce(emision,0)) as pago
                    FROM  rentas.view_ren_emision
                    where '."
                    modulo  <> 'especies'   
                    group by anio
                    order by anio desc ";

        $resultado  = $this->bd->ejecutar($sql);


        echo '<ul class="list-group">';


        while ($x=$this->bd->obtener_fila($resultado)){

        echo '<li class="list-group-item"><b>'.trim($x['anio']).'</b></li>';

        $this->movimiento_compras_anio( $f1,$f2,$cajero,trim($x['anio']));

        }


        echo '</ul>';


}
     /*
   REPORITE DE PAGOS REALIZADOS POR AÑO
   */
  function _opcion030( $f1,$f2,$cajero){
        
                  
                $sql = 'SELECT  anio ,
                            count(*)   as "Nro tramite",
                            sum(coalesce(emision,0)) as pago
                        FROM  rentas.view_ren_emision
                        where '."
                        fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)." and
                        anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio,true)." and 
                        modulo  <> 'especies'   
                        group by anio
                        order by anio desc ";

            $resultado  = $this->bd->ejecutar($sql);
             

            echo '<ul class="list-group">';

             while ($x=$this->bd->obtener_fila($resultado)){

            echo '<li class="list-group-item"><b>'.trim($x['anio']).'</b></li>';

            $this->movimiento_compras_diario( $f1,$f2,$cajero,trim($x['anio']));

            }

            echo '<li class="list-group-item"><b>Años Anteriores</b></li>';


            $this->movimiento_compras_anterior( $f1,$f2,$cajero,$this->anio);
            




echo '</ul>';


}
    function _opcion08( $f1,$f2,$cajero){
        
        
        $formulario  = ' ';
        $action      = ' ';
 
        
        $sql = "SELECT  id_ren_movimiento as movimiento,
                        fechap,
                        secuencial  || ' ' as factura ,
                        idprov   || ' ' as ruc ,
                        razon,
                        detalle,
                        autorizacion  || ' ' as autorizacion ,
                        comprobante,
                        estado,
                        base12 as base_imponible,
                        iva as monto_iva,
                        base0 as tarifa_cero,
                         total
        FROM  rentas.view_ren_factura
        where  fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true)." and ".$this->bd->sqlvalue_inyeccion($f2,true)." and envio = 'S'
        order by secuencial desc";

         
        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        
        $_SESSION['sql_activo'] = $sql;
        
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(10,"base_imponible","monto_iva", "tarifa_cero","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }
    //-------------
    function _opcion03( $f1,$f2,$cajero){
        
        
        $formulario  = ' ';
        $action      = ' ';
        
        $sql = "SELECT  estado_proceso as estado,
                        count(*)  || ' '  as nro_titulos,
                        sum(coalesce(interes,0)) as interes,
                        sum(coalesce(descuento,0)) as descuento,
                        sum(coalesce(recargo,0)) as recargo,
                        sum(coalesce(emision,0)) as emision,
                        sum(coalesce(total,0)) as total
        FROM  rentas.view_ren_emision
        where  fecha_emision between ".$this->bd->sqlvalue_inyeccion( $f1,true)." and ".$this->bd->sqlvalue_inyeccion($f2,true)." and
               modulo  <> 'especies'  
        group by estado_proceso
        order by estado_proceso desc ";
        
        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        
        $_SESSION['sql_activo'] = $sql;
        
        echo '<div class="col-md-5"> ';
        
        $this->obj->grid->KP_sumatoria(3,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        echo '</div> ';
    }
    //----------------------------------------------
    function _opcion04( $f1,$f2,$cajero) {
        
        
        $sql = 'SELECT  nombre_rubro ,
                        count(*)   as "Nro tramite" 
        FROM  rentas.view_ren_emision
        where  fecha_emision between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
               sesion = '.$this->bd->sqlvalue_inyeccion( $cajero,true)."  and 
               modulo  <> 'especies'   
        group by nombre_rubro
        order by nombre_rubro desc ";
        
        $resultado  = $this->bd->ejecutar($sql);
         

       echo '<ul class="list-group">';
  
        
       while ($x=$this->bd->obtener_fila($resultado)){
           
           echo '<li class="list-group-item"><b>'.trim($x['nombre_rubro']).'</b></li>';
            
           $this->movimiento_compras( $f1,$f2,$cajero,trim($x['nombre_rubro']));
        }
       
        
        echo '</ul>';
      
     
        
       
    }
    /*
    */
    function _opcion05( $f1,$f2,$cajero) {
        
        
 
        
        $sql = 'SELECT  idproducto_ser,servicio
        FROM  rentas.view_emision_cta
        where  fecha between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)."
        group by idproducto_ser,servicio
        order by servicio";
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        echo '<ul class="list-group">';
        
        
        while ($x=$this->bd->obtener_fila($resultado)){
            
            echo '<li class="list-group-item"><b>'.trim($x['servicio']).'</b></li>';
            
            $this->movimiento_pagos( $f1,$f2,$cajero,trim($x['idproducto_ser']));
        }
        
        
        echo '</ul>';
 
        
    }
  /*
  */
  function _opcion06( $f1,$f2,$cajero) {
        
        
 
        
    $sql = 'SELECT  partida, _partida(partida) as detalle
    FROM  rentas.view_emision_cta
    where  fecha between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)."
    group by partida
    order by partida";
    
    $resultado  = $this->bd->ejecutar($sql);
    
    
    
    echo '<ul class="list-group">';
    
    
    while ($x=$this->bd->obtener_fila($resultado)){
        
        echo '<li class="list-group-item"><b>'.trim($x['partida']).'-'.trim($x['detalle']).'</b></li>';
        
        $this->movimiento_partida( $f1,$f2,$cajero,trim($x['partida']));
    }
    
    
    echo '</ul>';

    
}
/*
*/
function movimiento_compras_anterior( $f1,$f2,$cajero,$anio){
         
        
    $sql = "SELECT  nombre_rubro as rubro,
                    sum(coalesce(interes,0)) as interes,
                    sum(coalesce(descuento,0)) as descuento,
                    sum(coalesce(recargo,0)) as recargo,
                    sum(coalesce(emision,0)) as emision ,
                    sum(coalesce(total,0)) as total
    FROM  rentas.view_ren_emision
    where  fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
           estado= '.$this->bd->sqlvalue_inyeccion( 'P',true)." and  
           modulo  <> 'especies' and 
           anio < ".$this->bd->sqlvalue_inyeccion( $anio,true)."
           group by nombre_rubro
           order by nombre_rubro desc ";
    
    $stmt       = $this->bd->ejecutar($sql);
    $tipo 		= $this->bd->retorna_tipo();
    $formulario = '';
    $action     = '';
     
    $this->obj->grid->KP_sumatoria(2,"interes","descuento", "recargo","emision","total");
    
    $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','','','','',2,'12px');
    
    pg_free_result ($stmt) ;

 
    
}
/*
*/
function movimiento_compras_diario( $f1,$f2,$cajero,$anio){
         
        
    $sql = "SELECT  nombre_rubro as rubro,
                    sum(coalesce(interes,0)) as interes,
                    sum(coalesce(descuento,0)) as descuento,
                    sum(coalesce(recargo,0)) as recargo,
                    sum(coalesce(emision,0)) as emision ,
                    sum(coalesce(total,0)) as total
    FROM  rentas.view_ren_emision
    where  fechap between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
           estado= '.$this->bd->sqlvalue_inyeccion( 'P',true)." and  
           modulo  <> 'especies' and 
           anio = ".$this->bd->sqlvalue_inyeccion( $anio,true)."
           group by nombre_rubro
           order by nombre_rubro desc ";
    
    $stmt       = $this->bd->ejecutar($sql);
    $tipo 		= $this->bd->retorna_tipo();
    $formulario = '';
    $action     = '';
     
    $this->obj->grid->KP_sumatoria(2,"interes","descuento", "recargo","emision","total");
    
    $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','','','','',2,'12px');
    
    pg_free_result ($stmt) ;

 
    
}

/*
*/
 function movimiento_compras_anio( $f1,$f2,$cajero,$anio){
        


        
        
        $sql = "SELECT  nombre_rubro as rubro,
                        sum(coalesce(interes,0)) as interes,
                        sum(coalesce(descuento,0)) as descuento,
                        sum(coalesce(recargo,0)) as recargo,
                        sum(coalesce(emision,0)) as emision ,
                        sum(coalesce(total,0)) as total
        FROM  rentas.view_ren_emision
        where  anio=".$this->bd->sqlvalue_inyeccion($anio,true).' and
               estado= '.$this->bd->sqlvalue_inyeccion( 'P',true)." and  modulo  <> 'especies'
               group by nombre_rubro
               order by nombre_rubro desc ";
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
         
        $this->obj->grid->KP_sumatoria(2,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        pg_free_result ($stmt) ;
        
    }
  /*
  por por rubro
  */
    function movimiento_compras( $f1,$f2,$cajero,$cuenta){
        


        
        
        $sql = "SELECT  id_ren_movimiento as tramite,
                         fecha_emision,
                        idprov  || ' ' as identificacion,
                        razon as contribuyente,
                        estado_proceso as estado,
                        coalesce(interes,0) as interes,
                        coalesce(descuento,0) as descuento,
                        coalesce(recargo,0) as recargo,
                        coalesce(emision,0 ) as emision ,
                        coalesce(total,0) as total
        FROM  rentas.view_ren_emision
        where  fecha_emision between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
               sesion = '.$this->bd->sqlvalue_inyeccion( $cajero,true).' and 
               nombre_rubro= '.$this->bd->sqlvalue_inyeccion( $cuenta,true)." and  modulo  <> 'especies'
        order by id_ren_movimiento desc ";
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
         
        $this->obj->grid->KP_sumatoria(6,"interes","descuento", "recargo","emision","total");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','','','','',2,'12px');
        
        pg_free_result ($stmt) ;
        
    }
    //----------------------------
    function movimiento_pagos( $f1,$f2,$cajero,$cuenta){
        
        
        $sql = "SELECT   partida,
                         nom_cuenta_ing as detalle,  
                         cxcobrar as cuenta_cobrar, 
                         cuenta_ing as ingreso, 
                         sum(costo) as emision, 
                         sum(monto_iva) monto_iva , 
                         sum(descuento) descuento, 
                         sum(interes) interes, 
                         sum(recargo) recargo, 
                         sum(total) total 
        FROM  rentas.view_emision_cta
        where  fecha between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
               idproducto_ser = '.$this->bd->sqlvalue_inyeccion( $cuenta,true)."
               group by partida, nom_cuenta_ing,cxcobrar,cuenta_ing
               order by partida desc";
        
  
        $stmt       = $this->bd->ejecutar($sql);

        $tipo 		= $this->bd->retorna_tipo();
  
        
        $this->obj->grid->KP_sumatoria(5,"emision","monto_iva", "descuento","interes","recargo","total");

        $this->obj->grid->KP_with("10,43,7,5,5,5,5,5,5,5,5");
        
        $this->obj->grid->KP_GRID_CTA_visor($stmt,$tipo,'12px');
        
         
    }
    //-----------
    function movimiento_partida( $f1,$f2,$cajero,$cuenta){
        
        
        $sql = "SELECT   cxcobrar as cuenta_cobrar, 
                        nom_cuenta_ing as detalle,  
                         cuenta_ing as ingreso, 
                         sum(costo) as emision, 
                         sum(monto_iva) monto_iva , 
                         sum(descuento) descuento, 
                         sum(interes) interes, 
                         sum(recargo) recargo, 
                         sum(total) total 
        FROM  rentas.view_emision_cta
        where  fecha between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
               partida = '.$this->bd->sqlvalue_inyeccion( $cuenta,true)."
               group by  nom_cuenta_ing,cxcobrar,cuenta_ing
               order by cxcobrar desc";
        
  
        $stmt       = $this->bd->ejecutar($sql);

        $tipo 		= $this->bd->retorna_tipo();
  
        
        $this->obj->grid->KP_sumatoria(4,"emision","monto_iva", "descuento","interes","recargo","total");

        $this->obj->grid->KP_with("7,53,5,5,5,5,5,5,5,5");
        
        $this->obj->grid->KP_GRID_CTA_visor($stmt,$tipo,'12px');
        
         
    }
    //---------------
    function firmas( ){
        
        $sesion     = trim($_SESSION['email']);
        
        $datos = $this->bd->query_array('par_usuario',
            'completo',
            'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
            );
        
        $nombre     =  $datos['completo'];
        
        echo '<div class="col-md-12"  style="padding-bottom:10;padding-top:10px"> ';
        
        echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="50%" style="text-align: left;padding: 30px">&nbsp;</td>
        	<td width="50%" style="text-align: left">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: left">'.$nombre.' </td>
        	<td style="text-align: left"> </td>
        	</tr>
        	<tr>
        	<td style="text-align: left">Elaborado</td>
        	<td style="text-align: left"> </td>
        	</tr>
        	</tbody>
        	</table>';
        
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
   
    ///----------------------
    function titulo_reporte (){
        
        $name       = $_SESSION['razon'] ;
        $sesion     = trim($_SESSION['email']);
        $hoy = date("Y-m-d H:i:s");
        
        $datos = $this->bd->query_array('par_usuario',
            'completo',
            'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
            );
        
        $nombre     =  $datos['completo'];
        $year       = date('Y');

        
        
        $codeContents .= '<h5><b>'.$this->ruc.' '.$name."<br>";
        $codeContents .= 'FECHA: '.$hoy."<br>";
        $codeContents .= 'DOCUMENTO: '.$nombre."<br>";
        $codeContents .= 'PERIODO :'.$year."<br></b></h5>";
         
        echo $codeContents;
        
    
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
    
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
    $cajero             =     $_GET["cajero"];
    $id                 =     $_GET["id"];
    
    
    $gestion->grilla( $f1,$f2,$cajero,$id );
    
    
}



?>
 
  