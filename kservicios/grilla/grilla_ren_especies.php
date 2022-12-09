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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($GET){
      
      
          $ffecha1 = $GET['ffecha1'];
          $ffecha2 = $GET['ffecha2'];
          $festado = $GET['festado'];
          $frubro  = $GET['frubro'];

          $ccnombre  = trim($GET['ccnombre']);

          
          $len = strlen(  $ccnombre );
          

          if ( $festado == '-'){
            $cadena0 =  '  ';
          }else {
        
            $cadena0 =  '( estado = '.$this->bd->sqlvalue_inyeccion(trim($festado),true).') and ';
           }
         
        
        $cadena1 = '( idproducto_ser ='.$this->bd->sqlvalue_inyeccion(trim($frubro),true).") and ";

      	$cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 

        if (  $len >4 ) {
          $cadena0  = '( razon like '.$this->bd->sqlvalue_inyeccion(trim('%'.strtoupper($ccnombre).'%'),true).") and ";
          $cadena2  = '';
          $cadena1 = '( idproducto_ser ='.$this->bd->sqlvalue_inyeccion(trim($frubro),true).")   ";
        }
 

      	$where = $cadena0.$cadena1.$cadena2;
      	
 
      	
      	$sql = 'SELECT *
                from rentas.view_ren_especies   where '. $where;
 
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
  
 																					 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
  
          if ( empty( trim($fetch['autorizacion']))){
            $autorizacion = '';
          }else  	
          {
             $autorizacion =  ' ('.trim($fetch['autorizacion']).')' ;
           }
      	 

           if (  trim($fetch['autorizacion']) =='-'){
            $autorizacion = '';
          }

      	    
      	        $razon = '<b>≡ '. trim($fetch['contribuyente']).' '.$autorizacion.'</b>';
      	 

              
      	    
 	          $output[] = array (
      				    $fetch['id_ren_movimiento'],
 				          		$fetch['fecha'],
                         $fetch['idprov'],
  	                     $razon,
                          $fetch['comprobante'],
         	              $fetch['total'] 
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
       echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
 
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
        
            //------ consulta grilla de informacion
            if (isset($_GET))	{
            
 
             	 
                $gestion->BusquedaGrilla($_GET);
            	 
            }
  
  
   
 ?>
 
  