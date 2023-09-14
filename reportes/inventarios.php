<?php 
session_start( );   
  
    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    include('phpqrcode/qrlib.php');
    
    
    class componente{
 
      private $obj;
      private $bd;
      private $codigo;
      private $POST;
      //--------------------
      private   $AEMPRESA;
      private   $ACERTIFICACION;
      private $ruc;
      
      private $ACAJA;
      public $Registro;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                 
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->ruc       =     $_SESSION['ruc_registro'];
              
      }
      //-
      function _Cab( $dato ){
          
          return $this->Registro[$dato];
      }
      ///  
      function rifa($id){
          
          $dato =  $this->bd->query_array('par_ciu',
              '*',
              'idprov='. $this->bd->sqlvalue_inyeccion(trim($id) ,true)
              );
          
          
          
          
          $datoBanco =  $this->bd->query_array('par_ti',
              '*',
              'idprov='. $this->bd->sqlvalue_inyeccion(trim($id) ,true)
              );
          
          
          $dato['id_par_ti'] =  $datoBanco['id_par_ti'];
          
          
          return $dato;
      }
    
      function Empresa( ){
          
          $sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
          
          $resultado = $this->bd->ejecutar($sql);
          
          $this->Registro = $this->bd->obtener_array( $resultado);
          
          return $this->Registro['razon'];
      }
//----------------------------------------------
      function Conciliar($id){
       
       $dato =  $this->bd->query_array('co_concilia',
              'id_concilia,fecha,  anio, mes, detalle, sesion,   estado, cuenta, saldobanco, notacredito, notadebito, saldoestado,  cheques, depositos',
           'id_concilia='. $this->bd->sqlvalue_inyeccion($id ,true)
              ); 
          
       
		  
    $sql = "SELECT sum(debe) as debe, sum(haber) as haber
            FROM  view_bancos_concilia
where 	registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)." and
        cuenta = ".$this->bd->sqlvalue_inyeccion(trim($dato["cuenta"]),true)." and
        coalesce(tipo,'-')   <>   'cheque'  and  concilia = 'S' and
        anio   = ".$this->bd->sqlvalue_inyeccion($dato["anio"],true)."  and
        mes    = ".$this->bd->sqlvalue_inyeccion($dato["mes"],true);		

   
    $stmt = $this->bd->ejecutar($sql);
    
    $debe  = 0;
    $haber = 0;
 
    
    while ($x=$this->bd->obtener_fila($stmt)){
      	
    	$haber =  $haber +  $x['haber'] ;
     	$debe =  $debe +  $x['debe'] ;
     	
    }
       
       
       $datoBanco =  $this->bd->query_array('co_plan_ctas',
           ' max(detalle) as detalle',
           'cuenta='. $this->bd->sqlvalue_inyeccion(trim($dato['cuenta']) ,true)
           );
       
       
          $dato['banco'] =  $datoBanco['detalle'];
		  
		   $dato['debeb']  = $debe;
		   $dato['haberb'] = $haber;
 
       
          return $dato;
      }
      //-------------------------------------------
 
  //----------------------------------------------
    function ConsultaMovimiento($codigo){
 
       $this->codigo = $codigo;
       
       $this->ACERTIFICACION = $this->bd->query_array('view_inv_movimiento',
                       '*',
           'id_movimiento='.$this->bd->sqlvalue_inyeccion( $codigo ,true)
           );
       
       $this->AEMPRESA = $this->bd->query_array('web_registro',
           'razon,correo',
           'tipo='.$this->bd->sqlvalue_inyeccion('principal',true)
           ); 

       
       $datosb = $this->bd->query_array('inv_bodega',
           '*',
           'idbodega='.$this->bd->sqlvalue_inyeccion(trim($this->ACERTIFICACION['idbodega']),true)
           );
       
       
       $this->ACERTIFICACION['bodega'] = $datosb['nombre'];
       
            
       
 
	     $datos = $this->bd->query_array('par_usuario',
           'completo',
           'email='.$this->bd->sqlvalue_inyeccion(trim($this->ACERTIFICACION['sesion']),true)
           ); 
	   
	     
	     
	   return  $datos['completo'];
		   
  } 
 //---------
		function pie_rol($cliente,$sesionm=""){
	    
	  
	//------------- llama a la tabla de parametros ---------------------//
	
	$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
	
	$pie_contenido = $reporte_pie["pie"];

	// NOMBRE / CARGO
	$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	$pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
 	$pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
	
 	$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	$pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
 	$pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	 $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	 $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);

 
	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));
	 $pie_contenido = str_replace('#BIENES',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_BIENES',trim($a10['carpetasub']), $pie_contenido);
			
     $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
	 $pie_contenido = str_replace('#GUARDAALMACEN',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_GUARDAALMACEN',trim($a10['carpetasub']), $pie_contenido);			
 
 		 
	 $razon = $this->ACERTIFICACION['razon'] ;
	 $cargo = $this->ACERTIFICACION['unidad'] ;
				 
	 $pie_contenido = str_replace('#FUNCIONARIO',$razon, $pie_contenido);
	 $pie_contenido = str_replace('#UNIDADFUNCIONARIO',$cargo, $pie_contenido);
 
	
	echo $pie_contenido ;
 
}
  //----------------------------------------------
  function ConsultaTiket($codigo){
      
      $this->codigo = $codigo;
      
 
      
      $this->AEMPRESA = $this->bd->query_array('web_registro',
          'razon,correo',
          'tipo='.$this->bd->sqlvalue_inyeccion('principal',true)
          );
      
      
      $this->ACERTIFICACION = $this->bd->query_array('flow.view_itil_tiket',
          '*',
          'id_tiket='.$this->bd->sqlvalue_inyeccion($codigo,true)
          );
      
      
 
      
  } 
  //----------------------------------------------
  function QR_DocumentoDoc($codigo ){
      
      
      $name       = $_SESSION['razon'] ;
      $sesion     = trim($_SESSION['email']);
       
      $datos = $this->bd->query_array('par_usuario',
          'completo',
          'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
          );
      
      $nombre     =  $datos['completo'];
      $year       = date('Y');
      $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
      $elaborador = base64_encode($codigo);
      
      $hoy = date("Y-m-d H:i:s");
      
      // we building raw data
      $codeContents .= 'GENERADO POR:'.$nombre."\n";
      $codeContents .= 'FECHA: '.$hoy."\n";
      $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
      $codeContents .= 'INSTITUCION :'.$name."\n";
      $codeContents .= '2.4.0'."\n";
      
       
      QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
  }
 
  //---------------------------------------------- 
  function QR_Firma( ){
      
      
      $datos = $this->bd->query_array('par_usuario',
          'completo',
          'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
          );
      
      $sesion_elabora =  trim($datos['completo']);
      
      echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
      
  }
  function ConsultaMovimientoCarga($codigo){
      
      $this->codigo = $codigo;
 
      
      $this->ACERTIFICACION = $this->bd->query_array('inv_carga_movimiento',
          'fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
          id_periodo, documento, idprov, id_asiento_ref, fechaa, cierre, iva,
          base0, base12, total, transaccion, novedad, carga',
          'id_cmovimiento='.$this->bd->sqlvalue_inyeccion( $codigo ,true)
          );
      
      $this->AEMPRESA = $this->bd->query_array('web_registro',
          'razon,correo',
          'tipo='.$this->bd->sqlvalue_inyeccion('principal',true)
          );
      
      
  } 
  //----------------------------------------------
  function _getEmpresa($etiqueta){
          
      return $this->AEMPRESA[$etiqueta];
 
  }  
  
  //----------------------------------------------
  function _getSolicita($etiqueta){
      
      return $this->ACERTIFICACION[$etiqueta];
      
  }  
  //-------------------------
  //----------------------------------------------
  function _getDetalle($id_movimiento){
      
      
      $sql = 'SELECT a.id_movimientod as id,
                    b.producto,
	 				b.unidad,
					coalesce(a.cantidad,0) as cantidad,
					coalesce(a.costo,0) as costo,
					coalesce(a.total,0) as total,
					b.lifo,	  b.codigo ,b.saldo ,
                    a.monto_iva,
                    a.baseiva,
                    a.tarifa_cero
			from inv_movimiento_det a, web_producto b
			where 	a.idproducto = b.idproducto and
					a.id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true). ' order by id_movimientod';
      
        /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1; 
      $n1  =0;
      $n2 = 0;

      $n3 = 0;
      $n4 = 0;
      $n5 = 0;
      

      while ($x=$this->bd->obtener_fila($resultado)){


        $sub = $x['baseiva'] + $x['tarifa_cero'];
          
       echo '<tr>  
                  <td width="10%" align="center">'.$x['id'].'</td>
				  <td width="50%" >'.$x['producto'].'</td>
				  <td width="10%" >'.$x['unidad'].'</td>
				  <td width="10%" align="right" >'.$x['cantidad'].'</td>
				  <td width="10%" align="right" >'.number_format( $sub ,4,",",".").'</td>
				   <td width="10%" align="right" >'.number_format($x['monto_iva'],2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($x['total'],2,",",".").'</td>
				</tr>';
    
          $i++;
          $n1 = $n1 + $x['costo'];
          $n2 = $n2 + $x['total'];

          $n3 = $n3 + $x['monto_iva'];
          $n4 = $n4 + $x['baseiva'];
          $n5 = $n5 + $x['tarifa_cero'] ;
 

      }
 
    
 

      $monto_iva = $n4 * (12/100);

      $total =  $monto_iva + $n4  +  $n5;

      $subtotal =   $n4 +   $n5;

      echo '<tr>
                  <td width="10%" align="center"> </td>
				  <td width="50%" > </td>
				  <td width="10%" > </td>
				  <td width="10%" align="right" > TOTAL</td>
				  <td width="10%" align="right" >'.number_format($subtotal,2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($monto_iva,2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($n2,2,",",".").'</td>
				</tr>';
      
				
      return 1 ;
  }  
		
/*
funcion para detalle de egresos
*/
		function _getDetalle_egreso($id_movimiento){
      
      
      $sql = 'SELECT a.id_movimientod as id,
                    b.producto,
	 				b.unidad,
					coalesce(a.cantidad,0) as cantidad,
					coalesce(a.costo,0) as costo,
					coalesce(a.total,0) as total,
					b.lifo,	  b.codigo ,b.saldo ,
                    a.monto_iva,
                    a.baseiva,
                    a.tarifa_cero
			from inv_movimiento_det a, web_producto b
			where 	a.idproducto = b.idproducto and
					a.id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true). ' order by id_movimientod';
      
        /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1; 
      $n1  =0;
      $n2 = 0;

      $n3 = 0;
      $n4 = 0;
      $n5 = 0;
      

      while ($x=$this->bd->obtener_fila($resultado)){
          
       echo '<tr>  
                  <td width="10%" align="center">'.$x['id'].'</td>
				  <td width="50%" >'.$x['producto'].'</td>
				  <td width="10%" >'.$x['unidad'].'</td>
				  <td width="10%" align="right" >'.$x['cantidad'].'</td>
				  <td width="10%" align="right" >'.number_format($x['costo'],4,",",".").'</td>
 				  <td width="10%" align="right" >'.number_format($x['total'],2,",",".").'</td>
				</tr>';
    
          $i++;
          $n1 = $n1 + $x['costo'];
          $n2 = $n2 + $x['total'];
 

      }

 
 
      $total =  $n2 ;

      echo '<tr>
                  <td width="10%" align="center"> </td>
				  <td width="50%" > </td>
				  <td width="10%" > </td>
				  <td width="10%" align="right" > TOTAL</td>
				  <td width="10%" align="right" >'.number_format($n1,2,",",".").'</td>
 				  <td width="10%" align="right" >'.number_format($total,2,",",".").'</td>
				</tr>';
      
				
      return 1 ;
  }  
		
	
/*
funcion para detalle de egresos
*/
		function _getDetalle_egreso_pedido($id_movimiento){
      
      
      $sql = 'SELECT a.id_movimientod as id,
                    b.producto,
	 				b.unidad,
					coalesce(a.cantidade,0) as cantidad,
					coalesce(a.costo,0) as costo,
					coalesce(a.total,0) as total,
					b.lifo,	  b.codigo ,b.saldo ,
                    a.monto_iva,
                    a.baseiva,
                    a.tarifa_cero
			from inv_movimiento_det a, web_producto b
			where 	a.idproducto = b.idproducto and
					a.id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true). ' order by id_movimientod';
      
        /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1; 
      $n1  =0;
      $n2 = 0;

      $n3 = 0;
      $n4 = 0;
      $n5 = 0;
      

      while ($x=$this->bd->obtener_fila($resultado)){
          
       echo '<tr>  
                  <td width="10%" align="center">'.$x['id'].'</td>
				  <td width="50%" >'.$x['producto'].'</td>
				  <td width="10%" >'.$x['unidad'].'</td>
				  <td width="10%" align="right" >'.$x['cantidad'].'</td>
 				</tr>';
    
          $i++;
          
 

      }

 
 
      $total =  $n2 ;
 
      
				
      return 1 ;
  }  		
  //----------------------------------
  function _getDetalle_conta($id_movimiento){
      
      
      $sql = 'SELECT    cuenta_inv, ncuenta_inv, debito,
                      sum(cantidad) as cantidad,
                      avg(costo) as costo,
                       sum(baseiva) baseimponible,
                      sum(monto_iva) as iva,
                      sum(tarifa_cero) as tarifa_cero,
                      sum(descuento) as descuento,
                      sum(total) as total
			from view_inv_movimiento_det
			where id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true).'
            group by cuenta_inv, ncuenta_inv,  debito';
 
 
	
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1;
      $n1 =0;
      $n2 = 0;
      $n3 =0;
      $n4 = 0;
      $n5 = 0;
      
      while ($x=$this->bd->obtener_fila($resultado)){
          

        $monto_iva = $x['baseimponible'] * (12/100);
 
         $subtotal1 =   $x['tarifa_cero'] + $x['baseimponible'];
         $total1 =  $x['total'];

          echo '<tr>
                   <td width="20%" >'.trim($x['cuenta_inv']).'</td>
				  <td width="40%" >'.trim($x['ncuenta_inv']).'</td>
				  <td width="10%" >'.trim($x['debito']).'</td>
                  <td width="10%" align="right" >'.trim($x['cantidad']).'</td>
				  <td width="10%" align="right" >'.number_format( $subtotal1 ,2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format( $total1 ,2,",",".").'</td>
				</tr>';
          
          $i++;
          $n1 = $n1 + $x['costo'];
          $n2 = $n2 + $x['baseimponible'];
          $n3 = $n3 + $x['iva'];
          $n4 = $n4 + $x['tarifa_cero'];
          $n5 = $n5 + $x['total'];
       }
 
 
       $monto_iva = $n2 * (12/100);
 
       $total =  $monto_iva + $n5  +  $n2;
      echo '<tr>
                  <td width="20%" > </td>
				  <td width="40%" > </td>
                  <td width="10%" > </td>
				  <td width="10%" align="right" > TOTAL</td>
                  <td width="10%" align="right" >'.number_format($n1,2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($n5,2,",",".").'</td>
				</tr>';
      
      
      return 1 ;
  }  
  //-------------------------------------------
  function _getDetalleCarga($id_movimiento){
      
      
      $sql = 'SELECT idproducto, producto,saldo,cantidad, costo,   total,sesion
			from inv_carga_inicial
			where  id_cmovimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1;
      $n1 =0;
      $n2 = 0;
      while ($x=$this->bd->obtener_fila($resultado)){
          
          echo '<tr>
                  <td width="10%" align="center">'.$x['idproducto'].'</td>
				  <td width="40%" >'.$x['producto'].'</td>
				  <td width="10%" >'.$x['saldo'].'</td>
				  <td width="10%" align="right" >'.$x['cantidad'].'</td>
				  <td width="10%" align="right" >'.number_format($x['costo'],2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($x['total'],2,",",".").'</td>
                  <td width="10%" >______________</td>
				</tr>';
          
          $i++;
          $n1 = $n1 + $x['costo'];
          $n2 = $n2 + $x['total'];
      }
      echo '<tr>
                  <td width="10%" align="center"> </td>
				  <td width="50%" > </td>
				  <td width="10%" > </td>
				  <td width="10%" align="right" > </td>
				  <td width="10%" align="right" >'.number_format($n1,2,",",".").'</td>
				  <td width="10%" align="right" >'.number_format($n2,2,",",".").'</td>
				</tr>';
      
      
      return 1 ;
  } 
  //----------------------------------------------
  function _getId(){
      
      $soli = str_pad($this->codigo, 7, "0", STR_PAD_LEFT);
 
    //  $solicitud = $soli.'-'.$this->ACERTIFICACION['ANIO'];
      
      return $soli;
      
  }

  function FirmasPie(){
      
     
      
      ///-------------------------------------------
      $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
      $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
      $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
      $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
      $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
      $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
      
      
      $a16 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
      $a20 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));
      
      $datos["p10"] = $a10["carpeta"];
      $datos["p11"] = $a10["carpetasub"];
      $datos["g10"] = $a11["carpeta"];
      $datos["g11"] = $a11["carpetasub"];
      
      $datos["f10"] = $a12["carpeta"];
      $datos["f11"] = $a12["carpetasub"];
      
      $datos["t10"] = $a13["carpeta"];
      $datos["t11"] = $a13["carpetasub"];
      
      $datos["c10"] = $a14["carpeta"];
      $datos["c11"] = $a14["carpetasub"];
      
      $datos["e10"] = $a16["carpeta"];            // guardaalmacen
      $datos["e11"] = $a16["carpetasub"];
      
      $datos["b10"] = $a20["carpeta"];   // bienes
      $datos["b11"] = $a20["carpetasub"];
      
 
 
      
      $usuarios = $this->bd->__user(trim($this->sesion));
      
      $datos['elaborado'] = ucwords(strtolower($usuarios['completo']));
      $datos['unidad']    =  ucwords(strtolower($usuarios['unidad']));
      
 
      
      
      return $datos;
  }
///------------------------------------------------------------------------
function FichaNomina($id ){
          
   	
    $qquery = array( 
        array( campo => 'idprov',   valor => trim($id),  filtro => 'S',   visor => 'S'),
        array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
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
    
       
         $datos = $this->bd->JqueryArrayVisorDato('view_nomina_rol',$qquery );           


 
       
         $x = $this->bd->query_array('view_nomina_banco',   // TABLA
         'banco, codigo_banco, tipo_cuenta,nro_banco,sueldo',                        // CAMPOS
         'identificacion='.$this->bd->sqlvalue_inyeccion( trim($id),true) // CONDICION
        );

        $datos["banco"]        =  $x["banco"];
        $datos["codigo_banco"] =  $x["codigo_banco"];
        $datos["tipo_cuenta"]  =  $x["tipo_cuenta"];
        $datos["nro_banco"]    =  $x["nro_banco"];
        $datos["sueldo"]       =  $x["sueldo"];

    
       return  $datos;
       
     }	
///------------------------------------------------------------------------
  }
 