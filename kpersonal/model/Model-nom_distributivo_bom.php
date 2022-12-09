<?php 
session_start( );   
  
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	     = 'bomberos.asignacion_dis';
                $this->secuencia 	     = 'bomberos.asignacion_dis_id_asigna_dis_seq';
                
 

                $this->ATabla = array(
                    array( campo => 'id_asigna_dis',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha_solicitud',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'doccumento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'autoriza',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'operaciones',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $this->hoy, key => 'N') 
                );
                
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                      if ($accion == 'del')    
                          $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
                          
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
         array( campo => 'id_asigna_dis',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'fecha_solicitud',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'doccumento',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'autoriza',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'operaciones',   valor => '-',  filtro => 'N',   visor => 'S')
            );
            
 
 
             $this->bd->JqueryArrayVisor('bomberos.asignacion_dis',$qquery );           
 
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
     	
 
        	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia);
        	
         	$result = $this->div_resultado('editar',$id,1) ;
   
            echo $result;
          
     }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
 
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
         	
           $result = $this->div_resultado('editar',$id,1) ;
            
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
       
         $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>TRANSACCION ELIMINADA CON EXITO</b>';

         $cadena = 'id_asigna_dis='.$this->bd->sqlvalue_inyeccion(trim($id), true). ' and 
                    estado='.$this->bd->sqlvalue_inyeccion(trim('digitado'), true);

         $this->bd->JqueryDeleteSQL('bomberos.asignacion_dis',  $cadena );	

         $this->div_limpiar();
  
       echo $result;
      
   }
   /*
   */
   
   function autorizar_aprobar($id,$estado ){
      

    $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PROCESO YA GENERADO....</b>';
     	 
    
    if ( $estado == 'digitado'){

        $sql1 = "update bomberos.asignacion_dis
                 set estado = 'aprobado', activo = 'S'
                where id_asigna_dis =". $this->bd->sqlvalue_inyeccion($id,true) ;
            
                $this->bd->ejecutar($sql1);


                $sql = "SELECT  *
                FROM bomberos.view_dis_bom_lista
                where id_asigna_dis= ".$this->bd->sqlvalue_inyeccion(   $id , true)."   
                     order by responsable desc, funcionario";

                     $stmt1 = $this->bd->ejecutar($sql);

                    while ($fila=$this->bd->obtener_fila($stmt1)){
                        

                                $sql = "UPDATE nom_personal
                                    SET id_departamento=".$this->bd->sqlvalue_inyeccion($fila['id_departamento'], true).",
                                        responsable=".$this->bd->sqlvalue_inyeccion(trim($fila['responsable']), true)."
                                WHERE idprov=".$this->bd->sqlvalue_inyeccion(trim($fila['idprov']), true);
         
                                $this->bd->ejecutar($sql);


                                $sql = "UPDATE par_usuario
                                    SET id_departamento=".$this->bd->sqlvalue_inyeccion($fila['id_departamento'], true).",
                                        responsable=".$this->bd->sqlvalue_inyeccion(trim($fila['responsable']), true)."
                                WHERE cedula=".$this->bd->sqlvalue_inyeccion(trim($fila['idprov']), true);
         
                                $this->bd->ejecutar($sql);
          
                    

                    }
                   
                    $sql1 = "update bomberos.asignacion_dis
                    set  activo = 'N'
                   where estado = 'aprobado' and  
                         id_asigna_dis <> ". $this->bd->sqlvalue_inyeccion($id,true) ;


               
                   // $this->bd->ejecutar($sql1);


                    $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PROCESO GENERADO CON EXITO....</b>';

                    echo '<script type="text/javascript">';
                    echo  "$('#estado').val('aprobado')";               
                    echo '</script>';

    }
   

    
 

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
            
            $accion    = trim($_GET['accion']);
            $id        = $_GET['id'];
            
            if (  $accion  == 'aprobar'){

                $estado = trim($_GET['estado']);
                $gestion->autorizar_aprobar($id,$estado);

            }  else   {
                $gestion->consultaId($accion,$id);
            }      
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_asigna_dis"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  