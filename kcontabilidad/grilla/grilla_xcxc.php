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
      public function BusquedaGrilla( ){
      
      	
      
       	$cadena0 =  '(  registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '(  tipo_cuenta ='.$this->bd->sqlvalue_inyeccion(trim('C'),true).") and ";
      	
      	$cadena2 = '(  saldo <> '.$this->bd->sqlvalue_inyeccion(0,true).")   ";
  
      	
      	$where = $cadena0.$cadena1.$cadena2;
      	
      	$sql = 'SELECT idprov,
                       cuenta,razon,
                      saldo
                from view_aux_saldos where '. $where;
 
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      
      	    $x = $this->bd->query_array('par_ciu','novedad', 'idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true));
      	    
      	    
      	    $y = $this->bd->query_array('view_aux_saldos','sum(saldo) as saldo',
      	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true). ' AND
                                        tipo_cuenta ='.$this->bd->sqlvalue_inyeccion(trim('M'),true)
      	        
      	        );
      	    
      	    $saldocxp = $fetch['saldo'] ;
      	    
      	    $saldo_general =  $saldocxp -  $y['saldo'] ;
      	    
 	        $output[] = array (
      				    $fetch['idprov'],
 	                    strtoupper($fetch['razon']),
 	                    $x['novedad'],
 	                    $saldo_general
       		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
      	
//------------------ 
function _11_ActualizaMovimiento($id ,$idprov  ){
      	    
      	    $Array_Cabecera = $this->bd->query_array(
      	        'view_anexos_compras',
      	        'secretencion1, autretencion1',
      	        'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true).' and codigoe = 1 and 
                 idprov ='.$this->bd->sqlvalue_inyeccion($idprov,true)
      	        );
      	    
      	     
      	    
      	 return $Array_Cabecera['autretencion1'] ;
      	    
  
      	    
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
 
    
             	 
            	$gestion->BusquedaGrilla( );
  
   
 ?>
 
  