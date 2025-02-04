<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    /*
     * 1. movimientos
    $sql ='SELECT "Codigo_Empresa", "Localidad", "Ejercicio", "Num_Transaccion", "Fecha_Transaccion",
        "Num_Asiento", "Num_Compromiso", "CompromisoRel", "CedulaoTransaccion", "Tipo_Documento", 
        "Num_Documento", "TipoCOT", "Contrato", "Custodio", "CodigoCP", "Beneficiario", "Detalle", "AsientoRf",
        "TRDisponible", "Transferencia", "Unidad", "Centro", "SubCentro", "DireccionG", "Direccion", "Cotizacion", 
        "Cerrado", "Impresion", "FechaVc", "PtoOrigen", "Enviado", "Usuario", "FechaCre", "FechaUac", "PyGto" 
        FROM migra."dbo_YP_BUDGET_MOVAVAILABLE"
        where "Localidad" = '.$bd->sqlvalue_inyeccion('11',true).' order by 1';
  */
    
    /*
     * 2. partidas
    $sql = 'SELECT "Clave_Partida","Codigo_Proyecto" || "CPPIG" || "Distribuidor" as partida,
        	    "Codigo_Proyecto" as programa ,
        	    "Distribuidor",
        		"Descripcion", 
        		lpad("Financiamiento",3,'."'0'".') fin,    
        		"CPPIG", 
          	    "MEF",  
          	    "Codificado", 
          	    "Compromiso"
        FROM migra."dbo_YP_BUDGET_SPENDINGMATCHES"
        where "Localidad"=  '.$bd->sqlvalue_inyeccion('11',true).' order by 2';
        */
    
    
    $sql = 'SELECT a."Codigo_Empresa", a."Localidad", a."Ejercicio", a."Clave_Partida", a."Num_Transaccion",
	   a."Tipo_Transaccion", a."Num_Fila", a."Detalle", 
	   a."Tipo_Movimiento", a."Valor", a."Valor_Dolares", 
	   a."Disponible", 
	   a."ValorRetenido", a."Codigo_Linea", 
	   a."Retencion", a."Solicitud", a."CSJ", a."Enviado" ,
	   b."Codigo_Proyecto" || b."CPPIG" || b."Distribuidor" as partida,
	   b."Codigo_Proyecto" as programa ,
	   b."Distribuidor",
	  	lpad("Financiamiento",3,'."'0'".') fin,    
	   b."CPPIG"
FROM migra."dbo_YP_BUDGET_DETAVAILABLE" a
left join migra."dbo_YP_BUDGET_SPENDINGMATCHES" b on 
		a."Localidad" = b."Localidad"	and 
        a."Clave_Partida" = b."Clave_Partida" and 
        a."Localidad"=  '.$bd->sqlvalue_inyeccion('11',true);
    
    $stmt = $bd->ejecutar($sql);
    
    $i = 1;
    while ($x=$bd->obtener_fila($stmt)){
        
      //    agregar($bd, $x);
          
            agregarDetalle($bd, $x);     
           
    //         pone_cuenta($bd, $x);
       
            echo trim($x["partida"]).' Detalle -  '.$i.'<br> ';
        
            $i++;
        
    }
 //----------------------------------------------------------
 //----------------------------------------------------------
    function agregar( $bd, $x ){
     
        $fecha_registro = $x["Fecha_Transaccion"] ;
        
        $xf              = explode('-',$fecha_registro);
        
        $mes  			= $xf[1];
        $anio  			= $xf[0];
        $sesion         = $x["Usuario"] ;
        
        
        $idprov         = $x["Custodio"] ;
        
        $estado        = '6';
        $comprobante   = trim($x["Num_Transaccion"]);
        
        $id_tramite    = (int) $x["Num_Compromiso"] ;
        
        $ruc           = $_SESSION['ruc_registro'];
        
        //------------ seleccion de periodo
        $detalle       = trim($x["Detalle"]);
        
 
        //------------------------------------------------------------
        $ATabla = array(
            array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$id_tramite,   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor =>$fecha_registro, key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $ruc, key => 'N'),
            array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor =>$anio, key => 'N'),
            array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor =>$mes, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$detalle, key => 'N'),
            array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>$detalle, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
            array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $fecha_registro, key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor =>$comprobante, key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => $estado, valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>$comprobante, key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '14', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor =>$idprov, key => 'N'),
            array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => 'S', key => 'N'),
            array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
            array( campo => 'fcertifica',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor =>$fecha_registro, key => 'N'),
            array( campo => 'fcompromiso',tipo => 'DATE',id => '21',add => 'S', edit => 'S', valor =>$fecha_registro, key => 'N'),
            array( campo => 'fdevenga',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor =>$fecha_registro, key => 'N')
        );
        
       
    		
        $tabla 	  	  = 'presupuesto.pre_tramite';
        
        $bd->_InsertSQL($tabla,$ATabla,$id_tramite,0);
    										        
    }
 //---------------------------
    function agregarDetalle( $bd, $x ){
        
        
        $tabla 	  	  = 'presupuesto.pre_tramite_det';
        
        $secuencia 	     = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
        
        $ruc         =  $_SESSION['ruc_registro'];
        $sesion 	 =  trim($_SESSION['email']);
        $hoy 	     =  date("Y-m-d");
        
        
        $anio 	     =    $_SESSION['anio'];
        
        $distribuidor = trim($x["fin"]);
        
        if (trim($x["fin"]) == '000'){
            $distribuidor = '001';
        }
        
        $partida       =  trim($x["partida"]).$distribuidor;
        
 
        
        $ATabla = array(
            array( campo => 'id_tramite_det',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $x["Num_Transaccion"], key => 'N'),
            array( campo => 'partida',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $partida, key => 'N'),
            array( campo => 'saldo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor =>$x["Valor"], key => 'N'),
            array( campo => 'certificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>  $x["Valor"], key => 'N'),
            array( campo => 'compromiso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor =>  $x["Valor"], key => 'N'),
            array( campo => 'devengado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor =>  $x["Valor"], key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
            array( campo => 'fsesion',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => $hoy, key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $ruc, key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => $anio, key => 'N')
        );
 

        $bd->_InsertSQL($tabla,$ATabla,$secuencia );
        
 
    }
    //---------------------------
    function pone_cuenta( $bd, $x ){
        
        
        $tabla 	  	  = 'presupuesto.pre_gestion';
        
        $secuencia 	     = 'NO';
        
        $anio       =  $_SESSION['anio'];
        
        $distribuidor = trim($x["fin"]);
        
        if (trim($x["fin"]) == '000'){
            $distribuidor = '001';
        }
        
        $partida       =  trim($x["partida"]).$distribuidor;
        
 
        $ATabla = array(
            array( campo => 'partida',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $partida,   filtro => 'N',   key => 'S'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => 'G', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => trim($x["Descripcion"]), key => 'N'),
            array( campo => 'clasificador',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => trim($x["CPPIG"]), key => 'N'),
            array( campo => 'fuente',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$distribuidor, key => 'N'),
            array( campo => 'activo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => 'S', key => 'N'),
            array( campo => 'funcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor =>  trim($x["programa"]), key => 'N'),
            array( campo => 'actividad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'titulo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'grupo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'subgrupo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'item',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => trim($x["CPPIG"]), key => 'N'),
            array( campo => 'subitem',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => trim($x["CPPIG"]), key => 'N'),
            array( campo => 'orientador',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'proforma',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'inicial',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'aumento',tipo => 'NUMBER',id => '16',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'disminuye',tipo => 'NUMBER',id => '17',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'codificado',tipo => 'NUMBER',id => '18',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'certificado',tipo => 'NUMBER',id => '19',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'compromiso',tipo => 'NUMBER',id => '20',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'devengado',tipo => 'NUMBER',id => '21',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'pagado',tipo => 'NUMBER',id => '22',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'disponible',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => $anio, key => 'N'),
            array( campo => 'proyecto',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'competencia',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
        
        $bd->_InsertSQL($tabla,$ATabla,$secuencia );
     
    }
    
?>
 
  