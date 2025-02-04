<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
 
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
   
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($mes,$anio){
        
     $this->VentasResumen($anio,$mes);
     $this->ComprasResumen( $anio,$mes);
      $this->ComprasFuente($anio,$mes);
     $this->ComprasIva($anio,$mes);
        
 
        
        $result = ' Datos Procesados: '.$mes.'-'.$anio;
        
        echo  $result;
    }
  
    //--------------------------------------------------------------------------------
    function ComprasFuente($anio,$mes){
        
        
        $formulario = '';
        $tab = '';
        
        echo '<p align="center"> <b>RESUMEN DE RETENCIONES DE COMPRAS DE IMPUESTO A LA RENTA</b> </p>';
        
        $label1 = "' -  '";
        
        $espacio = " ||  '  '";
        
        $label2 = "'TOTAL RETENCIONES A LA FUENTE'";
        
      
        
        $sql = 'SELECT  V.codretair '.$espacio.' as "Codigo", V.tiporetencion as "Concepto de retencion",
                        count(V.codretair) as "Nro.Registros",  SUM(V.baseimpair) as "Base retencion",
                        SUM(V.valretair) as "Valor retenido"
                FROM view_anexos_fuente V
                WHERE  V.baseimpair > 0 and 
                       V.mes      =  '.$this->bd->sqlvalue_inyeccion( $mes ,true).' AND
                       V.registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                       V.anio     = '.$this->bd->sqlvalue_inyeccion(  $anio ,true).'
                GROUP BY V.codretair, V.tiporetencion
                UNION
                SELECT  '.$label1.'  as "Codigo", '.$label2.' as "Concepto de retencion",
                         count(V.codretair) as "Nro.Registros",  SUM(V.baseimpair) as "Base retencion",
                         SUM(V.valretair) as "Valor retenido"
                FROM view_anexos_fuente V
                WHERE  V.baseimpair > 0 and 
                       V.mes = '.$this->bd->sqlvalue_inyeccion($mes ,true).' AND
                       V.registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                       V.anio = '.$this->bd->sqlvalue_inyeccion($anio ,true).' order by 1 desc';
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
    }
    
    //------------------------------------------------
    //------------------------------------------------
    function VentasResumen( $anio,$mes){
        
        echo '<p align="center"> <b>VENTAS </b> </p>';
        
        $label = "'RESUMEN VENTAS PERIODO'";
        $tab        ='';
        $formulario ='';
        
        $cabecera = "CASE WHEN TIPOCOMPROBANTE='18' THEN 'Documentos Autorizados de Vta' WHEN
        TIPOCOMPROBANTE='04' THEN 'Nota de Credito' ELSE 'Nota de Debito' END";
        
        $sql = 'select '.$cabecera.' as "Tipo Comprobante", count(*) as "Nro.Registros",
                    sum(BASEIMPGRAV) as "Base Imponible",
                    sum(BASEIMPONIBLE) as "Base Tarifa Cero",
                    sum(BASENOGRAIVA)  as "Base No sujeta IVA",
                    sum(MONTOIVA)  as "Monto IVA"
            from view_anexos_ventas
            where MES = '.$this->bd->sqlvalue_inyeccion($mes ,true).' AND
                  registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                  ANIO = '.$this->bd->sqlvalue_inyeccion($anio ,true).'
            group by TIPOCOMPROBANTE
            union
            select '.$label.' as "Tipo Comprobante", count(*)   as "Nro.Registros",
                    sum(BASEIMPGRAV)  as "Base Imponible",
                    sum(BASEIMPONIBLE) as "Base Tarifa Cero",
                    sum(BASENOGRAIVA) as "Base No sujeta IVA",
                    sum(MONTOIVA)  as "Monto IVA"
            from view_anexos_ventas
            where MES = '.$this->bd->sqlvalue_inyeccion($mes ,true).' AND
                  registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                  ANIO = '.$this->bd->sqlvalue_inyeccion($anio ,true);
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        return   true;
    }
    //------------------------------------------------
    //------------------------------------------------
    function ComprasResumen( $anio,$mes){
        
        echo '<p align="center"> <b>COMPRAS </b>  </p>';
        
        $label = "'RESUMEN COMPRAS PERIODO'";
        
        $tab        ='';
        $formulario ='';
        
        $sql = 'select comprobante as "Tipo Comprobante", count(*) as "Nro.Registros",
                    sum(baseimpgrav) as "Base Imponible",
                    sum(baseimponible) as "Base Tarifa Cero",
                    sum(basenograiva)  as "Base No sujeta IVA",
                    sum(montoiva)  as "Monto IVA"
            from view_anexos_compras
            where mes = '.$this->bd->sqlvalue_inyeccion($mes ,true).' AND
                  registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                  estado =  '.$this->bd->sqlvalue_inyeccion('S'  ,true).' AND
                  anio = '.$this->bd->sqlvalue_inyeccion($anio ,true).'
            group by comprobante
            union
            select '.$label.' as "Tipo Comprobante", count(*)   as "Nro.Registros",
                    sum(baseimpgrav)  as "Base Imponible",
                    sum(baseimponible) as "Base Tarifa Cero",
                    sum(basenograiva) as "Base No sujeta IVA",
                    sum(montoiva)  as "Monto IVA"
            from view_anexos_compras
            where  mes = '.$this->bd->sqlvalue_inyeccion($mes ,true).' AND
                   estado =  '.$this->bd->sqlvalue_inyeccion('S'  ,true).' AND
                   registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                   anio = '.$this->bd->sqlvalue_inyeccion($anio ,true);
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        return   true;
    }
    /////////////// llena datos de la consulta individual
    function ComprasIva($anio,$mes ){
        
        echo '<p align="center"> <b>RESUMEN DE RETENCIONES DE COMPRAS COMO AGENTES DE RETENCION</b> </p>';
        
        $tab = "' - '";
        
        $formulario = '';
        
        $sql = ' SELECT V.ivaretencion AS "Tipo de Retencion IVA"  ,
                     count(V.ivaretencion) as "Nro.Registros", 
                     SUM(V.baseimpgrav) as "Base Imponible",
                     SUM(V.montoiva) as "Base IVA",
                     SUM(V.retencion) as "Retencion IVA"
            FROM view_anexos_iva V
            WHERE V.mes ='. $this->bd->sqlvalue_inyeccion($mes ,true).' AND 
                  V.registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                  V.anio = '. $this->bd->sqlvalue_inyeccion($anio ,true).'
            GROUP BY V.ivaretencion';
     
        
        $resultado  =  $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        
    }
   
    function VentasIva($anio,$mes ){
        
        echo '<p align="center"> <b>RESUMEN DE RETENCIONES DE VENTAS IVA EFECTUADAS EN EL PERIODO</b> </p>';
        
        $tab = "' - '";
        
        $formulario = "'VENTAS'";
        
        $sql = ' SELECT '.$formulario.' AS "Operacion"  ,
                     count(*) as "Nro.Registros",
                     SUM(valorretrenta) as "RENTA",
                     SUM(valorretbienes) as "Bienes",
                     SUM(valorretservicios) as "Servicios",
                     SUM(iva_retenido) as "IVA",
                     SUM(retenido) as "RETENIDO"
            FROM view_anexos_ventas
            WHERE  mes ='. $this->bd->sqlvalue_inyeccion($mes ,true).' AND
                   registro =  '.$this->bd->sqlvalue_inyeccion( $this->ruc   ,true).' AND
                   retenido > '.$this->bd->sqlvalue_inyeccion( 0  ,true).' AND
                   anio = '. $this->bd->sqlvalue_inyeccion($anio ,true) ;
        
        
        
        
        $resultado  =  $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        
    }

    function Facturacion($anio,$mes ){
        
        echo '<p align="center"> <b>DETALLE DE ENLACE FACTURACION</b> </p>';
        
        $tab = "' - '";
        
        $formulario = "'VENTAS'";
        
        $sql = "SELECT  id_ren_movimiento as movimiento,
        fechap,
        secuencial  || ' ' as factura ,
        idprov   || ' ' as ruc ,
        razon,
        detalle,
        autorizacion  || ' ' as autorizacion ,
        comprobante,
        estado,
        coalesce(base12,0) as base_imponible,
        coalesce(iva,0) as monto_iva,
        coalesce(base0,0) as tarifa_cero,
        coalesce(total,0) AS total
FROM  rentas.view_ren_factura
where  anio = ".$this->bd->sqlvalue_inyeccion( $anio,true)." and  
      mes= ".$this->bd->sqlvalue_inyeccion($mes,true)." and envio = 'S'
order by secuencial desc";
        
        
        
        $resultado  =  $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        
    }
    /*
    */

    function FacturacionTotal($anio,$mes ){
        
        echo '<p align="center"> <b>RESUMEN PERIODO</b> </p>';
        
        $tab = "' - '";
        
        $formulario = "'VENTAS'";
        
        $sql = "SELECT  
        count(*) as nro_registros,
        coalesce(sum(base12),0) as base_imponible,
        coalesce(sum(iva),0) as monto_iva,
        coalesce(sum(base0),0) as tarifa_cero,
        coalesce(sum(total),0) AS total
FROM  rentas.view_ren_factura
where  anio = ".$this->bd->sqlvalue_inyeccion( $anio,true)." and  
      mes= ".$this->bd->sqlvalue_inyeccion($mes,true)." and envio = 'S' ";
        
      
        
        $resultado1  =  $this->bd->ejecutar($sql);
        
        $tipo 		=  $this->bd->retorna_tipo();
        
        $this->obj->grid->KP_GRID_SIMPLE($resultado1,$tipo,'id',$formulario,'N','N','N','N',$tab);
        
        
    }
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
//------ poner informacion en los campos del sistema
if (isset($_GET['mes']))	{
    
    $mes    = $_GET['mes'];
    $anio    = $_GET['anio'];
    
    $gestion->consultaId($mes,$anio) ;
    
    
}


?>
 
  