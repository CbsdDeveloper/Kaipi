<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
           
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
  
   //----------------------------------------------
      function principal($idepartamento,$anio){
      
 
          $acciones ='';
          $funcion='';
          
          $qcabecera = array(
              array(etiqueta => 'anio',campo => 'anio',ancho => '0%', filtro => 'S', valor => $anio, indice => 'N', visor => 'N'),
              array(etiqueta => 'id_departamento',campo => 'id_departamento',ancho => '0%', filtro => 'S', valor => $idepartamento, indice => 'N', visor => 'N'),
              array(etiqueta => ' ',campo => 'idcaso',ancho => '2%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
              array(etiqueta => 'Descripcion',campo => 'descripcion',ancho => '78%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
              array(etiqueta => 'Fecha',campo => 'fecha',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
              array(etiqueta => 'Descargar',campo => 'archivo',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S')
          );
          
          $acciones = "";
          $funcion = '';
          $this->bd->_order_by('idcaso desc');
          $this->bd->JqueryArrayTable('flow.view_documentos_casos',$qcabecera,$acciones,$funcion,'tabla_aux' );
        
          
   }  
  //------------------
   //----------------------------------------------
   function principal_cadena($cadena,$anio,$ccedula){
       
       
       $acciones ='';
       $funcion='';
       
       $limit  = '10'; 
       $offset = '0';
       
       
       $len = strlen($ccedula);
       $len1 = strlen($cadena);
       
       $filtro1= 'N';
       $filtro2= 'N';
       
       if ($len >= 3 ){
           $filtro1= 'S';
           $filtro2= 'N';
       }else{
            
           if ($len1 >= 3 ){
               $filtro1= 'N';
               $filtro2= 'S';
           }else{
               $filtro1= 'N';
               $filtro2= 'S';
               $this->bd->__limit($limit, $offset);
           }
       }
       
       $cadena = '%'.strtoupper($cadena).'%';
       
      
       
       $qcabecera = array(
           array(etiqueta => 'anio',campo => 'anio',ancho => '0%', filtro => 'S', valor => $anio, indice => 'N', visor => 'N'),
           array(etiqueta => ' ',campo => 'idcaso',ancho => '2%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
           array(etiqueta => 'Descripcion',campo => 'descripcion',ancho => '78%', filtro => $filtro2, valor => 'LIKE.'.$cadena, indice => 'N', visor => 'S'),
           array(etiqueta => 'Fecha',campo => 'fecha',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'idprov',campo => 'idprov',ancho => '10%', filtro => $filtro1, valor => $ccedula, indice => 'N', visor => 'N'),
           array(etiqueta => 'Descargar',campo => 'archivo',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S')
       );
       
       $acciones = "";
       $funcion = '';
       
       
       $this->bd->_order_by('idcaso desc');
       $this->bd->JqueryArrayTable('flow.view_documentos_casos',$qcabecera,$acciones,$funcion,'tabla_aux' );
       
       
   }  
  
  //-------------------------- 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['accion']))	{
  	
  	$idproceso        = $_GET['departamento'];
  	$anio             = $_GET['anio'];
  	$accion           = $_GET['accion'];
  	$cadena           = $_GET['cadena'];
  	$ccedula          = $_GET['ccedula'];

  	if ($accion == 1){
  	    $gestion->principal_cadena($cadena,$anio,$ccedula);
  	}else {
  	    $gestion->principal($idproceso,$anio);
  	}
  	
  	
  }
 
?>

 