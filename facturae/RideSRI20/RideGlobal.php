<?php 
/** 
* Copyright (c)2018 - EN Systems Apps
* @abstract Crea Los rides del sri
* @author Erik Niebla
* @mail ep_niebla@hotmail.com, ep.niebla@gmail.com
* @version 1.0
* Fecha de creación  2018-02-27
* http://ensystems.ddns.net
*/
require_once(dirname(__file__).'/libs/fpdf/barCode_2.0.php');

class RideGlobal extends PDF_Code128{
    private $data;
    private $no_logo = 'no_logo.jpg';
    
    public function createPdf($array, $logo_path=null, $option='I'){
        $this->data=$array;
        $datoXml=$array['comprobante'];
        
        $this->newMargin();
        $infTrib= $datoXml['infoTributaria'];
        $code   = $infTrib['claveAcceso'];
        $offline = !$array['online'];
        if($array['autorized']==true) $offline=($array['numeroAutorizacion']==$code);    
        
        $no_logo=dirname(__file__).'/libs/'.$this->no_logo;
        $logo_path=(!isset($logo_path) || empty($logo_path)|| (!file_exists($logo_path) || !is_file($logo_path))? $no_logo : $logo_path);
        $this->centerImageFile( $logo_path ,10,7,105,50);
        
        // A,C,B sets   CODIGO DE BARRA CLAVE DE ACCESO
        $this->SetFont('helvetica','',8.5);
        $this->Code128(118,82,$code,87,10);
        $this->SetXY(119,92);
        $this->Write(4,$code);
        /* Config textos  */
        $this->SetFont('Arial','',9);
        $this->SetLineWidth(0.1);
        $this->SetFillColor(300);

        /*RECTANGULO INFO COMPROBANTE*/
        $this->RoundedRect(118, 10, 86, 65, 3.5, '12','');
        /* DATOS INFO COMPROBANTE */
        $this->SetFont('Arial','B',9);
        $this->Text(121,16,"R.U.C.:");
        $this->SetFont('Arial','',9);
        $this->Text(141,16,$infTrib['ruc']);
        $this->setField(121,34,"No:",'B');
        $this->SetTextColor(194,8,8);
        $this->setField(141,34,"$infTrib[estab]-$infTrib[ptoEmi]-$infTrib[secuencial]",'',9);
        $this->SetTextColor(0,0,0);
        $this->setField(121,41,"NÚMERO DE AUTORIZACIÓN:",'B');
        if($array['numeroAutorizacion']=='PENDIENTE')$this->SetTextColor(194,8,8);
        $this->setField(121,46,$array['numeroAutorizacion'],'',(isset($offline)&&$offline==true?8.34:9));
        $this->SetTextColor(0,0,0);
        if(!empty($array['fechaAutorizacion'])){
            $this->setField(121,54,"FECHA Y HORA DE AUTORIZACIÓN:",'B');
            if($array['fechaAutorizacion']=='PENDIENTE')$this->SetTextColor(194,8,8);
            $this->setField(121,59,$array['fechaAutorizacion']);
            $this->SetTextColor(0,0,0);
        }
        $this->setField(121,67,"AMBIENTE:",'B');
        $this->setField(141,67,$infTrib['ambiente']*1==1?'PRUEBAS':'PRODUCCIÓN');
        $this->setField(121,72,"EMISIÓN:",'B');
        $this->setField(141,72,$infTrib['tipoEmision']*1==1?'NORMAL':'INDISPONIBILIDAD DEL SISTEMA');
        $this->setField(121,80,"CLAVE DE ACCESO:",'B');

        /* RECTANGULO INFO EMPRESA*/
        $this->RoundedRect(10, 58, 106, 38, 3.5, '1', 'DF');
        /* DATOS INFO EMPRESA */

        $this->setField(15,60,'','B',9,null,100);
        $this->SetCWidths(array(106));
        $this->SetFont('Arial','B',9);
        $this->SetCHeight(3);
        $this->Row(array($infTrib['razonSocial']),false,true);
        $this->setField(11,$this->getY()+3,$this->issetText($infTrib,'nombreComercial'),'',8.5,null,100);
        $this->setField(13,78,"DIRECCIÓN:",'B',8);
        $this->setField(38,78,$infTrib['dirMatriz'],'',8,null,78);
        $this->setField(13,81,"DIR. SUCURSAL:",'B',8);
        $this->setField(13,84,"CONTRIBUYENTE ESPECIAL Nro.:",'B',8);
        $this->setField(13,87,"OBLIGADO A LLEVAR CONTABILIDAD:",'B',8);
        
        if(!empty($this->issetText($infTrib,'regimenMicroempresas','')))
            $this->setField(13,92,"CONTRIBUYENTE RÉGIMEN MICROEMPRESAS",'B',8);
        if(!empty($this->issetText($infTrib,'agenteRetencion'))){
            $line=!empty($this->issetText($infTrib,'regimenMicroempresas',''))?95:92;
            $this->setField(13,$line,"AGENTE DE RETÉNCION RES. No.: ",'B',8);
            $this->setField(70,$line, $this->issetText($infTrib,'agenteRetencion','') ,'',8);
        }
        if(!empty($this->issetText($infTrib,'contribuyenteRimpe','')))
            $this->setField(13,95,"CONTRIBUYENTE RÉGIMEN RIMPE",'B',8);

        // NOTA: En los if controlar las versiones, en caso de que el xml haya cambiado
        switch($array['documento']){
            case '01': // FACTURA ELECTRONICA
                if(in_array($array['version'],array( '1.0.0', '1.1.0', '2.0.0', '2.1.0' ))){
                    $this->createFactura($datoXml);
                } break;
            case '03': // LIQUIDACION EN COMPRAS
                if(in_array($array['version'],array( '1.0.0', '1.1.0' ))){
                    $this->createLiquidacion($datoXml);
                } break;
            case '04': // NOTA DE CREDITO
                if(in_array($array['version'],array( '1.0.0', '1.1.0' ))){
                    $this->createNotaCredito($datoXml);
                } break;
            case '05': // NOTA DE DEBITO
                if(in_array($array['version'],array( '1.0.0', '1.1.0' ))){
                    $this->createNotaDebito($datoXml);
                } break;
            case '06': // GUIA DE REMISION
                if(in_array($array['version'],array( '1.0.0', '1.1.0' ))){
                    $this->createGuiaRemi($datoXml);
                } break;
            case '07': // COMPROBANTE DE RETENCION
                if(in_array($array['version'],array( '1.0.0', '1.1.0' ))){
                    $this->createRetencion($datoXml);
                }
                elseif(in_array($array['version'],array( '2.0.0' ))){
                    $this->createRetencion2($datoXml);
                } break;
        }
        $this->setField(165,289, 'Impresion: '.date('Y-m-d H:i:s'),'I',7,null);
        if($option!=false && in_array($option,array('I','D'))){
            $this->Output("$code.pdf", $option);
            exit();
        }
        if($option!=false && $option=='S') return $this->Output("$code.pdf",$option);
        return $this;
    }
    private function createLiquidacion($datoXml){
        $documento="LIQUIDACIÓN DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS";
        /* Inicio Datos Dedicados */
        $infoFact=$datoXml['infoLiquidacionCompra'];
        $this->SetY(19);
        $this->SetX(120);
        $this->SetCAligns('J');
        $this->SetFont('Arial','B',11);
        $this->SetCWidths(array(80));
        $this->Row(array($documento),false,true);
        //$this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoFact,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoFact,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoFact,'obligadoContabilidad','NO') ,'',8);

        /* RECTANGULO INFO PROVEEDOR */
        //$this->RoundedRect(10, 98, 194, 13, 0, '');
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoFact['razonSocialProveedor'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoFact['identificacionProveedor']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(108,108,$infoFact['fechaEmision']);
        if(strlen($this->issetText($infoFact,"direccionProveedor"))>0){
            $this->setField(13,113,"DIRECCIÓN:","B",8);
            $this->setField(40,113,$this->issetText($infoFact,"direccionProveedor"),null,8,null,160);
            $this->RoundedRect(10, 98, 194, 18, 0, "", "");
            $this->SetY(118);
        }else{
            $this->RoundedRect(10, 98, 194, 13, 0, "", "");
            $this->SetY(113);
        }
        $this->createDetalleFactLiqui($datoXml,$infoFact);
    }
    private function createFactura($datoXml){
        $documento="F A C T U R A";
        /* Inicio Datos Dedicados */
        $infoFact=$datoXml['infoFactura'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoFact,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoFact,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoFact,'obligadoContabilidad','NO') ,'',8);

        /* RECTANGULO INFO CLIENTE */
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoFact['razonSocialComprador'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoFact['identificacionComprador']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(108,108,$infoFact['fechaEmision']);
        $this->setField(142,108,"GUÍA DE REMISIÓN:",'B',8);
        $this->setField(172,108, $this->issetText($infoFact, 'guiaRemision'));
        if(strlen($this->issetText($infoFact,"direccionComprador"))>0){
            $this->setField(13,113,"DIRECCIÓN:","B",8);
            $this->setField(40,113,$this->issetText($infoFact,"direccionComprador"),null,8,null,160);
            $this->RoundedRect(10, 98, 194, 18, 0, "", "");
            $this->SetY(118);
        }else{
            $this->RoundedRect(10, 98, 194, 13, 0, "", "");
            $this->SetY(113);
        }
        $this->createDetalleFactLiqui($datoXml,$infoFact);
    }
    private function createDetalleFactLiqui($datoXml,$infoFact){
        $isSubsidio=!empty($this->issetText($infoFact,'totalSubsidio'));
        $totSubsidio=0; $totSinSubsidio=0;
        /*T A B L A */
        $this->SetCHeight(7);
        $this->SetCAligns('C');
        $this->SetFont('Arial','B',8);
        $this->SetCWidths(array(7,17,16,100,21,13,20));
        $this->Row(array('No.','CÓDIGO','CANTIDAD','DESCRIPCIÓN','PRECIO U.','DESC.','TOTAL'),true,false);
        $this->SetFont('Arial','',8);
        $this->SetCFonts(array(array('Arial','',6.5),array('Arial','',6)));
        $this->SetCAligns(array('L','C','C','L','R','R','R'));
        $this->SetCHeight(5);
        foreach($this->formatArray($datoXml['detalles']['detalle'])AS $i=>$deta){
            if($isSubsidio){
                $subs=!empty($this->issetText($deta,'precioSinSubsidio'));
                if($subs){
                    $valSub=round($deta['cantidad']*$deta['precioSinSubsidio'],2)-($deta['precioTotalSinImpuesto']*1);
                    $totSinSubsidio=round($deta['cantidad']*$deta['precioSinSubsidio'],2);
                    $totSubsidio+=$valSub;
                }else $totSinSubsidio+=$deta['precioTotalSinImpuesto'];
                foreach($this->formatArray($deta['impuestos']['impuesto'])AS $i=>$imp){
                    $tarf=$imp["tarifa"]*1; $baseimpn=$imp["baseImponible"]*1;
                    if($tarf>0 && $baseimpn>0){
                        $totSinSubsidio+=($tarf*$baseimpn/100);
                        if($subs && $valSub>0){
                            $totSubsidio+=($tarf*$valSub/100);
                            $totSinSubsidio+=($tarf*$valSub/100);
                        }
                    }
                }
            }
            $this->Row(array(($i+1),trim($this->issetText($deta,'codigoPrincipal')),$deta['cantidad']*1,trim($deta['descripcion']).$this->detallesAdi($deta),$deta['precioUnitario']*1,($deta['descuento']*1)?:'',number_format($deta['precioTotalSinImpuesto'],2) ),true,true);
            $iva=false; foreach($this->formatArray($deta['impuestos']['impuesto'])AS $i=>$imp) if($imp['codigo']=="2"&&$imp["tarifa"]*1>0){ $iva=true; break; } if($iva) $this->Text(184,$this->getY()-1,'*');
        }
        /* iniciamos en cero las variables */
        $iva=array(
            '0'=>array('base'=>0,'valor'=>0),  // 0%
            '1'=>array('base'=>0,'valor'=>0),  // 10%
            '2'=>array('base'=>0,'valor'=>0),  // 12%
            '3'=>array('base'=>0,'valor'=>0),  // 14%
            '6'=>array('base'=>0,'valor'=>0),  // No Objeto Iva
            '7'=>array('base'=>0,'valor'=>0),  // Exento
            'total'=>array('base'=>0,'valor'=>0), //total acumulado
            'baseIva'=>0 // Base grava IVA
        );
        $ice=  array('total'=>array('base'=>0,'valor'=>0));
        $ibnrp=array('total'=>array('base'=>0,'valor'=>0));

        $totImp=$this->formatArray($infoFact['totalConImpuestos']['totalImpuesto']);
        foreach($totImp as $imp){
            if($imp['codigo']=="2"){ // Acumulo IVA
                $iva[$imp['codigoPorcentaje']]['base'] +=((float)$imp['baseImponible']);
                $iva[$imp['codigoPorcentaje']]['valor']+=((float)$imp['valor']);
                $iva['total']['base'] +=((float)$imp['baseImponible']);
                $iva['total']['valor']+=((float)$imp['valor']);
                if(((float)$imp['valor'])>0) $iva['baseIva']+=((float)$imp['baseImponible']);
            }else if($imp['codigo']=="3"){ // Acumulo ICE
                $ice['total']['base'] +=((float)$imp['baseImponible']);
                $ice['total']['valor']+=((float)$imp['valor']);
            }else if($imp['codigo']=="5"){ // Acumulo impuesto botellas no retornables
                $ibnrp['total']['base'] +=((float)$imp['baseImponible']);
                $ibnrp['total']['valor']+=((float)$imp['valor']);
            }
        }
        $total= $iva['total']['base'] + $iva['total']['valor'] +$ibnrp['total']['valor'];
        $otrosRubros=0;
        if(isset($datoXml['otrosRubrosTerceros']))
        foreach($this->formatArray($datoXml['otrosRubrosTerceros']['rubro'])AS $i=>$rubro){
            $otrosRubros+=$rubro['total'];
        }
        //totales
        $this->Ln(3);
        $xAuxTota=$this->GetY();
        $xPageTota=$this->page;
        $this->setX(139);
        $this->SetCAligns(array('L','R'));
        $this->SetCWidths(array(40,25));
        $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8)) );

        $this->Row(array("SUBTOTAL IVA"          ,number_format($iva['baseIva'],2)),true,false);
        $this->Row(array("SUBTOTAL 0%"           ,number_format($iva['0']['base'],2)),true,false);
        if($iva['6']['base']>0)
            $this->Row(array("SUBTOTAL NO SUJETO IVA",number_format($iva['6']['base'],2)),true,false);
        if($iva['7']['base']>0)
            $this->Row(array("EXCENTO DE IVA"    ,number_format($iva['7']['base'],2)),true,false);
        $this->Row(array("SUBTOTAL SIN IMPUESTO" ,number_format((float)$infoFact['totalSinImpuestos'],2)),true,false);
        $this->Row(array("DESCUENTO"             ,number_format((float)$infoFact['totalDescuento'],2)),true,false);
        if($ice['total']['valor']>0)
            $this->Row(array("ICE"               ,number_format($ice['total']['valor'],2)),true,false);
        $this->Row(array("IVA"                   ,number_format($iva['total']['valor'],2)),true,false);
        if($ibnrp['total']['valor']>0)
            $this->Row(array("IRBPNR"            ,number_format($ibnrp['total']['valor'],2)),true,false);
        if($otrosRubros>0)
            $this->Row(array("RUBROS A TERCEROS" ,number_format($otrosRubros,2)),true,false);
        if(isset($infoFact['propina'])&&$infoFact['propina']*1>0)
            $this->Row(array("PROPINA"           ,number_format((float)($infoFact['propina']??'0'),2)),true,false);
        $this->Row(array("TOTAL"                 ,number_format((float)($infoFact['importeTotal']??$total),2)),true,false);
        if($isSubsidio&&$totSubsidio>0){
            $this->centerImageFile( dirname(__file__).'/libs/subsidio.jpg' ,168,$this->GetY()+1,43,6);
            $this->Ln(3); $this->setX(139);
            $this->SetCFonts(array(array('Arial','B',6),array('Arial','',6)) );
            $this->Row(array("(Incluye IVA cuando aplica)",""),false,false);
            $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8)) );
            $this->Row(array("TOTAL SIN SUBSIDIO",number_format($totSinSubsidio,2)),true,false);
            $this->Row(array("AHORRRO POR SUBSIDIO",number_format($totSubsidio,2)),true,false);
        }
        $xAuxFin1=$this->GetY()+2;
        $xAuxPageFin1=$this->page;
        /* Info Adicional */
        $this->page=$xPageTota;
        $this->setY($xAuxTota);
        $this->Ln(2);

        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($this->GetY(),$datoXml['infoAdicional']['campoAdicional']);
        }
        $this->Ln(2);
        if(isset($infoFact['pagos'])){
            $this->pagosDoc($this->GetY(),$infoFact['pagos']['pago']);
        }
        $xAuxFin2=$this->GetY()+2;
        $xAuxPageFin2=$this->page;
        $this->page=($xAuxPageFin2>$xAuxPageFin1?$xAuxPageFin2:$xAuxPageFin1);
        $this->SetY($xAuxPageFin2>$xAuxPageFin1?$xAuxFin2:($xAuxFin1<$xAuxFin2?$xAuxFin2:$xAuxFin1));

        if(isset($datoXml['reembolsos'])){
           $this->Ln(1);
           $pos=$this->GetY();
           if($pos<12) $pos=12;
           $this->SetY($pos);
           $this->SetCFonts(null);
           $this->SetFont("Arial","B",8);
           $this->SetCAligns(array("C","C","C","C","C","C","C","C"));
           $this->SetCWidths(array(194));
           $this->Row(array("DETALLE DE COMPROBANTES REEMBOLSO"),true,false);
           $this->SetCHeight(4);
           $this->SetCWidths(array(15,21,7,25,70,20,15,21));

           $this->Row(array("FECHA","RUC / CI","TIPO","SERIE","AUTORIZACION","BASE","IMPUESTOS","TOTAL"),true,false);
           $this->SetCFonts(array(array("Arial","","7"),array("Arial","","7"),array("Arial","","7"),array("Arial","","7.2"),array("Arial","","7"),array("Arial","","7"),array("Arial","","7"),array("Arial","","7")));
           $this->SetCAligns(array("L","L","C","L","L","R","R","R"));

           foreach($this->formatArray($datoXml['reembolsos']['reembolsoDetalle']) as $reem){
                $basReem=0;
                $impueReem=0;
                $reemImpuest=$this->formatArray($reem['detalleImpuestos']['detalleImpuesto']);
                foreach($reemImpuest as $eReem){
                    if($eReem["codigo"]=="2")
                        $basReem+=(("0".$eReem["baseImponibleReembolso"])*1);
                    $impueReem+=("0".$eReem["impuestoReembolso"])*1;
                }
                $this->row(array(
                    $reem["fechaEmisionDocReembolso"],
                    $reem["identificacionProveedorReembolso"],
                    $reem["codDocReembolso"],
                    $reem["estabDocReembolso"]."-".$reem["ptoEmiDocReembolso"]."-".$reem["secuencialDocReembolso"],
                    $reem["numeroautorizacionDocReemb"],
                    number_format($basReem,2),
                    number_format($impueReem,2),
                    number_format($basReem+$impueReem,2)
                ),true,false);
           }
        }
        if(isset($datoXml['otrosRubrosTerceros'])){
            $this->Ln(1);
            $pos=$this->GetY();
            if($pos<12) $pos=12;
            $this->SetY($pos);
            $this->SetCFonts(null);
            $this->SetFont("Arial","B",8);
            $this->SetCAligns(array("C","C"));
            $this->SetCWidths(array(90));
            $this->Row(array("RUBROS A TERCEROS"),true,false);
            $this->SetCHeight(4);
            $this->SetCWidths(array(65,25));

            $this->Row(array("CONCEPTO","RUBRO"),true,false);
            $this->SetCFonts(array(array("Arial","","7"),array("Arial","","7")));
            $this->SetCAligns(array("L","R"));
            foreach($this->formatArray($datoXml['otrosRubrosTerceros']['rubro'])AS $i=>$rubro){
                $this->Row(array($rubro['concepto'],number_format($rubro['total'],2)),true,false);
            }
        }
        if(isset($infoFact['incoTermFactura'])){
            if(!empty($this->issetText($infoFact,'paisDestino'))&&class_exists(\App\Models\Pais::class)){
                $pais = \App\Models\Pais::where('pais_csri', $this->issetText($infoFact,'paisDestino'))->first();
                if($pais) $infoFact['paisDestino'] = $pais->pais_desc;
            }
            $this->Ln(1);
            $pos=$this->GetY();
            if($pos<12) $pos=12;
            $this->SetY($pos);
            $this->SetCFonts(null);
            $this->SetFont("Arial","B",8);
            $this->SetCAligns("C");
            $this->SetCWidths(array(125));
            $this->Row(array("INCOTERM"),true,false);
            $this->SetCHeight(4);
            $this->SetCAligns(array('L','L','L','R'));
            $this->SetCFonts(array(array("Arial","B","7"),array("Arial","","7"),array("Arial","B","7"),array("Arial","","7")));
            $this->SetCWidths(array(28,97));
            $this->Row(array('Factura :',$this->issetText($infoFact,'incoTermFactura')),true,false);
            $this->SetCWidths(array(28,53,26,18));
            $this->Row(array('Lugar :',$this->issetText($infoFact,'lugarIncoTerm'),'Flete :',number_format($this->issetText($infoFact,'fleteInternacional'),2)),true,false);
            $this->Row(array('Puerto de Embarque :',$this->issetText($infoFact,'puertoEmbarque'),'Seguro :',number_format($this->issetText($infoFact,'seguroInternacional'),2)),true,false);
            $this->Row(array('Pais Destino :',$this->issetText($infoFact,'paisDestino'),'Gastos Aduaneros :',number_format($this->issetText($infoFact,'gastosAduaneros'),2)),true,false);
            $this->Row(array('Puerto Destino :',$this->issetText($infoFact,'puertoDestino'),'Transp - Otros :',number_format($this->issetText($infoFact,'gastosTransporteOtros'),2)),true,false);
        }
    }
    private function createRetencion($datoXml){
        $documento="COMPROBANTE DE RETENCIÓN";
        /* Inicio Datos Dedicados */
        $infoCompRet=$datoXml['infoCompRetencion'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoCompRet,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoCompRet,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoCompRet,'obligadoContabilidad','NO') ,'',8);

        /*RECTANGULO INFO CLIENTE*/
        $this->SetFont('Arial','B',8);
        $this->RoundedRect(10, 98, 194, 13, 0, '');
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoCompRet['razonSocialSujetoRetenido'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoCompRet['identificacionSujetoRetenido']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(110,108,$infoCompRet['fechaEmision']);

        /*T A B L A */
        $this->SetY(113);
        $this->SetCHeight(7);
        $this->SetCAligns('C');
        $this->SetFont('Arial','B',8);
        $this->SetCWidths(array(30,28,22,23,22,22,22,25));
        $this->Row(array('Comprobante','Número','Fecha Emisión','Ejercicio Fiscal','Base Imponible','Impuesto','Porcentaje %','Valor Retenido'),true,false);
        $this->SetFont('Arial','',8);
        $this->SetCAligns(array('C','C','C','C','R','L','C','R'));
        $this->SetCHeight(5);
        $sumaTotal=0;
        foreach ($this->formatArray($datoXml['impuestos']['impuesto'])AS $i=>$impu){
            $sumaTotal+=round(((float)$impu['baseImponible']*(float)$impu['porcentajeRetener'])/100,2);
            $this->Row(array(
                $this->selectDoc($impu['codDocSustento']),$impu['numDocSustento'],$impu['fechaEmisionDocSustento'],$infoCompRet['periodoFiscal'],
                number_format((float)$impu['baseImponible'],2),
                ($impu['codigo']=='1'?'RENTA':($impu['codigo']=='2'?'IVA':'ISD')).'  '.($impu['codigo']!='2'?$impu['codigoRetencion']:$this->ret_iva[$impu['codigoRetencion']]),
                $impu['porcentajeRetener'],
                number_format((float)$impu['valorRetenido'],2)
            ) ,true,false);
        }
        $this->SetFont('Arial','B',8);
        $this->Cell(144);
        $this->Cell(25,5,'TOTAL:',0,0,'R');
        $this->Cell(25,5,number_format($sumaTotal,2),1,0,'R');

        /* Info Adicional */
        $this->Ln(10);
        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($this->GetY(),$datoXml['infoAdicional']['campoAdicional']);
        }
    }
    private function createRetencion2($datoXml){
        $documento="COMPROBANTE DE RETENCIÓN";
        /* Inicio Datos Dedicados */
        $infoCompRet=$datoXml['infoCompRetencion'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoCompRet,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoCompRet,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoCompRet,'obligadoContabilidad','NO') ,'',8);

        /*RECTANGULO INFO CLIENTE*/
        $this->SetFont('Arial','B',8);
        $this->RoundedRect(10, 98, 194, 13, 0, '');
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoCompRet['razonSocialSujetoRetenido'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoCompRet['identificacionSujetoRetenido']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(110,108,$infoCompRet['fechaEmision']);

        /*T A B L A */
        $this->SetY(113);
        $this->SetCHeight(7);
        $this->SetCAligns('C');
        $this->SetFont('Arial','B',8);
        $this->SetCWidths(array(30,28,22,23,22,22,22,25));
        $this->Row(array('Comprobante','Número','Fecha Emisión','Ejercicio Fiscal','Base Imponible','Impuesto','Porcentaje %','Valor Retenido'),true,false);
        $this->SetFont('Arial','',8);
        $this->SetCAligns(array('C','C','C','C','R','L','C','R'));
        $this->SetCHeight(5);
        $sumaTotal=0;
        foreach ($this->formatArray($datoXml['docsSustento']['docSustento'])AS $doc){
            foreach ($this->formatArray($doc['retenciones']['retencion'])AS $impu){
                $sumaTotal+=round(((float)$impu['baseImponible']*(float)$impu['porcentajeRetener'])/100,2);
                $this->Row(array(
                    $this->selectDoc($doc['codDocSustento']),$doc['numDocSustento'],$doc['fechaEmisionDocSustento'],$infoCompRet['periodoFiscal'],
                    number_format((float)$impu['baseImponible'],2),
                    ($impu['codigo']=='1'?'RENTA':($impu['codigo']=='2'?'IVA':'ISD')).'  '.($impu['codigo']!='2'?$impu['codigoRetencion']:$this->ret_iva[$impu['codigoRetencion']]),
                    $impu['porcentajeRetener'],
                    number_format((float)$impu['valorRetenido'],2)
                ) ,true,false);
            }
        }
        $this->SetFont('Arial','B',8);
        $this->Cell(144);
        $this->Cell(25,5,'TOTAL:',0,0,'R');
        $this->Cell(25,5,number_format($sumaTotal,2),1,0,'R');

        /* Info Adicional */
        $this->Ln(10);
        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($this->GetY(),$datoXml['infoAdicional']['campoAdicional']);
        }
    }
    private function createNotaCredito($datoXml){
        $documento="N O T A       DE       C R É D I T O";
        /* Inicio Datos Dedicados */
        $infoNCred=$datoXml['infoNotaCredito'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoNCred,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoNCred,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoNCred,'obligadoContabilidad','NO') ,'',8);

        /* RECTANGULO INFO CLIENTE */
        $this->RoundedRect(10, 98, 194, 30, 0, '');
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoNCred['razonSocialComprador'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoNCred['identificacionComprador']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(110,108,$infoNCred['fechaEmision']);

        //(inicio X, inicio Y,fin X, fin Y)
        $this->Line(13,110,200,110);

        $this->setField(13,115,"COMPROBANTE QUE SE MODIFICA:",'B');
        $this->setField(95,115, $this->selectDoc($infoNCred['codDocModificado']).' - '.$infoNCred['numDocModificado']);
        $this->setField(13,120,"FECHA DE EMISIÓN (Comprobante a modificar):",'B');
        $this->setField(95,120,$infoNCred['fechaEmisionDocSustento']);
        $this->setField(13,125,"RAZON DE MODIFICACIÓN:",'B');
        $this->setField(58,125,$infoNCred['motivo'],null,null,null,140);

        /*T A B L A */
        $this->SetY(131);
        $this->SetCHeight(7);
        $this->SetCAligns('C');
        $this->SetFont('Arial','B',8);
        $this->SetCWidths(array(8,15,106,20,23,22));
        $this->Row(array('No.','CÓDIGO','DESCRIPCIÓN','CANTIDAD','PRECIO U.','TOTAL'),true,false);
        $this->SetFont('Arial','',8);
        $this->SetCAligns(array('L','C','L','C','R','R'));
        $this->SetCHeight(5);
        foreach ($this->formatArray($datoXml['detalles']['detalle'])AS $i=>$deta){
                $this->Row(array(($i+1),$this->issetText($deta,'codigoAdicional'),$deta['descripcion'].$this->detallesAdi($deta),$deta['cantidad'],$deta['precioUnitario'],number_format((float)$deta['cantidad']*(float)$deta['precioUnitario'],2)  ) ,true,false);
        }

        /* iniciamos en cero las variables */
        $iva=array(
            '0'=>array('base'=>0,'valor'=>0),  // 0%
            '1'=>array('base'=>0,'valor'=>0),  // 10%
            '2'=>array('base'=>0,'valor'=>0),  // 12%
            '3'=>array('base'=>0,'valor'=>0),  // 14%
            '6'=>array('base'=>0,'valor'=>0),  // No Objeto Iva
            '7'=>array('base'=>0,'valor'=>0),  // Exento
            'total'=>array('base'=>0,'valor'=>0), //total acumulado
            'baseIva'=>0 // Base grava IVA
        );
        $ice=  array('total'=>array('base'=>0,'valor'=>0));
        $ibnrp=array('total'=>array('base'=>0,'valor'=>0));

        $totImp=$this->formatArray($infoNCred['totalConImpuestos']['totalImpuesto']);
        foreach($totImp as $imp){
            if($imp['codigo']=="2"){ // Acumulo IVA
                $iva[$imp['codigoPorcentaje']]['base'] +=((float)$imp['baseImponible']);
                $iva[$imp['codigoPorcentaje']]['valor']+=((float)$imp['valor']);
                $iva['total']['base'] +=((float)$imp['baseImponible']);
                $iva['total']['valor']+=((float)$imp['valor']);
                if(((float)$imp['valor'])>0) $iva['baseIva']+=((float)$imp['baseImponible']);
            }else if($imp['codigo']=="3"){ // Acumulo ICE
                $ice['total']['base'] +=((float)$imp['baseImponible']);
                $ice['total']['valor']+=((float)$imp['valor']);
            }else if($imp['codigo']=="5"){ // Acumulo impuesto botellas no retornables
                $ibnrp['total']['base'] +=((float)$imp['baseImponible']);
                $ibnrp['total']['valor']+=((float)$imp['valor']);
            }
        }
        $total= $iva['total']['base'] + $iva['total']['valor'];

        //totales
        $alto_totales=40;
        $this->Ln(3);
        $this->setX(139);
        $this->SetCAligns(array('L','R'));
        $this->SetCWidths(array(40,25));
        $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8)) );

        $this->Row(array("SUBTOTAL IVA"          ,number_format($iva['baseIva'],2)),true,false);
        $this->Row(array("SUBTOTAL 0%"           ,number_format($iva['0']['base'],2)),true,false);
        $this->Row(array("SUBTOTAL NO SUJETO IVA",number_format($iva['6']['base'],2)),true,false);
        $this->Row(array("SUBTOTAL SIN IMPUESTO" ,number_format((float)$infoNCred['totalSinImpuestos'],2)),true,false);
        $this->Row(array("DESCUENTO"             ,number_format(/*(float)$infoNCred['totalDescuento']*/0,2)),true,false);
        $this->Row(array("ICE"                   ,number_format($ice['total']['valor'],2)),true,false);
        $this->Row(array("IVA"                   ,number_format($iva['total']['valor'],2)),true,false);
        $this->Row(array("TOTAL"                 ,number_format($total,2)),true,false);

        /* Info Adicional */
        $this->Ln(2);
        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($this->GetY()-$alto_totales,$datoXml['infoAdicional']['campoAdicional']);
        }
    }
    private function createNotaDebito($datoXml){
        $documento="N O T A        DE        D É B I T O";
        /* Inicio Datos Dedicados */
        $infoNDeb=$datoXml['infoNotaDebito'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoNDeb,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoNDeb,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoNDeb,'obligadoContabilidad','NO') ,'',8);

        /* RECTANGULO INFO CLIENTE */
        $this->RoundedRect(10, 98, 194, 25, 0, '');
        $this->setField(13,103,"RAZÓN SOCIAL:",'B',8);
        $this->setField(40,103,$infoNDeb['razonSocialComprador'],null,null,null,160);
        $this->setField(13,108,"RUC / CI:",'B',8);
        $this->setField(30,108,$infoNDeb['identificacionComprador']);
        $this->setField(75,108,"FECHA DE EMISIÓN:",'B',8);
        $this->setField(110,108,$infoNDeb['fechaEmision']);

        //(inicio X, inicio Y,fin X, fin Y)
        $this->Line(13,110,200,110);

        $this->setField(13,115,"COMPROBANTE QUE SE MODIFICA:",'B');
        $this->setField(95,115,$this->selectDoc($infoNDeb['codDocModificado']).' - '.$infoNDeb['numDocModificado']);
        $this->setField(13,120,"FECHA DE EMISIÓN (Comprobante a modificar):",'B');
        $this->setField(95,120,$infoNDeb['fechaEmisionDocSustento']);


        /*T A B L A */
        $this->SetY(126);
        $this->SetCHeight(7);
        $this->SetCAligns('C');
        $this->SetFont('Arial','B',9);
        $this->SetCWidths(array(8,136,50));
        $this->Row(array('No.','RAZON DE LA MODIFICACION','VALOR DE LA MODIFICACIÓN'),true,false);
        $this->SetFont('Arial','',8);
        $this->SetCAligns(array('L','L','R'));
        $this->SetCHeight(5);
        foreach($this->formatArray($datoXml['motivos']['motivo'])AS $i=>$deta){
            $this->Row(array(($i+1),$deta['razon'],$deta['valor']  ) ,true,false);
        }

        /* iniciamos en cero las variables */
        $baseImp0=0; $valorImp0=0;
        $baseImp12=0; $valorImp12=0;
        $baseNoObjeto=0; $valorNoObjeto=0;
        $baseExento=0; $valorExento=0;
        $valorIce=0;

        $totImp=$this->formatArray($infoNDeb['impuestos']['impuesto']);
        for($x=0;$x<count($totImp);$x++){
            if ($totImp[$x]['codigo']=="2" || $totImp[$x]['codigo']=="3"){ /* IVA */
                if ($totImp[$x]['codigoPorcentaje']=="0"){  /* IVA 0%*/
                    $baseImp0=(float)$totImp[$x]['baseImponible'];
                    $valorImp0=(float)$totImp[$x]['valor'];
                }
                if ($totImp[$x]['codigoPorcentaje']=="2"){ /* IVA 12%*/
                    $baseImp12=(float)$totImp[$x]['baseImponible'];
                    $valorImp12=(float)$totImp[$x]['valor'];
                }
                if ($totImp[$x]['codigoPorcentaje']=="3"){ /* IVA 14%*/
                    $baseImp12=(float)$totImp[$x]['baseImponible'];
                    $valorImp12=(float)$totImp[$x]['valor'];
                }
                if ($totImp[$x]['codigoPorcentaje']=="6"){ /* No Objeto de Impuesto */
                    $baseNoObjeto=(float)$totImp[$x]['baseImponible'];
                    $valorNoObjeto=(float)$totImp[$x]['valor'];
                }
                if ($totImp[$x]['codigoPorcentaje']=="7"){ /* Exento de IVA */
                    $baseExento=(float)$totImp[$x]['baseImponible'];
                    $valorExento=(float)$totImp[$x]['valor'];
                }
            }
            if($totImp[$x]['codigo']=="3"){ /* ICE */
                $valorIce= $valorIce + (float)$totImp[$x]['valor']; /* SUMA TODOS LOS ICE */
            }
        }
        $total=((float)$infoNDeb['totalSinImpuestos'] )+ (float)$valorIce + (float)$valorImp12;

        //totales
        $alto_totales=40;
        $this->Ln(3);
        $this->setX(139);
        $this->SetCAligns(array('L','R'));
        $this->SetCWidths(array(40,25));
        $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8)) );

        $this->Row(array("SUBTOTAL IVA"          ,number_format($baseImp12,2)),true,false);
        $this->Row(array("SUBTOTAL 0%"           ,number_format($baseImp0,2)),true,false);
        $this->Row(array("SUBTOTAL NO SUJETO IVA",number_format($baseNoObjeto,2)),true,false);
        $this->Row(array("SUBTOTAL SIN IMPUESTO" ,number_format((float)$infoNDeb['totalSinImpuestos'],2)),true,false);
        $this->Row(array("DESCUENTO"             ,number_format(/*(float)$infoNDeb['totalDescuento']*/0,2)),true,false);
        $this->Row(array("ICE"                   ,number_format($valorIce,2)),true,false);
        $this->Row(array("IVA"                   ,number_format($valorImp12,2)),true,false);
        $this->Row(array("TOTAL"                 ,number_format($total,2)),true,false);

        /* Info Adicional */
        $this->Ln(2);
        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($this->GetY()-$alto_totales,$datoXml['infoAdicional']['campoAdicional']);
        }

        $this->Ln(4);
        if(isset($infoNDeb['pagos'])){
            $this->pagosDoc($this->GetY(),$infoNDeb['pagos']['pago']);
        }

    }
    private function createGuiaRemi($datoXml){
        $documento="GUIA  DE  REMISIÓN";
        /* Inicio Datos Dedicados */
        $infoGuia=$datoXml['infoGuiaRemision'];
        $this->setField(121,25,$documento,'B',12);
        $this->setField(38,81, $this->issetText($infoGuia,'dirEstablecimiento'),'',8,null,74);
        $this->setField(70,84, $this->issetText($infoGuia,'contribuyenteEspecial','NO') ,'',8);
        $this->setField(70,87, $this->issetText($infoGuia,'obligadoContabilidad','NO') ,'',8);

        /* RECTANGULO INFO TRANSPORTISTA*/
        $this->RoundedRect(10, 98, 194, 27, 0, '');
        /* DATOS INFO TRANSPORTISTA */
        $this->setField(13,103,"IDENTIFICACIÓN (TRANSPORTÍSTA):",'B',8);
        $this->setField(75,103,$infoGuia['rucTransportista'],'',8);
        $this->setField(13,108,"RAZÓN SOCIAL / NOMBRES Y APELLIDOS:",'B',8);
        $this->setField(75,108,$infoGuia['razonSocialTransportista'],'',8);
        $this->setField(13,113,"PLACA:",'B',8);
        $this->setField(75,113,$infoGuia['placa'],'',8);
        $this->setField(13,118,"PUNTO DE PARTIDA:",'B',8);
        $this->setField(75,118,$infoGuia['dirPartida'],'',8,null,127);
        $this->setField(13,123,"FECHA SALIDA TRANSPORTE:",'B',8);
        $this->setField(115,123,"FECHA LLEGADA TRANSPORTE:",'B',8);
        $this->setField(75,123, $infoGuia['fechaIniTransporte'],'',8);
        $this->setField(166,123,$infoGuia['fechaFinTransporte'],'',8);

        $iapos=129;
        /* recorro los destinatarios */
        foreach($this->formatArray($datoXml['destinatarios']['destinatario']) AS $desti){

            if($this->CheckPageBreak(54)){ $this->newMargin(); $iapos=10; }
            $this->setY($iapos);

            $detalles=$this->formatArray($desti['detalles']['detalle']);
            $intemPos=(count($detalles)+1)*5;
            $this->RectCof(10, $iapos-2,194,54, 'TLR');
            ///$this->RoundedRect(10, $iapos-2 , 194, 53+$intemPos, 0, '');

            $this->setField(13,$iapos+2,"COMPROBANTE DE VENTA:",'B',8);
            $this->setField(132,$iapos+2,"FECHA DE EMISIÓN:",'B',8);
            $this->setField(13,$iapos+7,"NÓMERO DE AUTORIZACIÓN:",'B',8);

            $this->setField(75,$iapos+2, (!isset($desti['numDocSustento'])||empty($desti['numDocSustento']))?'': $this->selectDoc($desti['codDocSustento'])." - ".$desti['numDocSustento'],'',8);
            $this->setField(166,$iapos+2, $this->issetText($desti,'fechaEmisionDocSustento'));
            $this->setField(75,$iapos+7,  $this->issetText($desti,'numAutDocSustento'));

            $this->setField(13,$iapos+12,"MOTIVO DE TRASLADO:",'B',8);
            $this->setField(75,$iapos+12,strtoupper($desti['motivoTraslado']),'',8,null,127);

            $this->setField(13,$iapos+17,"DESTINO (PUNTO DE LLEGADA):",'B',8);
            $this->setField(75,$iapos+17,strtoupper($desti['dirDestinatario']),'',8,null,127);

            $this->setField(13,$iapos+22,"IDENTIFICACIÓN (DESTINATARIO):",'B',8);
            $this->setField(75,$iapos+22,strtoupper($desti['identificacionDestinatario']),'',8);

            $this->setField(13,$iapos+27,"RAZÓN SOCIAL / NOMBRES Y APELLIDOS:",'B',8);
            $this->setField(75,$iapos+27,strtoupper($desti['razonSocialDestinatario']),'',8);

            $this->setField(13,$iapos+32,"DOCUMENTO ADUANERO:",'B',8);
            $this->setField(75,$iapos+32,strtoupper($this->issetText($desti,'docAduaneroUnico')),'',8);

            $this->setField(13,$iapos+37,"CÓDIGO ESTABLECIMIENTO DESTINO:",'B',8);
            $this->setField(75,$iapos+37,strtoupper($this->issetText($desti,'codEstabDestino')),'',8);

            $this->setField(13,$iapos+42,"RUTA:",'B',8);
            $this->setField(75,$iapos+42,strtoupper($this->issetText($desti,'ruta')),'',8,null,127);

            /* Tabla Itemas */
            $this->setY($iapos+47);
            $this->setX(12);
            $this->SetFont('Arial','B',8);
            $this->SetCWidths(array(8,22,28,132));
            $this->SetCAligns(array());
            $this->Row(array('No','CÓD. PRINCIPAL','CANTIDAD','DESCRIPCIÓN'),true,false);
            $this->SetCAligns(array(null,'C','R',null));
            $this->SetFont('Arial','',8);
            /* recorro los items */
            $this->setX(12);
            foreach($detalles AS $i=>$deta){
                //$this->setX(12);
                $this->RectCof(10, $this->GetY(), 194, 5, 'LR');
                $this->Row(array($i+1,$deta['codigoInterno'],$deta['cantidad'],$deta['descripcion'].$this->detallesAdi($deta)),true,false);
            }
            $this->RectCof(10, $this->GetY(), 194, 3, 'LRB');
            $iapos=$this->GetY()+10;
        }

        /* Info Adicional */
        if(isset($datoXml['infoAdicional'])){
            $this->infoAddi($iapos,$datoXml['infoAdicional']['campoAdicional']);
        }
    }
    /* FUNCIONES GLOBALES */
    // campos indefinidos
    private function issetText($obj,$col,$def=''){ return isset($obj[$col])?(is_string($obj[$col])?$this->unicode2html($obj[$col]):$obj[$col]):$def; }
    // Info Adicional
    private function infoAddi($pos,$dato){
        if($pos<12) $pos=12;
        $this->setY($pos+2);
        $this->setField(14,null,"INFORMACIÓN ADICIONAL",'B',9,3);
        $this->RoundedRect(10, $this->getY()-7 , 125, 6, 0, '');
        $this->SetCHeight(3);
        $this->SetCWidths(array(35,90));
        $this->SetCAligns(array());
        $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8)));
        $this->RectCof(10, $this->GetY()-1, 125, 1, 'LR');
        foreach($this->formatArray($dato) AS $v){
            $h=$this->Row(array($v['@attributes']['nombre'].(trim($v['@attributes']['nombre'])==''?'':':'),$v['@value'].''));
            $this->RectCof(10, $this->GetY()-$h, 125, $h, 'LR');
        }
        $this->RectCof(10, $this->GetY(), 125, 1, 'LRB');
        $this->SetCHeight(5);
    }
    // Pagos documentos
    private function pagosDoc($pos,$dato){
        $tipos=array(
            '01'=>"SIN UTILIZACION DEL SISTEMA FINANCIERO",
            '15'=>"COMPENSACIÓN DE DEUDAS",
            '16'=>"TARJETA DE DÉBITO",
            '17'=>"DINERO ELECTRÓNICO",
            '18'=>"TARJETA PREPAGO",
            '19'=>"TARJETA DE CRÉDITO",
            '20'=>"OTROS CON UTILIZACION DEL SISTEMA FINANCIERO",
            '21'=>"ENDOSO DE TÍTULOS"
        );
        if($pos<12) $pos=12;
        $this->setY($pos+2);
        $this->SetCWidths(array(7,75,23,20));
        $this->SetCAligns('C');
        $this->SetCFonts(array(array('Arial','B',7),array('Arial','B',8),array('Arial','B',8),array('Arial','B',8)));
        $this->Row(array('COD','FORMA DE PAGO','VALOR','PLAZO') ,true,false);
        $this->SetCFonts(array(array('Arial','B',8),array('Arial','',8),array('Arial','',8),array('Arial','',8)));
        $this->SetCAligns(array('C','L','R','L'));
        foreach($this->formatArray($dato) AS $v){
            $this->Row(array($v['formaPago'],$this->issetText($tipos,$v['formaPago'],'NO DEFINIDO'),number_format($v['total'],2), $this->issetText($v,'plazo').' '.$this->issetText($v,'unidadTiempo') ) ,true,false);
        }
    }
    // Detalles adicionales productos
    private function detallesAdi($deta,$key='detallesAdicionales'){
        $str=' ';
        if(!is_array($deta)||!count($deta)||!is_array($deta[$key]??false)) return '';
        if(isset($deta[$key])) foreach($this->formatArray($deta[$key]['detAdicional']) AS $v) $str.="[".$v['@attributes']['nombre'].":".$v['@attributes']['valor']."] ";
        return $str;
    }
    // Seleccionar tipo de documento
    private function selectDoc($cod){
        $docs=array(
            '01'=>"FACTURA",
            '02'=>"NOTA O BOLETA DE VENTA",
            '03'=>"LIQUIDACION DE COMPRAS",
            '04'=>"NOTA DE CREDITO",
            '05'=>"NOTA DE DEBITO",
            '11'=>"PASAJES DE AVIACION",
            '16'=>"F. UNICO EXPORTACION",
            '17'=>"D. UNICO IMPORTACION",
            '41'=>"DOC. REEMBOLSOS",
        );
        return $this->issetText($docs,$cod,'NO DEFINIDO');
    }
}