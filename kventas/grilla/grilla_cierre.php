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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                // $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->bd->conectar('postgres','db_kaipi','Cbsd2019');
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($estado,$cajero,$fecha1,$cierre){
      
          $filtro = 'S';

          if (  $cajero== '-'){

            $filtro = 'N';

          }	   
       
          $qquery = array( 
              array( campo => 'fechaa',   valor => $fecha1,  filtro => 'S',   visor => 'S'),
              array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'base12',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'base0',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'cierre',   valor => $cierre,  filtro => 'S',   visor => 'S'),
              array( campo => 'autorizacion',   valor =>  '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'envio',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'sesion',   valor => $cajero,  filtro => $filtro,   visor => 'N'),
              array( campo => 'registro',   valor =>$this->ruc ,  filtro => 'S',   visor => 'N'),
              array( campo => 'estado',     valor => $estado,  filtro => 'S',   visor => 'N')
          );
         
        // filtro para fechas
     
        
          
      	$resultado = $this->bd->JqueryCursorVisor('view_ventas_fac',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $lon     = strlen($fetch['autorizacion']);
      	    
      	    $envio   = trim($fetch['envio']);
      	    
      	    if ($lon==0){
      	        $imagen =  '<img src="../../kimages/star.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';
      	    }else{
      	        if ( $envio == 'S'){
      	            $imagen =  '<img src="../../kimages/starok.png"   title="'.$fetch['autorizacion'].'"/>';
      	        }else{
      	            $imagen =  '<img src="../../kimages/star_medio.png"   title="'.$fetch['autorizacion'].'"/>';
      	        }
      	       
      	    }
      	    
      		$output[] = array (
      		                    $fetch['id_movimiento'],
      		    $fetch['fechaa'],$fetch['fecha'],$fetch['comprobante'],$fetch['idprov'],
      		                    $fetch['razon'],$fetch['total'],$fetch['cierre'],$imagen,
      		                     
       					);
      	}	
      
      	echo json_encode($output);
      }
      
      //-----------------------------
      function Verifica_suma_facturas(  $cajero,$fecha1  ){
          
          
          $sql_det1 = "select min(idfacpago) as idfacpago , id_movimiento,tipopago,formapago, count(*) as nn
                        FROM inv_fac_pago	
                        where 	sesion = ".$this->bd->sqlvalue_inyeccion($cajero,true)." and 
                                fecha = ".$this->bd->sqlvalue_inyeccion($fecha1,true)."
                        group by  id_movimiento,tipopago,formapago
                        order by 5 desc ";
                                  
          
          
          $stmt1 = $this->bd->ejecutar($sql_det1);
          
          
          while ($x=$this->bd->obtener_fila($stmt1)){
              
              $idfacpago      = $x['idfacpago'];
              $id_movimiento  = $x['id_movimiento'];
 
              
              $sqlEdit = "delete from inv_fac_pago 
                           where idfacpago <> ".$this->bd->sqlvalue_inyeccion($idfacpago,true)."  and 
                                 id_movimiento = ".$this->bd->sqlvalue_inyeccion($id_movimiento,true) ;
              
           //    $this->bd->ejecutar($sqlEdit);
              
              
          }
 
      
    
      //-------------------------
      //-------------------------
      
      $sql_det1 = "  select  a.id_movimiento,a.monto,a.idfacpago,a.fecha,
                            (Select b.fechaa from view_ventas_fac b where  a.id_movimiento =  b.id_movimiento) as fecha_mov,
                            (Select b.total from view_ventas_fac b where  a.id_movimiento =  b.id_movimiento) as monto_mov
                       FROM inv_fac_pago a	
                      where 	a.sesion = ".$this->bd->sqlvalue_inyeccion($cajero,true)."  and 
                                a.fecha = ".$this->bd->sqlvalue_inyeccion($fecha1,true);
 
      
      $stmt1 = $this->bd->ejecutar($sql_det1);
      
      
      while ($x=$this->bd->obtener_fila($stmt1)){
          
          $id_movimiento  = $x['id_movimiento'];
          
          $fecha      = $x['fecha'];
          $fecha_mov  = $x['fecha_mov'];
          
          $monto      = $x['monto'];
          $monto_mov  = $x['monto_mov'];
          
          
          $fecha		   = $this->bd->fecha($fecha_mov);
          
          if ( $fecha == $fecha_mov ){
              
          }else {
              
              $sqlEdit = "update inv_fac_pago
                         set fecha = ".$fecha."
                       where id_movimiento = ".$this->bd->sqlvalue_inyeccion($id_movimiento,true) ;
              
            //  $this->bd->ejecutar($sqlEdit);
              
          }
          
          if ( $monto == $monto_mov ){
              
          }else {
              
              $sqlEdit = "update inv_fac_pago
                         set monto = ".$this->bd->sqlvalue_inyeccion($monto_mov,true)."
                       where id_movimiento = ".$this->bd->sqlvalue_inyeccion($id_movimiento,true) ;
              
              $this->bd->ejecutar($sqlEdit);
              
          }
          
          
      }
      
      //-------------------------
      
      $sql_det1 = "Select id_movimiento from view_ventas_fac
                    where sesion = ".$this->bd->sqlvalue_inyeccion($cajero,true)." and
                          fechaa = ".$this->bd->sqlvalue_inyeccion($fecha1,true)." and
                          estado = 'anulado' ";
      
      
      $stmt1 = $this->bd->ejecutar($sql_det1);
      
      
      while ($x=$this->bd->obtener_fila($stmt1)){
          
          $id_movimiento  = $x['id_movimiento'];
          
          
          $sqlEdit = "update inv_fac_pago
                         set monto = 0
                       where id_movimiento = ".$this->bd->sqlvalue_inyeccion($id_movimiento,true) ;
          
          $this->bd->ejecutar($sqlEdit);
          
          
      }
    
      
      
    }
    
      
      
      
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
     
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['estado']))	{
   			 
   			 	$estado= $_GET['estado'];
   			 	
   			 	$cajero= trim($_GET['cajero']);
   			 	
   			 	$fecha1= $_GET['fecha1'];
   			 	
   			 	$cierre= $_GET['cierre'];
   		 	 	 
   			 //	$gestion->Verifica_suma_facturas($cajero,$fecha1);
   			 	
   			 	$gestion->BusquedaGrilla($estado,$cajero,$fecha1,$cierre);
   			 	 
   			 }
 
  
  
   
 ?>
 
  