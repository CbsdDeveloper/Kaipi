<?php
session_start( );

 
class formulas{
    
    
    private $obj;
    private $bd;
    private $saldos;
    
 
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function formulas( $obj, $bd ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	$obj;
        $this->bd	   =	$bd;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function permisos( $id ){
        
        
        $datosaux  = $this->bd->query_array('rentas.view_catalogo_var',
            'idcatalogo',
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true).' and
			tipo ='.$this->bd->sqlvalue_inyeccion( 'Actividad Negocio',true)
            );
        
        $idcatalogo_a		= $datosaux['idcatalogo'];
 
        $datosaux  = $this->bd->query_array('rentas.view_catalogo_var',
            'idcatalogo',
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true).' and
			tipo ='.$this->bd->sqlvalue_inyeccion( 'Categoria Negocio',true)
            );
        
        $idcatalogo_b		= $datosaux['idcatalogo'];
        
        
        $datosaux  = $this->bd->query_array('rentas.view_catalogo_var',
            'idcatalogo',
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true).' and
			tipo ='.$this->bd->sqlvalue_inyeccion( 'Tipo de Negocio',true)
            );
        
        $idcatalogo_c		= $datosaux['idcatalogo'];
        
        
        
        $datosaux  = $this->bd->query_array('rentas.ren_servicios_cat',
            'valor',
            'idcatalogo1='.$this->bd->sqlvalue_inyeccion($idcatalogo_a,true).' and
			 idcatalogo2 ='.$this->bd->sqlvalue_inyeccion( $idcatalogo_b,true).' and
			 idcatalogo3 ='.$this->bd->sqlvalue_inyeccion( $idcatalogo_c,true)
            );
        
        $valor		= $datosaux['valor'];

        if (empty($valor)){
            $valor ='0.00';
        }
 
        
            return $valor;
            
      
        
    }
    
    
    
}
?>