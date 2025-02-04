<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
   
	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
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
                $this->bd	   =		new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
             echo '<script type="text/javascript">';
             
             echo  '$("#action").val("'.$accion.'");';
             
             echo  '$("#id_par_modulo").val("'.$id.'");';
             
             echo '</script>';
             
             
         
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                     $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>'; 
                  if ($accion == 'del')    
                     $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>'; 
                     
             }
             
             if ($tipo == 1){
                
                  
                     $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>'; 
                  
             }
             
             
            return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	
 	$qquery = array( 
 			array( campo => 'id_par_modulo',   valor => $id,  filtro => 'S',   visor => 'S'),
  			array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'vinculo',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'ruta',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'accion',   valor => '-',  filtro => 'N',   visor => 'S')
 	);
 	 
 	
            $datos = $this->bd->JqueryArrayVisor('par_modulos',$qquery );           
 
      
     
             echo '<script type="text/javascript">'.
        		       ' DetalleOpcion(); '.
               	       '</script>';
             
  
        $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                 // ------------------  agregar
                 if ($action == 'add'){
                    
                     $this->agregar( );
                 
                 }  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
/*       
         $cuenta1 = @$_POST["cuenta_inv"];
         $cuenta2 = @$_POST["cuenta_ing"];
         
         $InsertQuery = array(   
                                    array( campo => 'producto',   valor => @$_POST["producto"]),
                                    array( campo => 'referencia',   valor => @$_POST["referencia"]),
                                    array( campo => 'tipo',   valor => @$_POST["tipo"]),
                                    array( campo => 'idcategoria',   valor => @$_POST["idcategoria"]),
                                    array( campo => 'estado',   valor => @$_POST["estado"]),
                                    array( campo => 'url',   valor => @$_POST["url"]),
                                    array( campo => 'idmarca',  @$_POST["idmarca"]),
                                    array( campo => 'unidad',   valor => @$_POST["unidad"]),
                                    array( campo => 'facturacion',   valor => @$_POST["facturacion"]),
                                    array( campo => 'idbodega',   valor => @$_POST["idbodega"]),
                                    array( campo => 'cuenta_inv',   valor => $cuenta1),
                                    array( campo => 'cuenta_ing',   valor => $cuenta2),
                                    array( campo => 'tributo',   valor => @$_POST["tributo"]),
                                    array( campo => 'costo',   valor => @$_POST["costo"])
                                );
                    
            $idD = $this->bd->JqueryInsertSQL('web_producto',$InsertQuery);
            
            //------------ seleccion de periodo
          */
                 
            $result = $this->div_resultado('editar',$idD,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
       
        
             $UpdateQuery = array( 
                        array( campo => 'id_par_modulo',   valor => $id ,  filtro => 'S'),
                        array( campo => 'modulo',   valor => @$_POST["modulo"],  filtro => 'N'),
                        array( campo => 'estado',      valor => @$_POST["estado"],  filtro => 'N'),
                        array( campo => 'tipo',      valor => @$_POST["tipo"],    filtro => 'N'),
                        array( campo => 'publica', valor => @$_POST["publica"],    filtro => 'N'),
                        array( campo => 'ruta',      valor => @$_POST["ruta"],    filtro => 'N'),
                        array( campo => 'detalle',       valor => @$_POST["detalle"],  filtro => 'N') 
               );
  
             
           $this->bd->JqueryUpdateSQL('par_modulos',$UpdateQuery);
             
          $result = $this->div_resultado('editar',$id,1);
            
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
  
     	
     	
     	$sql_consulta = "SELECT count(*) as nro_registros
	  FROM   where fid_par_modulo = ".$id;
  	
            $resultado = $this->bd->ejecutar($sql);
  	 
            $datos_valida = $this->bd->obtener_array( $resultado);
	 
  	  if ($datos_valida['nro_registros'] == 0){
  	     
  	      $this->bd->JqueryDeleteSQL('par_modulos',
                                        'id_par_modulo='.$this->bd->sqlvalue_inyeccion($id, true));
                                        
         
  	  }
		  
       
       $result = $this->div_limpiar();
  
       echo $result;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action = @$_POST["action"];
        
            $id =     @$_POST["idproducto"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  