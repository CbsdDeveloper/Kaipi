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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
                $this->anio       =  $_SESSION['anio'];
                
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( $qunidad , $qambito  ){
      
      	 
        $output = array();
      	
		if ( $qunidad == '-'){
			$where = ' anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true) ;
 	  	}else {
 			$where = ' anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true)  .' and id_departamento = '.$qunidad ;
	  	}
			
 
	   if ( $qambito == '-'){
			$where = ' anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true) ;
	  	}else {
			if ( $qambito  == 'AGREGADORA DE VALOR'){
 				$where = ' anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true)  .' and ambito = '."'".trim($qambito)."'" ;
			}else	{
				$where = ' anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true)  .' and ambito <>'."'".trim($qambito)."'" ;
		   } 
	  	}

 

		 $sql = 'SELECT *
						      FROM view_nomina_vacacion_resumen 
							 WHERE '. $where. ' order by razon';



			$resultado  = $this->bd->ejecutar($sql);

      	
      	
       
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 

			$x = $this->bd->query_array('nom_cvacaciones',
			'saldo_anterior, dias_derecho, dias_tomados, dias_pendientes,horas_tomadas, horas_dias, dias', 
			'idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov'] ),true) .' and 
 			 periodo ='.$this->bd->sqlvalue_inyeccion($this->anio,true)  
           );


		   $y= $this->bd->query_array('nom_vacaciones',
		   'count(*) as nn', 
		   'idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov'] ),true) .' and 
		    estado='.$this->bd->sqlvalue_inyeccion('4',true) .' and 
		    anio ='.$this->bd->sqlvalue_inyeccion($this->anio,true)  
		  );
 
		  $cimagen = '';

		  $nombre = trim($fetch['razon']);

		  if (  $y['nn'] > 0 ) {

			$cimagen = '<img src="../../kimages/alert.png" align="absmiddle" /> ';

			$nombre =  '<b>'. $nombre .'</b>';
			}

      		$output[] = array (
						    $fetch['unidad'],
							$cimagen. $nombre,
      		                $fetch['cargo'],
      		                $fetch['fecha_ingreso'],
      		                $x['dias_derecho'],
                  		    $x['saldo_anterior'],
                  		    $x['dias_tomados'],
                  		    $x['horas_tomadas'],
      		                $x['dias_pendientes'] ,
      		                $fetch['idprov'] 
       		);
       
      		 
      	}
      
      	echo json_encode($output);
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
            if (isset($_GET['qunidad']))	{
            
                 $qunidad  = $_GET['qunidad'];

				 $qambito  = $_GET['qambito'];

				 
                 
                $gestion->BusquedaGrilla( $qunidad , $qambito );
            	 
            }
  
  
   
 ?>
 
  