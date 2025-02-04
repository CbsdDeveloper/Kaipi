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
      function FiltroFormulario( $nombre ){
      
 
          
           $sql = 'SELECT   producto, referencia,    unidad,      costo,  saldo,   codigob
    			from web_producto
			   where  estado = '.$this->bd->sqlvalue_inyeccion('S', true). ' AND 
                      producto like '.$this->bd->sqlvalue_inyeccion($nombre.'%', true) ;
          
          $stmt = $this->bd->ejecutar($sql);
          
          $this->cabecera();
          
          
          
          while ($x=$this->bd->obtener_fila($stmt)){
             
              echo '<tr>
                   <td> '.$x['producto'].' </td>
                    <td>  '.$x['unidad'].' </td>
                   <td>  '.$x['codigob'].' </td>
                  <td align="right">  '.$x['costo'].' </td>
                  <td align="right">  '.$x['saldo'].' </td> 
                   </tr>';
              
          }
          
          
          $VisorArticulo = "</tbody></table>";
          
          echo $VisorArticulo;
      
      }
      //-----------------------------------------------------------------
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          
      
          
          echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                     <th> Articulo </th>
                      <th> Unidad </th>
                     <th> Codigo Barra </th>
                     <th> Costo </th>
                    <th> Saldo </th>
                     </tr>
                  </thead>
                <tbody>';
          
          
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   if (isset($_GET['nombre']))	{
       
       
       $nombre       = $_GET['nombre'];
        
       $gestion->FiltroFormulario( $nombre );
       
   }
 

 ?>


 
  