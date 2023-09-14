<?php
/**
* Copyright (c)2018 - EN Systems Apps
* @abstract Lee los xml y envia a crear los pdfs
* @author Erik Niebla
* @mail ep_niebla@hotmail.com, ep.niebla@gmail.com
* @version 1.0
* Fecha de creación  2018-02-27
* http://ensystems.ddns.net
*/
require_once dirname(__FILE__)."/RideGlobal.php"; // Libreria para el pdf
require_once dirname(__FILE__)."/libs/xml/XML2Array.php"; // convierte el xml a un array

class RideSRI
{
    public function createRide($file_xml, $logo_path=null, $option='I', $online=false)
    {
        $doc=$this->getXmlArray($file_xml, $online);
        if($doc['success']==false) throw new Exception($doc['message']);
        if($doc['autorized']==false) $doc['online']=$online;
        $pdf = new RideGlobal();
        return $pdf->createPdf($doc, $logo_path, $option, $online);
    }
    public static function unCleanEspecialCharacters(&$input){
        if (is_string($input)){
            $input=html_entity_decode($input, ENT_QUOTES | ENT_HTML5);
        } else if (is_array($input)) {
            foreach ($input as &$value) { self::unCleanEspecialCharacters($value); } unset($value);
        } else if (is_object($input)) { $vars = array_keys(get_object_vars($input)); foreach ($vars as $var) { self::unCleanEspecialCharacters($input->$var); } }
    }
    public static function cleanErrorCDATA($file_xml){ $matches=[];
        preg_match('/<comprobante><!\[CDATA\[(.*)]]><\/comprobante>/s',$file_xml,$matches,PREG_OFFSET_CAPTURE,0);
        if($matches[1]??false){ $matches2=[];
            $file_xml=str_replace($matches[1][0],$matches[1][0]=str_replace(']]><![CDATA[','',$matches[1][0]),$file_xml);
            preg_match_all('/<!\[CDATA\[(.*)]]>/sU',$matches[1][0],$matches2,PREG_SET_ORDER,0);
            if($matches2?:false) foreach($matches2 as $match) $file_xml=str_replace($match[0],trim(str_ireplace([chr(13).chr(10), "\r\n", "\n", "\r",'&',"'","\"", '<', '>'],[" ", " ", " ", " ","&amp;", "&apos;", "&quot;", "&lt;", "&gt;"],$match[1])),$file_xml);
        } return $file_xml;
    }
    public static function getXmlArray($file_xml,$online=false){
        $result=array('success'=>true, 'autorized'=>false, 'online'=>false, 'comprobante'=>null, 'claveAcceso'=>null, 'numeroAutorizacion'=>'PENDIENTE', 'fechaAutorizacion'=>'PENDIENTE');
        try{
            $is_readable=!empty($file_xml)&&strlen($file_xml)<4096&&is_readable($file_xml);
            $aux_xml=self::cleanErrorCDATA($is_readable?file_get_contents($file_xml):$file_xml);
            $xml=!mb_detect_encoding($aux_xml,'UTF-8',true)?mb_convert_encoding($aux_xml,'UTF-8','ISO-8859-1'):$aux_xml;
            if(!empty($xml)){
                libxml_use_internal_errors(true);
                $sxe=simplexml_load_string($xml);
                if(!$sxe){
                    $str="";
                    foreach(libxml_get_errors() as $error) $str.=("\t".$error->message);
                    return array('success'=>false,'message'=>'No se pudo interpretar el xml!.\n'.$str,'type'=>'setter');
                }
            }else return array('success'=>false,'message'=>'No se especifico la ruta del archivo xmls o estaba vacio!','type'=>'setter');
            $sri=XML2Array::createArray($xml);
            if(isset($sri['autorizacion'])){
                $result['autorized'] = true;
                $comp=XML2Array::createArray($sri['autorizacion']['comprobante']["@cdata"]);
                $result['comprobante']=$comp[key($comp)];
                $result['numeroAutorizacion']= $sri['autorizacion']['numeroAutorizacion'];
                if(!empty($sri['autorizacion']['fechaAutorizacion']["@value"])) $result['fechaAutorizacion'] = substr($sri['autorizacion']['fechaAutorizacion']["@value"],0,10).'  '.substr($sri['autorizacion']['fechaAutorizacion']["@value"],11,8);
                else if(is_string($sri['autorizacion']['fechaAutorizacion']) ) $result['fechaAutorizacion'] = substr($sri['autorizacion']['fechaAutorizacion'],0,10).'  '.substr($sri['autorizacion']['fechaAutorizacion'],11,8);
                $result['online'] = !($result['comprobante']['infoTributaria']['claveAcceso']==$result['numeroAutorizacion']);
            }else{
                $result['comprobante']=$sri[key($sri)];
                $result['online']=$online;

                if($online==false){
                    $result['numeroAutorizacion']=$result['comprobante']['infoTributaria']['claveAcceso'];
                    $result['fechaAutorizacion']="PENDIENTE";
                }
            }
            $result['claveAcceso']=$result['comprobante']['infoTributaria']['claveAcceso'];
            $result['documento']=substr($result['claveAcceso'],8,2);
            $result['version']=$result['comprobante']['@attributes']['version'];
            self::unCleanEspecialCharacters($result['comprobante']);
        }catch (Exception $e) {
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application');
        } return $result;
    }
}