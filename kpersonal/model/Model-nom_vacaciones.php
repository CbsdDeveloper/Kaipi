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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;

                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];

                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =     date("Y-m-d");    
        
                $this->anio       =  $_SESSION['anio'];
                
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	     = 'nom_vacaciones';
                  
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
                    array( campo => 'dia_pendientes',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '0', key => 'N'),
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
      function div_resultado($accion,$id,$tipo,$idprov){
            
        
             echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."',"."'".$idprov."'".')</script>';

             if ( trim($accion) == 'aprobado') {
                 echo "<script>$('#estado').val('2');</script>";
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
   /*
   */

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
         array( campo => 'hora_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'hora_out',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'hora_in',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'dia_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'dia_acumula',   valor => '-',  filtro => 'N',   visor => 'S'),
      );
     
     
       $datos = $this->bd->JqueryArrayVisorTab('view_nomina_vacacion',$qquery,'tab3' );        
       
       
       $hora = $this->bd->query_array('nom_cvacaciones',  
       'dias_pendientes,dias_tomados,(saldo_anterior + dias_derecho) as total,horas_dias',                       
       'idprov='.$this->bd->sqlvalue_inyeccion(  trim( $datos['idprov']),true).' and 
        periodo=' .$this->bd->sqlvalue_inyeccion(   $this->anio ,true) 
       );
   
                       
 
       
    /*
                total = saldo_anterior + dias_derecho
                dias_tomados  // suma todos los dias
                dias_pendientes = total - dias_tomados
                // tabla vacaciones

                   dia_acumula  = valor q se va  calcular
                dia_tomados dias
                hora_tomados horas
                */

              

       echo "<script> ValidaPermisos("."'". trim( $datos['tipo'])."',1".")</script>";

       echo "<script>$('#dia_acumula').val(". trim( $hora['total']).")</script>";
       echo "<script>$('#dias_tomados').val(". trim( $hora['dias_tomados']).")</script>";
       echo "<script>$('#hora_tomados1').val(". trim( $hora['horas_dias']).")</script>";
       echo "<script>$('#dia_valida').val(". trim( $hora['dias_pendientes']).")</script>";

  


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
 
            $dia_valida        = $_POST["dia_toca"];
            $dia_max           = $_POST["dia_max"];
            $hora_max          = $_POST["hora_max"];

            $tipo_permiso       = trim($_POST["tipo"]);
            $bandera = 0 ;
 
            $numero_dias = $this->dias_pasados($fecha_inicial,$fecha_final);

            $mensaje =   ' ('. $dia_valida  .') Dias Max: '. $dia_max.' Hora Max: '.  $hora_max ;

        
            if (  trim($tipo_permiso)   == 'permiso_hora'){
 
                    $hora        =  $this->restaHoras($DateAndTime1, $DateAndTime);
                    $array        = explode(":",$hora );
                    $minuto       = $array[1];
                    $hora         = $array[0];
                    $hora         =   intval( $hora );
                    $min_hora     =   $minuto * 0.0166667 ;
                    $hora_parcial =   $min_hora + $hora  ;
                    $numero_dias  = '0';
                     $hora_dia    = $hora_parcial;   

                     if (  $hora_dia   <=  $hora_max ){
                         $dia_hora_calculo =   $this->Calculo_hora_dia( $hora_dia, $dia_valida   );
                         $bandera = 1 ;
                    }

                 
                 $mensaje = ' ('. $dia_valida  .') Dias Max: '. $dia_max.' Hora Max: '.  $hora_max .' =>'.$hora_dia;
               
             }  

             if (  $tipo_permiso   == 'permiso_dia'){
                    $numero_dias =  $this->dias_pasados($fecha_inicial,$fecha_final) + 1;
                    if (  $numero_dias  <=  $dia_max ){
                        $dia_hora_calculo =   $this->Calculo_dia( $numero_dias, $dia_valida  );
                        $bandera = 1 ;
                    }  
             }  

             if (  $tipo_permiso   == 'vacaciones'){
                    $numero_dias      =   $this->dias_pasados($fecha_inicial,$fecha_final) + 1;
                    $dia_hora_calculo =   $this->Calculo_vacacion( $numero_dias,$dia_valida  );
                    $bandera = 1 ;
                    $this->ATabla[17][valor] = '00:00' ;
                    $this->ATabla[18][valor] = '00:00' ;
 
            }  
    
            if ($bandera == 1 ) {


                $this->ATabla[10][valor] =    $dia_hora_calculo ;
                $this->ATabla[11][valor] =    $numero_dias;
                $this->ATabla[12][valor] =    $hora_dia; 
 
                
                $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia  );
                
                $this->suma_dias( trim($idprov)  );

                $result = $this->div_resultado('editar',$id,1,$idprov);



           }else	 {

       

            $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LOS RANGOS DE LA FECHA/HORA SOLICITADA?</b> '.$mensaje; 

           }
   
         
            
            echo $result;
          
     }	
       //-----------------------------------  
       function Calculo_hora_dia( $horas , $variable   ){


        $dia_calculo      =  $variable ;

        $horas_laborables = 8;

        $parametro = ($dia_calculo  *   $horas ) / $horas_laborables ;

         	 
       

        return   $parametro ;

    } 
    //--------------------------
    function Calculo_dia( $dia , $variable ){


        $dia_calculo      = $variable;

        $dia_laborables = 1;

        $parametro = ($dia_calculo  *   $dia ) / $dia_laborables ;

         	 
        return   $parametro ;

    } 

    function Calculo_vacacion( $dia , $variable  ){


        $dia_calculo      =   $variable ;

        $dia_laborables = 1;

        $parametro = ($dia_calculo  *   $dia ) / $dia_laborables ;

         	 
        return   $parametro ;

    } 
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
        
        $idprov 			= $_POST["idprov"];

            $fecha_inicial      = $_POST["fecha_out"];
            $fecha_final        = $_POST["fecha_in"];
 
            $DateAndTime1       = $_POST["hora_out"];
            $DateAndTime        = $_POST["hora_in"];
 
            $dia_valida        = $_POST["dia_toca"];
            $dia_max           = $_POST["dia_max"];
            $hora_max          = $_POST["hora_max"];

            $tipo_permiso       = trim($_POST["tipo"]);
            $bandera = 0 ;
     

        $numero_dias = $this->dias_pasados($fecha_inicial,$fecha_final);
    
        if (  trim($tipo_permiso)   == 'permiso_hora'){
          
                $hora        =  $this->restaHoras($DateAndTime1, $DateAndTime);
                $array        = explode(":",$hora );
                $minuto       = $array[1];
                $hora         = $array[0];
                $hora         =   intval( $hora );
                $min_hora     =   $minuto * 0.0166667 ;
                $hora_parcial =   $min_hora + $hora  ;
                $numero_dias  = '0';
                 $hora_dia    = $hora_parcial;   

                 if (  $hora_dia   <=  $hora_max ){
                     $dia_hora_calculo =   $this->Calculo_hora_dia( $hora_dia, $dia_valida   );
                     $bandera = 1 ;
                }
              
              
         }  

         if (  $tipo_permiso   == 'permiso_dia'){
                $numero_dias =  $this->dias_pasados($fecha_inicial,$fecha_final) + 1;
                if (  $numero_dias  <=  $dia_max ){
                    $dia_hora_calculo =   $this->Calculo_dia( $numero_dias, $dia_valida  );
                    $bandera = 1 ;
                }  
         }  

         if (  $tipo_permiso   == 'vacaciones'){
                $numero_dias      =   $this->dias_pasados($fecha_inicial,$fecha_final) + 1;
                $dia_hora_calculo =   $this->Calculo_vacacion( $numero_dias,$dia_valida  );
                $bandera = 1 ;
                $this->ATabla[17][valor] = '00:00' ;
                $this->ATabla[18][valor] = '00:00' ;

        }  
        



           if (   trim($estado) 	== '1') {
            $bandera = 1 ;
           }
           if (   trim($estado) 	== '4') {
            $bandera = 1 ;
           }
           if (   trim($estado) 	== '2') {
            $bandera = 1 ;
           }


               if ($bandera == 1 ) {
   
   
                   $this->ATabla[10][valor] =    $dia_hora_calculo ;
                   $this->ATabla[11][valor] =    $numero_dias;
                   $this->ATabla[12][valor] =    $hora_dia; 
   
                   
                   $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
          	
                   $result = $this->div_resultado('editar',$id,1,$idprov);
   
           }else	 {
   
               $result = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>VERIFIQUE LOS RANGOS DE LA FECHA/HORA SOLICITADA?</b> '.$mensaje; 
           }
      

         


/*
           $numero_dias = $this->dias_pasados($fecha_inicial,$fecha_final);

           $hora  =  $this->restaHoras($DateAndTime1, $DateAndTime);
   
           $array= explode(":",$hora );
   
           $minuto   = $array[1];
           $hora     = $array[0];
           $hora     = intval( $hora );
          
           $min_hora =  $minuto * 0.0166667 ;
   
           $hora_parcial =   $min_hora + $hora  ;
   
           $hora_dia = $hora_parcial * 0.0416667;
   
           // 1 minuto - 0.0166667 
           // 1 hora - 0.0416667
           $total =  $numero_dias +  $hora_dia;
   
           $this->ATabla[10][valor] =  $total;
           $this->ATabla[11][valor] =  $numero_dias;
           $this->ATabla[12][valor] =  $hora_dia; 



          
     
            
           $this->suma_dias( trim($idprov)  );
     
           */
 
           echo $result;
    }
  //---------------
    function suma_dias( $id  ){
        
        
        $x = $this->bd->query_array('nom_vacaciones',
                                    ' (max(dia_derecho) + max(dia_acumula)) - sum(dia_tomados) as saldo, round(sum(hora_tomados)/24,2)  as dia_hora', 
                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true) .' and 
                                     anio ='.$this->bd->sqlvalue_inyeccion( $this->anio,true) ." and
                                     cargoa = 'S' "
         );
        
        
        
        $saldo 			= $x["saldo"] -  $x["dia_hora"];
           
        $sql = "update nom_vacaciones
				  set dia_pendientes=".$this->bd->sqlvalue_inyeccion($saldo,true)." 
				  where idprov =".$this->bd->sqlvalue_inyeccion($id,true)."  and
                        anio =".$this->bd->sqlvalue_inyeccion($this->anio,true)  ;
        
        $this->bd->ejecutar($sql);
       
       
    }

    function saldos_tramite($id  ){

        $x = $this->bd->query_array('nom_vacaciones',
        'idprov,cierre,estado,dia_tomados,hora_tomados,dia_acumula',
        'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
        );

        $this->saldos_dias(trim($x['idprov']));


    }  
          //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
      function aprobar_tramite($id  ){
           
        $x = $this->bd->query_array('nom_vacaciones',
        'idprov,cierre,estado,dia_tomados,hora_tomados,dia_acumula',
        'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
        );

        $result = $this->div_resultado('novalido',$id,-1,'');


        $bandera = 0;

        if ( trim($x['estado']) == '4') {
             $bandera = 1;
        }
        if ( trim($x['estado']) == '1') {
             $bandera = 1;
        }

          /*
                total = saldo_anterior + dias_derecho
                dias_tomados  // suma todos los dias
                dias_pendientes = total - dias_tomados
                // tabla vacaciones

                   dia_acumula  = valor q se va  calcular
                dia_tomados dias
                hora_tomados horas
                */

 
 
        if (   $bandera == 1 ) {

             $sql = "update nom_vacaciones
            set estado=".$this->bd->sqlvalue_inyeccion(2,true)." 
            where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;
  
            $this->bd->ejecutar($sql);


            $this->saldos_dias(trim($x['idprov']));
                     
            $result = $this->div_resultado('aprobado',$id,4,$idprov);
         
        }
        echo $result;
 }

 function saldos_dias($idprov  ){


            $x = $this->bd->query_array('nom_vacaciones',
            'sum(dia_acumula) total,
            sum(dia_tomados) dia_tomados,
            sum(hora_tomados) hora_tomados', 
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and 
            estado in ('."'1','4','2'".') and
            anio ='.$this->bd->sqlvalue_inyeccion(  $this->anio  ,true) 
        );


        $acumula =  $x["total"]  ;

        

            if  ( $acumula> 0  ){
            
                $dia_tomados 			= $x["dia_tomados"] ;
                $hora_tomados 			= $x["hora_tomados"] ;
            }else{

                $dia_tomados 			= 0;
                $hora_tomados 			= 0 ;
            }


            $sql = "update nom_cvacaciones
                    set dias_tomados= coalesce(ajuste,0) + ".$this->bd->sqlvalue_inyeccion($acumula,true)." ,
                        horas_dias =".$this->bd->sqlvalue_inyeccion($hora_tomados,true)." ,
                        dias= ".$this->bd->sqlvalue_inyeccion($dia_tomados,true)." 
                    where  
                    idprov=".$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and 
                    periodo ='.$this->bd->sqlvalue_inyeccion(  $this->anio     ,true) ;
            
                    
            $this->bd->ejecutar($sql);
            
            
            $sql = "update nom_cvacaciones
                    set dias_pendientes= (coalesce(dias_derecho,0) + coalesce(saldo_anterior,0)) - dias_tomados
                    where  
                    idprov=".$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and 
                    periodo ='.$this->bd->sqlvalue_inyeccion(  $this->anio     ,true) ;
            
                    
            $this->bd->ejecutar($sql);


            $result= 'SALDOS ACTUALIZADOS... ';

            echo $result;



 }
 /*
  anular tramite del proceso
  */
 function anular_tramite($id, $tipo  ){
           
    $x = $this->bd->query_array('nom_vacaciones',
    'idprov,cierre,estado,dia_tomados,hora_tomados',
    'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
    );

    $result = $this->div_resultado('novalido',$id,-1,'');

    if ( trim($tipo)  == '2' ) {

        


                $sql = "update nom_vacaciones
                set estado=".$this->bd->sqlvalue_inyeccion(1,true)." 
                where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;

                $this->bd->ejecutar($sql);

            
                $idprov = trim($x['idprov']);

                $this->saldos_dias(trim($x['idprov']));
                        
                $result = $this->div_resultado('solicitado',$id,1,'');
            
          
        }else  {
            if ( trim($x['estado']) == '4') {
                $sql = "update nom_vacaciones
                set estado=".$this->bd->sqlvalue_inyeccion(3,true)." 
                where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;

                $this->bd->ejecutar($sql);

            
                $idprov = trim($x['idprov']);

                $this->saldos_dias(trim($x['idprov']));
                        
                $result = $this->div_resultado('anulado',$id,4,'');
            }
        }

    echo $result;
}
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
         
         $x = $this->bd->query_array('nom_vacaciones',
             'idprov,cierre,estado',
             'id_vacacion='.$this->bd->sqlvalue_inyeccion( $id ,true)  
             );
         
         
         
         $idprov 			= trim($x["idprov"]) ;
         
         if ( trim($x["estado"]) == '1'){
             
            $sql = "update nom_vacaciones
                       set estado=".$this->bd->sqlvalue_inyeccion(3,true)." 
                     where id_vacacion =".$this->bd->sqlvalue_inyeccion($id,true)  ;

            
             $this->bd->ejecutar($sql);
             
             $this->saldos_dias(trim($x['idprov']));
             
             $result = $this->div_resultado('editar',$id,3,$idprov);
             
         }else {
             $result = 'PERIODO CERRADO NO SE PUEDE ELIMINAR REGISTRO ';
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
            
            if ( $accion == 'aprobar'){

                $gestion->aprobar_tramite($id);

            } else {

                if ( $accion == 'anular'){
                    $tipo    = trim($_GET['tipo']);
                    $gestion->anular_tramite($id,$tipo );
                 } else {
                   if ( $accion == 'saldos'){
                       
                    $gestion->saldos_tramite($id );
                      
                 } else {
                      $gestion->consultaId($accion,$id);
                     }
                 }

            } 
           
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_vacacion"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  