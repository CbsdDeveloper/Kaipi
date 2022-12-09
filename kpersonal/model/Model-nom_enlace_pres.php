<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
    require 'ajax_envio_email_nom.php';
    
    
  
    class proceso{
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      
      private $ATabla_detalle;
      
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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'presupuesto.pre_tramite';
                
                $this->secuencia 	     = 'presupuesto.pre_tramite_id_tramite_seq';
                
                $this->anio       =  $_SESSION['anio'];
                
                $this->ATabla = array(
                    array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                    array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => 'N', key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fcertifica',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N')
                 );
                
                
                $this->ATabla_detalle = array(
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
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor =>  $this->anio, key => 'N')
                );
      }
       //-----------------------------------------------------------------------------------------------------------
       //-----------------------------------------------------------------------------------------------------------
      function _actualiza_regimen_tramite($id,$id_rol1,$regimen){
            
 
          $sql = 'UPDATE nom_rol_pagod
                SET  id_tramite='.$this->bd->sqlvalue_inyeccion($id, true). '
                WHERE id_rol='.$this->bd->sqlvalue_inyeccion($id_rol1, true). ' and
                      regimen = '.$this->bd->sqlvalue_inyeccion($regimen, true);
          
          $this->bd->ejecutar($sql);
          
      }
 
      //-----------------------------------------------------------------------------------------------------------
       //-----------------------------------------------------------------------------------------------------------
      function _verifica_partidas( $id_rol1,$regimen,$programa ){
            
          
          $sql1 = "SELECT  programa, clasificador, patronal as monto
                FROM  view_rol_patronal
                where id_rol= ".$this->bd->sqlvalue_inyeccion($id_rol1, true)." and 
                      regimen = ".$this->bd->sqlvalue_inyeccion($regimen, true).' union ';
 
          
          $sql = $sql1. 'SELECT programa  ,clasificador,sum(ingreso) as monto
                  FROM view_rol
                  where id_rol='.$this->bd->sqlvalue_inyeccion($id_rol1, true)." and
                        tipo = 'Ingresos' and 
                        regimen =".$this->bd->sqlvalue_inyeccion($regimen, true)."
                group by programa,clasificador,nombre";
          
          $stmt = $this->bd->ejecutar($sql);
           
        
          $bandera = '0';
          
          //---------------------------------------------------
          
          while ($x=$this->bd->obtener_fila($stmt)){
              
              $programa     = trim($x["programa"]);
              $clasificador = trim($x["clasificador"]);
              $monto        = $x["monto"];
              
              $datos_partida = $this->_saldo_partida($clasificador,$programa );
              
              if ( empty(trim($datos_partida["partida"]))){
                   $bandera = $programa.' '. $clasificador;
              }else{
                  if ($monto > $datos_partida["disponible"] ){
                      $bandera = $monto .' - '.$datos_partida["disponible"].'<br>'.$programa.' '. $clasificador. ' No hay saldo!!!';
                      echo $bandera.'<br>';
                  }
                  
                  
              }
          }

     
 
          return $bandera;
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
      function certificacion($accion,$id_rol1,$regimen,$programa,$sesion_asigna ){
          
          $periodo = $this->_periodo($id_rol1);
          
          $fecha    = $periodo["fecha"];
        
          $mes1     = $periodo["mes"];
          
          $estado = '2';
          $this->ATabla[1][valor]  =   $fecha ;
          $this->ATabla[20][valor] =   $fecha ;
          $this->ATabla[3][valor]  =   $this->anio ;
          $this->ATabla[4][valor]  =   $mes1;
          
          $this->ATabla[5][valor]  = 'Tramite para el proceso de pago de nomina de acuerdo al regimen '.$regimen.' correspondiente al periodo de ( '.$this->anio .' - '.$periodo["mes"].' )';
          $this->ATabla[6][valor]  = 'Inicio de tramite de pago de Talento Humano';
          
          $this->ATabla[8][valor]  = $this->sesion;
          
          $this->ATabla[11][valor] =  $estado;
          $this->ATabla[12][valor] =  'N';
          $this->ATabla[13][valor] =  $this->anio .'-'.$id_rol1;
          
          $this->ATabla[16][valor] =  'S';
          
          $this->ATabla[19][valor] =  $this->sesion;
          
          $iddepa = $this->_solicita();
          
          $this->ATabla[14][valor] = $iddepa['id_departamento'];
          $this->ATabla[15][valor] = $iddepa['cedula'];
          
          $valida = $this->_verifica_partidas( $id_rol1,$regimen,$programa );
          
          
          $id_tramite = $this->valida_tramite($id_rol1,$regimen);
          
       if ( $valida == '0' ){
              
              if ( $id_tramite ==  0){
              
                 $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                  
                  $this->certificacion_detalle(  $id, $id_rol1,$regimen,$programa  );
                  
                  $result = 'Tramite generado generado por el regimen '.$regimen.'( '.$id.' )';
                  
                  $this->_actualiza_regimen_tramite($id,$id_rol1,$regimen);
                  
                  $this->actualiza_saldo_presupuesto($id); 
                  
                  $this->genera_comprobante(  $id ,$sesion_asigna,$id_rol1,$regimen) ;
                  
               }else  {
                  
                  $result = 'Certificacion  Emitida '.$regimen.' (  Nro.Tramite '.$id_tramite. ' ) verifique su informacion...';
                  
              }
              
          }else{
              
              $result = 'No se puede emitir la certificacion  '.$regimen.'( Verifique saldos en las partidas ) '.$valida;
          } 
         
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function _periodo($id){
          
 
         $AResultado = $this->bd->query_array('nom_rol_pago',
                                              'id_rol, id_periodo, mes, anio, registro, estado, fecha, novedad, sesion', 
                                              'id_rol='.$this->bd->sqlvalue_inyeccion($id,true));
         
         return $AResultado;
          
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function certificacion_detalle(  $idtramite, $id_rol1,$regimen,$programa  ){
     	
         $sql1 = "SELECT  programa, clasificador, patronal as monto
                FROM  view_rol_patronal
                where id_rol= ".$this->bd->sqlvalue_inyeccion($id_rol1, true)." and
                      regimen = ".$this->bd->sqlvalue_inyeccion($regimen, true).' union ';
         
         $sql = $sql1.'SELECT programa  ,clasificador,sum(ingreso) as monto
                  FROM view_rol
                  where id_rol='.$this->bd->sqlvalue_inyeccion($id_rol1, true)." and
                        tipo = 'Ingresos' and regimen =".$this->bd->sqlvalue_inyeccion($regimen, true)."
                group by programa,clasificador,nombre";
    
         $stmt = $this->bd->ejecutar($sql);
         
         
         $tabla 	  	     = 'presupuesto.pre_tramite_det';
         $secuencia 	     = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
         
          //---------------------------------------------------
          
         while ($x=$this->bd->obtener_fila($stmt)){
             
             $programa     = trim($x["programa"]);
             $clasificador = trim($x["clasificador"]);
             $monto        = $x["monto"];
              
             $datos_partida = $this->_saldo_partida($clasificador,$programa );
             
             $this->ATabla_detalle[1][valor] =  $idtramite;
             $this->ATabla_detalle[2][valor] =  $datos_partida['partida'];
             $this->ATabla_detalle[3][valor] =  $datos_partida['disponible'];
             
             $this->ATabla_detalle[4][valor] =  '0';
             $this->ATabla_detalle[5][valor] =  $monto;
             
             $this->ATabla_detalle[6][valor] =  $monto;
             $this->ATabla_detalle[7][valor] =  $monto;
             
             $this->bd->_InsertSQL($tabla,$this->ATabla_detalle,$secuencia );
             
             
         }
         
           
        
         
     }	
      //---------------------------------------------------
     function _saldo_partida($clasificador,$programa ){
          
         
           $partida = array();
         
           $z = $this->bd->query_array('presupuesto.pre_gestion',
                                     'partida,clasificador,  coalesce(disponible,0) as disponible', 
                                     'funcion='.$this->bd->sqlvalue_inyeccion($programa,true).' and 
                                      clasificador  ='.$this->bd->sqlvalue_inyeccion($clasificador,true).' and
                                      anio=  '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
             );
         
           $partida["partida"]    = trim($z["partida"]) ;
           $partida["disponible"] = $z["disponible"]; 
 
            
           return  $partida;
     }
     ///--------------------------------------------------------
    function _solicita(  ){
        
        $AResultado = $this->bd->query_array('par_usuario',
                                             ' email, cedula,id_departamento', 
                                             'email='.$this->bd->sqlvalue_inyeccion( $this->sesion,true)
            );
        
 
        return $AResultado;
 }
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
 function valida_tramite(  $id_rol1 ,$regimen){
           
 
           
           $AResultado = $this->bd->query_array('nom_rol_pagod',
               ' max(id_tramite) as idtramite',
               'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol1, true). ' and
                      regimen = '.$this->bd->sqlvalue_inyeccion($regimen, true)
               );
           
           $id_tramite = 0;
           
           if ( $AResultado['idtramite'] > 1 ) {
               
               $id_tramite = $AResultado['idtramite'];
               
           } 
           
           return $id_tramite;
               
    }
    //--------------------------------------------------------------------------------
    function actualiza_saldo_presupuesto(  $idtramite ){
        
        
        $sql1 = "SELECT   id_tramite,  partida, certificado
         FROM presupuesto.pre_tramite_det
        where id_tramite = ".$this->bd->sqlvalue_inyeccion($idtramite,true) ;
        
        
        
        
        $stmt1 = $this->bd->ejecutar($sql1);
        
        
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
            $partida = trim($fila['partida']);
            
            
            $sqlEditPre = "UPDATE presupuesto.pre_gestion
               SET certificado = certificado + ".$this->bd->sqlvalue_inyeccion($fila['certificado'],true).",
                   disponible  = disponible - ".$this->bd->sqlvalue_inyeccion($fila['certificado'],true) ."
              where partida = ".$this->bd->sqlvalue_inyeccion($partida,true). ' and
                 anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true) ;
            
            $this->bd->ejecutar($sqlEditPre);
        
 
    }
  }
    //----------------
  function genera_comprobante(  $idtramite,$sesion_asigna,$id_rol1,$regimen){
      
      
      envio_tramite($this->bd, $this->obj,$id_rol1 ,$regimen,$sesion_asigna);
      
          
       /* 
        $sql = "SELECT   count(*) as secuencia
            FROM presupuesto.pre_tramite
            where comprobante is not null and registro = ".$this->bd->sqlvalue_inyeccion($this->ruc   ,true);
        
        
        $parametros 			= $this->bd->ejecutar($sql);
        $secuencia 				= $this->bd->obtener_array($parametros);
 
         $contador = $secuencia['secuencia'] + 1;
        
        $input = str_pad($contador, 5, "0", STR_PAD_LEFT).'-'.$this->anio;
        
        
        
        
        $sqlEdit = "UPDATE presupuesto.pre_tramite
                   SET 	comprobante=".$this->bd->sqlvalue_inyeccion($input, true)."
                  where id_tramite = ".$this->bd->sqlvalue_inyeccion($idtramite,true) ;
        
        
      $this->bd->ejecutar($sqlEdit);
        
       */
        
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
            
            $accion      = $_GET['accion'];
            $id_rol1     = $_GET['id_rol'];
            $regimen     = $_GET['regimen'];
            $programa    = $_GET['programa'];
            
            $sesion_asigna    = $_GET['sesion_asigna'];
 
            
            if ( $accion == 'certificacion' ){
                
                if (!empty($regimen)){
                    $gestion->certificacion($accion,$id_rol1,$regimen,$programa,$sesion_asigna);
                }
             
                
                
            }
                
            
        
            
            
            
     }  
  
 
  
     
   
 ?>
 
  