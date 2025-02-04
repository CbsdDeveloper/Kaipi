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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
            	$this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =  date('Y-m-d');
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
             echo '<script type="text/javascript">';
             
             echo  '$("#action").val("'.$accion.'");';
             
             echo  '$("#id_teletrabajo").val("'.$id.'");';

             echo 'visor_actividades()';
             
             echo '</script>';
             
             
         
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
                    array( campo => 'idusuario',   valor =>$id ,  filtro => 'S',   visor => 'S'),
                        array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'email',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'cedula',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'clave',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'enlace',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'caja',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'supervisor',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'noticia',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'rol',   valor => '-',  filtro => 'N',   visor => 'S'),
                         array( campo => 'empresas',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'tarea',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S') ,
                         array( campo => 'establecimiento',   valor => '-',  filtro => 'N',   visor => 'S') ,
                    );
 
          
            $datos = $this->bd->JqueryArrayVisor('par_usuario',$qquery );           
 
             $password = base64_decode($datos["clave"]);	
 
              $url = $this->pathFile(2);
     
              echo '<script type="text/javascript">';
             
              echo  'imagenfoto("'.$url.$datos['url'].'");';
             
             echo '$("#clave").val("'.$password.'")';
             
             echo '</script>';
             
             
        
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
       
              
            $fecha = explode('-',$this->hoy);
            $anio =  $fecha[0];
            $mes  = $fecha[1];

               $InsertQuery = array(   
                                    array( campo => 'idprov_jefe',         valor => trim($_POST["idprov_jefe"])),
                                    array( campo => 'idprov',         valor => trim($_POST["idprov"])),
                                    array( campo => 'fecha',               valor =>  $this->hoy),
                                    array( campo => 'estado',              valor => 'S'),
                                    array( campo => 'actividades',         valor => trim($_POST["actividades"])),
                                    array( campo => 'sesion',              valor => $this->sesion),
                                    array( campo => 'id_teleasigna',       valor => $_POST["id_teleasigna"] ),
                                    array( campo => 'fecha_inicio',        valor => $_POST["fecha_inicio"]),
                                    array( campo => 'fecha_fin',     valor => $_POST["fecha_fin"]),
                                    array( campo => 'anio',          valor =>$anio),
                                    array( campo => 'mes',           valor => $mes)
                                );
               
             $this->bd->pideSq('nom_tele_trabajo_id_teletrabajo_seq');

 
            $idD = $this->bd->JqueryInsertSQL('nom_tele_trabajo',$InsertQuery);
 
       
          $result = $this->div_resultado('editar',$idD,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
       
            $password = @$_POST["clave"];	
            $clave    = $this->obj->var->_codifica($password);	
              
            $completo = trim($_POST["apellido"]).' '.trim($_POST["nombre"]);


  
             $UpdateQuery = array( 
                        array( campo => 'idusuario',        valor => $id ,  filtro => 'S'),
                        array( campo => 'nombre',           valor => @$_POST["nombre"],  filtro => 'N'),
                        array( campo => 'apellido',         valor => @$_POST["apellido"],  filtro => 'N'),
                        array( campo => 'email',            valor => @$_POST["email"],  filtro => 'N'),
                        array( campo => 'estado',           valor => @$_POST["estado"],    filtro => 'N'),
                        array( campo => 'responsable',      valor => @$_POST["responsable"],    filtro => 'N'),
                        array( campo => 'completo',         valor => $completo,  filtro => 'N'),
                        array( campo => 'clave',            valor => $clave,  filtro => 'N'),
                        array( campo => 'rol',              valor => @$_POST["rol"],  filtro => 'N') ,
                        array( campo => 'direccion',        valor => @$_POST["direccion"],  filtro => 'N'),
                        array( campo => 'telefono',         valor => @$_POST["telefono"],    filtro => 'N'),
                        array( campo => 'caja',             valor =>   trim($_POST["caja"]),  filtro => 'N'),
                        array( campo => 'id_departamento',  valor => $_POST["id_departamento"],  filtro => 'N'),
                        array( campo => 'supervisor',       valor => trim($_POST["supervisor"]),  filtro => 'N'),
                        array( campo => 'tipo',             valor => @$_POST["tipo"],  filtro => 'N') ,
                        array( campo => 'enlace',           valor => @$_POST["enlace"],  filtro => 'N') ,
                        array( campo => 'tarea',            valor => @$_POST["tarea"],  filtro => 'N') ,
                        array( campo => 'url',              valor => @$_POST["url"],  filtro => 'N') ,
                        array( campo => 'noticia',          valor => @$_POST["noticia"],  filtro => 'N') ,
                        array( campo => 'nomina',           valor => @$_POST["nomina"],  filtro => 'N') ,
                        array( campo => 'empresas',         valor => @$_POST["empresas"],  filtro => 'N') ,
                        array( campo => 'cedula',           valor => @$_POST["cedula"],  filtro => 'N') ,
                        array( campo => 'idciudad',         valor => @$_POST["idciudad"],  filtro => 'N') ,
                        array( campo => 'tipourl',          valor => 2,  filtro => 'N') ,
                        array( campo => 'movil',            valor => @$_POST["movil"],  filtro => 'N') ,
                        array( campo => 'establecimiento',  valor => @$_POST["establecimiento"],  filtro => 'N') 
               );
  
             
             
           $this->bd->JqueryUpdateSQL('par_usuario',$UpdateQuery);
             
           $result = $this->div_resultado('editar',$id,1);
 
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
         
         $sql = 'delete from par_usuario  where idusuario='.$this->bd->sqlvalue_inyeccion($id, true);
         
         $this->bd->ejecutar($sql);
        
         $this->div_limpiar();
       
         $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ELIMINADA CON EXITO ['.$id.']</b>';
   
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
        
            $id =     @$_POST["id_teletrabajo"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  