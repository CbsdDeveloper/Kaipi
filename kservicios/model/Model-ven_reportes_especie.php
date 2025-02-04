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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function grilla(   $id , $mesc,$anioc ){
        
     
        
        if ( $id == '1'){
            
            $this->titulo_reporte();
            $destino     = 'MOVIMIENTO CONTROL DIARIO  ';
            $ViewForm    = ' <h5><b>GESTION DE ESPECIES </h5><h6> <br>Periodo  '.$mesc.' - '.$anioc.'<br>'.$destino.' </h6> </b>';
              
            echo $ViewForm;
            
            $this->_opcion01( $mesc,$anioc  );
            
            $this->firmas();
        }


        if ( $id == '2'){
            
            $this->titulo_reporte();
            $destino     = 'MOVIMIENTO CONTROL MENSUAL  ';
            $ViewForm    = ' <h5><b>GESTION DE ESPECIES </h5><h6> <br>Periodo  '.$mesc.' - '.$anioc.'<br>'.$destino.' </h6> </b>';
              
            echo $ViewForm;
            
            $this->_opcion02( $mesc,$anioc  );
            
            $this->firmas();
        }


        if ( $id == '3'){
            
            $this->titulo_reporte();
            $destino     = 'RESUMEN ANUAL DE CONTROL';
            $ViewForm    = ' <h5><b>GESTION DE ESPECIES </h5><h6> <br>ANUAL '.$anioc.'<br>'.$destino.' </h6> </b>';
            echo $ViewForm;
            
            $this->_opcion03( $mesc,$anioc  );
            
            $this->firmas();
        }
         

    }
     
    //------------
    function _opcion01(  $mesc,$anioc){
        
        
        $formulario  = '';
        $action      = '';
        
        $sql = "select  a.fecha,
                        b.producto as detalle,
                        min(a.comprobante) as inicial, 
                        max(a.comprobante) as final,
                        sum(a.cantidad) as cantidad,
                        COALESCE(sum(a.base),0) total
            from rentas.view_ren_especies a, rentas.ren_servicios b
            where a.anio= ".$this->bd->sqlvalue_inyeccion( $anioc,true)." and 
                  a.mes= ".$this->bd->sqlvalue_inyeccion( $mesc,true)." and
                  a.idproducto_ser = b.idproducto_ser
            group by a.fecha,a.idproducto_ser,b.producto
            order by a.fecha,a.idproducto_ser,b.producto";
 

        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
         
        $_SESSION['sql_activo'] = $sql;
 
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(5,"cantidad","total", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
        
        echo '</div> ';
    }
     
    //------------------
    function _opcion02( $mesc,$anioc){
          
        
        $formulario  = '';
        $action      = '';
        
        $sql = "select  b.producto as detalle,
                        min(a.comprobante) as inicial, 
                        max(a.comprobante) as final,
                        sum(a.cantidad) as cantidad,
                        COALESCE(sum(a.base),0) total
            from rentas.view_ren_especies a, rentas.ren_servicios b
            where a.anio= ".$this->bd->sqlvalue_inyeccion( $anioc,true)." and 
                  a.mes= ".$this->bd->sqlvalue_inyeccion( $mesc,true)." and
                  a.idproducto_ser = b.idproducto_ser
            group by  a.idproducto_ser,b.producto
            order by  a.idproducto_ser,b.producto";
 

        $resultado  = $this->bd->ejecutar($sql);
        $tipo 		= $this->bd->retorna_tipo();
         
        $_SESSION['sql_activo'] = $sql;
 
        echo '<div class="col-md-12"> ';
        
        $this->obj->grid->KP_sumatoria(4,"cantidad","total", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
        
        echo '</div> ';


    }
      
     
    //----------------------------------------------
    function _opcion03( $mesc,$anioc){
        
        
        $sql = "select   a.idproducto_ser, b.producto 
        from rentas.view_ren_especies a, rentas.ren_servicios b
        where a.anio= ".$this->bd->sqlvalue_inyeccion( $anioc,true)." and 
              a.idproducto_ser = b.idproducto_ser
        group by   a.idproducto_ser,b.producto 
        order by   a.idproducto_ser";
         
        
        $resultado  = $this->bd->ejecutar($sql);
         

       echo '<ul class="list-group">';
  
        
       while ($x=$this->bd->obtener_fila($resultado)){
           
           echo '<li class="list-group-item"><b>'.trim($x['producto']).'</b></li>';
            
           $this->movimiento_pagos( $mesc,$anioc,trim($x['idproducto_ser']));
        }
       
        
        echo '</ul>';
      
     
        
       
    }
       
    //----------------------------
    function movimiento_pagos( $mesc,$anioc,$idproducto_ser){
        
       
        
        $sql = " select  
                                CASE
                            WHEN mes = '1' THEN '1. Enero'::text
                            WHEN mes = '2' THEN '2. Febrero'::text
                            WHEN mes = '3' THEN '3. Marzo'::text
                            WHEN mes = '4' THEN '4. Abril'::text
                                        WHEN mes = '5' THEN '5. Mayo'::text
                            WHEN mes = '6' THEN '6. Junio'::text
                            WHEN mes = '7' THEN '7. Julio'::text
                            WHEN mes= '8' THEN '8. Agosto'::text
                                        WHEN mes = '9' THEN '9. Septiembre'::text
                            WHEN mes = '10' THEN '10. Octubre'::text
                            WHEN mes = '11' THEN '11. Noviembre'::text
                            WHEN mes= '12' THEN '12. Diciembre'::text
                        END AS mes,
                        min(comprobante) as inicial, 
                        max(comprobante) as final,
                        sum(cantidad) as cantidad,
                        COALESCE(sum(base),0) total
                from rentas.view_ren_especies
                where anio= ".$this->bd->sqlvalue_inyeccion( $anioc,true)." and
                      idproducto_ser = ".$this->bd->sqlvalue_inyeccion( $idproducto_ser,true)." 
                group by  mes,idproducto_ser
                order by  mes,idproducto_ser";
        
         
  
        $stmt       = $this->bd->ejecutar($sql);

        $tipo 		= $this->bd->retorna_tipo();
  
        $this->obj->grid->KP_sumatoria(4,"cantidad","total", "","");
        
        $this->obj->grid->KP_GRID_CTA_visor($stmt,$tipo);
        
         
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
    
    
 

    $id 				=     $_GET["id"];
    $mesc               =     $_GET["mesc"];
    $anioc              =     $_GET["anioc"];
    
    
    $gestion->grilla(  $id , $mesc,$anioc );
    
    
}



?>
 
  