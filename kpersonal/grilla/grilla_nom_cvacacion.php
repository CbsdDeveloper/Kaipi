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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($qestado,$qunidad ,$qregimen){
      
      	 
        $output = array();
        
		$filtro = 'S';
		$filtror = 'S';
		
		if ( $qunidad == '-'){
			$filtro = 'N';
	  	}
			
	  	if ( $qregimen == '-'){
	  	    $filtror = 'N';
	  	}
		   	
		   	
			
      	$qquery = array(
      	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
       	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'saldo_anterior',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'dias_derecho',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'dias_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'dias_pendientes',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
                  array( campo => 'id_cvacacion',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'ajuste',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'periodo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'estado',   valor => $qestado ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'id_departamento',   valor => $qunidad ,  filtro => $filtro,   visor => 'N'),
      	        array( campo => 'regimen',   valor => trim($qregimen) ,  filtro => $filtror,   visor => 'N') 
      	);
          
          

      	
      	$resultado = $this->bd->JqueryCursorVisor('view_nomina_vaca',$qquery);
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 

      
            $total = $fetch['saldo_anterior'] + $fetch['dias_derecho'];

            $diferencia = $this->suma_dias( $fetch['id_cvacacion'],trim($fetch['idprov']) ,  $fetch['ajuste'],  $fetch['periodo'], $total);

            $pendiente =  $total - $diferencia;
         
      		$output[] = array (
      		                $fetch['unidad'],
      		                $fetch['razon'],
      		                $fetch['cargo'],
      		                $fetch['fecha'],
      		                $fetch['saldo_anterior'],
      		                $fetch['dias_derecho'],            
      		                $diferencia,
                            round($pendiente,2),  
                            trim($fetch['idprov']),
                            $fetch['ajuste'],  
       		);
      
      	 
      		 
      	}
      
      	echo json_encode($output);
      }
   /*
   suma valida dias
   */
      function suma_dias( $id_cvacacion, $id ,$ajuste, $periodo, $total ){
        

 
        $x = $this->bd->query_array('nom_vacaciones',
                                    ' sum(dia_acumula) total,sum(dia_tomados) dia,sum(hora_tomados) hora', 
                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true) .' and 
                                     estado ='.$this->bd->sqlvalue_inyeccion( '2',true) .' and
                                     anio ='.$this->bd->sqlvalue_inyeccion( $periodo,true) ." and
                                     cargoa = 'S' "
         );
        
        
        
        $saldo 			= $x["total"]  + $ajuste;
        
        $diferencia  = $total -  $saldo ;
         
        
        $sql = "update nom_cvacaciones
				  set dias_tomados=".$this->bd->sqlvalue_inyeccion($saldo,true)." ,
                      horas_tomadas=".$this->bd->sqlvalue_inyeccion( $x["hora"],true)." ,
                      dias=".$this->bd->sqlvalue_inyeccion( $x["dia"],true)." ,
                      dias_pendientes=".$this->bd->sqlvalue_inyeccion($diferencia,true)." 
				  where  
                  id_cvacacion =".$this->bd->sqlvalue_inyeccion($id_cvacacion,true)  ;
        
        $this->bd->ejecutar($sql);
       
        return   $saldo;
 

       
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
            if (isset($_GET['qestado']))	{
            
                $qestado   = $_GET['qestado'];
                $qunidad   = trim($_GET['qunidad']);
                $qregimen  = trim($_GET['qregimen']);
                
                $gestion->BusquedaGrilla($qestado,$qunidad ,$qregimen);
            	 
            }
  
  
   
 ?>
 
  