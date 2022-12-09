<?php 
     session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
  
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
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =  date('Y-m-d');
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'bomberos.bombero_carro';
                
                 $this->secuencia 	     = 'bomberos.bombero_carro_id_bom_carro_seq';
     
                 $time =  date('H:i:s');

                $this->ATabla = array(
                    array( campo => 'id_bom_carro',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_bita_bom',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'actividad_c',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_creacion',tipo => 'DATE',id => '3',add => 'S', edit => 'S', valor => $this->hoy 	, key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$this->sesion , key => 'N'),
                    array( campo => 'idbien',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'carro_tipo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'km',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'comb',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'aceite_a',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'aceite_c',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tiempo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$time , key => 'N'),
                );
 
      
              
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
         
       	   
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
 function consultaId($accion,$id ){
          
 	
  	
        $qquery = array( 
                    array( campo => 'id_bom_carro',   valor =>$id,  filtro => 'S',   visor => 'S'),
                     array( campo => 'idbien',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'actividad_c',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'km',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'comb',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'aceite_a',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'aceite_c',valor => '-',filtro => 'N', visor => 'S')
                      );
 
  
          
            $this->bd->JqueryArrayVisor('bomberos.bombero_carro',$qquery );           
 
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
     	
          
           $id     = $_POST["id_bita_bom_03"];
        
             
           $this->ATabla[1][valor] =  $id ;
         
         
        	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia  );
     	    
            //------------ seleccion de periodo
          
            $result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
       	
            $result = $this->div_resultado('editar',$id,1);
            
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
         $this->bd->JqueryDeleteSQL($this->tabla,'id_bom_carro='.$this->bd->sqlvalue_inyeccion($id, true));
         
         $result ='<b>DATO ELIMINADO CORRECTAMENTE....</b>';
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

     if (isset($_POST["action_03"]))	{
        
            $action = $_POST["action_03"];
        
            $id     = $_POST["id_bom_carro"];
        
           $gestion->xcrud(trim($action),$id );
           
    }         
  
    
   
 ?>