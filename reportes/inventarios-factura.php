<?php 
session_start( );   
require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
include('phpqrcode/qrlib.php'); 


class componente{
 
      private $obj;
      private $bd;
      private $codigo;
	  private $ruc;
      private $POST;
      //--------------------
      private   $AEMPRESA;
      private   $ACERTIFICACION;
      private $ACAJA;
      public $Registro;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 
                $this->sesion 	 =  $_SESSION['login'];
                
		     	$this->ruc       =     $_SESSION['ruc_registro'];
              
      }
//----------------------------------------------
	function Empresa( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}
	///---------------
			function _Cab( $dato ){
	      
	    return $this->Registro[$dato];
	}
		///////////////////////
   function ConsultaMovimiento($codigo){
 
       $this->codigo = $codigo;
       
       $this->ACERTIFICACION = $this->bd->query_array('view_inv_movimiento',
                       'fecha, registro, detalle, sesion,  comprobante, estado, tipo,   documento, idprov, 
                        proveedor, razon, 
                         direccion, telefono, correo, contacto, 
                         fechaa, anio, mes,transaccion',
           'id_movimiento='.$this->bd->sqlvalue_inyeccion( $codigo ,true)
           );
       
       $this->AEMPRESA = $this->bd->query_array('web_registro',
           'razon,correo',
           'tipo='.$this->bd->sqlvalue_inyeccion('principal',true)
           ); 

 
  }  
  //----------------------------------------------
  function _get_caja(){
      
      $this->AEMPRESA = $this->bd->query_array('web_registro',
          'razon,correo',
          'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc ,true)
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
  //----------------------------------------------
  function _get_cajero($etiqueta){
      
      return $this->ACAJA[$etiqueta];
      
  }  
  //----------------------------------------------
  function _cajero($cajero){
      
      
      $this->ACAJA = $this->bd->query_array('par_usuario',
          'login,  completo , estado,   rol, url,tipourl,caja,supervisor',
          'email='.$this->bd->sqlvalue_inyeccion($cajero ,true)
          );
      
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
                    coalesce(a.monto_iva,0) as iva,
                    coalesce(a.tarifa_cero,0) as tarifa0,
 					b.lifo,	  b.codigo ,b.saldo 
			from inv_movimiento_det a, web_producto b
			where 	a.idproducto = b.idproducto and
					a.id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
      
        /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $i = 1; 
      $n1 =0;
      $n2 = 0;
      $n3 = 0;
      $n4 = 0;
      while ($x=$this->bd->obtener_fila($resultado)){
          
       echo '<tr>  
                  <td width="10" align="center">'.$x['id'].'</td>
				  <td width="50" >'.$x['producto'].'</td>
				  <td width="10" >'.$x['unidad'].'</td>
				  <td width="10" align="right" >'.$x['cantidad'].'</td>
				  <td width="10" align="right" >'.number_format($x['costo'],2,",",".").'</td>
				  <td width="10" align="right" >'.number_format($x['total'],2,",",".").'</td>
				</tr>';
    
          $i++;
          $n1 = $n1 + $x['costo'];
          $n2 = $n2 + $x['total'];
          $n3 = $n3 + $x['iva'];
          $n4 = $n4 + $x['tarifa0'];
      }
      
      $base = $n2 - ($n3+ $n4);
      echo '</tr>
		      <tr>
                 <td colspan="5" align="right" valign="middle">Base Imponible</td>
                 <td align="right" valign="middle">'.number_format($base,2,",",".").'</td>
             </tr>
             <tr>
                 <td colspan="5" align="right" valign="middle">12% IVA</td>
                 <td align="right" valign="middle">'.number_format($n3,2,",",".").' </td>
             </tr>
            <tr>
                 <td colspan="5" align="right" valign="middle">Tarifa 0%</td>
                 <td align="right" valign="middle">'.number_format($n4,2,",",".").' </td>
             </tr>
            <tr>
                 <td colspan="5" align="right" valign="middle">Total</td>
                 <td align="right" valign="middle">'.number_format($n2,2,",",".").' </td>
             </tr>
  ';
      
				
      return 1 ;
  }  
  
  //----------------------------------------------
  function _getId(){
      
      $soli = str_pad($this->codigo, 7, "0", STR_PAD_LEFT);
 
    //  $solicitud = $soli.'-'.$this->ACERTIFICACION['ANIO'];
      
      return $soli;
      
  }
  //--------------------- 
  function resumenClientes($fecha,$cajero, $parte){
 
   
      
      $sql = 'SELECT fechap, razon,count(*) as nn,
             sum(base0) as base, 
             sum(base12) as base12,
             sum(interes) as interes,
             sum(descuento) as descuento,
             sum(recargo) as recargo,
             sum(iva) as iva,
             sum(total) as total
      FROM rentas.view_ren_movimiento_pagos
      where fechap = '.$this->bd->sqlvalue_inyeccion($fecha ,true)." and 
            estado = 'P' and 
            id_renpago in ( select  a.id_renpago 
                             from rentas.ren_movimiento_pago a 
                             where a.parte = ".$this->bd->sqlvalue_inyeccion( $parte ,true).") and
            sesion_pago = ".$this->bd->sqlvalue_inyeccion(trim($cajero) ,true) ." group by fechap,razon"     ;
 
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      $baseimpgrav = 0;
      $montoiva = 0;
      $baseimponible = 0;
      $total2 = 0;
      $recargo= 0;
      
      while ($x=$this->bd->obtener_fila($resultado)){
          
          $total = $x['total']  ;

          $emision = $x['base12'] + $x['base'];
          
          echo '<tr>
                  <td   width="10%" align="center">'.$x['fechap'].'</td>
				  <td   width="30%" >'.$x['razon'].'</td>
				  <td   width="10%" >'.$x['nn'].'</td>
 				  <td   width="10%" align="right" >'.number_format(  $emision,2,",",".").'</td>
                 <td   width="10%" align="right" >'.number_format($x['interes'],2,",",".").'</td>
                 <td   width="10%" align="right" >'.number_format($x['descuento'],2,",",".").'</td>
                 <td   width="10%" align="right" >'.number_format($x['recargo'],2,",",".").'</td>
                  <td   width="10%" align="right" >'.number_format($total,2,",",".").'</td>
				</tr>';
          
          $baseimpgrav = $baseimpgrav + $emision;
          $montoiva    = $montoiva + $x['interes'];
          $baseimponible = $baseimponible + $x['descuento'];
          $recargo = $recargo + $x['recargo'];
          $total2        = $total2 + $total;
          
      }
      
      echo '<tr>
                  <td></td>
				  <td></td>
				  <td>TOTAL</td>
 				  <td align="right">'.number_format($baseimpgrav,2,",",".").'</td>
                  <td align="right">'.number_format($montoiva,2,",",".").'</td>
                  <td align="right">'.number_format($baseimponible,2,",",".").'</td>
                  <td align="right">'.number_format($recargo,2,",",".").'</td>
                  <td align="right">'.number_format($total2,2,",",".").'</td>
				</tr>';
      
  }
 //---------------------
 function resumenClientes_especie($fecha,$cajero, $codigo){
 
   
      
    $sql = 'select id_ren_movimiento ,fecha ,idprov,contribuyente ,comprobante , documento ,total ,cantidad
             from rentas.view_ren_especies
             where  
                   fecha = '.$this->bd->sqlvalue_inyeccion($fecha ,true) .' and 
                   idproducto_ser = '.$this->bd->sqlvalue_inyeccion($codigo ,true).' order by comprobante desc';
    
 
 
    /*Ejecutamos la query*/
    $resultado = $this->bd->ejecutar($sql);
    
    $baseimpgrav = 0;
    $montoiva = 0;
    $baseimponible = 0;
    $total2 = 0;
    
    while ($x=$this->bd->obtener_fila($resultado)){
        
        $total = $x['total']  ;
        
        echo '<tr>
                <td   width="10%" align="center">'.$x['fecha'].'</td>
                <td   width="10%" >'.trim($x['idprov']).'</td>
                <td   width="30%" >'.trim($x['contribuyente']).'</td>
                <td   width="15%" >'.$x['comprobante'].'</td>
                <td   width="10%" >'.$x['documento'].'</td>
				 <td   width="10%" >'.intval($x['cantidad']).'</td>
                <td   width="15%" align="right" >'.number_format($total,2,",",".").'</td>
              </tr>';
        
       
        $total2        = $total2 + $total;
        
    }
    
    echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
				  
				    <td></td>
                <td>TOTAL</td>
                <td align="right" style="font-size: 14px"> <b>'.number_format($total2,2,",",".").'</b></td>
              </tr>';
    
} 
//--------------------------
  function resumenPagoBaja($fecha,$cajero,$parte){
      
 
    $sql = 'SELECT fecha_pago,
    formapago, 
    tipopago, 
    banco,
    cuenta, 
    parte,   
    sum(total) as pagado
 FROM rentas.view_ren_emision
 where fecha_pago = '.$this->bd->sqlvalue_inyeccion($fecha ,true).' and 
       sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero) ,true).' and 
       parte = '.$this->bd->sqlvalue_inyeccion(trim($parte) ,true)." and
       estado  <>  'P'
 group by fecha_pago,formapago, tipopago, cuenta, parte,   banco";
      
 
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
       
      while ($x=$this->bd->obtener_fila($resultado)){
          
          echo '<tr>
                  <td   width="12%" align="center">'.$x['fecha_pago'].'</td>
				  <td   width="20%" >'.$x['formapago'].'</td>
				  <td   width="18%" >'.$x['tipopago'].'</td>
                  <td   width="25%" >'.$x['banco'].'</td>
                 <td    width="15%" >'.$x['cuenta'].'</td>
 				  <td   width="10%" align="right" >'.number_format($x['pagado'],2,",",".").'</td>
				</tr>';
 
      }
       
  }  
  //----------------------------------------------
  function resumenPago($fecha,$cajero,$parte){
      
 
    $sql = 'SELECT fecha_pago,
    formapago, 
    tipopago, 
    banco,
    cuenta, 
    parte,   
    sum(total) as pagado
 FROM rentas.view_ren_diario_pagos
 where fecha_pago = '.$this->bd->sqlvalue_inyeccion($fecha ,true).' and 
       sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero) ,true).' and 
       parte = '.$this->bd->sqlvalue_inyeccion(trim($parte) ,true)." and
       estado = 'P'
 group by fecha_pago,formapago, tipopago, cuenta, parte,   banco";
      
 
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
       
      while ($x=$this->bd->obtener_fila($resultado)){
          
          echo '<tr>
                  <td   width="12%" align="center">'.$x['fecha_pago'].'</td>
				  <td   width="20%" >'.$x['formapago'].'</td>
				  <td   width="18%" >'.$x['tipopago'].'</td>
                  <td   width="25%" >'.$x['banco'].'</td>
                 <td    width="15%" >'.$x['cuenta'].'</td>
 				  <td   width="10%" align="right" >'.number_format($x['pagado'],2,",",".").'</td>
				</tr>';
 
      }
       
  }  
  
  //--------------
  function bitacora_herramientas($codigo){
      
      
      
      $sql = "select  fecha_creacion,tiempo,tipo_m,actividad_m
            from bomberos.bombero_material
            where id_bita_bom = ".$this->bd->sqlvalue_inyeccion($codigo, true).
            " order by id_bom_mate desc";
      
      $cabecera =  "Fecha,Hora,Tipo Actividad,Novedad"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
      
      $tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
      
      $evento   = "";  // nombre funcion javascript-columna de codigo primario
      
      $resultado  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
      
      /*
       entrada:
       resultado =  resulta do del sql
       tipo      =  tipo de conexion
       editar    =  evento editar / seleccionar
       del       =  evento eliminar / del
       evento    =  nombre funcion javascript separada - index de la variable clave
       cabecera  = columnas
       */
      
      $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
      
  }
  //-------------
  function bitacora_carros($codigo){
      
      $sql = "select  fecha_creacion,tiempo,carro,actividad_c,carro_tipo,comb
            from bomberos.view_bom_carro
            where id_bita_bom = ".$this->bd->sqlvalue_inyeccion($codigo, true).
            " order by id_bom_carro desc";
      
      $cabecera =  "Fecha,Hora,Vehiculo/Maquinaria,Novedad,Uso,Combustible"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
      
      $tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
      
      $evento   = "";  // nombre funcion javascript-columna de codigo primario
      
      $resultado  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
      
      /*
       entrada:
       resultado =  resulta do del sql
       tipo      =  tipo de conexion
       editar    =  evento editar / seleccionar
       del       =  evento eliminar / del
       evento    =  nombre funcion javascript separada - index de la variable clave
       cabecera  = columnas
       */
      
      $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
      
  }
  //---------------
  function bitacora_actividad($codigo){
      
      $sql = "select  fecha_creacion,tiempo,tipo_actividad,actividad_d
            from bomberos.bombero_actividad
            where id_bita_bom = ".$this->bd->sqlvalue_inyeccion($codigo, true).
            " order by id_bom_acti desc";
      
      $cabecera =  "Fecha,Hora,Novedad,Actividad desarrollada"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
      
      $tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
      
      $evento   = "";  // nombre funcion javascript-columna de codigo primario
      
      $resultado  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
      
      /*
       entrada:
       resultado =  resulta do del sql
       tipo      =  tipo de conexion
       editar    =  evento editar / seleccionar
       del       =  evento eliminar / del
       evento    =  nombre funcion javascript separada - index de la variable clave
       cabecera  = columnas
       */
      
      $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
      
  }
  
  //-----------------
  function bitacora_personal($codigo){
      
      $sql = "select  fecha_creacion,tiempo,funcionario, denominacion, actividad
            from bomberos.view_bom_bitacora_bom
            where id_bita_bom = ".$this->bd->sqlvalue_inyeccion($codigo, true).
            " order by id_bom_bita desc";
      
      
      $cabecera =  "Fecha,Hora,Personal,Denominacion,Novedad"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
      
      $tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
      
      $evento   = "";  // nombre funcion javascript-columna de codigo primario
      
      $resultado  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
      
      /*
       entrada:
       resultado =  resulta do del sql
       tipo      =  tipo de conexion
       editar    =  evento editar / seleccionar
       del       =  evento eliminar / del
       evento    =  nombre funcion javascript separada - index de la variable clave
       cabecera  = columnas
       */
      
      $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
      
  }
      
  //----------------------------------------------
  function resumenProducto($fecha,$cajero,$parte){
      
    
    $sql = "SELECT  nombre_rubro, 
                    count(*) || ' ' as titulos,
                    COALESCE(sum(base0),0) as tarifa_cero, 
                    COALESCE(sum(base12),0) as base_imponible,
                    COALESCE(sum(iva),0) as monto_iva, 
                    COALESCE(sum(interes),0) as interes, 
                    COALESCE(sum(descuento),0) as descuento, 
                    COALESCE(sum(recargo),0) as recargo, 
                    COALESCE(sum(subtotal),0) as subtotal,
                    COALESCE(sum(apagar),0) as pagado
            FROM rentas.view_ren_movimiento_pagos
            where sesion_pago = ".$this->bd->sqlvalue_inyeccion($cajero ,true).'  and 
                fechap = '.$this->bd->sqlvalue_inyeccion($fecha ,true)." and
                id_renpago in ( select  a.id_renpago 
                                 from rentas.ren_movimiento_pago a 
                                 where a.parte = ".$this->bd->sqlvalue_inyeccion(trim($parte) ,true).')
            group by nombre_rubro
            order by nombre_rubro';
      
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      
      while ($x=$this->bd->obtener_fila($resultado)){
          
          echo '<tr>
 				  <td   width="30%">'.trim($x['nombre_rubro']).'</td>
				  <td   width="8%" align="right">'.$x['titulos'].'</td>
                  <td   width="10%" align="right" >'.$x['tarifa_cero'].'</td>
                  <td   width="10%" align="right" >'.$x['base_imponible'].'</td>
                  <td   width="10%" align="right" >'.$x['monto_iva'].'</td>
                  <td   width="10%" align="right" >'.$x['subtotal'].'</td>
 				  <td   width="12%" align="right" >'.trim(number_format($x['pagado'],2,",",".")).'</td>
				</tr>';
          
      }
      
  }  
//----------------------	
	function resumenVentaNotas($fecha,$cajero){
      
      
     
      
      $sql = 'select a.idcliente,a.numdocmodificado ,a.fechaemision ,a.fecha_factura ,a.fechaemisiondocsustento ,a.secuencial ,
				   b.comprobante, b.razon,b.base12, b.iva, b.base0, b.total 
			from doctor_vta a
			join view_ventas_fac b on b.id_movimiento = a.id_diario and 
				 a.fechaemisiondocsustento='.$this->bd->sqlvalue_inyeccion($fecha ,true);
	   
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
 
      
      while ($x=$this->bd->obtener_fila($resultado)){
          
		 //  $total = $x['base12'] + x['iva'] +$x['base0'] ;
		  
          echo '<tr>
                   <td   width="10%">'.$x['fechaemisiondocsustento'].'</td>
				   <td   width="30%">'.$x['razon'].'</td>
  				   <td   width="15%" align="center">'.$x['numdocmodificado'].'</td>
				   <td   width="10%" align="center" >'.$x['secuencial'].'</td>
                   <td   width="10%" align="right" >'.number_format($x['base12'],2,",",".").'</td>
                   <td   width="10%" align="right" >'.number_format($x['iva'],2,",",".").'</td>
                   <td   width="10%" align="right" >'.number_format($x['base0'],2,",",".").'</td>
 				   <td   width="10%" align="right" >'.number_format( $x['total'],2,",",".").'</td>
				</tr>';
          
      }
      
  }  
  //----

  function Especie_nombre($codigo,$fecha,$cajero){

  $x = $this->bd->query_array('rentas.view_control_especie ',   // TABLA
  'inicio, fin, actual,    completo,producto ',                        // CAMPOS
  'idproducto_ser='.$this->bd->sqlvalue_inyeccion($codigo,true) ." and estado = 'S' "// CONDICION
 );


 echo  'Referencia Especie: <b>'.$x['producto'] .'</b><br>' ;

	  
	    $xx = $this->bd->query_array('rentas.view_ren_especies ',   // TABLA
									'sum(cantidad) as nn, min(comprobante) as d1, max(comprobante) as d2 ',       
									'fecha = '.$this->bd->sqlvalue_inyeccion($fecha ,true) .' and 
                   					 idproducto_ser = '.$this->bd->sqlvalue_inyeccion($codigo ,true) 
 		);

	  
	   $ulti = $this->bd->query_array('rentas.view_ren_especies ',   // TABLA
									'cantidad -1 as d2 ',       
									'comprobante = '.$this->bd->sqlvalue_inyeccion($xx['d2'] ,true) 
 		);
	  
	  
 
	  
	  
	echo    '<br><br>Nro. Especies emitidas : <b>'.intval($xx['nn']).'</b>';  
	  
	  $inicio = ($xx['d2'] - intval($xx['nn'])) + 1 ;
	  
	  $inicio = intval($xx['d1'])  ;
	  
	  $fin =   intval($xx['d2'])   +  intval($ulti['d2']) ;
	  
	 
	echo    '<br>Desde: '.  $inicio.' Hasta: '.  $fin ;
	  
     
	  

}  
/*

reporte de mes de especies mensual
*/
	
  function Especie_nombre_mes($codigo,$fecha,$cajero){

  $x = $this->bd->query_array('rentas.view_control_especie ',   // TABLA
  'inicio, fin, actual,    completo,producto ',                        // CAMPOS
  'idproducto_ser='.$this->bd->sqlvalue_inyeccion($codigo,true) ." and estado = 'S' "// CONDICION
 );


 echo  'Referencia Especie: <b>'.$x['producto'] .'</b><br>'.
       '<br>Lote Inicio: '.$x['inicio'] .
       '<br>Lote Hasta: '.$x['fin'] .
       '<br>Secuencia Actual: <b>'.$x['actual'] .'</b>';

	  
	    $xx = $this->bd->query_array('rentas.view_ren_especies ',   // TABLA
									'sum(cantidad) as nn ',       
									'fecha = '.$this->bd->sqlvalue_inyeccion($fecha ,true) .' and 
                   					 idproducto_ser = '.$this->bd->sqlvalue_inyeccion($codigo ,true) 
 		);

	  
	   echo    '<br>Nro. Especies emitidas hoy : <b>'.intval($xx['nn']) .'</b>';
	  
	  $periodo = explode( '-',$fecha);
	
	  $anio = $periodo[0];
	  $mes  = intval($periodo[1]) ;
	  
	   $xy = $this->bd->query_array('rentas.view_ren_especies ',   // TABLA
									'sum(cantidad) as nn ',       
									'   mes = '.$this->bd->sqlvalue_inyeccion($mes ,true) .' and 
									 anio = '.$this->bd->sqlvalue_inyeccion($anio ,true) .' and 
                   					 idproducto_ser = '.$this->bd->sqlvalue_inyeccion($codigo ,true)  
 		);
     
	    echo    '<br>Nro. Especies emitidas Mensual : <b>'.intval($xy['nn']) .'</b>';
	  

}  
	
	/*
	DETALLE MENSUAL DE ESPECIES
	*/
  function resumenClientes_especie_mes($fecha,$cajero, $codigo){
 
   
	  $periodo = explode( '-',$fecha);
	
	  $anio = $periodo[0];
	
	  $mes  = intval($periodo[1]) ;
	  
      
    $sql = 'select fecha ,min(comprobante) as d1, max(comprobante) as d2 ,sum(total) total, sum(cantidad) as nn 
             from rentas.view_ren_especies
             where  
                   mes = '.$this->bd->sqlvalue_inyeccion($mes ,true) .' and 
				   anio = '.$this->bd->sqlvalue_inyeccion($anio ,true) .' and 
                   idproducto_ser = '.$this->bd->sqlvalue_inyeccion($codigo ,true).' 
				   group by fecha
				   order by fecha desc';
 
 
    /*Ejecutamos la query*/
	  
    $resultado = $this->bd->ejecutar($sql);
    
 
    $total2 = 0;
	  
	    
    
    while ($x=$this->bd->obtener_fila($resultado)){
        
        $total = $x['total']  ;
        $final = intval(trim($x['d1'])) + intval($x['nn']) - 1;
        
        echo '<tr>
                <td   width="10%" align="center">'.$x['fecha'].'</td>
                <td   width="20%" align="center"  >'.trim($x['d1']).'</td>
                <td   width="20%" align="center" >'.trim($final).'</td>
                <td   width="10%" align="center" >'.intval($x['nn']).'</td>
                <td   width="10%" align="right" >'.number_format($total,2,",",".").'</td>
              </tr>';
        
       
        $total2        = $total2 + $total;
        
    }
    
    echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                 <td>TOTAL</td>
                <td align="right" style="font-size: 14px"> <b>'.number_format($total2,2,",",".").'</b></td>
              </tr>';
    
} 
  //----------------------------------------------
  function resumenVenta($fecha,$cajero){
      
      
     
      
      $sql = 'SELECT  fecha ,
                      facturas ,
                    base12,
                    iva ,
                    base0 ,
                    total
      FROM view_factura_caja
      where fecha = '.$this->bd->sqlvalue_inyeccion($fecha ,true).' and
            sesion = '.$this->bd->sqlvalue_inyeccion($cajero ,true)      ;
      
      /*Ejecutamos la query*/
      $resultado = $this->bd->ejecutar($sql);
      
      
      while ($x=$this->bd->obtener_fila($resultado)){
          
		 //  $total = $x['base12'] + x['iva'] +$x['base0'] ;
		  
          echo '<tr>
                  <td   width="20%" align="center">'.$x['fecha'].'</td>
 				  <td   width="20%" align="right">'.$x['facturas'].'</td>
                   <td   width="20%" align="right" >'.number_format($x['base12'],2,",",".").'</td>
                  <td   width="10%" align="right" >'.number_format($x['iva'],2,",",".").'</td>
                  <td   width="10%" align="right" >'.number_format($x['base0'],2,",",".").'</td>
 				  <td   width="20%" align="right" >'.number_format( $x['total'],2,",",".").'</td>
				</tr>';
          
      }
      
  }  
  
  //----------
  function bitacora_informe($id){
          
      
      $CierreCaja = $this->bd->query_array('bomberos.view_bom_bitacora_det',
          '*',
          'id_bita_bom='.$this->bd->sqlvalue_inyeccion($id,true) 
          );
      
	    $urlimagen = '../kimages/'.trim($CierreCaja['grafico']);
	  
       
	  $CierreCaja['foto'] = $urlimagen;
		  
      return $CierreCaja;
      
      
      
       
  
  }  
  
  //----------------------------------------------
  function informe_cierre($fecha,$cajero){
      
      $CierreCaja = $this->bd->query_array('view_inv_cierre',
          'fecha, sesion, novedad,cierre,facturas',
          'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true).' and 
           fecha = '.$this->bd->sqlvalue_inyeccion($fecha,true)
          );
      
      $cadena = 'Caja cerrada? ['.$CierreCaja['cierre'].'] '.$CierreCaja['novedad'];
      
      return $cadena;
      
  }  
	/*
	*/
  function parte_cierre($parte,$cajero){
      
      $CierreCaja = $this->bd->query_array('rentas.ren_movimiento_pago',
          'hora,fecha_pago',
          'parte = '.$this->bd->sqlvalue_inyeccion(trim($parte),true)
          );
      
       
      return $CierreCaja;
      
  }  	
  ///------------------------------------------------------------------------

  function QR_DocumentoDoc($codigo){
	    
	    
    $name       = trim($_SESSION['razon']) ;
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

function QR_Firma( ){
	    
	    
    $datos = $this->bd->query_array('par_usuario',
        'completo',
        'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
        );
    
    $sesion_elabora =  trim($datos['completo']);
    
    echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
    
}

}
 