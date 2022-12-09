<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_menu_lateral_tarea{
 
  
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
      function Controller_menu_lateral_tarea( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario($tarea){
      
      	/*
          
          $datos = $this->bd->query_array(
               'planificacion.sitarea',
               'modulo, tarea,recurso,responsable, fechainicial, fechafinal,enlace_pac', 
               'idtarea='.$this->bd->sqlvalue_inyeccion($tarea,true)." and estado ='S'"
              );
          
          $requerimiento = trim($datos['modulo']);
          
           
          $sqlO1= 'SELECT  secuencia, id_departamento, proceso
              FROM planificacion.proceso
              where tipo ='.$this->bd->sqlvalue_inyeccion($requerimiento,true)." and 
                    estado ='S'
              order by secuencia";
 
          echo '<div class="list-group">
          <a href="#" class="list-group-item active">Guia del Proceso</a>';
          
          
          
          $stmt_ac = $this->bd->ejecutar($sqlO1);
          
          while ($x=$this->bd->obtener_fila($stmt_ac)){
              
              $proceso   = trim($x[proceso]);
                
              $id_departamento = $x[id_departamento];
              
               
              if ( $id_departamento > 0  ){
                   echo '<a href="#"   title="SELECCIONE EL TIPO DE PROCESO QUE VA A EJECUTAR..." class="list-group-item">' .$proceso .'</a>';
              }else {
                   echo '<a href="#"   title="SELECCIONE EL TIPO DE PROCESO QUE VA A EJECUTAR..."  class="list-group-item"><span style="color: #026BEF"> ' .$proceso .'</span></a>';
              }
              
           
               
          }
              
        
          
          
         
          echo '</div>';
          
          
      */
      	
       
      	 
 
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new Controller_menu_lateral_tarea;
  
        
   $tarea    = $_GET['tarea'];
 
    
   $gestion->FiltroFormulario( $tarea);
   

 ?> 