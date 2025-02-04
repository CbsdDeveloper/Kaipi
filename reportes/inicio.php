<?php 

     session_start( );   
  
    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    class componente{
 
      private $obj;
      private $bd;
       private $POST;
      //--------------------
       private   $Afile;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 
                $this->sesion 	 =  $_SESSION['login'];
                
                   
              
      }

   //----------------------------------------------
   function _getCarpeta($codigo){
       
       
	   $ruc       =  trim($_SESSION['ruc_registro']);
	   
       $this->Afile = $this->bd->query_array('wk_config',
           'carpeta,  carpetasub,formato',
           'tipo='.$this->bd->sqlvalue_inyeccion( $codigo ,true).' and 
		   registro = '.$this->bd->sqlvalue_inyeccion( $ruc ,true)
           );
       
	   $dcarpeta = trim($this->Afile['carpeta']);
	   
	   if ($dcarpeta == 'local'){
		   $dcarpeta = '';
	    }  
	   
	   if ($dcarpeta == '-'){
		   $dcarpeta = '';
	    } 
	   
       $carpeta = $dcarpeta.trim($this->Afile['carpetasub']);
       
       return $carpeta;
 
  }  
	///------------- _getCarpeta_cierre	
function _getCarpeta_cierre($codigo){
       
       
	   $ruc       =  trim($_SESSION['ruc_registro']);
	   
       $this->Afile = $this->bd->query_array('wk_config',
           'carpeta,  carpetasub,formato',
           'tipo='.$this->bd->sqlvalue_inyeccion( $codigo ,true).' and 
		   registro = '.$this->bd->sqlvalue_inyeccion( $ruc ,true)
           );
       
	   $dcarpeta = trim($this->Afile['carpeta']);
	   
	   if ($dcarpeta == '-'){
	       $dcarpeta = '';
	   }
	   
       $carpeta = $dcarpeta.trim($this->Afile['carpetasub']);
       
       return $carpeta;
 
  }  		
  //----------------------------------------------
  function _getFormato(){
      
      
      
      $carpeta = trim($this->Afile['formato']);
      
      return $carpeta;
      
  }  
  
  //----------------------------------------------
    
 function detalle_movimiento($codigo){
       
 
  $sql_detalle = ' SELECT a.id_rubro, c.reporte 
FROM rentas.ren_movimiento a, rentas.ren_rubros c
where a.id_renpago = '.$this->bd->sqlvalue_inyeccion($codigo, true).' and a.id_rubro = c.id_rubro 
group by a.id_rubro, c.reporte';
  
   


$stmt_detalle = $this->bd->ejecutar($sql_detalle);  

  
return $stmt_detalle;
 

}  	
  ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
 