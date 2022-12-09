<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
    require '../../kconfig/Obj.conf.php';  
    require 'Model_saldos.php';
    
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $perfil;
      private $POST;
      private $ATabla;
      private $ATablaDetalle;
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
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'presupuesto.pre_tramite';
                
                $this->secuencia 	     = 'presupuesto.pre_tramite_id_tramite_seq';
                
                $this->perfil =  $this->bd->__user( $this->sesion );
                
                $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
                
                if ($this->perfil['supervisor']  == 'S'){
                    $estado_var ='S';
                }else{
                    $estado_var ='N';
                }
                
                
                $this->ATabla = array(
                    array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                    array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => $estado_var, valor => '-', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => $this->sesion, key => 'N') ,
                    array( campo => 'cur',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N') ,
                    array( campo => 'fcertifica',tipo => 'DATE',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fcompromiso',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fdevenga',tipo => 'DATE',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N')
                 );
                
                $this->ATablaDetalle = array(
                    array( campo => 'id_tramite_det',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'partida',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'saldo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'base',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'certificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'compromiso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'devengado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'fsesion',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N')
                );
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion){
            //inicializamos la clase para conectarnos a la bd
      
         $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO </b>';
                 
 
            return $resultado;   
 
      }
 //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function actualizar_enlace($id,$cur,$anio ){
       
     
     
     $sqlEditPre = "UPDATE presupuesto.matriz_sigef_dato
               SET id_tramite = ".$this->bd->sqlvalue_inyeccion($id,true)."
        where no_cur = ".$this->bd->sqlvalue_inyeccion(trim($cur),true). ' and
                 ejercicio = '.$this->bd->sqlvalue_inyeccion($anio,true) ;
     
     $this->bd->ejecutar($sqlEditPre);
     
     
     
 
  }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function detalle_partida($id,$cur,$anio){
          
             $tabla 	  	  = 'presupuesto.pre_tramite_det';
             $secuencia 	  = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
     
             $sql1 = "SELECT ejercicio,  actividad,   renglon, fuente,    monto_presupuesto
                         FROM presupuesto.matriz_sigef_dato
                         where ejercicio = ".$this->bd->sqlvalue_inyeccion($anio,true). " and 
                               clase_registro = 'DEV' and 
                               no_cur =".$this->bd->sqlvalue_inyeccion($cur,true);

         
             $stmt = $this->bd->ejecutar($sql1);
             
             
             while ($x=$this->bd->obtener_fila($stmt)){
                 
                 $partida = trim($x['actividad']).trim($x['renglon']).trim($x['fuente']);
                 
                 $this->ATablaDetalle[1][valor] =  $id;
                 $this->ATablaDetalle[2][valor] =  $partida;
                 $this->ATablaDetalle[3][valor] =  0;
                 $this->ATablaDetalle[4][valor] =  0;
                 
                 $this->ATablaDetalle[5][valor] =  $x['monto_presupuesto'];
                 $this->ATablaDetalle[6][valor] =  $x['monto_presupuesto'];
                 $this->ATablaDetalle[7][valor] =  $x['monto_presupuesto'];
                 $this->ATablaDetalle[8][valor] =  $x['monto_presupuesto'];
                 
                 $this->ATablaDetalle[12][valor] = $anio;
                 
                 $this->bd->_InsertSQL($tabla,$this->ATablaDetalle,$secuencia);
                     
             }
             
              
             
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar( $anio  ){
     	
          
         $sql1 = "SELECT ejercicio, 
                         no_cur,   
                         descripcion,
 		                fec_solicitud, fec_aprobado, fec_solicitud_pago, fec_pagado_total,
                        nombre_beneficiario,nit
            FROM presupuesto.matriz_sigef_dato
            where ejercicio = ".$this->bd->sqlvalue_inyeccion($anio,true). " and 
                  clase_registro = 'DEV' and 
                  id_tramite is null
            group by ejercicio, no_cur,   descripcion,  nombre_beneficiario,fec_solicitud, 
                     fec_aprobado, fec_solicitud_pago, fec_pagado_total,nit";
         
         
         $stmt1 = $this->bd->ejecutar($sql1);
         
         
         while ($fila=$this->bd->obtener_fila($stmt1)){
              
      
             $fecha = $fila["fec_solicitud"];
             $trozos = explode("/", $fecha,3);
             $anio1  = $trozos[2];
             $mes1   =  (int) $trozos[1];
              
    
             $this->ATabla[1][valor] =  $this->Fecha_datos($fila["fec_solicitud"] ) ;
             
             $this->ATabla[21][valor] =  $this->Fecha_datos($fila["fec_aprobado"] ) ;
             $this->ATabla[22][valor] =  $this->Fecha_datos($fila["fec_solicitud_pago"] ) ;
             $this->ATabla[23][valor] =  $this->Fecha_datos($fila["fec_pagado_total"] ) ;
             
             $this->ATabla[3][valor] =  $anio1;
             $this->ATabla[4][valor] =  $mes1;
             $this->ATabla[5][valor] =  trim($fila["descripcion"]);
             $this->ATabla[6][valor] = 'Proceso de enlace esigef - '.trim($fila["nombre_beneficiario"]);
             $this->ATabla[8][valor] =  $this->sesion;
             
             $this->ATabla[10][valor] =  'ESIGEF-'.trim($fila["no_cur"]);
             $this->ATabla[11][valor] =  '6';
             
             $this->ATabla[13][valor] =  trim($fila["no_cur"]);
             $this->ATabla[14][valor] =  13;
             $this->ATabla[15][valor] =  trim($fila["nit"]);
             $this->ATabla[16][valor] =  'S';
             $this->ATabla[17][valor] =  0;
             $this->ATabla[20][valor] =  trim($fila["no_cur"]);
             
             $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
             
             
             $this->detalle_partida($id,trim($fila["no_cur"]),$anio1);
          
             
             $this->actualizar_enlace($id,trim($fila["no_cur"]),$anio1 );
             
         }
         
            $this->saldos->_saldo_partidas($anio);
              
        	$result = $this->div_resultado('editar');
   
            echo $result;
          
     }	
      //---------------------------------------------------
     function Fecha_datos($idFecha ){
          
          
         $fecha = trim($idFecha);
         $trozos = explode("/", $fecha,3);
         $anio1  = $trozos[2];
         $dia    = $trozos[0];
         $mes   = $trozos[1];
         
         return  $anio1.'-'.$mes.'-'.$dia ;
     }
     ///--------------------------------------------------------
     
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['anio']))	{
            
            $anio                = $_GET['anio'];
         
            $gestion->agregar($anio);
            
            
     }  
  
          
  
     
   
 ?>
