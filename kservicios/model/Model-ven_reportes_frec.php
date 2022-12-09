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
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function grilla( $f1,$f2,$cajero,$id ){
        
     
        
        if ( $id == '1'){
            
            $this->titulo_reporte();
            $destino     = 'MOVIMIENTO POR PERIODO';
            $ViewForm    = ' <h5><b>GESTION DE FRECUENCIA </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
              
            echo $ViewForm;
            
            $this->_opcion01($f1,$f2,$cajero);
            
            $this->firmas();
        }
        
        if ( $id == '2'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN DE TRAMITES POR USUARIO';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion02($f1,$f2,$cajero);
            
            $this->firmas();
            
        }
        
  
        
        if ( $id == '4'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR DETALLE DE FRECUENCIA';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion04($f1,$f2,$cajero);
            
            $this->firmas();
        }


        if ( $id == '3'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN POR DETALLE DE FRECUENCIA';
            $ViewForm    = ' <h5><b>GESTION DE INGRESOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion03($f1,$f2,$cajero);
            
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
        
 

        $sql = "SELECT  hora, 
                         idprov  || ' ' as identificacion, 
                        razon as cooperativa,
                        ruta_ori as origen,
                        ruta_des as destino,
                        num_carro as nro_unidad,
                        hora_registro, 
                        hora_llegada,
                        cajero as usuario
        FROM  rentas.view_frec_resu
        where  fecha  between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
        order by hora asc ';
        
        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
         
        $_SESSION['sql_activo'] = $sql;
 
        echo '<div class="col-md-12"> ';
        
        //$this->obj->grid->KP_sumatoria(7,"pago","", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
        
        echo '</div> ';
    }
    //------------------
    function _opcion02( $f1,$f2,$cajero){
        
      
        $sql = 'SELECT  cajero,
                        count(*)   as "Nro tramite"
        FROM  rentas.view_frec_resu
        where  fecha between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
        group by cajero
        order by cajero desc ';
        
        $resultado  = $this->bd->ejecutar($sql);
 
        
       while ($x=$this->bd->obtener_fila($resultado)){
           
           echo '<li class="list-group-item"><b>'.trim($x['cajero']).'</b></li>';
            
           $this->movimiento_frecuenciac( $f1,$f2,$cajero,trim($x['cajero']));
        }
       
        
        echo '</ul>';
      



    }
    //-------------
    function _opcion03( $f1,$f2,$cajero){
        
        
        $sql = 'SELECT  idprov, razon ,
                        count(*)   as "Nro tramite"
        FROM  rentas.view_frec_resu
        where  fecha between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
        group by idprov, razon
        order by razon desc ';
        
        $resultado  = $this->bd->ejecutar($sql);
 
        
       while ($x=$this->bd->obtener_fila($resultado)){
           
           echo '<li class="list-group-item"><b>'.trim($x['razon']).'</b></li>';
            
           $this->movimiento_frecuenciat( $f1,$f2,$cajero,trim($x['idprov']));
        }


    }
    //----------------------------------------------
    function _opcion04( $f1,$f2,$cajero) {
        
        
        $sql = 'SELECT  idprov, razon ,
                        count(*)   as "Nro tramite"
        FROM  rentas.view_frec_resu
        where  fecha between '.$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
        group by idprov, razon
        order by razon desc ';
        
        $resultado  = $this->bd->ejecutar($sql);
 
        
       while ($x=$this->bd->obtener_fila($resultado)){
           
           echo '<li class="list-group-item"><b>'.trim($x['razon']).'</b></li>';
            
           $this->movimiento_frecuencia( $f1,$f2,$cajero,trim($x['idprov']));
        }
       
        
        echo '</ul>';
      
     
        
       
    }
    function movimiento_frecuenciac( $f1,$f2,$cajero,$idprov){
        
        $sql = "SELECT  hora, 
        idprov  || ' ' as identificacion, 
       razon as cooperativa,
       ruta_ori as origen,
       ruta_des as destino,
       num_carro as nro_unidad,
       hora_registro, 
       hora_llegada, total
FROM  rentas.view_frec_resu_total
where  cajero=".$this->bd->sqlvalue_inyeccion( $idprov,true)." and 
        fecha  between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
order by hora asc ';


 
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
         
        $this->obj->grid->KP_sumatoria(9,"total","", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','',$action,'','');
        
        pg_free_result ($stmt) ;
        
    }
  
    //----------------------------
    function movimiento_frecuencia( $f1,$f2,$cajero,$idprov){
        
        $sql = "SELECT  hora, 
        idprov  || ' ' as identificacion, 
       razon as cooperativa,
       ruta_ori as origen,
       ruta_des as destino,
       num_carro as nro_unidad,
       hora_registro, 
       hora_llegada,
       cajero as usuario
FROM  rentas.view_frec_resu
where  idprov=".$this->bd->sqlvalue_inyeccion( $idprov,true)." and 
        fecha  between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
order by hora asc ';


 
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
         
        //$this->obj->grid->KP_sumatoria(6,"pago","", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','',$action,'','');
        
        pg_free_result ($stmt) ;
        
    }
    //----------------------------
    function movimiento_frecuenciat( $f1,$f2,$cajero,$idprov){
        
        $sql = "SELECT  hora, 
        idprov  || ' ' as identificacion, 
       razon as cooperativa,
       ruta_ori as origen,
       ruta_des as destino,
       num_carro as nro_unidad,
       hora_registro, 
       hora_llegada,
       cajero as usuario,
       total
FROM  rentas.view_frec_resu_total
where  idprov=".$this->bd->sqlvalue_inyeccion( $idprov,true)." and 
        fecha  between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).'  
order by hora asc ';


 
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
         
        $this->obj->grid->KP_sumatoria(10,"total","", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','',$action,'','');
        
        pg_free_result ($stmt) ;
        
    }
    //----------------------------
    function movimiento_pagos( $f1,$f2,$cajero,$cuenta){
        
        
        $sql = "SELECT  id_ren_tramite as tramite,
                        fecha_inicio  as fecha,
                        idprov  || ' ' as identificacion,
                        razon as contribuyente,
                        estado_proceso as estado,
                        coalesce(total,0 ) as pago
        FROM  rentas.view_tramite_estados
        where  fecha_inicio between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' and
               sesion = '.$this->bd->sqlvalue_inyeccion( $cajero,true).' and
               nombre_rubro= '.$this->bd->sqlvalue_inyeccion( $cuenta,true)." and 
               estado = 'P'   
        order by id_ren_tramite desc";
        
        $stmt       = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
        $formulario = '';
        $action     = '';
        
        $this->obj->grid->KP_sumatoria(6,"pago","", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($stmt,$tipo,'Id',$formulario,'S','',$action,'','');
        
        pg_free_result ($stmt) ;
        
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
 
  