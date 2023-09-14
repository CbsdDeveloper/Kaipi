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
      private $anio;
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

                $this->anio       =  $_SESSION['anio'];
        
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
                array( campo => 'periodo',   valor =>  $this->anio ,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'estado',   valor => $qestado ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'id_departamento',   valor => $qunidad ,  filtro => $filtro,   visor => 'N'),
      	        array( campo => 'regimen',   valor => trim($qregimen) ,  filtro => $filtror,   visor => 'N') 
      	);
          
          

      	
      	$resultado = $this->bd->JqueryCursorVisor('view_nomina_vaca',$qquery);
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 

          /*
                total = saldo_anterior + dias_derecho
                dias_tomados  // suma todos los dias
                dias_pendientes = total - dias_tomados
                // tabla vacaciones

                   dia_acumula  = valor q se va  calcular
                dia_tomados dias
                hora_tomados horas
                */
            $total = $fetch['saldo_anterior'] + $fetch['dias_derecho'];

            $this->suma_dias( $fetch['id_cvacacion'],trim($fetch['idprov']) ,  $fetch['ajuste'],  $fetch['periodo'], $total);

            $pendiente =  $total -  ($fetch['dias_tomados'] +  $fetch['ajuste']);
         
      		$output[] = array (
      		                $fetch['unidad'],
      		                $fetch['razon'],
      		                $fetch['cargo'],
      		                $fetch['fecha'],
      		                $fetch['saldo_anterior'],
      		                $fetch['dias_derecho'],            
      		                $fetch['dias_tomados'],   
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
                                    'sum(dia_acumula) total,
                                     sum(dia_tomados) dia_tomados,
                                     sum(hora_tomados) hora_tomados', 
                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true) .' and 
                                     estado ='.$this->bd->sqlvalue_inyeccion( '2',true) .' and
                                     anio ='.$this->bd->sqlvalue_inyeccion(  $this->anio     ,true) 
         );
        
        
      
 
         if(  ($x["dia_tomados"]  +   $x["hora_tomados"] ) > 0  ){
  
            $saldo 			        = $x["total"] ;
            $dia_tomados 			= $x["dia_tomados"] ;
            $hora_tomados 			= $x["hora_tomados"] ;
        }else{
  
            $saldo 			        = 0 ;
            $dia_tomados 			= 0;
            $hora_tomados 			= 0 ;
        }


        $sql = "update nom_cvacaciones
				  set dias_tomados= coalesce(ajuste,0) + ".$this->bd->sqlvalue_inyeccion($saldo,true)." ,
                      horas_dias =".$this->bd->sqlvalue_inyeccion($hora_tomados,true)." ,
                      dias= ".$this->bd->sqlvalue_inyeccion($dia_tomados,true)." ,
                      dias_pendientes=(saldo_anterior + dias_derecho - coalesce(ajuste,0) ) - ".$this->bd->sqlvalue_inyeccion($saldo,true).'
				  where  
                  idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true) .' and 
                  periodo ='.$this->bd->sqlvalue_inyeccion(  $this->anio     ,true) ;
        

                 
        $this->bd->ejecutar($sql);
       
        
 

       
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
 
  