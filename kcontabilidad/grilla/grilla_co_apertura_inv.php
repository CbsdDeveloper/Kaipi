<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
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
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($fanio,$grupo ){
      
     
          $anio = $fanio - 1;
      
          $sql = "select cuenta,sum(debe)as debe, sum(haber) as haber
        from view_diario_conta
        where subgrupo like ". $this->bd->sqlvalue_inyeccion($grupo.'%' ,true) ." and 
                anio =". $this->bd->sqlvalue_inyeccion($anio ,true) ."  
        group by cuenta
        order by cuenta";
                  
          
           
          $resultado  = $this->bd->ejecutar($sql);
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
        
      	  
      	    $x = $this->bd->query_array('co_plan_ctas',    
      	        'detalle',                      
      	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($fetch['cuenta']),true). ' and 
                  anio = '.$this->bd->sqlvalue_inyeccion($anio,true)
      	        );
      	  
     
      	     
      	    $cuenta = $x_dato['cuenta'];
      	    
       	    
              $saldo = $fetch['debe'] - $fetch['haber'] ; 

              if (    $saldo    <> 0 ) {
      	 
                        $output[] = array (
                                            trim($fetch['cuenta']),
                                            trim($x['detalle']),
                                            $fetch['debe'],
                                            $fetch['haber'],
                                            round($saldo,2)
                        );
                    }
      	}

      	echo json_encode($output);
      	
      	
      	}
 
      	
   //---------------------
      	public function total_98($fanio,$cuenta ){
      	    
      	    $sql = "select id_asiento,  debe
                      from view_diario_conta  
                     where cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)." 
                           and anio= ".$this->bd->sqlvalue_inyeccion($fanio ,true) ;

       	    
      	    $resultado_asiento  = $this->bd->ejecutar($sql);
      	    
      	    $total = 0;
      	    
      	    $subgrupo_acumulacion = substr($cuenta, 0,3);
      	    
       	    $cuenta = trim($subgrupo_acumulacion).'.98';
      	    
      	    while ($fetch_dato=$this->bd->obtener_fila($resultado_asiento)){
      	        
      	        $x = $this->bd->query_array('view_diario_conta',  
      	            'sum(haber) as dato',                      
      	            'id_asiento='.$this->bd->sqlvalue_inyeccion($fetch_dato['id_asiento'],true)  ." and
                    subgrupo = ".$this->bd->sqlvalue_inyeccion($cuenta,true) 
      	            );
      	        
      	        if ( $x['dato'] > 0 ){
      	            $total = $total +  $fetch_dato['debe'];
      	        }
      	     
      	        
      	    }
      	    
      	    $x_dato['cuenta'] = $cuenta;
      	    $x_dato['haber'] = $total;
      	    
      	    pg_free_result($resultado_asiento);
      	    
      	    return $x_dato;
      	}
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
  
            //------ consulta grilla de informacion
            if (isset($_GET['fanio']))	{
            
                $fanio  = $_GET['fanio'];
            	$grupo  = $_GET['grupo'];
             	 
            	$gestion->BusquedaGrilla($fanio,$grupo );
            	 
            }
  
  
   
 ?>
 
  