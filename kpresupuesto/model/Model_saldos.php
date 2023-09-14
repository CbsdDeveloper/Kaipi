<?php
session_start( );

class saldo_presupuesto{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $saldos;
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function saldo_presupuesto( $obj, $bd){
         
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------------------------------------------------------
    //SALDOS PRESUPUESTARIOS DE GASTOS A LA FECHA
    
    function _saldo_gasto($anio){
      
        
        // ANALISIS REFORMAS A LA FECHA
        
         $this->_inicial_nulo( $anio );
        
         
        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET certificado  =  ".$this->bd->sqlvalue_inyeccion(0,true).",
                                 compromiso   = ".$this->bd->sqlvalue_inyeccion(0,true) .",
                                 pagado       = ".$this->bd->sqlvalue_inyeccion(0,true) .",
                                 aumento      = ".$this->bd->sqlvalue_inyeccion(0,true).",
                                 disminuye    = ".$this->bd->sqlvalue_inyeccion(0,true) .",
                                 devengado    = ".$this->bd->sqlvalue_inyeccion(0,true) ."
                           where tipo = 'G' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
         
        $this->bd->ejecutar($sqlEditPre);


        $this->Reformas_saldo( $anio, "G" )   ;
        
        //---------------------------------
        $sql_det = 'SELECT partida, 
                           sum(certificado) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and 
                         estado = '.$this->bd->sqlvalue_inyeccion('3', true).' 
                group by  partida 
                order by partida';
        
        $stmt13 = $this->bd->ejecutar($sql_det);
          
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']) ; 
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion
                             SET certificado  =  certificado + ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                 tipo = 'G' and         
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        //-------------------------------------------------
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(compromiso) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                         estado in ( '5','6')
                group by  partida
                order by partida";
        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);
         
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion
                             SET compromiso  = compromiso + ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                 tipo = 'G' and      
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        //-------------------------------------------------
 
        
        //-------------------------------------------------
        $sql_det_dev = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and
                         principal ='.$this->bd->sqlvalue_inyeccion('S', true).'  and
                         debe   <> 0  and
                         partida_enlace = '.$this->bd->sqlvalue_inyeccion('gasto', true).'
                group by  partida
                order by partida';
        
        $stmt13 = $this->bd->ejecutar($sql_det_dev);
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion
                             SET devengado  = devengado + ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true).  " and
                                 tipo = 'G' and
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        
        
        //-----------------------------------------------
        $sql_det_pago = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and 
                         partida is not null and
                         cuenta like '.$this->bd->sqlvalue_inyeccion('21%', true).'
                group by  partida
                order by partida';
        
        $stmt13p = $this->bd->ejecutar($sql_det_pago);
        
        while ($fila_p=$this->bd->obtener_fila($stmt13p)){
            
            $partida = trim($fila_p['partida']) ;
            $monto   = $fila_p['c1'] ;
            
            $sqlEdit3_pago = "UPDATE presupuesto.pre_gestion
                             SET pagado  =  pagado + ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                 tipo = 'G' and
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3_pago);
            
        }
        
        //----------------------------------------------------------------------
        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET codificado = coalesce(inicial,0) + (coalesce(aumento,0) - coalesce(disminuye,0))
                           where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ." and tipo = 'G' ";
        
        $this->bd->ejecutar($sqlEditPre);
        
        //----------------------------------------------------------------
        $sqlEdit = "UPDATE presupuesto.pre_gestion
                             SET disponible = codificado - (certificado  + compromiso )
                           where tipo = 'G' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEdit);
        
 
        
    }
    //----------------- saldo a la fecha de ingresos presupuestarios.... 
    function _saldo_ingreso($anio){
        
       
        
  

        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET certificado  =  ".$this->bd->sqlvalue_inyeccion(0,true).",
                                 pagado   = ".$this->bd->sqlvalue_inyeccion(0,true) .",
                                 aumento = ".$this->bd->sqlvalue_inyeccion(0,true).",
                                 disminuye = ".$this->bd->sqlvalue_inyeccion(0,true) .",
                                 devengado    = ".$this->bd->sqlvalue_inyeccion(0,true) ."
                           where   tipo = 'I' and  
                                   anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre);


        $this->Reformas_saldo( $anio,'I' ) ;
        
        
        
        $sql_det = 'SELECT sum(haber) as devengado, partida
                    FROM view_ingreso_devengado
                    where anio= '.$this->bd->sqlvalue_inyeccion($anio, true).'  group by  partida ';
  
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']) ;
                   
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion
                             SET devengado  =  ".$this->bd->sqlvalue_inyeccion($fila['devengado'],true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and 
                                 tipo = 'I' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
           
        }
        
        //----------------------------------
        $sql_det1 = 'SELECT  sum(haber) as recaudado, partida
                    FROM view_diario_presupuesto
                    where anio= '.$this->bd->sqlvalue_inyeccion($anio, true).' and 
                          partida_enlace ='.$this->bd->sqlvalue_inyeccion('-', true).'  and
                          tipo_presupuesto ='.$this->bd->sqlvalue_inyeccion('I', true).'  and
                          length(trim(credito))='.$this->bd->sqlvalue_inyeccion(2, true).'
                    group by  partida ';
 
 
        
        $stmt131 = $this->bd->ejecutar($sql_det1);
        
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion
                             SET pagado  =  ".$this->bd->sqlvalue_inyeccion($fila['recaudado'],true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true)." and  
                                 tipo = 'I' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        
        /* $sqlEdit3 = "UPDATE presupuesto.pre_gestion
         SET devengado  =  ".$this->bd->sqlvalue_inyeccion($fila['devengado'],true).",
         pagado  = ".$this->bd->sqlvalue_inyeccion($fila['recaudado'],true) ."
         where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
         anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
         */ 
        
        //---------------------------------------------------------------------------------------------------
        $this->caja_saldo( $anio ) ;
        
        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET disponible = codificado - (certificado + compromiso + devengado )
                           where  tipo = 'I' and anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre);
        
        return '0k Informacion actualizada ingresos';
        
    }
 
    //-----------------
    function saldo_gastos_periodo($f1,$fecha){
        
        
        $aperiodo = explode('-',$fecha);
        
        $anio = $aperiodo[0];
        
     //   $fecha1 = $anio.'-01-01';
     
        $fecha1 = $f1;
        
        
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(certificado) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                         estado = '3' AND
                         fcertifica  between ".$this->bd->sqlvalue_inyeccion($f1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true)."
                group by  partida
                order by partida";
        
        
        
        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);
        
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_periodo
                             SET certificado  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
 
        //-------------------------------------------------
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(compromiso) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                         estado in ('5','6') AND  
                         fcompromiso  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true)."
                group by  partida
                order by partida";
        
       
               

        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);
        
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_periodo
                             SET compromiso  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
    
        //-------------------------------------------------
         //-------------------------------------------------
        $sql_det_dev = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and 
                         principal ='.$this->bd->sqlvalue_inyeccion('S', true).'  and
                         debe    <> 0  and
                         fecha  between '.$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true).' 
                group by  partida
                order by partida';
        
   
        
        $stmt13 = $this->bd->ejecutar($sql_det_dev);
        
 
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_periodo
                             SET devengado  =   ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                 tipo = 'G' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        
        
        //-----------------------------------------------
        $sql_det_pago = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and
                         cuenta like '.$this->bd->sqlvalue_inyeccion('21%', true).' and partida is not null and
                         fecha  between '.$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true).' 
                group by  partida
                order by partida';
        
       
        $stmt13p = $this->bd->ejecutar($sql_det_pago);
        
        while ($fila_p=$this->bd->obtener_fila($stmt13p)){
            
            $partida = trim($fila_p['partida']) ;
            $monto   = $fila_p['c1'] ;
            
            $sqlEdit3_pago = "UPDATE presupuesto.pre_gestion_periodo
                             SET pagado  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                  tipo = 'G' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3_pago);
          
        }
        
        //----------------------------------------------------------------------
        $sqlEditPre = "UPDATE presupuesto.pre_gestion_periodo
                             SET codificado = coalesce(inicial,0) + (coalesce(aumento,0) - coalesce(disminuye,0))
                           where    tipo = 'G' and anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre);
        
        //----------------------------------------------------------------
     
        
        
    }
    //----------------
    function saldo_gastos_periodo_partida($f1,$fecha,$partida){
        
        
        $aperiodo = explode('-',$fecha);
        
        $anio = $aperiodo[0];
        
      
        $fecha1 = $f1;
        
        
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(certificado) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                          partida =".$this->bd->sqlvalue_inyeccion($partida, true)."  and
                         estado = '3' AND
                         fcertifica  between ".$this->bd->sqlvalue_inyeccion($f1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true)."
                group by  partida
                order by partida";
        
        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);
        
        $certificado  = 0 ;

        while ($fila=$this->bd->obtener_fila($stmt131)){
            
             $certificado   = $certificado + $fila['c1'] ;
            
         }
        
 
        //-------------------------------------------------
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(compromiso) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                         partida =".$this->bd->sqlvalue_inyeccion($partida, true)."  and
                         estado in ('5','6') AND  
                         fcompromiso  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true)."
                group by  partida
                order by partida";
        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);

        $compromiso = 0;
        
        while ($fila1=$this->bd->obtener_fila($stmt131)){
            
             $compromiso   =   $compromiso + $fila1['c1'] ;
            
        }
        
        $total_datos =   $compromiso + $certificado  ;
    
        
        return  $total_datos;
     
        
        
    }
    //--------------------
    //  resumen de pagos
    function saldo_gastos_pagos($fecha1,$fecha){
        
        
        $aperiodo = explode('-',$fecha);
        
        $anio = $aperiodo[0];
        
 
        
        
        //-------------------------------------------------
        $sql_compromiso = 'SELECT partida,
                           sum(certificado) as c1
                    FROM presupuesto.view_tramites
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true)."  and
                         estado = '3' AND
                         fcertifica  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true)."
                group by  partida
                order by partida";
        
        
        
        
        $stmt131 = $this->bd->ejecutar($sql_compromiso);
        
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_pagos
                             SET certificado  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        
        //-------------------------------------------------
 
        
        //-------------------------------------------------
        //-------------------------------------------------
        $sql_det_dev = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and
                         principal ='.$this->bd->sqlvalue_inyeccion('S', true).'  and
                         debe    <> 0  and
                         fecha  between '.$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true).'
                group by  partida
                order by partida';
        
        $stmt13 = $this->bd->ejecutar($sql_det_dev);
        
        
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']) ;
            $monto   = $fila['c1'] ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_pagos
                             SET devengado  =   ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
        
        
        //-----------------------------------------------
        $sql_det_pago = 'SELECT partida,
                           sum(debe) as c1
                    FROM view_diario_presupuesto
                   WHERE anio ='.$this->bd->sqlvalue_inyeccion($anio, true).'  and
                         cuenta like '.$this->bd->sqlvalue_inyeccion('21%', true).' and partida is not null and
                         fecha  between '.$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true).'
                group by  partida
                order by partida';
        
        
        $stmt13p = $this->bd->ejecutar($sql_det_pago);
        
        while ($fila_p=$this->bd->obtener_fila($stmt13p)){
            
            $partida = trim($fila_p['partida']) ;
            $monto   = $fila_p['c1'] ;
            
            $sqlEdit3_pago = "UPDATE presupuesto.pre_gestion_pagos
                             SET pagado  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3_pago);
            
        }
        
        //----------------------------------------------------------------------
        $sqlEditPre = "UPDATE presupuesto.pre_gestion_pagos
                             SET codificado = coalesce(inicial,0) + (coalesce(aumento,0) - coalesce(disminuye,0))
                           where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre);
        
        //----------------------------------------------------------------
        
        
        
    }
    //-----------------
    function saldo_ingreso_periodo($f1,$fecha){
        
        $aperiodo = explode('-',$fecha);

        $anio     = $aperiodo[0];
     
        $fecha1   = $f1;
        
 /*
        $sql = "UPDATE presupuesto.pre_gestion_periodo
                             SET devengado  = 0
                           where tipo = 'I' and  anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sql);

        */
        

        $this->caja_saldo_periodo( $anio ) ;
        
        
         
        $sql_t = 'SELECT sum(haber) as monto, partida
                    FROM view_ingreso_devengado
                    where fecha  between '.$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.
                                           $this->bd->sqlvalue_inyeccion($fecha, true).' and  
                    anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' group by  partida ';
 
                       
        
        $stmt13d = $this->bd->ejecutar($sql_t);
        
        while ($xx=$this->bd->obtener_fila($stmt13d)){
            
            $partida = trim($xx['partida']) ;
            
            $monto =  $xx['monto'];
            
             
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_periodo
                             SET devengado  =  ".$this->bd->sqlvalue_inyeccion($monto,true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and 
                                 tipo = 'I' and 
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
    
            $this->bd->ejecutar($sqlEdit3);
            
        }
 
        
 
        //----------------------------------
        $sql_det1 = 'SELECT  sum(haber) as recaudado, partida
                    FROM view_diario_presupuesto
                    where anio= '.$this->bd->sqlvalue_inyeccion($anio, true)." and
                          partida_enlace = '-' and
                          length(trim(credito))=".$this->bd->sqlvalue_inyeccion(2, true)." and 
                          tipo_presupuesto = 'I' and 
                          fecha  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($fecha, true).'
                    group by  partida ';
 
     
        
        $stmt131 = $this->bd->ejecutar($sql_det1);
        
        while ($fila=$this->bd->obtener_fila($stmt131)){
            
            $partida = trim($fila['partida']) ;
            
            $sqlEdit3 = "UPDATE presupuesto.pre_gestion_periodo
                             SET pagado  =  ".$this->bd->sqlvalue_inyeccion($fila['recaudado'],true)."
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). " and
                                 tipo = 'I' and
                                 anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit3);
            
        }
        
  
     
        //---------------------------------------------------------------------------------------------------
  
        return '0k Informacion actualizada ingresos';
        
    }
    //-----------------
    function _inicial_nulo($anio){
        
                 
                 
        $sqlEdit = "UPDATE co_asientod
                             SET item  =  ".$this->bd->sqlvalue_inyeccion('-',true)."
                           where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) .' and
                                 partida is null';
        
        $this->bd->ejecutar($sqlEdit);
        
        $sqlEdit = "UPDATE co_asientod
                             SET partida =".$this->bd->sqlvalue_inyeccion('-',true)."
                           where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ." and
                                 cuenta like '112.%' ";
        
        $this->bd->ejecutar($sqlEdit);
        
        
        
        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET inicial  =  ".$this->bd->sqlvalue_inyeccion(0,true)."
                            where inicial is null and 
                                  anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre);
            
                
     
    }
    //---------------------------
    function _aprobacion_reforma($id){
        
        $estadoa = $this->bd->query_array('presupuesto.pre_reforma',
            'comprobante, estado, fecha, tipo, tipo_reforma, documento, id_departamento,anio',
            'id_reforma='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
         $estado 		    = trim($estadoa['estado']);
         $tipo_reforma		= trim($estadoa['tipo_reforma']);
         
            $bandera = 0;
            $comprobante = '-';
        
        if (trim($estado) == 'digitado'){
            
            $bandera = 1;
            //------------ verifica si el asiento esta cuadrado
            $sql =  "SELECT sum(aumento) - sum(disminuye) as saldo
				 							FROM presupuesto.pre_reforma_det
											WHERE id_reforma =".$this->bd->sqlvalue_inyeccion($id ,true);
            
 
            
            $parametros 	   = $this->bd->ejecutar($sql);
            $saldos 		   =  $this->bd->obtener_array($parametros);
            
            if ( $tipo_reforma == 'Traspaso')  {
                      if (  $saldos['saldo'] <> 0) {
                        $this->obj->var->_alerta('Reforma no Cuadrado');
                        $bandera = 0;
                    }
            }else  {
                if (  $saldos['saldo'] <> 0) {
                    $this->obj->var->_alerta('Reforma no esta cuadrada');
                    $bandera = 0;
                 }
            }
            //----------- ESTADO Y APROBACION DEL ASIENTO
            if ($bandera == 1){
                
                $comprobante = $this->_Comprobante($estadoa["tipo"],$estadoa["anio"]);
                
                $sql = "UPDATE presupuesto.pre_reforma
													   SET estado      =".$this->bd->sqlvalue_inyeccion('aprobado', true).",
														   comprobante =".$this->bd->sqlvalue_inyeccion($comprobante, true)."
													 WHERE id_reforma   =".$this->bd->sqlvalue_inyeccion($id, true);
                
                    
                $this->bd->ejecutar($sql);
                
                $this->ReformaDiario($id,$estadoa["anio"],trim($tipo_reforma));
                
            }
        }
        
        return $comprobante;
    }
    //-----------------------------------------------------------------------------------------------------------
    //---   libro diario
    function ReformaDiario($id  , $anio,$tipo_reforma){
        
      $sql_det = 'SELECT id_reforma_det, id_reforma, partida, tipo, saldo, aumento, sesion, fsesion, registro, anio, disminuye
                    FROM presupuesto.pre_reforma_det
                   WHERE id_reforma ='.$this->bd->sqlvalue_inyeccion($id, true);
        
      $stmt13 = $this->bd->ejecutar($sql_det);
        
        
      while ($fila=$this->bd->obtener_fila($stmt13)){
          
            
            $partida = trim($fila['partida']);
 
            if ($tipo_reforma == 'Traspaso')  {
            
                        $codificado = $fila['aumento'] -$fila['disminuye']; 
                        
                        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET aumento = aumento + ".$this->bd->sqlvalue_inyeccion($fila['aumento'],true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($fila['disminuye'],true) .",
                                             codificado  = codificado + ".$this->bd->sqlvalue_inyeccion($codificado,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            }
            
            if ($tipo_reforma == 'Suplemento')  {
                
                
                    
                    $codificado = $fila['aumento'] + $fila['disminuye'];
                    
                    $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET aumento = aumento + ".$this->bd->sqlvalue_inyeccion($codificado,true).",
                                             codificado  = codificado + ".$this->bd->sqlvalue_inyeccion($codificado,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
                
                
              
            }
            
            if ($tipo_reforma == 'Reduccion')  {
                
      
                    
                    $codificado = $fila['aumento'] + $fila['disminuye'];
                    
                    $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($codificado,true) .",
                                             codificado  = codificado - ".$this->bd->sqlvalue_inyeccion($codificado,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
                
              
            }
            
            $this->bd->ejecutar($sqlEditPre);
            
            
            $sqlEditPre = "UPDATE presupuesto.pre_gestion
                             SET disponible = codificado - (certificado + compromiso + devengado )
                           where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                 anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEditPre);
            
            
        }
        
 
    }
    //------------------------------
    function caja_saldo( $anio ){
        
        $sql_det = "SELECT   partida, sum(monto) as monto
                        FROM presupuesto.pre_caja
                        where  anio =" .$this->bd->sqlvalue_inyeccion($anio, true)."
                        group by partida  order by partida";
        
         
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            $partida = trim($fila['partida']);
              
            $monto   = $fila['monto'];
            
            $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET devengado     =  ".$this->bd->sqlvalue_inyeccion($monto,true).",
                                             pagado   =  ".$this->bd->sqlvalue_inyeccion($monto,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEditPre);
        }
        
    }
    //-------------------------
    //------------------------------
    function caja_saldo_periodo( $anio ){
        
        $sql_caja = "SELECT  partida, sum(monto) as monto
                        FROM presupuesto.pre_caja
                        where  anio =" .$this->bd->sqlvalue_inyeccion($anio, true)."
                        group by partida  order by partida";
         
         
        $stmt_caja = $this->bd->ejecutar($sql_caja);
        
        while ($fila=$this->bd->obtener_fila($stmt_caja)){
            
            $partida = trim($fila['partida']);
            
            $monto   = $fila['monto'];
            
            $sqlEdit_caja = "UPDATE presupuesto.pre_gestion_periodo
                                         SET devengado     =  ".$this->bd->sqlvalue_inyeccion($monto,true).",
                                             pagado   =  ".$this->bd->sqlvalue_inyeccion($monto,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEdit_caja);
        }
        
    }
    //------ saldos de reformas por anio $anio,$f2
    function Reformas_saldo( $anio,$tipo_presupuesto ){
        
 
        $sql_det = "SELECT partida, tipo_reforma,tipo, 
                           sum(aumento) as aumento, 
                           sum(disminuye) as disminuye
                        FROM presupuesto.view_reforma_detalle
                        where estado ='aprobado' and 
                              tipo =".$this->bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and 
                              anio =" .$this->bd->sqlvalue_inyeccion($anio, true)."
                        group by partida, tipo,tipo_reforma  order by tipo_reforma";
 
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            
            $partida = trim($fila['partida']);
            
            $tipo_reforma = trim($fila['tipo_reforma']);
            
            $aumento   = $fila['aumento'];
            $disminuye = $fila['disminuye'];
              
            
            if ($tipo_reforma == 'Traspaso'){
                $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET aumento     = aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
                
            }
 
            if ($tipo_reforma == 'Reduccion'){
                
                $aumento   = $fila['aumento'] * -1 ;
                $disminuye = $fila['disminuye'];
                
               // $reformas = $aumento - $disminuye;
                
                $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET aumento = aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
                
            }
            
            if ($tipo_reforma == 'Suplemento'){
 
                $aumento   = $fila['aumento'] ;
                $disminuye = $fila['disminuye'] * -1 ;
                 
                $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                         SET aumento = aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
                
            }
               $this->bd->ejecutar($sqlEditPre);
             
        }
         
        $sqlEditPre1 = "UPDATE presupuesto.pre_gestion
                                         SET codificado  = inicial + (aumento - disminuye)"."
                                       where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ." and 
                                             tipo =".$this->bd->sqlvalue_inyeccion($tipo_presupuesto, true);
        
        $this->bd->ejecutar($sqlEditPre1); 
        
    }
    //-----------------------------------
    //------------------------------
    //--- saldos de reformas por fecha para esigef 
    function saldo_Reformas_periodo( $anio,$f1,$f2,$tipo_presupuesto ){
        
        
        $aperiodo = explode('-',$f2);
        
        $anio = $aperiodo[0];
        
    //    $fecha1 = $anio.'-01-01';
    
        $fecha1 = $f1;
         
        
        $sql_det = "SELECT partida, tipo, tipo_reforma,sum(aumento) aumento, sum(disminuye)    disminuye
                        FROM presupuesto.view_reforma_detalle
                        where estado = 'aprobado' and 
                              anio =" .$this->bd->sqlvalue_inyeccion($anio, true)." and 
                              tipo =" .$this->bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and 
                              fecha  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($f2, true)."
                        group by partida, tipo,tipo_reforma  order by tipo_reforma";
        
      
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        while ($fila=$this->bd->obtener_fila($stmt13)){
            
            
            $partida   = trim($fila['partida']);
            $aumento   = $fila['aumento'];
            $disminuye = $fila['disminuye'];
            
           // $reformas = $aumento - $disminuye;
           
            $tipo         = trim($fila['tipo']);
            
            $tipo_reforma = trim($fila['tipo_reforma']);
            
            
            if ($tipo_reforma == 'Traspaso'){
                
                $sqlEditPre = "UPDATE presupuesto.pre_gestion_periodo
                                         SET aumento     = aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            }
         
            if ($tipo_reforma == 'Reduccion'){
                 
                
                if ( $tipo == 'I'){
                    $disminuye   = $fila['aumento']  ;
                    $aumento     = $fila['disminuye'];
                }else{
                    $aumento   = $fila['aumento']  ;
                    $disminuye = $fila['disminuye'];
                }
                 
                $sqlEditPre = "UPDATE presupuesto.pre_gestion_periodo
                                         SET aumento     =  aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   =  disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            }
            
            if ($tipo_reforma == 'Suplemento'){
                
                if ( $tipo == 'I'){
                    $aumento   = $fila['aumento']  ;
                    $disminuye     = $fila['disminuye'];
                }else{
                    $aumento   = $fila['disminuye']  ;
                    $disminuye = $fila['aumento'];
                }
                 
                $sqlEditPre = "UPDATE presupuesto.pre_gestion_periodo
                                         SET aumento     = aumento + ".$this->bd->sqlvalue_inyeccion($aumento,true).",
                                             disminuye   = disminuye + ".$this->bd->sqlvalue_inyeccion($disminuye,true) ."
                                       where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                                             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
            }
            
             $this->bd->ejecutar($sqlEditPre);
             
        }
        
 
        
        
        $sqlEditPre1 = "UPDATE presupuesto.pre_gestion_periodo
                                         SET codificado  = inicial + aumento - disminuye "."
                                       where
                                           tipo =" .$this->bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and 
                                            anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $this->bd->ejecutar($sqlEditPre1); 
        
        
  }
  //-----------------------------
  function saldo_Reformas_periodo_fecha( $anio,$f1,$f2,$tipo_presupuesto,$partida ){
        
        
    $aperiodo = explode('-',$f2);
    
    $anio = $aperiodo[0];
    
 
    $fecha1 = $f1;
     
    
    $sql_det = "SELECT partida, tipo, tipo_reforma,sum(aumento) aumento, sum(disminuye)    disminuye
                    FROM presupuesto.view_reforma_detalle
                    where estado = 'aprobado' and 
                          anio =" .$this->bd->sqlvalue_inyeccion($anio, true)." and 
                          partida =" .$this->bd->sqlvalue_inyeccion($partida, true)." and 
                          tipo =" .$this->bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and 
                          fecha  between ".$this->bd->sqlvalue_inyeccion($fecha1, true).'  and '.$this->bd->sqlvalue_inyeccion($f2, true)."
                    group by partida, tipo,tipo_reforma  order by tipo_reforma";
    
  

    $total_reforma = 0                 ;
    
    $stmt13 = $this->bd->ejecutar($sql_det);
    
    while ($fila=$this->bd->obtener_fila($stmt13)){
        
        
        $partida   = trim($fila['partida']);
        $aumento   = $fila['aumento'];
        $disminuye = $fila['disminuye'];
        
     
       
        $tipo         = trim($fila['tipo']);
        
        $tipo_reforma = trim($fila['tipo_reforma']);
        
        
        if ($tipo_reforma == 'Traspaso'){
 
           $total_reforma =  $total_reforma  +  ( $aumento - $disminuye);                             
        }
     
        if ($tipo_reforma == 'Reduccion'){
             
            
            if ( $tipo == 'I'){
                $disminuye   = $fila['aumento']  ;
                $aumento     = $fila['disminuye'];
            }else{
                $aumento   = $fila['aumento']  ;
                $disminuye = $fila['disminuye'];
            }
            
            $total_reforma =  $total_reforma  +  ( $aumento - $disminuye);           

        }
        
        if ($tipo_reforma == 'Suplemento'){
            
            if ( $tipo == 'I'){
                $aumento   = $fila['aumento']  ;
                $disminuye     = $fila['disminuye'];
            }else{
                $aumento   = $fila['disminuye']  ;
                $disminuye = $fila['aumento'];
            }
             
            $total_reforma =  $total_reforma  +  ( $aumento - $disminuye);    
        }
        
          
    }
    

     return  $total_reforma;
    
    
}
    //--------------------------------------------------------------------------
    function _Comprobante($tipo,$anio){
        
        
        $secuencia = $this->bd->query_array('presupuesto.pre_reforma',
            'count(*) as doc',
            'tipo='.$this->bd->sqlvalue_inyeccion($tipo,true).' and
                                             anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                             estado='.$this->bd->sqlvalue_inyeccion( 'aprobado',true)
            );
        
  
        
        $contador 				= $secuencia['doc'] + 1;
        
        $input = str_pad($contador, 10, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    ///------------------------
    function _elimina_asiento($id,$estado){
        
        
        if (trim($estado) == 'digitado'){
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras_f where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_asiento where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
        }
        //------------------
        if (trim($estado) == 'aprobado'){
            
            
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras_f where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            
            $sql = 'UPDATE co_asiento
        	         SET  	estado ='.$this->bd->sqlvalue_inyeccion('anulado', true).'
        	         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $this->LibroDiarioElimina($id);
            
            
            /*
             if (trim($estado) == 'aprobado'){
             
             $sql = 'SELECT count(*) as refe
             FROM co_asiento_aux a
             WHERE a.id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and a.id_asiento_ref > 0';
             
             $resultado      = $this->bd->ejecutar($sql);
             $datos_asiento  = $this->bd->obtener_array( $resultado);
             
             if ($datos_estado["refe"] == 0){
             
             
             
             }
             }
             */
        }
        
    }
    //------------------------
    function _elimina_asientocxc($id,$estado){
        
        
        if (trim($estado) == 'digitado'){
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_ventas where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_asiento where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'update inv_movimiento
                       set id_asiento_ref = 0
                     where id_asiento_ref='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            
        }
        //------------------
        if (trim($estado) == 'aprobado'){
            
            
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_ventas where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'UPDATE co_asiento
        	         SET  	estado ='.$this->bd->sqlvalue_inyeccion('anulado', true).'
        	         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'update inv_movimiento
                       set id_asiento_ref = 0
                     where id_asiento_ref='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $this->LibroDiarioElimina($id);
            
            
            
        }
        
    }
    
    
    /////////////// llena para consultar
    function LibroDiarioElimina($id ){
        
        $sql = 'DELETE
							    FROM  co_diario
								WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        /////////////////////////////////////////////////////////////////////
        // suma de balance
        
        $sql_saldos = 'select cuenta,debe,haber
									 from co_asientod
									where id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $stmt_saldos = $this->bd->ejecutar($sql_saldos);
        
        while ($x=$this->bd->obtener_fila($stmt_saldos)){
            
            $sql_uno = 'UPDATE co_plan_ctas
										 		  SET  debe = debe  - '.$this->bd->sqlvalue_inyeccion($x['1'], true).',
												  	   haber= haber - '.$this->bd->sqlvalue_inyeccion($x['2'], true).'
												  where cuenta ='.$this->bd->sqlvalue_inyeccion(trim($x['0']) ,true);
            
            $this->bd->ejecutar($sql_uno);
        }
        
        /*
         $sql_uno = 'UPDATE co_asiento_aux
         SET  debe='.$this->bd->sqlvalue_inyeccion(0, true).',
         haber='.$this->bd->sqlvalue_inyeccion(0, true).',
         pago='.$this->bd->sqlvalue_inyeccion('S', true).',
         bandera='.$this->bd->sqlvalue_inyeccion(2, true).',
         detalle='.$this->bd->sqlvalue_inyeccion('Anulado... ', true).' || detalle
         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id ,true);
         
         $bd->ejecutar($sql_uno);*/
    }
    
    //------------------
    function _asiento_contable($fecha,$detalle,$tipo,$comprobante,$id_asiento,$modulo ,$documento,$idprov){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        if (empty($id_asiento)){
            $id_asiento = 0;
        }
        
        $fecha_registro		= $this->bd->fecha($fecha);
        
        $sql = "INSERT INTO co_asiento(   fecha, registro, anio, mes, detalle, sesion, creacion,
                                          comprobante, estado, tipo, documento,id_asiento_ref,
                                modulo,idprov,estado_pago,id_periodo)
                                VALUES (".$fecha_registro.",".
                                $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
                                $this->bd->sqlvalue_inyeccion($anio, true).",".
                                $this->bd->sqlvalue_inyeccion($mes, true).",".
                                $this->bd->sqlvalue_inyeccion($detalle, true).",".
                                $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                                $this->hoy .",".
                                $this->bd->sqlvalue_inyeccion($comprobante, true).",".
                                $this->bd->sqlvalue_inyeccion('digitado', true).",".
                                $this->bd->sqlvalue_inyeccion($tipo, true).",".
                                $this->bd->sqlvalue_inyeccion($documento, true).",".
                                $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
                                $this->bd->sqlvalue_inyeccion($modulo, true).",".
                                $this->bd->sqlvalue_inyeccion($idprov, true).",".
                                $this->bd->sqlvalue_inyeccion('S', true).",".
                                $this->bd->sqlvalue_inyeccion( $periodo_s['id_periodo'], true).")";
                                
                                $this->bd->ejecutar($sql);
                                
                                $id_asiento_banco = $this->bd->ultima_secuencia('co_asiento');
                                
                                return $id_asiento_banco;
                                
                                
    }
    //-----------------------------------------------------
    function _detalle_contable($fecha,$idasiento_matriz,$cuenta,$debe,$haber){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        
        
        $x = $this->bd->query_array('co_plan_ctas',
            'aux',
            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true) .' and
             registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        $aux		= $x['aux'];
        
        
        $sql = " INSERT INTO co_asientod( id_asiento, cuenta, aux,debe, haber,id_periodo,anio,mes,sesion, creacion, registro)
                    				VALUES (".
                    				$this->bd->sqlvalue_inyeccion($idasiento_matriz , true).",".
                    				$this->bd->sqlvalue_inyeccion($cuenta, true).",".
                    				$this->bd->sqlvalue_inyeccion($aux, true).",".
                    				$this->bd->sqlvalue_inyeccion($debe, true).",".
                    				$this->bd->sqlvalue_inyeccion($haber, true).",".
                    				$this->bd->sqlvalue_inyeccion($periodo_s["id_periodo"], true).",".
                    				$this->bd->sqlvalue_inyeccion($anio, true).",".
                    				$this->bd->sqlvalue_inyeccion($mes, true).",".
                    				$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                    				$this->hoy .",".
                    				$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                    				
                    				$this->bd->ejecutar($sql);
                    				
                    				$id_asiento_banco_aux1 = $this->bd->ultima_secuencia('co_asientod');
                    				
                    				return    $id_asiento_banco_aux1;
                    				
    }
    //-------------------------------------------------------------------------
    function _aux_contable($fecha,$idasiento_matriz,$id_asiento_d,$detalle,$cuenta,$idprov,$debe,$haber,$id_asiento_ref,$pago,$cheque){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        
        $fecha_registro		= $this->bd->fecha($fecha);
        
        $sql = "INSERT INTO co_asiento_aux(id_asientod, id_asiento, idprov, cuenta,cheque,fecha,pago, detalle,debe, haber, id_periodo,
          									  anio, mes, sesion, creacion, id_asiento_ref,registro) VALUES (".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_d  , true).",".
          									  $this->bd->sqlvalue_inyeccion($idasiento_matriz , true).",".
          									  $this->bd->sqlvalue_inyeccion($idprov , true).",".
          									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
          									  $this->bd->sqlvalue_inyeccion($cheque , true).",".
          									  $fecha_registro.",".
          									  $this->bd->sqlvalue_inyeccion($pago , true).",".
          									  $this->bd->sqlvalue_inyeccion($detalle , true).",".
          									  $this->bd->sqlvalue_inyeccion($debe , true).",".
          									  $this->bd->sqlvalue_inyeccion($haber , true).",".
          									  $this->bd->sqlvalue_inyeccion($periodo_s["id_periodo"] , true).",".
          									  $this->bd->sqlvalue_inyeccion($anio, true).",".
          									  $this->bd->sqlvalue_inyeccion($mes, true).",".
          									  $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
          									  $this->hoy.",".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_ref , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->ruc , true).")";
          									  
          									  $this->bd->ejecutar($sql);
          									  
          									  
    }
//-------------------------------------------------------------------
// saca informacion de cedulas por periodo
    function PresupuestoPeriodo($f2 ){
        
        
         $aperiodo = explode('-',$f2);
        
         $anio = $aperiodo[0];
 
        $this->bd->JqueryDeleteSQL('presupuesto.pre_gestion_periodo',
                                   'anio ='.$this->bd->sqlvalue_inyeccion($anio , true)
            );
        
            $sql_saldos = "INSERT INTO presupuesto.pre_gestion_periodo (tipo, funcion, titulo, grupo, subgrupo, item, orientador, 
                                       proforma, inicial, aumento, disminuye, codificado, certificado, compromiso, devengado, pagado, 
                                       anio, proyecto, competencia, partida, detalle, fuente) 
                            SELECT  tipo, funcion, titulo, grupo, 
                                    substring(subgrupo,3,2)  as subgrupo, substring(item,5,2) as item, 
                                    orientador,  proforma,  inicial, 0 as aumento, 0 as disminuye, 0 as codificado,
                                0 as certificado, 0 as compromiso, 0 as devengado, 0 as pagado, 
                                anio, proyecto, competencia, partida, detalle, fuente
                            FROM presupuesto.pre_gestion
                            where ( coalesce(inicial,0) + coalesce(abs(codificado),0) +coalesce(devengado,0) + coalesce(compromiso,0)  )  >  0  and 
                                 anio = ".$this->bd->sqlvalue_inyeccion( $anio , true);

            $this->bd->ejecutar($sql_saldos);
        
         
        
        //$anio,$f1,$f2
        $f1 = $anio.'-01-01';
        
        $this->saldo_Reformas_periodo($anio,$f1,$f2,'I');
        $this->saldo_Reformas_periodo($anio,$f1,$f2,'G');
 
        $this->saldo_ingreso_periodo($f1,$f2);
 
        $this->saldo_gastos_periodo($f1,$f2);
 
            $sqlEditPre1 = "UPDATE presupuesto.pre_gestion_periodo
                                         SET codificado  = inicial + aumento - disminuye "."
                                       where anio = ".$this->bd->sqlvalue_inyeccion($anio,true) ;
            
            $this->bd->ejecutar($sqlEditPre1); 
        
 
    }

    function PresupuestoDisponible_partida($f2,$partida,$tipo_presupuesto ){
        
        
        $aperiodo = explode('-',$f2);
       
        $anio = $aperiodo[0];
 

        $p1_inicial = $this->bd->query_array('presupuesto.pre_gestion',
        'inicial',
          'anio='.$this->bd->sqlvalue_inyeccion($anio ,true). ' and partida = '.$this->bd->sqlvalue_inyeccion($partida ,true)
        );

       $monto_inicial =   $p1_inicial['inicial'];
       
       //$anio,$f1,$f2
       $f1 = $anio.'-01-01';
       
       if ( trim($tipo_presupuesto)  == 'I'){

       } else    {

          $compromiso_certificado  =    $this->saldo_gastos_periodo_partida($f1,$f2,$partida);


          $reforma                 =   $this->saldo_Reformas_periodo_fecha($anio,$f1,$f2,'G',$partida);

         

          $total_disponible =    ( $monto_inicial  +  $reforma)  -    $compromiso_certificado;

        
       }

      

       return $total_disponible;
/*


      
  

       $this->saldo_ingreso_periodo($f1,$f2);

     

      */

   }
    //------------------
    function PresupuestoPeriodo_pagos($f1,$f2 ){
        
        
        $aperiodo = explode('-',$f2);
        
        $anio = $aperiodo[0];
        
        $this->bd->JqueryDeleteSQL('presupuesto.pre_gestion_pagos',
            'anio ='.$this->bd->sqlvalue_inyeccion($anio , true). " and tipo ='G' "
            );
        
        $sql_saldos = 'SELECT tipo, partida,clasificador, grupo, subgrupo, item, competencia, orientador,
                              inicial, codificado, aumento, disminuye, certificado,
                               compromiso, devengado, pagado, anio,funcion
                        FROM presupuesto.pre_gestion
                        where anio  ='.$this->bd->sqlvalue_inyeccion( $anio , true). " and tipo ='G' ".
                        'order by tipo desc, clasificador';
        
        
        
        $stmt_saldos = $this->bd->ejecutar($sql_saldos);
        
        
        $this->bd->pideSq(0);
        
        while ($x=$this->bd->obtener_fila($stmt_saldos)){
            
            $tipo       		= $x['tipo'] ;
            $partida       		= trim($x['partida']) ;
            $grupo       		= trim($x['grupo']) ;
            $subgrupo      		= substr($x['subgrupo'],2,2) ;
            $item       		= $x['item'] ;
            $titulo             = substr(trim($x['grupo']),0,1) ;
            
            $compentencia      		= $x['competencia'] ;
            $orientador       		= $x['orientador'] ;
            
            $funcion = $x['funcion'] ;
            $inicial       		= $x['inicial'] ;
            $codificado         = $x['codificado'] ;
            $monto = '0.00';
            
            $InsertQuery = array(
                array( campo => 'tipo',   valor => $tipo),
                array( campo => 'partida',   valor => trim($partida)),
                array( campo => 'funcion',   valor => $funcion),
                array( campo => 'titulo',   valor => $titulo),
                array( campo => 'grupo',   valor => trim($grupo)),
                array( campo => 'subgrupo',   valor => trim($subgrupo)),
                array( campo => 'item',   valor =>$item),
                array( campo => 'orientador',   valor => trim($orientador) ),
                array( campo => 'proforma',   valor => $inicial),
                array( campo => 'inicial',   valor =>$inicial),
                array( campo => 'aumento',   valor => $monto),
                array( campo => 'disminuye',   valor => $monto),
                array( campo => 'codificado',   valor => $codificado),
                array( campo => 'certificado',   valor => $monto),
                array( campo => 'compromiso',   valor =>$monto),
                array( campo => 'devengado',   valor => $monto),
                array( campo => 'pagado',   valor => $monto),
                array( campo => 'anio',   valor => $anio),
                array( campo => 'proyecto',   valor => '00'),
                array( campo => 'competencia',   valor => $compentencia)
            );
            
            $this->bd->JqueryInsertSQL('presupuesto.pre_gestion_pagos',$InsertQuery);
            
            
            
            
        }
        
 
        
        $this->saldo_gastos_pagos($f1,$f2);
        
        
        
    }
    //-------------------
    function PresupuestoPeriodo_gasto($f1,$f2 ){
        
        
        $aperiodo = explode('-',$f2);
        
        $anio = $aperiodo[0];
        
        $this->bd->JqueryDeleteSQL('presupuesto.pre_gestion_periodo',
            'anio ='.$this->bd->sqlvalue_inyeccion($anio , true). " and tipo ='G' "
            );
        
             
        $sql_saldos = "INSERT INTO presupuesto.pre_gestion_periodo (tipo, funcion, titulo, grupo, subgrupo, item, orientador, 
                        proforma, inicial, aumento, disminuye, codificado, certificado, compromiso, devengado, pagado, 
                    anio, proyecto, competencia, partida, detalle, fuente) 
                SELECT  tipo, funcion, titulo, grupo, subgrupo, item, orientador,  proforma, inicial, 0 as aumento, 0 as disminuye, 0 as codificado,
                    0 as certificado, 0 as compromiso, 0 as devengado, 0 as pagado, 
                    anio, proyecto, competencia, partida, detalle, fuente
                FROM presupuesto.pre_gestion
                where tipo = 'G' and (inicial + abs(codificado)  )  >  0 and anio = ".$this->bd->sqlvalue_inyeccion( $anio , true);


                $this->bd->ejecutar($sql_saldos);

        
        $this->saldo_Reformas_periodo($anio,$f1,$f2,'G');
 
        
        $this->saldo_gastos_periodo($f1,$f2);
        
        
        
    }
    ///-------------------------------------------------------------------------
    function PresupuestoPeriodo_ingreso($f1,$f2 ){
        
        
        $aperiodo = explode('-',$f2);
        
        $anio = $aperiodo[0];
        
        
        $this->bd->JqueryDeleteSQL('presupuesto.pre_gestion_periodo',
                                    'anio ='.$this->bd->sqlvalue_inyeccion($anio , true). " and tipo ='I' "
            );
        
  

        $sql_saldos = "INSERT INTO presupuesto.pre_gestion_periodo (tipo, funcion, titulo, grupo, subgrupo, item, orientador, 
                                proforma, inicial, aumento, disminuye, codificado, certificado, compromiso, devengado, pagado, 
                               anio, proyecto, competencia, partida, detalle, fuente) 
                        SELECT  tipo, funcion, titulo, grupo, subgrupo, item, orientador,  proforma,  inicial, 0 as aumento, 0 as disminuye, 0 as codificado,
                            0 as certificado, 0 as compromiso, 0 as devengado, 0 as pagado, 
                            anio, proyecto, competencia, partida, detalle, fuente
                        FROM presupuesto.pre_gestion
                        where (inicial + abs(codificado)  )  >  0 and  tipo = 'I' and anio = ".$this->bd->sqlvalue_inyeccion( $anio , true);


         $this->bd->ejecutar($sql_saldos);
         
        
         $this->saldo_Reformas_periodo($anio,$f1,$f2,'I');
        
        
        $this->saldo_ingreso_periodo($f1,$f2);
        
        
        
    }
}

?>