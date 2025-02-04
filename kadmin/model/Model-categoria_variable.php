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
      private $ATabla;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'web_categoria_var';
                
                $this->secuencia 	     = 'web_categoria_var_idcategoriavar_seq';
                
                $this->ATabla = array(
                		 array( campo => 'idcategoriavar',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                         array( campo => 'idcategoria',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                         array( campo => 'nombre_variable',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                         array( campo => 'registro',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                         array( campo => 'imprime',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                         array( campo => 'tipo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                         array( campo => 'lista',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N')
                );
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion_variable('. $id. ','. "'".$accion."'" .')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                      if ($accion == 'del')    
                          $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                          
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                 
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
      function consultaId($idcategoriavar ){
          
 	
  	
        $qquery = array( 
            array( campo => 'idcategoriavar',   valor => $idcategoriavar,  filtro => 'S',   visor => 'S'),
            array( campo => 'nombre_variable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'lista',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'imprime',valor => '-',filtro => 'N', visor => 'S')
                    );
 
          
         $this->bd->JqueryArrayVisorObj('web_categoria_var',$qquery ,0);           
 
         $result =  $this->div_resultado('editar',$idcategoriavar,0);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
      function xcrud($accion,$variable,$idcategoria,$imprime,$idcategoriavar,$tipo,$lista ,$tipo_dato){
          
 
                 // ------------------  agregar
                 if ($accion == 'add'){
                    
                     $this->agregar($variable,$idcategoria,$imprime,$tipo,$lista ,$tipo_dato );
                 
                 }  
                 // ------------------  editar
                 if ($accion == 'editar'){
        
                     $this->edicion( $idcategoriavar,$variable,$idcategoria,$imprime,$tipo,$lista,$tipo_dato   );
     
                 }   
                 // ------------------  eliminar
                 if ($accion == 'del'){
        
                  //   $this->eliminar($id );
     
                 }  
 
                 if ($accion == 'visor'){
                     
                     $this->consultaId( $idcategoriavar );
                     
                 }  
                 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar( $variable,$idcategoria,$imprime,$tipo,$lista,$tipo_dato  ){
     	
        
              
         
         $this->ATabla[1][valor] =  $idcategoria;
         $this->ATabla[2][valor] =  strtoupper (trim($variable)) ;
         $this->ATabla[4][valor] =  trim($imprime) ;
         
         $this->ATabla[5][valor] =  trim($tipo) ;
         $this->ATabla[6][valor] =  strtoupper(trim($lista)) ;
         
         $bandera = 1;
         $lon = strlen($lista);
         $lon1 = strlen($variable);
         
         if ($tipo == 'L'){
             if ( $lon < 5){
                 $bandera = 0;
             }else {
                 $bandera = 1;
             }
         }
         
         
         if ($tipo == 'B'){
             $this->ATabla[6][valor] = trim($tipo_dato) ;
             $bandera = 1;
         }
         //----------variable 
         
         if ( $lon1 < 4 ){
             $bandera = 0;
         }else{
             $bandera = 1;
         }
         	
         if ( $bandera == 0 ){
             
             $GuardaVariable = 'Verifique los datos, lista separado por ,';
             
         }else{
             
             $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia);
             
            $GuardaVariable = $this->div_resultado('editar',$id,1);
             
          }
        	
        	
        	echo $GuardaVariable;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
     function edicion($idcategoriavar,$variable,$idcategoria,$imprime,$tipo,$lista,$tipo_dato ){
 
           $this->ATabla[1][valor] =  $idcategoria;
           $this->ATabla[2][valor] =  strtoupper (trim($variable)) ;
           $this->ATabla[4][valor] =  trim($imprime) ;
           
           $this->ATabla[5][valor] =  trim($tipo) ;
           $this->ATabla[6][valor] =  strtoupper(trim($lista)) ;
           
           $bandera = 1;
           $lon = strlen($lista);
           
           if ($tipo == 'L'){
               if ( $lon < 5){
                   $bandera = 0;
               }else {
                   $bandera = 1;
               }
           }
           
           if ($tipo == 'B'){
               $this->ATabla[6][valor] = trim($tipo_dato) ;
               $bandera = 1;
           }
           
           
           
           if ( $bandera == 0 ){
               $GuardaVariable = 'Verifique los datos, lista separado por ,';
           }else{
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$idcategoriavar);
               $GuardaVariable = $this->div_resultado('editar',$idcategoriavar,1);
           }
 
 
            echo $GuardaVariable;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
       
         
         $sql = " delete  
                   from web_categoria_var
            	  where idcategoriavar=".$this->bd->sqlvalue_inyeccion($id, true);
         
         $this->bd->ejecutar($sql);
         
       
         $GuardaVariable = $this->div_resultado('editar',$id,1);
  
         echo $GuardaVariable;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
     if (isset($_GET['action_variable']))	{
            
            $accion             = $_GET['action_variable'];
            
            $variable           = trim($_GET['variable']);
            $idcategoria        = $_GET['idcategoria'];
            $imprime            = trim($_GET['imprime']);
            $idcategoriavar     = trim($_GET['idcategoriavar']);
           
            $tipo            = trim($_GET['tipo']);
            $lista           = trim($_GET['lista']);
            $tipo_dato       = trim($_GET['tipo_dato']);
            
            
            
            $GuardaVariable = $accion;
     
            if ( $accion == 'del'){
                
                $gestion->eliminar($idcategoriavar); 
                
            }else{
                
                $gestion->xcrud($accion,$variable,$idcategoria,$imprime,$idcategoriavar,$tipo,$lista,$tipo_dato);
                
            }
            
        
             
         
          
     }  
     
 

    
    echo $GuardaVariable;
     
  
     
   
 ?>
 
  