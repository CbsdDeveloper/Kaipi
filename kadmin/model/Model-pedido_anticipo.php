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
                
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	     	 = 'co_anticipo';
                  
                $this->secuencia 	     = 'co_anticipo_id_anticipo_seq';
                
     

                $this->ATabla = array(
                    array( campo => 'id_anticipo',tipo => 'NUMBER',id => '1',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'anio',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $this->anio, key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '5',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => 'solicitado', key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '00000-0000', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idprov_ga',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'estado_pago',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'N', key => 'N'),
                    array( campo => 'solicita',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'mensual',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'plazo',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'rige',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_asiento',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
                    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'modificacion',tipo => 'DATE',id => '17',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'novedad',tipo => 'VARCHAR2',id => '18',add => 'N', edit => 'N', valor => '-', key => 'N') 
                );
                
                
              
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            
        
          $idprov = '1';

          if ($tipo == 99){
           }else {
                 echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."',"."'".$idprov."'".')</script>';
           }      

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
             array( campo => 'id_anticipo',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov_ga',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado_pago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'solicita',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'mensual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'plazo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'rige',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sueldo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'email',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'razon_g',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cargo_g',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sueldo_g',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'unidad_g',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'email_g',valor => '-',filtro => 'N', visor => 'S')
            );
 
           
       $datos = $this->bd->JqueryArrayVisor('view_lista_anticipo',$qquery );           
 
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
      

            $sueldo 			= $_POST["sueldo"];
            $sueldo_g 			= $_POST["sueldo_g"];


            
            $idprov 			=  trim($_POST["idprov"]);
            $idprov_ga 			=  trim($_POST["idprov_ga"]);

            $plazo              = $_POST["plazo"];

            $sueldo_tope		= $sueldo * 3;
            $solicita 			= $_POST["solicita"];
            $rige    			= $_POST["rige"];
            $mes                = intval(  date("m") ) ;
            
            $bandera =  0 ;
            $tope_mes =  13 -   $rige   ;

            if ( $idprov == $idprov_ga  ){
                $bandera = 1 ;
                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION GARANTE  Y SOLICITANTE ? NO SE OLVIDE QUE SU ANTICIPO VALIDO DICIEMBRE</b>'; 
            }
          

            if ( $sueldo  >  $sueldo_g  ){
                $bandera = 1 ;
                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION GARANTE  MONTO NO VALIDO ? NO SE OLVIDE QUE SU ANTICIPO VALIDO DICIEMBRE</b>'; 
            }	

            if ( $solicita  >  $sueldo_tope  ){
                $bandera = 1 ;
                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION MONTO SUPERA SU REMUNERACION? NO SE OLVIDE QUE SU ANTICIPO VALIDO DICIEMBRE</b>'; 
            }

            if ( $rige  <  $mes  ){
                $bandera = 1 ;
                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>01. VERIFIQUE LA INFORMACION DESDE RIGE?</b> '.$rige  .' - '.$mes .'NO SE OLVIDE QUE SU ANTICIPO VALIDO DICIEMBRE'; 
            }
           

             

         if ( $tope_mes   <  $plazo  ){
                $bandera = 1 ;
                $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>02. VERIFIQUE LA INFORMACION DE LOS PLAZOS?</b>'. $tope_mes .' '.$plazo. ' NO SE OLVIDE QUE SU ANTICIPO VALIDO DICIEMBRE'; 
            }
          
            
            
            if ($bandera == 0 ) {

                    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                    
                    $result = $this->div_resultado('editar',$id,1,$idprov) ;
 
              
            }
         
            
            echo $result;
 
     }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
      

        $estado 	         = $_POST["estado"];
 
        $sueldo 			= $_POST["sueldo"];
        $sueldo_g 			= $_POST["sueldo_g"];

        $idprov 			=  trim($_POST["idprov"]);
        $idprov_ga 			=  trim($_POST["idprov_ga"]);
        
        $plazo              = $_POST["plazo"];

        $sueldo_tope		= $sueldo * 3;
        $solicita 			= $_POST["solicita"];
        $rige    			= $_POST["rige"];
        $mes                = intval(  date("m") ) ;
        
        $bandera =  0 ;
        $tope_mes =  (13  -   $rige)  ;

      
        if ( $idprov == $idprov_ga  ){
            $bandera = 1 ;
            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION GARANTE  Y SOLICITANTE ?</b>'; 
        }

        if ( $sueldo  >  $sueldo_g  ){
            $bandera = 1 ;
            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION GARANTE  MONTO NO VALIDO ?</b>'; 
        }	

        if ( $solicita  >  $sueldo_tope  ){
            $bandera = 1 ;
            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LA INFORMACION MONTO SUPERA SU REMUNERACION?</b>'; 
        }

        if ( $rige  <  $mes  ){
            $bandera = 1 ;
            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>01. VERIFIQUE LA INFORMACION DESDE RIGE?</b>'; 
        }
       

         

        if ( $tope_mes   <  $plazo  ){
            $bandera = 1 ;
            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>02. VERIFIQUE LA INFORMACION DE LOS PLAZOS?</b>'.$tope_mes .' - '.  $plazo ; 
        }

        if (   trim($estado) 	== 'solicitado') {

            if ($bandera == 0 ) {

                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
          	
                $result = $this->div_resultado('editar',$id,1) ;

           
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
     function eliminar($id ){
       
         
         $x = $this->bd->query_array( $this->tabla 	,
             'estado',
             'id_anticipo='.$this->bd->sqlvalue_inyeccion( $id ,true)  
             );
         
           
         
         if ( trim($x["estado"]) == 'solicitado'){
          
            $sql = "delete from ".$this->tabla."
            where id_anticipo =".$this->bd->sqlvalue_inyeccion($id,true)  ;
   
            $this->bd->ejecutar($sql);
            
             $result = div_resultado('TRANSACCION ELIMINADA CON EXITO ',$id,99);
               
         }else {
            $result = div_resultado('TRANSACCION NO AUTORIZADA ',$id,99);
         }
         
       echo $result;
      
   }
   /*
   envio datos
   */
  function envio_datos($id ){
       
         
    $x = $this->bd->query_array( $this->tabla 	,
        '*',
        'id_anticipo='.$this->bd->sqlvalue_inyeccion( $id ,true)   
        );
    
      
    
    if ( trim($x["estado"]) == 'solicitado'){
     
       $sql = "update ".$this->tabla."
              set estado = 'tthh'
       where id_anticipo =".$this->bd->sqlvalue_inyeccion($id,true)  ;

       $this->bd->ejecutar($sql);
       
        $result = $this->div_resultado('TRANSACCION ENVIADA A LA UNIDAD DE TTHH, PARA SU ANALISIS ',$id,99);
 
    }else {
        $result = $this->div_resultado('TRANSACCION NO AUTORIZADA ',$id,99);
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
            
             if (  trim($accion) == 'del' ) {
                 $gestion->eliminar($id);
             }  
 
             if ( trim($accion) == 'editar' ) {
                    $gestion->consultaId($accion,$id);
             }
             
             if ( trim($accion) == 'envio' ) {
            
                $gestion->envio_datos($id );
              }
        
           
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_anticipo"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  