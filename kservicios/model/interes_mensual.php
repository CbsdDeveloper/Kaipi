<?php
session_start( );

class interes_variable{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    
    function interes_variable( $obj, $bd){
      
        
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->anio       =  $_SESSION['anio'];
        
        
    }
    //--------------------------------------------------------------------------------------
       
    //-----------------
    function _prueba(){
        
        $fecha_emision = '2018-05-15';
        $fecha_obligacion = date("Y-m-d",strtotime($fecha_emision."+ 30 days"));
        
        //$fecha_actual  =  date("Y-m-d");
        $anio_actual   =  date("Y");
        $mes_actual    =  date("m");
        
        $monto = 30;
        
        $fecha_temporal = explode('-', $fecha_obligacion);
        $anio_emision = $fecha_temporal[0];
        $mes_emision  = $fecha_temporal[1];
        
        
        if ( $anio_actual == $anio_emision ) {
            
            echo $this->interes_mensual ( $monto,$anio_emision,$mes_emision,$mes_actual );
            
        }
        
        if ( $anio_emision < $anio_actual ) {
            
            $total_anio = $this->interes_anual ( $monto,$anio_emision,$anio_actual );
            
            $total_mes = $this->interes_mensual ( $monto,$anio_actual,$mes_emision,$mes_actual );
            
            echo $total_anio + $total_mes;
        }
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //---   interes_mensual
    //---------------------------------------
    
    function interes_mensual( $monto,$anio_emision,$mes_emision,$mes_actual ){
        
        $x_mensual = $this->bd->query_array('tesoreria.te_interes',
            'sum(monto) porcentaje_interes',
            'anio='.$this->bd->sqlvalue_inyeccion($anio_emision,true). ' and
         mes between '.$this->bd->sqlvalue_inyeccion($mes_emision,true). ' and '.$this->bd->sqlvalue_inyeccion($mes_actual,true)
            );
        
        $monto_interes = $monto  * ($x_mensual['porcentaje_interes']/100);
        
        return  round($monto_interes,2) ;
        
    }
    //----------------
    function interes_mensual_anual( $monto,$anio_emision,$mes_emision,$mes_actual ){
        
        
        
        $x_mensual = $this->bd->query_array('tesoreria.te_interes',
            'sum(monto) porcentaje_interes',
            ' anio  >='.$this->bd->sqlvalue_inyeccion($anio_emision,true)
            );
        
     
 
        $monto_interes = $monto  * ($x_mensual['porcentaje_interes']/100);
        
        return  round($monto_interes,2) ;
        
    }
    //--------------------------------------------------------------------------
    function interes_anual($monto,$anio_emision,$anio_actual){
        
        
        $anio_actual = $anio_actual - 1;
        
        $x_mensual = $this->bd->query_array('tesoreria.view_te_interes_anual',
            'sum(monto) porcentaje_interes',
            'anio between '.$this->bd->sqlvalue_inyeccion($anio_emision,true). ' and '.$this->bd->sqlvalue_inyeccion($anio_actual,true)
            );
        
        
        $monto_interes = $monto  * ($x_mensual['porcentaje_interes']/100);
        
        return  round($monto_interes,2) ;
    }
    
    ///------------------------
    function _arriendo_facturacion($id){
        
        
        $x = $this->bd->query_array('inv_movimiento',
            'estado,fecha,base0, base12',
            'id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true). ' and 
            modulo='.$this->bd->sqlvalue_inyeccion('arriendo',true)
            );
        
        $y = $this->bd->query_array('view_movimiento_det',
            'sum(total) as total',
            'id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true). ' and
             producto<>'.$this->bd->sqlvalue_inyeccion('INTERES',true)
            );
            
     
        $fecha_emision = $x['fecha'];
         
        $fecha_obligacion = date("Y-m-d",strtotime($fecha_emision."+ 15 days"));
       
        
        $anio_actual   =  date("Y");
        $mes_actual    =  date("m");
        
         
        $monto = $y['total'];
         
        $fecha_temporal = explode('-', $fecha_obligacion);
        $anio_emision = $fecha_temporal[0];
        $mes_emision  = $fecha_temporal[1];
       
 
        
        if (  trim($x['estado']) == 'digitado'){
        
                if ( $anio_actual == $anio_emision ) {
                   
                    if ($mes_emision == $mes_actual) {
                        
                        return 0;
                        
                    }else  {
                        
                        return $this->interes_mensual ($monto,$anio_emision,$mes_emision,$mes_actual );
                        
                    }
                }else  {
                    
                   
                    return $this->interes_mensual_anual ($monto,$anio_emision,$mes_emision,$mes_actual );
                    
                }
                
              /*      
                }
                
                if ( $anio_emision < $anio_actual ) {
                    
                  //  $total_anio = $this->interes_anual ($monto,$anio_emision,$anio_actual );
                  
                    $total_anio = 0;
                    
                    $total_mes = $this->interes_mensual ($monto,$anio_actual,$mes_emision,$mes_actual );
                    
                    return $total_anio + $total_mes;
                }
                */
        }
        
       
        
    }
   
}

?>
 
  