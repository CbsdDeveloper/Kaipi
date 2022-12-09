<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


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
        $this->set     = 	new ItemsController;
        $this->bd	   =	new Db;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        
        //-----------------------------
        $this->bdFactura	   =	new Db;
        $this->bdFactura->conectar_sesion();
        
        
        
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
     //-----------------------
    function _02_CodigoAutorizacion( $referencia ,$id, $bandera){
        
        if ( $bandera == 1) {
            $filtro =   'emi01codi   ='.$this->bdFactura->sqlvalue_inyeccion($id,true). " and 
                         coddoc = '07' and 
                         ruc=".$this->bd->sqlvalue_inyeccion($this->ruc,true) ;
        }else{
            $filtro =   'cab_codigo   ='.$this->bdFactura->sqlvalue_inyeccion($referencia,true) . " and 
                         coddoc = '07' and ruc=".$this->bd->sqlvalue_inyeccion($this->ruc,true) ;
        }
        
       
        
        
        $this->ArrayAutorizacion = $this->bdFactura->query_array(
            'spo_cabecera',
            'cab_estado_comprobante,cab_autorizacion,cab_codigo,cab_observacion',
            $filtro
            );
        
        return $this->ArrayAutorizacion ['cab_estado_comprobante'].'  <br>'.$this->ArrayAutorizacion ['cab_observacion'];
        
    }
    //---------------------------
    function _DaCodigo( $id ){
        
        
        $ArrayT = $this->bd->query_array(
            'co_compras',
            'codigoe',
            'id_compras ='.$this->bd->sqlvalue_inyeccion($id,true) 
            );
        
        
        return $ArrayT['codigoe'];
        
    }
    //------------------------
    //-----------------------
    function _Autorizacion( ){
        
        
        return $this->ArrayAutorizacion ['cab_autorizacion'];
        
    }
    
    function _CodFactura( ){
        
        
        return $this->ArrayAutorizacion ['cab_codigo'];
        
    }
    
     
    //-----------------------------------------
    function _GetCabecera( $variable ){
        
        return  $this->Array_Cabecera[$variable];
        
    }
     
    //-----------------------------------------
    function _01_Verifica_estado( $id,$idprov ){
        
        
        
        $ArrayVer = $this->bd->query_array(
            'co_compras',
            "autretencion1",
            "id_compras = ".$this->bd->sqlvalue_inyeccion($id,true)." and 
             registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
       
        
        $estado = trim($ArrayVer['autretencion1']);
        
        $lon = strlen(trim($estado) ) ;
        
        if ($lon >  5){
            
            if (trim($estado) == 'enviada'){
                
                return 'E';
                
            }else {
                
                return 'S';
                
            }
            
        }else{
            
            return 'N';
            
        }
        
        
        
        
        
    }
     
    
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

$gestion   = 	new componente;



$id_compras               = $_GET['id_compras'];
$secuencial               = $_GET['secuencial'];
$idprov                   = $_GET['idprov'];
 
$key       =  $gestion->_keyFactura();
 

if ($key == 1) {
    
    $codFac = $gestion->_DaCodigo($id_compras);
    
    $data = $gestion->_02_CodigoAutorizacion( $codFac,$id_compras,0 );
    
       
    $data = '<h6>'.$data.'</h6>';
    
}else {
    $data = 'Solicite al administrador la parametrizacion para envio de la facturacion electronica ' .$idprov;
}




echo  $data;





?>
 
 
  