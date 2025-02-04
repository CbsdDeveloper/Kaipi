<?php 
session_start( );   
  
require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  
  
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
                
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	     = 'par_ciu';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
                    array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
                    array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor =>  $this->hoy ,   filtro => 'N',   key => 'N'),
                    array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'N',   edit => 'S',   valor => $this->hoy ,   filtro => 'N',   key => 'N'),
                    array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
                    array( campo => 'serie',   tipo => 'VARCHAR2',   id => '19',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '20',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '21',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'apellido',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'registro',   tipo => 'VARCHAR2',   id => '24',  add => 'S',   edit => 'N',   valor => $this->ruc ,   filtro => 'N',   key => 'N'),
                    array( campo => 'grafico',   tipo => 'VARCHAR2',   id => '25',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'id_banco',   tipo => 'NUMBER',   id => '26',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo_cta',   tipo => 'VARCHAR2',   id => '27',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cta_banco',   tipo => 'VARCHAR2',   id => '28',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'vivienda',   tipo => 'NUMBER',   id => '29',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'salud',   tipo => 'NUMBER',   id => '30',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'educacion',   tipo => 'NUMBER',   id => '31',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'alimentacion',   tipo => 'NUMBER',   id => '32',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'vestimenta',   tipo => 'NUMBER',   id => '33',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'sifondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
                    array( campo => 'programa',   tipo => 'VARCHAR2',   id => '35',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
                    array( campo => 'fondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
                    array( campo => 'turismo',   tipo => 'NUMBER',   id => '35',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
                    
                  );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
       
        $resultado = $this->bd->resultadoCRUD($mensaje='ACTUALIZACION',
        $accion,
        $id,
        $tipo,
        $estado='X');

       return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
        
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
         array( campo => 'idprov',   valor => trim($id),  filtro => 'S',   visor => 'S'),
         array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'regimen',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sueldo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fechan',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nacionalidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'etnia',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'ecivil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vivecon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tsangre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargas',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cta_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tipo_cta',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sifondo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vivienda',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'salud',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'educacion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'alimentacion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estudios',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'recorrido',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'titulo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'carrera',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tiempo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'genero',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'emaile',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fondo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vestimenta',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'foto',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'programa',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sidecimo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha_salida',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sicuarto',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sihoras',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sisubrogacion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'discapacidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'turismo',   valor => '-',  filtro => 'N',   visor => 'S')
           );
     
        
          $datos = $this->bd->JqueryArrayVisor('view_nomina_rol',$qquery );           
 
          $url =  $this->bd->_carpeta_archivo('2',1); // path archivos
  
        

          $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
        
      }	
  
      
      //---retorna el valor del campo para impresion de pantalla  
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
     	
     	 $bandera  =  '0';
         $nombre   =  $_POST["nombre"];
         $apellido =  $_POST["apellido"];
         $id       =  trim($_POST["idprov"]);

         
         if ($id == 'YA_EXISTE'){
            $bandera = '1';
         }

         if ($id == 'NO_VALIDO'){
            $bandera = '1';
         }

         
        
         if ($bandera == '1'){
             
             $result =  'EL CODIGO QUE ESTA INTENTANDO CREAR... YA SE ENCUENTRA EN LA BASE DE DATOS PROVEEDOR/CLIENTE';
             
             echo $result;
         }
         else    {
             
            $this->ATabla[1][valor] =  trim($apellido).' '. trim($nombre);
          
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
        	
        	$this->k_situacion_actual($id );
        	
        	$this->k_nom_adicional($id );
        	
            
        	$result = $this->div_resultado('editar',$id,1).'['. $id.']';
   
            echo $result;
         }
     }	
      //---------------------------------------------------
     function k_situacion_actual($id ){
          
         
         $sql_movimiento = "SELECT count(*) as movimiento FROM nom_personal  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
         
         $resultado_mov         = $this->bd->ejecutar($sql_movimiento);
         
         $datos_movimiento      = $this->bd->obtener_array( $resultado_mov);
         
         $fecha			        = $this->bd->fecha($_POST["fecha"]);
         



         $fecha_salida		    = $this->bd->fecha($_POST["fecha_salida"]);
                
 
         
         
         if  ($datos_movimiento["movimiento"] == 0){
             
             $sql = "INSERT INTO nom_personal( idprov, id_departamento, id_cargo, responsable, regimen, fecha, 
                contrato, registro,genero,foto,sidecimo,sicuarto,sihoras,sisubrogacion,discapacidad,motivo,sueldo)
    				VALUES (".
    				$this->bd->sqlvalue_inyeccion( $_POST["idprov"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",".
    				$fecha.",".
    				$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",".
    				$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sidecimo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sicuarto"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sihoras"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sisubrogacion"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["discapacidad"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["motivo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true).")";
				

    				
    				$this->bd->ejecutar($sql);
         }
         else {
             
             $sql = "UPDATE nom_personal
    			     SET  id_departamento  =".$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",
    			   		id_cargo         =".$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",
    					responsable      =".$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",
	                    registro         =".$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",
    					regimen          =".$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",
                        sidecimo          =".$this->bd->sqlvalue_inyeccion( $_POST["sidecimo"], true).",
                        sicuarto          =".$this->bd->sqlvalue_inyeccion( $_POST["sicuarto"], true).",
                        sihoras          =".$this->bd->sqlvalue_inyeccion( $_POST["sihoras"], true).",
                        sisubrogacion          =".$this->bd->sqlvalue_inyeccion( $_POST["sisubrogacion"], true).",
                        foto          =".$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",
    					fecha            =".$fecha.",
    					contrato         =".$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",
                        discapacidad         =".$this->bd->sqlvalue_inyeccion( $_POST["discapacidad"], true).",
                        motivo         =".$this->bd->sqlvalue_inyeccion( $_POST["motivo"], true).",
                        genero         =".$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",
    					sueldo           =".$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true)."
     			 WHERE idprov            =".$this->bd->sqlvalue_inyeccion($id, true);
             

             
             $this->bd->ejecutar($sql);
         }
         
         return  $datos_movimiento["movimiento"];
     }
     ///--------------------------------------------------------
    function k_nom_adicional($id ){
        

        
        $sql_movimiento1 = "SELECT count(*) as movimiento FROM nom_adicional  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
         
        $resultado_mov1     = $this->bd->ejecutar($sql_movimiento1);
         
        $datos_movimiento1  = $this->bd->obtener_array( $resultado_mov1);
         
        $fecha			    = $this->bd->fecha(@$_POST["fechan"]);
         
         if  ($datos_movimiento1["movimiento"] == 0){
             
             $sql = "INSERT INTO nom_adicional( idprov,  nacionalidad, etnia, ecivil, vivecon,fechan, tsangre,
                estudios ,recorrido, tiempo ,emaile,carrera,titulo,cargas)
				VALUES (".
				$this->bd->sqlvalue_inyeccion(@$_POST["idprov"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",".
				$fecha.",".
				$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["estudios"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["recorrido"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["tiempo"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["emaile"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["carrera"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["titulo"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true).")";
 
				
				$this->bd->ejecutar($sql);
         }
         else {
             
             $sql = "UPDATE nom_adicional
			   SET  nacionalidad=".$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",
			   		etnia       =".$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",
					ecivil      =".$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",
					vivecon     =".$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",
					fechan      =".$fecha.",
					tsangre     =".$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",
                    estudios     =".$this->bd->sqlvalue_inyeccion(@$_POST["estudios"], true).",
                    recorrido     =".$this->bd->sqlvalue_inyeccion(@$_POST["recorrido"], true).",
                    tiempo     =".$this->bd->sqlvalue_inyeccion(@$_POST["tiempo"], true).",
                    emaile     =".$this->bd->sqlvalue_inyeccion(@$_POST["emaile"], true).",
                    carrera     =".$this->bd->sqlvalue_inyeccion(@$_POST["carrera"], true).",
                    titulo     =".$this->bd->sqlvalue_inyeccion(@$_POST["titulo"], true).",
					cargas      =".$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true)."
 			 WHERE idprov       =".$this->bd->sqlvalue_inyeccion($id, true);
             
    
             
             $this->bd->ejecutar($sql);
             
         }
         
     }
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $bandera  = '0';
           $nombre   =  $_POST["nombre"];
           $apellido =  $_POST["apellido"];
           $id       =  trim($_POST["idprov"]);
           
         if ($id == 'YA_EXISTE'){
            $bandera = '1';
         }

         if ($id == 'NO_VALIDO'){
            $bandera = '1';
         }

           
           if ($bandera == '1'){
               
               $result =  'EL CODIGO QUE ESTA INTENTANDO CREAR... YA SE ENCUENTRA EN LA BASE DE DATOS PROVEEDOR/CLIENTE';
               
               echo $result;
           }
           else    {
           
           $this->ATabla[1][valor] =  trim($apellido).' '. trim($nombre);
 
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
           $this->k_situacion_actual($id );
           
           $this->k_nom_adicional($id );
       	
           $result = $this->div_resultado('editar',$id,1).'['. $id.']';
  
           echo $result;
           
           }
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
          
         $x = $this->bd->query_array('nom_rol_pagod', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $y = $this->bd->query_array('co_asiento_aux', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $z = $this->bd->query_array('inv_movimiento', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $valida = $x['nn'] +  $y['nn'] +  $z['nn'];
         
         
         if ( $valida > 0  ){
             
             $result ='<b>NO SE PUEDE ELIMINAR ... TIENE REGISTROS GENERADOS EN CONTABILIDAD - ROLES - INVENTARIOS</b>';
             
         }else{
             
             $this->bd->JqueryDeleteSQL('par_ciu','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_personal','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_adicional','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_laboral','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
          
             $result ='REGISTRO ELIMINADO CON EXITO ('.$valida.') Referencia: '. $id;
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
            
            $accion    = $_GET['accion'];
            
            $id        = trim($_GET['id']);
            
            if ( $accion == 'del'){
                
                $gestion->eliminar($id);
                
            }else {
                
                $gestion->consultaId($accion,$id);
                
            }
       
            
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= trim($_POST["idprov"]);
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  