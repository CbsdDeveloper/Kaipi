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
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
  
                $this->obj     = 	new objects;

                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =     date("Y-m-d");    
        
                $this->anio       =  $_SESSION['anio'];
                
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	     	 = 'nom_vacaciones';
                  
                $this->secuencia 	     = 'nom_vacaciones_id_vacacion_seq';
                
                $this->ATabla = array(
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'id_vacacion',tipo => 'NUMBER',id => '1',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'motivo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cargoa',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'S', key => 'N'),
                    array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->anio, key => 'N'),
                    array( campo => 'fecha_in',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_out',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dia_derecho',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dia_acumula',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dia_tomados',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_tomados',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dia_pendientes',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'cierre',tipo => 'VARCHAR2',id => '16',add => 'N', edit => 'N', valor => '-', key => 'N')  ,
                    array( campo => 'hora_out',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N')  ,
                    array( campo => 'hora_in',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N')  ,
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor => '1', key => 'N')  ,
                );
                
                
              
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            
        
        $idprov=1;
      
        
          echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."',"."'".$idprov."'".')</script>';
             
          $resultado = $this->obj->boton->mensaje_crud($tipo,$accion,$id); 

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
         array( campo => 'id_vacacion',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargoa',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha_in',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha_out',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'dia_derecho',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'dia_acumula',   valor => '-',  filtro => 'N',   visor => 'N'),
         array( campo => 'hora_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'hora_out',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'hora_in',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'dia_tomados',   valor => '-',  filtro => 'N',   visor => 'S')
           );
            
       $datos = $this->bd->JqueryArrayVisor('view_nomina_vacacion',$qquery );           

       echo '<script>valida_tipo_q('."'".trim($datos['tipo'])."'".')</script>';
         
  
       $result =  $this->div_resultado($accion,$id,0,$datos["idprov"]);
     
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
      
            $idprov 			= $_POST["idprov"];
            $fecha_inicial      = $_POST["fecha_out"];
            $fecha_final        = $_POST["fecha_in"];
 
            $DateAndTime1       = $_POST["hora_out"];
            $DateAndTime        = $_POST["hora_in"];

            $tipo_permiso       = trim($_POST["tipo"]);
            
            $dia_limite         = $_POST["dia_valida"];
            $derecho            = $_POST["derecho"];
            
            $numero_dias =  $this->dias_pasados($fecha_inicial,$fecha_final);
            //$dia_desde   =  $this->dias_pasados( $this->hoy ,$fecha_inicial);
 
            $hora        =  $this->restaHoras($DateAndTime1, $DateAndTime);
            $bandera = 0 ;
            $array        = explode(":",$hora );
            $minuto       = $array[1];
            $hora         = $array[0];
            $hora         =   intval( $hora );
            $min_hora     =   $minuto * 0.0166667 ;
            $hora_parcial =   $min_hora + $hora  ;
            $hora_dia     =   $hora_parcial * 0.0416667;
            // valida 
            $array_t1        = explode(":",$DateAndTime1 );
            $array_t2        = explode(":",$DateAndTime );
            $hora1            = intval($array_t1[0]);
            $hora2            = intval($array_t2[0]);
     
    
            if (  trim($tipo_permiso)   == 'permiso_hora'){
                $fecha_inicial      = $_POST["fecha_out"];
                $fecha_final        = $_POST["fecha_out"];
    
                $this->ATabla[7][valor] =  $fecha_inicial;
                $this->ATabla[8][valor] =  $fecha_inicial; 
    
                if ($hora1 >  $hora2 ){
                    $bandera = 1 ;
                    $mensaje = $hora.' horario mas del tiempo permitido';
                }
     
                $numero_dias  = '0';
            }
    
    
            if (  $tipo_permiso   == 'permiso_dia'){
                $numero_dias  = $numero_dias  + 1;
    
                if ($numero_dias >  3 ){
                    $bandera = 1 ;
                    $mensaje = $numero_dias.' solicita mas del tiempo permitido';
                }
                $this->ATabla[17][valor] =  '00:00';
                $this->ATabla[18][valor] =  '00:00';
                
                $hora_dia     = '0';
            }
        
            if (  $tipo_permiso   == 'vacacion'){
                $numero_dias  = $numero_dias  + 1;
    
                if ($numero_dias < 8 ){
                    $bandera = 1 ;
                    $mensaje = $numero_dias.' solicitados';
                   
                }


                $this->ATabla[17][valor] =  '00:00';
                $this->ATabla[18][valor] =  '00:00';
                          $hora_dia     = '0';
            }
    
            // 1 minuto - 0.0166667 
            // 1 hora   - 0.0416667
            $total =  $numero_dias +  $hora_dia;
    
            $this->ATabla[10][valor] =  $total;
            $this->ATabla[11][valor] =  $numero_dias;
            $this->ATabla[12][valor] =  $hora_dia; 
 
            $total_valida =  $total + $dia_limite;
            
            if ( $total_valida >  $derecho  ){
                $mensaje = $numero_dias.' No puede solicitar vacaciones...'.$total_valida;
                $bandera = 1 ;
            }
    
            if ($bandera == 0 ) {

                    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia  );
                    
                    $result = $this->div_resultado('editar',$id,1,$idprov);

            }else	 {

                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LOS RANGOS DE LA FECHA/HORA SOLICITADA?</b> '.$mensaje; 
            }
         
            
            echo $result;
 
     }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
      
       
        $fecha_inicial      = $_POST["fecha_out"];
        $fecha_final        = $_POST["fecha_in"];
        $estado             = trim($_POST["estado"]);

        $DateAndTime1       = $_POST["hora_out"];
        $DateAndTime        = $_POST["hora_in"];

        $tipo_permiso       = trim($_POST["tipo"]);
        
        $dia_limite         = $_POST["dia_valida"];
        $derecho            = $_POST["derecho"];
        
        $numero_dias =  $this->dias_pasados($fecha_inicial,$fecha_final);
 
        $hora        =  $this->restaHoras($DateAndTime1, $DateAndTime);
        $bandera = 0 ;
        $array        = explode(":",$hora );

        $minuto       = $array[1];
        $hora         = $array[0];
        $hora         =   intval( $hora );
        $min_hora     =   $minuto * 0.0166667 ;
        $hora_parcial =   $min_hora + $hora  ;
        $hora_dia     =   $hora_parcial * 0.0416667;
        // valida 
        $array_t1        = explode(":",$DateAndTime1 );
        $array_t2        = explode(":",$DateAndTime );
        $hora1            = intval($array_t1[0]);
        $hora2            = intval($array_t2[0]);
 


        $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>NO HABILITADO LA INFORMACION ...</b>'.$tipo_permiso; 


        if (  trim($tipo_permiso)   == 'permiso_hora'){

            $fecha_inicial      = $_POST["fecha_out"];
            $fecha_final        = $_POST["fecha_out"];

            $this->ATabla[7][valor] =  $fecha_inicial;
            $this->ATabla[8][valor] =  $fecha_inicial; 

            if ($hora1 >  $hora2 ){
                $bandera = 1 ;
                $mensaje = $hora.' horario mas del tiempo permitido';
            }
 
            $numero_dias  = '0';
        }


        if (  $tipo_permiso   == 'permiso_dia'){
            $numero_dias  = $numero_dias  + 1;

            if ($numero_dias >  3 ){
                $bandera = 1 ;
                $mensaje = $numero_dias.' solicita mas del tiempo permitido  '.$numero_dias;
            }
            $this->ATabla[17][valor] =  '00:00';
            $this->ATabla[18][valor] =  '00:00';
            
            $hora_dia     = '0';
        }
    
        $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>NO HABILITADO LA INFORMACION ...</b>'.$estado; 

        if (  $tipo_permiso   == 'vacacion'){
            $numero_dias  = $numero_dias  + 1;

            if ($numero_dias < 8 ){
                $bandera = 1 ;
                $mensaje = $numero_dias.' solicitados';
               
            }


            $this->ATabla[17][valor] =  '00:00';
            $this->ATabla[18][valor] =  '00:00';
                      $hora_dia     = '0';
        }

        // 1 minuto - 0.0166667 
        // 1 hora   - 0.0416667
        $total =  $numero_dias +  $hora_dia;

        $this->ATabla[10][valor] =  $total;
        $this->ATabla[11][valor] =  $numero_dias;
        $this->ATabla[12][valor] =  $hora_dia; 


        $total_valida =  $total + $dia_limite;
        
        if ( $total_valida >  $derecho  ){
            $mensaje = $numero_dias.' No puede solicitar vacaciones...'.$total_valida;
            $bandera = 1 ;
        }
 
 
        if (   trim($estado) 	== '1') {

            if ($bandera == 0 ) {

                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
          	
                $result = $this->div_resultado('editar',$id,1);

            }else	 {

                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION ...</b>'. $mensaje; 
            }
      
        }
 
           echo $result;
    }

   //---------------
   function restaHoras($horaIni, $horaFin){

    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
    
    } 

  //---------------
  function dias_pasados($fecha_inicial,$fecha_final)
  {
        
        $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
        $dias = abs($dias); $dias = floor($dias);
        return $dias;

  }
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function notificar($id ){
      
         
         $x = $this->bd->query_array('nom_vacaciones',
             'idprov,cierre,estado',
             'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
             );
         
         
         
          
         if ( trim($x["cierre"]) == 'N'){
             
            if ( trim($x["estado"]) == '1'){

                    $sql = "update nom_vacaciones 
                            set estado = '4'
                            where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;
                    
                    $this->bd->ejecutar($sql);
                    
                    $result = 'EL TRAMITE FUE ENVIADO CON EXITO... A LA UNIDAD DE TALENTO HUMANO... ';
              } 

             
         }else {
             $result = 'NO SE PUEDE ELIMINAR EL REGISTRO ';
         }
         
        
         
       echo $result;
      
   }

   /*
   */
   function eliminar($id ){
      
         
    $x = $this->bd->query_array('nom_vacaciones',
        'idprov,cierre,estado',
        'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
        );
    
    
    
 
    if ( trim($x["cierre"]) == 'N'){
        
       if ( trim($x["estado"]) == '1'){

               $sql = "delete from  nom_vacaciones
                   where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;
               
               $this->bd->ejecutar($sql);
               
               $this->div_limpiar();
             
               $result = 'SOLICITUD ELIMINADA POR EL USUARIO ';
         } 

        
    }else {
        $result = 'NO SE PUEDE ELIMINAR EL REGISTRO ';
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

            if (  $accion == 'notificar'){
                $gestion->notificar($id);
            }  else{
                $gestion->consultaId($accion,$id);
            } 
            
            
           
     }  
  
      //------ grud de datos insercion

     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_vacacion"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>