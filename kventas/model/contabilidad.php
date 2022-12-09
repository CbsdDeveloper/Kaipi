<?php
session_start( );

 
class conta{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function conta( ){
        //inicializamos la clase para conectarnos a la bd
       
        $this->ruc       =     $_SESSION['ruc_registro'];
        $this->sesion 	 =     $_SESSION['email'];
        $this->hoy 	     =      date("Y-m-d");
       
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function db($Db){
        //inicializamos la clase para conectarnos a la bd
        $this->bd	   =	$Db ;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function periodo($fecha ){
        //inicializamos la clase para conectarnos a la bd
  
        
        $array_fecha   = explode("-", $fecha);
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];
          
        //------------ seleccion de periodo
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                 anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                  mes  ='.$this->bd->sqlvalue_inyeccion($mes ,true)
            );
        
        $id_periodo = $periodo_s['id_periodo'];
        
        if ( $id_periodo) {
            
            return $id_periodo;
            
        }else{
            
            return  '0' ;
        }
 
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function iva_ventas(  ){
        
        $ACuentaIVA = $this->bd->query_array( 'co_catalogo',
            'cuenta',
            'secuencia='.$this->bd->sqlvalue_inyeccion(123,true)
            );
        
        $acuenta_iva = $ACuentaIVA['cuenta'];
        
        if ( $acuenta_iva) {
            
            $nn = $this->valida_cuenta($acuenta_iva);
            
            if ( $nn == 1){
                
                return $acuenta_iva;
                
            }else{
                
                return  '0' ;
                
            }
              
        }else{
            
            return  '0' ;
        }
        
        
        
    }
 
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function valida_cuenta($cuenta){
        
        
        $ACuenta = $this->bd->query_array('co_plan_ctas',
            'count(*) as nn',
            'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
             cuenta ='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
             registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        $valida = $ACuenta['nn'];
        
        if ( $valida > 0 ) {
            
            return 1;
            
        }else{
            
            return  0 ;
        }
        
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function cuentaxcobrar(   ){
     
        $ACuentaCxC = $this->bd->query_array('co_plan_ctas',
            'cuenta',
            'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
             tipo_cuenta ='.$this->bd->sqlvalue_inyeccion('C',true).' and
             registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        $acuentacxc = $ACuentaCxC['cuenta'];
        
        if ( $acuentacxc) {
            
            return $acuentacxc;
            
        }else {
            
            return  '0' ;
            
        }
       
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
   
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
     
        
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 

 


?>
 
  