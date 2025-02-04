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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_tramite, $id_asiento, $ctipo ){
      
          
          $tipo = $this->bd->retorna_tipo();
          
          $cadena    = " || ' '" ;
          
          //-----------------------------------------------------------
          $sql = "SELECT  cuenta ".$cadena. " as cuenta , detalle_cuenta as detalle,  partida  ".$cadena. " as partida,   sum(haber) as monto 
                    FROM  view_asientocxp_nomina
                    where id_tramite = ". $this->bd->sqlvalue_inyeccion($id_tramite, true)." and  
                          modulo = ".$this->bd->sqlvalue_inyeccion($ctipo, true)." and   
                          pagado = 'N' and cuenta like '2%'
                    group by cuenta, detalle_cuenta,  partida order by cuenta";


 
          
          $resultado1 = $this->bd->ejecutar($sql);
          
          $this->obj->grid->KP_sumatoria(4,"monto","", "","");
          
          $this->obj->grid->KP_GRID_visor($resultado1,$tipo,'100%');
      	
 
 
      	
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
 
   
    $id_tramite   = $_GET['id_tramite'] ;
    $id_asiento   = $_GET['id_asiento'] ;
    $ctipo       = $_GET['ctipo'] ;
   
    $gestion->FiltroFormulario($id_tramite, $id_asiento, $ctipo);

 ?>


 
  