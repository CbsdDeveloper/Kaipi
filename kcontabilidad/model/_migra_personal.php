<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    $sql ='SELECT codigo, nombre, cedula, ffecha, estadocivil, sexo, banco,
tipocuenta, cuenta, sueldo, cargo, ingreso FROM migra."dbo_RPEMPLEADOS"' ;
    
    
    
    $sql ='SELECT "Codigo", nombre, detalle, monto FROM migra."dbo_RPCARGOS"';
    
 
    $stmt = $bd->ejecutar($sql);
    
    $i = 1;
    
    while ($x=$bd->obtener_fila($stmt)){
        
      //  $idD = agregar($bd, $x);
        
 
        /*
        $c1 = explode(' ', $nombre) ;
        
        $nombre1   = $c1[2]. ' '. $c1[3];
        $nombre2  = $c1[0]. ' '. $c1[1];
       
        
        $sql = "UPDATE par_ciu
    			   SET  nombre  =".$bd->sqlvalue_inyeccion( $nombre2, true).",
                        apellido  =".$bd->sqlvalue_inyeccion( $nombre1, true).",
                        razon  =".$bd->sqlvalue_inyeccion( $nombre, true)."
    			 WHERE idprov            =".$bd->sqlvalue_inyeccion(trim($x["cedula"]), true);
         
        */
        
        
         
        $nombre   =  trim($x["nombre"]);
        /*
        $sql = "UPDATE nom_cargo
    			   SET  nombre  =".$bd->sqlvalue_inyeccion( $nombre, true)."
     			 WHERE id_cargo  =".$bd->sqlvalue_inyeccion(trim($x["Codigo"]), true);
         
        $bd->ejecutar($sql);
        
        */
        
        $sql_movimiento = "SELECT count(*) as movimiento FROM nom_cargo  where id_cargo =".trim($x["Codigo"]);
        $resultado_mov  = $bd->ejecutar($sql_movimiento);
        $datos_movimiento = $bd->obtener_array( $resultado_mov);
      
        if ( $datos_movimiento["movimiento"]  > 0 ){
            
            echo    'YA <br> ';
            
        }else{
            
             
            $sql = "INSERT INTO nom_cargo ( nombre, id_cargo, productos, competencias, jerarquico, monto)
    				VALUES (".
    				$bd->sqlvalue_inyeccion( $nombre, true).",".
    				$bd->sqlvalue_inyeccion( $x["Codigo"], true).",".
    				$bd->sqlvalue_inyeccion( 'S', true).",".
    				$bd->sqlvalue_inyeccion( 'N', true).",".
    				$bd->sqlvalue_inyeccion('N', true).",".
    				$bd->sqlvalue_inyeccion(  $x["monto"], true).")";
            
            $bd->ejecutar($sql);
        }
        
        echo    $nombre.'   -  '.$x["Codigo"].'<br> ';
        
        $i++;
        
    }
 //----------------------------------------------------------
  
 //---------------------------
    function agregarDetalle( $bd, $dx ,$idproducto){
        
             
         $sesion 	       =    $_SESSION['email'];
         $bodegas = $dx["bodegas"];
         
         if ($bodegas == '1'){
             $id_movimiento = 1;
         }else{
             $id_movimiento = 2;
         }
         
      
        
        
                 
                 $monto_iva   = '0';
                 $egreso    = '0';
                 $ingreso = $dx["Cantidad"];
                 
                 $tarifa_cero = $dx["promedio"] * $ingreso;
              
                 $baseiva = '0';
                 $total = $tarifa_cero * $ingreso;
                 
                  
                      $ATabla = array(
                          array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
                          array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
                          array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                          array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => round($dx["promedio"],4),   filtro => 'N',   key => 'N'),
                          array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
                          array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
                          array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
                          array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
                          array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => 'T',   filtro => 'N',   key => 'N'),
                          array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
                          array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
                          array( campo => 'descuento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
                          array( campo => 'pdescuento',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
                      );
                
                      $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );

 
    }
    //---------------------------
    function agregar( $bd, $x ){
        
        
    
        $ruc         =  $_SESSION['ruc_registro'];
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =     date("Y-m-d");   
        
        
        $nombre   =  $x["nombre"];
        
        $c1 = explode($nombre, ' ') ;
        
        $nombre   = $c1[2]. ' '. $c1[3];
        $apellido = $c1[0]. ' '. $c1[1];
        
        $id =  trim($x["cedula"]);
        
        $cuenta =  trim($x["cuenta"]);
        

          
        $ATabla = array(
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
            array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => $nombre,   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => 'Chimbo',   filtro => 'N',   key => 'N'),
            array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '05 2999-999',   filtro => 'N',   key => 'N'),
            array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => 'personal@chimbo.gob.ec',   filtro => 'N',   key => 'N'),
            array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '593-09999-999',   filtro => 'N',   key => 'N'),
            array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
            array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => $nombre,   filtro => 'N',   key => 'N'),
            array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '05 2999-999',   filtro => 'N',   key => 'N'),
            array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'N',   edit => 'N',   valor => 'personal@chimbo.gob.ec',   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
            array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'N',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor =>  $hoy ,   filtro => 'N',   key => 'N'),
            array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'N',   edit => 'S',   valor => $hoy ,   filtro => 'N',   key => 'N'),
            array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'serie',   tipo => 'VARCHAR2',   id => '19',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '20',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '21',  add => 'N',   edit => 'N',   valor => '05 2999-999',   filtro => 'N',   key => 'N'),
            array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor =>$nombre,   filtro => 'N',   key => 'N'),
            array( campo => 'apellido',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'S',   valor => $apellido,   filtro => 'N',   key => 'N'),
            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '24',  add => 'S',   edit => 'N',   valor => $ruc ,   filtro => 'N',   key => 'N'),
            array( campo => 'grafico',   tipo => 'VARCHAR2',   id => '25',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'id_banco',   tipo => 'NUMBER',   id => '26',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo_cta',   tipo => 'VARCHAR2',   id => '27',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
            array( campo => 'cta_banco',   tipo => 'VARCHAR2',   id => '28',  add => 'S',   edit => 'S',   valor =>$cuenta,   filtro => 'N',   key => 'N'),
            array( campo => 'vivienda',   tipo => 'NUMBER',   id => '29',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'salud',   tipo => 'NUMBER',   id => '30',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'educacion',   tipo => 'NUMBER',   id => '31',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'alimentacion',   tipo => 'NUMBER',   id => '32',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'vestimenta',   tipo => 'NUMBER',   id => '33',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'sifondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
            array( campo => 'programa',   tipo => 'VARCHAR2',   id => '35',  add => 'S',   edit => 'S',   valor => '110',   filtro => 'N',   key => 'N') ,
            array( campo => 'fondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
        );

        
        $bd->_InsertSQL('par_ciu',$ATabla,$id);
        
         
      ///-----------------
        //-- 
        
        $fecha			        = $bd->fecha($x["ingreso"]);
        
        /*
         codigo, nombre, cedula, ffecha, estadocivil, sexo, banco,
         tipocuenta, cuenta, sueldo, cargo, ingreso
         */
        
        $sexo =  trim($x["sexo"]);
        
        if ( $sexo == '0' ){
            $genero = 'M' ;
        }else{
            $genero = 'F' ;
        }
        
        
        
        $sql = "INSERT INTO nom_personal( idprov, id_departamento, id_cargo, responsable, regimen, fecha,
                contrato, registro,genero,foto,sidecimo,sicuarto,sihoras,sisubrogacion,discapacidad,motivo,sueldo)
    				VALUES (".
    				$bd->sqlvalue_inyeccion( $id, true).",".
    				$bd->sqlvalue_inyeccion( 1, true).",".
    				$bd->sqlvalue_inyeccion( $x["cargo"], true).",".
    				$bd->sqlvalue_inyeccion( 'N', true).",".
    				$bd->sqlvalue_inyeccion('NOMBRAMIENTOS LOSEP', true).",".
    				$fecha.",".
    				$bd->sqlvalue_inyeccion( 'AC-01', true).",".
    				$bd->sqlvalue_inyeccion(  $ruc , true).",".
    				$bd->sqlvalue_inyeccion( $genero, true).",".
    				$bd->sqlvalue_inyeccion( '-', true).",".
    				$bd->sqlvalue_inyeccion( 'S', true).",".
    				$bd->sqlvalue_inyeccion( 'S', true).",".
    				$bd->sqlvalue_inyeccion( 'N', true).",".
    				$bd->sqlvalue_inyeccion('N', true).",".
     				$bd->sqlvalue_inyeccion( '-', true).",".
    				$bd->sqlvalue_inyeccion( '-', true).",".
    				$bd->sqlvalue_inyeccion(  $x["sueldo"], true).")";
    				
    				$bd->ejecutar($sql);
           
        
     	
    }
    
?>
 
  