<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      
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
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
            $datos = array();
               
            $evento = '';
            
            $anio = date('Y');

            $tipo = $this->bd->retorna_tipo();

             $MATRIZ_E= $this->obj->array->catalogo_compras();
       
      		  $MATRIZ_A = array(
                '-'                 => 'No Aplica',
                'BIEN'              => 'BIEN',
                'OBRAS'              => 'OBRAS',
                'CONSULTORIA'       => 'CONSULTORIA',
                'SERVICIO'          => 'SERVICIO'    
            );

            $MATRIZ_B = array(
                '-'                 => 'No Aplica',
                'COMUN'             => 'COMUN',
                'ESPECIAL'          => 'ESPECIAL'   
            );

            $MATRIZ_C = array(
                '-'                     => 'No Aplica',
                'GASTO CORRIENTE'       => 'GASTO CORRIENTE',
                'PROYECTO DE INVERSION' => 'PROYECTO DE INVERSION'   
            );

            $MATRIZ_D = array(
                '-'        => 'No Aplica',
                'NORMALIZADO'      => 'NORMALIZADO',
                'NO NORMALIZADO'   => 'NO NORMALIZADO'   
            );

            $MATRIZ_F = array(
                $anio        =>  $anio,
                $anio-1      =>  $anio-1,
                $anio-2   => $anio-2,
                $anio-3   => $anio-3,
                $anio-4   => $anio-4,
            );
      
         $this->obj->list->listae('<b>Periodo</b>',$MATRIZ_F,'anio',$datos,'required','',$evento,'div-2-4');

    	  $this->obj->list->listae('Tipo',$MATRIZ_A,'btipo',$datos,'required','',$evento,'div-2-4');
          
          $this->obj->list->listae('Regimen',$MATRIZ_B,'bregimen',$datos,'required','',$evento,'div-2-4');

          $this->obj->list->listae('Tipo de proyecto',$MATRIZ_C,'btipo_proyecto',$datos,'required','',$evento,'div-2-4');

          $this->obj->list->listae('Tipo de producto',$MATRIZ_D,'btipo_producto',$datos,'required','',$evento,'div-2-4');

          
          $resultado = $this->bd->catalogo_compras() ;
          $this->obj->list->listadbe($resultado,$tipo,'Procedimiento','bprocedimiento',$datos,'required','',$evento,'div-2-4');
      

      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>