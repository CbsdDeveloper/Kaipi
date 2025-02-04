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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$qid_asiento){
      
      	
      	$sql_ruc ='(SELECT x.razon FROM par_ciu x where x.idprov = a.idprov) as razon';
     
       	$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '( a.estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
      
      	$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	if ( $qid_asiento  > 0 ){
      	    $where = $cadena0.' id_asiento='.$this->bd->sqlvalue_inyeccion($qid_asiento,true);
      	}else{
      	    $where = $cadena0.$cadena1.$cadena2;
      	}
      	
      	
      	
      	$sql = 'SELECT a.id_asiento,
                       a.fecha,
                       a.comprobante,  a.estado,
                       a.detalle,'.$sql_ruc.',
                       a.tipo,
                       a.modulo,a.id_tramite
                from co_asiento a where '. $where;
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    
          	     $ASaldo = $this->bd->query_array('co_asientod',
      	                                      'sum(debe) as debe, sum(haber) as haber', 
          	                                  'id_asiento='.$this->bd->sqlvalue_inyeccion($fetch['id_asiento'],true)
      	         );
      	    
      	    
      	    
      	    
             	$output[] = array (
                  				    $fetch['id_asiento'],
             						$fetch['fecha'],
             	                    trim($fetch['estado']),
            						trim($fetch['comprobante']),
                  				    trim($fetch['razon']).' '.trim($fetch['detalle']),
                  				    $ASaldo['debe'],
             	                    $ASaldo['haber'],
									 $fetch['id_tramite'], 
                    		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['festado']))	{
            
            	$festado= $_GET['festado'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
            	$qid_asiento= $_GET['qid_asiento'];
             	 
            	
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$qid_asiento);
            	 
            }
  
  
   
 ?>
 
  