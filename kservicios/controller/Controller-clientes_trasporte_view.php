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
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  $this->bd->hoy();
				
                 
      }
     //---------------------------------------
     function Formulario( ){
      
       
        $sql1 = "SELECT idprov, razon,id_par_ciu,correo ,contacto,grafico
                    FROM par_ciu
                    where estado = 'S' and serie = 'C'
                    order by razon 
                    limit 10";
                    
        $stmt =  $this->bd->ejecutar($sql1);

 
     


        $i = 1;
 

        while ($fila= $this->bd->obtener_fila($stmt)){
            
            $codigo = trim($fila['idprov']) ;
            $marca  = trim($fila['contacto']) ;
            $id_par_ciu  = trim($fila['id_par_ciu']) ;
            $correo      = trim($fila['correo']) ;
            $grafico      = trim($fila['grafico']) ;

            $evento = ' onClick="ver_cliente_ruta('."'".$codigo."'".','."'" .$marca."'".')" ';

          

            echo ' <div class="col-md-4"  align="center" style="padding-bottom: 10px;padding-top: 10px">';

            echo '  <a href="#" '.$evento .' ><img src="../../kimages/'.$grafico.'" align="absmiddle" width="150" height="120" alt=""/> <br><b>'.$marca.'</b></a><br>';
            
            echo '</div>';
            
         
             

            $i++;
 
        }

      


      
   }
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
?>

