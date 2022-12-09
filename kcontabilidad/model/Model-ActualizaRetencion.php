<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class componente{
    
    
    public $obj;
    public $bd;
    public $bdFactura;
    public $set;
    
    private $formulario;
    private $evento_form;
    
    
    public $Array_Cabecera;
    public $ArrayTotal;
    public $ArrayAutorizacion;
    
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function componente( ){
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
          
        
    }
    //-----------------------------------------
    function _keyFactura(){
        
        $ADatos = $this->bd->query_array(
            'web_registro',
            'felectronica',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
            );
        
        if ($ADatos['felectronica'] == 'S' ){
            return 1;
        }else{
            return 0;
        }
    }
    //-----------------------------------------
    function _11_ActualizaMovimiento($id ,$idprov  ){
          
        $Array_Cabecera = $this->bd->query_array(
            'view_anexos_compras',
            'anio, mes, idprov, razon, id_compras,   codsustento, tpidprov, tipocomprobante, fecharegistro,
              establecimiento, puntoemision, secuencial, fechaemision, autorizacion, basenograiva, baseimponible,
              baseimpgrav, montoice, montoiva, valorretbienes, valorretservicios, valretserv100, registro,
              porcentaje_iva, baseimpair, pagolocext, paisefecpago, faplicconvdobtrib, formadepago, fechaemiret1,
              serie1, secretencion1, autretencion1, docmodificado, secmodificado, estabmodificado,
               autmodificado, fpagextsujretnorleg, serie, detalle,comprobante,direccion,correo,id_asiento',
             'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true).' and  
              idprov ='.$this->bd->sqlvalue_inyeccion($idprov,true)
            );
        
 
        
        $fecha		 = $this->bd->fecha($Array_Cabecera['fecharegistro']);
        
        $sql = "UPDATE co_asiento_aux
						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion(trim($Array_Cabecera['autretencion1']), true).",
                                retencion=".$this->bd->sqlvalue_inyeccion(trim($Array_Cabecera['secretencion1']), true).",
                                fechap=".$fecha."
 						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). ' and
                               idprov='.$this->bd->sqlvalue_inyeccion($idprov, true) ;
        
        $this->bd->ejecutar($sql);
        
        $ADatos = $this->bd->query_array(
            'web_registro',
            'razon, contacto, correo,direccion,felectronica,estab',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
            );
        
    
        $estab       = trim($ADatos['estab'] ) ;
        
        $serie1 = $estab.'001';
        
        $sql = "UPDATE co_compras
						   SET   formadepago=".$this->bd->sqlvalue_inyeccion('01', true).",
                                 pagolocext=".$this->bd->sqlvalue_inyeccion('01', true).",
                                 faplicconvdobtrib=".$this->bd->sqlvalue_inyeccion('NA', true).",
                                 paisefecpago=".$this->bd->sqlvalue_inyeccion('NA', true).",
                                 fpagextsujretnorLeg=".$this->bd->sqlvalue_inyeccion('NA', true).",
                                 serie1=".$this->bd->sqlvalue_inyeccion($serie1, true).",
                                fechaemiret1=".$fecha."
 						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). ' and
                               idprov ='.$this->bd->sqlvalue_inyeccion($idprov, true) ;
        
        
        $this->bd->ejecutar($sql);
        
        echo json_encode( array("a"=>trim($Array_Cabecera['secretencion1']), 
                                "b"=> trim($Array_Cabecera['autretencion1']) ,
                                "c"=>  ($Array_Cabecera['fecharegistro']) 
                    )  
            );
        
      
        
    }
    
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------
            
            $gestion   = 	new componente;
            
               
            $id                = $_GET['id_asiento'];
           
            $idprov            = $_GET['idprov'];
            
            $gestion->_11_ActualizaMovimiento( $id ,$idprov  );
      



?>
 
 
  