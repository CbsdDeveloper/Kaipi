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
      function FiltroFormulario( $anio, $mes ,$idcategoria ){
      
  
          
          
           $sql = 'SELECT   idproducto, producto, count(*) as registros,sum(total) as total
    			from view_mov_aprobado
			   where  anio = '.$this->bd->sqlvalue_inyeccion($anio, true). ' and 
                      mes = '.$this->bd->sqlvalue_inyeccion($mes, true). ' and 
                      tipo_inventario = '.$this->bd->sqlvalue_inyeccion('S', true). ' and 
                      idcategoria =  '.$this->bd->sqlvalue_inyeccion($idcategoria, true).'
                group by idproducto, producto
               order by producto';

 
          $stmt = $this->bd->ejecutar($sql);
          
          $this->cabecera();
          
          
          
          while ($x=$this->bd->obtener_fila($stmt)){
             
              echo '<tr>
                   <td> '.$x['idproducto'].' </td>
                   <td> '.$x['producto'].' </td>
                   <td align="right">  '.$x['registros'].' </td>
                   <td align="right">  '.$x['total'].' </td>
                    </tr>';
              
          }
          
          
          $VisorArticulo = "</tbody></table>";
          
          echo $VisorArticulo;
      
      }
      //-----------------------------------------------------------------
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          

          
          echo '<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                     <th> Referencia </th>
                     <th> Servicio </th>
                     <th> Registros </th>
                     <th> Total </th>
                     </tr>
                  </thead>
                <tbody>';
          
          
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   if (isset($_GET['anio']))	{
       
       
       $anio       = $_GET['anio'];
       $mes       = $_GET['mes'];
       $idcategoria       = $_GET['idcategoria'];
        
       $gestion->FiltroFormulario( $anio, $mes ,$idcategoria );
       
   }
 
   
 

 ?>


 
  