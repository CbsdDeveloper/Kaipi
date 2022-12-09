<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(  ){
      
 
        $datos = array();
        
        $MATRIZ =  $this->obj->array->catalogo_anio();
        
        $evento= '';
        
        $this->obj->list->listae('Periodo',$MATRIZ,'panio',$datos,'required','',$evento,'div-2-10');
        
        echo '<div class="col-md-12" style="padding: 20px">';
       
        $sql1 = "SELECT id_departamento ,unidad
                FROM flow.view_documentos_casos
                group by id_departamento ,unidad";
        
        $stmt1 = $this->bd->ejecutar($sql1);
        
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
            $id_departamento  =  $fila['id_departamento'];
            $unidad           =  trim($fila['unidad']);
            
           
            
            echo ' <div class="col-md-3" align="center"><a onClick="BuscarArchivos('.$id_departamento.')" href="#">	
				   <img src="../../kimages/folder_seg.png" width="48" height="48" title = "Buscar archivos por unidad"/> </a> 
					<br>'.$unidad.'</div>';
            
        }
        
        
        echo '</div>';
      }
   
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }   
 
 
   $gestion   = 	new componente;
  
    
   $gestion->FiltroFormulario(   );

 ?>


 
  