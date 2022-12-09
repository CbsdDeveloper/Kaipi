<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php'; 
  
    class componente{
 
       
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
        }
     //---------------------------------------
        function costo_saldo( $id,$fecha1,$fecha2  ){
      
 
        $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".$this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
            
            
         
         $sql_det =' SELECT  fecha, tipo, costo,cantidad,total,
                            coalesce(ingreso,0) AS ingreso,
                            coalesce(egreso,0) AS egreso,
                            (cantidad * costo) as total_variable,
                             id_movimiento, detalle,razon,comprobante,producto
        FROM  view_mov_aprobado
        WHERE idproducto= '.$this->bd->sqlvalue_inyeccion($id,true).$cadena2.'
        order by fecha asc,ingreso desc, tipo asc';
         
         $stmt21 = $this->bd->ejecutar($sql_det);
         
         $i = 1;
         
         $total_saldo    = 0;
         $total_cantidad = 0;
         $tota_promedio  = 0;
 
         
         $num_ingreso = 0;
         $num_egreso  = 0;
         $tota_PVP = 0;
         
         while ($y=$this->bd->obtener_fila($stmt21)){
             $costo    = $y['costo'];
             $tipo     = $y['tipo'];
             $cantidad = $y['cantidad'];
             $total    = $y['total_variable'];
             
              
             
             if ( $i == 1) {
                 
                 if ( $tipo == 'I') {
                     $total_cantidad = $total_cantidad + $cantidad;
                     $total_saldo    = $total_saldo + $total;
                     $tota_promedio  = $total_saldo / $total_cantidad;
                     $num_ingreso = $num_ingreso + $cantidad;
                  }
                 
             }else{
                 
                 if ( $tipo == 'I') {
                     
                     $total_cantidad = $total_cantidad + $cantidad;
                     $total_saldo    = round($total_saldo + $total,2);
                     $tota_promedio  = round($total_saldo / $total_cantidad,4);
                     $num_ingreso = $num_ingreso + $cantidad;
                  }else {
                     
                     $total_egreso   = $cantidad * $tota_promedio;
                     
                     $tota_PVP = $tota_PVP + $total ;
                     
                     $total_cantidad = $total_cantidad - $cantidad;
                     
                     $total_saldo    = round($total_saldo - $total_egreso,2);
                     $tota_promedio  = round($total_saldo / $total_cantidad,4);
                     
                     if ( $total_cantidad == 0 ){
                         $tota_promedio = 0;
                     }
                     $num_egreso  =  $num_egreso  + $cantidad ;
 
                     $costo_egreso   = $tota_promedio;
                     $total_egreso   = $costo *$costo_egreso ;
                 }
                 
             }
             //-----------------------------------------------------------------
            
  //           $total_ingreso = $total_ingreso +   $y['ingreso'];
  //           $total_egreso  = $total_egreso  +   $y['egreso'];
             
             $i ++;
         }
         
         
         $datos['venta']        = $tota_PVP;
 
     
         $datos['costo']        = $tota_promedio;
         
         $datos['cantidad']     = round($total_cantidad,2);
         
         $datos['saldo']        = round($total_saldo,2);
         
         $datos['ingreso']     = round($num_ingreso,2);
         
         $datos['egreso']        = round($num_egreso,2);
         
         return $datos;
		 
		 
   }
   
   function Resumen_productos( $fecha1,$fecha2  ){
       
       
       $sql_det =' delete from web_producto_resumen WHERE  1=1';
       
      $this->bd->ejecutar($sql_det);
       
 
       
       $cadena2 = '   ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".$this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
       
       
       
       $sql_det = ' SELECT idproducto,count(*) as nn,producto
                 from view_inv_movimiento_det
                where '.$cadena2.' 
                group by idproducto,producto';
       
        $stmt1 = $this->bd->ejecutar($sql_det);
 
       
       while ($x=$this->bd->obtener_fila($stmt1)){
       
        $idproducto = $x['idproducto'];
        $producto   = $x['producto'];
 
        $datos=$this->costo_saldo( $idproducto,$fecha1,$fecha2  );
        
        
        $this->insertar_resumen($datos,$idproducto,$producto);
 
    
 
       }
       
       echo 'DATOS ACTUALIZADOS CORRECTAMENTE';
       
   }
 //----------------------------------------------
//----------------------------------------------
   function insertar_resumen($datos1,$idproducto,$producto){
         
 
       
       $x = $this->bd->query_array('web_producto','cuenta_inv, cuenta_ing,cuenta_gas', 'idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true));
       
       
       $costo_mensual = $datos1['costo'] * $datos1['egreso'];
       
       $ganancia = $datos1['venta'] - $costo_mensual;
       
       $ATabla = array(
           array( campo => 'idproducto',tipo => 'NUMBER',id => '0',add => 'S', edit => 'S', valor =>$idproducto, key => 'N'),
           array( campo => 'producto',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $producto, key => 'N'),
           array( campo => 'cuenta_inv',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>$x['cuenta_inv'], key => 'N'),
           array( campo => 'cuenta_ing',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>$x['cuenta_ing'], key => 'N'),
           array( campo => 'cuenta_gas',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$x['cuenta_gas'], key => 'N'),
           array( campo => 'costo',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $datos1['costo'] , key => 'N'),
           array( campo => 'ingreso',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>$datos1['ingreso'], key => 'N'),
           array( campo => 'egreso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor =>  $datos1['egreso'] , key => 'N'),
           array( campo => 'saldo',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $datos1['saldo'], key => 'N'),
           array( campo => 'promedio',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $datos1['costo'], key => 'N'),
           array( campo => 'actual',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $datos1['cantidad'], key => 'N'),
           array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
           array( campo => 'venta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor =>$datos1['venta'], key => 'N'),
           array( campo => 'costo_mensual',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor =>$costo_mensual, key => 'N'),
           array( campo => 'ganancia',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor =>$ganancia, key => 'N')
       );
       
       
       
       $this->bd->pideSq(1);
       
       $this->bd->_InsertSQL('web_producto_resumen',$ATabla,'NO');
       
 
       
   }  
    
 
  //----------------------------------------------
  //----------------------------------------------
   function visor($fecha1,$fecha2 ){
       
       
       $qcabecera = array(
           array(etiqueta => 'Codigo',campo => 'idproducto',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Producto',campo => 'producto',ancho => '30%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Cta. Inventarios',campo => 'cuenta_inv',ancho => '7%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Cta. Ingreso',campo => 'cuenta_ing',ancho => '7%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Cta. Gasto',campo => 'cuenta_gas',ancho => '7%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Ingreso',campo => 'ingreso',ancho => '6%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Egreso',campo => 'egreso',ancho => '6%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Cantidad Actual',campo => 'actual',ancho => '6%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Total Saldo',campo => 'saldo',ancho => '6%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Costo promedio',campo => 'promedio',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'Ventas Periodo (A)',campo => 'venta',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S') ,
           array(etiqueta => 'Costo Periodo (B)',campo => 'costo_mensual',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => '( A - B )',campo => 'ganancia',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
           array(etiqueta => 'sesion',campo => 'sesion',ancho => '0%', filtro => 'S', valor => $this->sesion , indice => 'N', visor => 'N')
         
       );
       
       
       $acciones = "'','',''";
       $funcion  = 'goToURLParametro';
       
       $this->bd->JqueryArrayTable('web_producto_resumen',$qcabecera,$acciones,$funcion,'tabla_config' );
       
       
   }
   
  //----------------------------------------------
 
  
 }    
  
 $gestion   = 	new componente;
 
       
       $fecha1 = $_GET['fecha1']; 
       $fecha2 = $_GET['fecha2']; 
       $accion = $_GET['accion']; 
       
       if ( $accion == 'procesa' ) {
           $gestion->Resumen_productos(  $fecha1,$fecha2 );
       }
   
       if ( $accion == 'grilla' ) {
           $gestion->visor(  $fecha1,$fecha2 );
       }
       
 
       
   
?>
 
  