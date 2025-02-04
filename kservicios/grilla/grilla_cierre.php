<?php 
session_start();   
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
    /**
     Clase contenedora para la creacion del formulario de visualizacion
     @return
     **/
    
    class grilla_cierre{
 
      private $obj;
      private $bd;
      
      /**
       Clase contenedora para la creacion del formulario de visualizacion
       @return
       **/
      function grilla_cierre(){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      
      public function BusquedaGrilla($estado,$cajero,$fecha1,$cierre){
          
          
          $filtro = 'S';
          
          if ( $estado == '-'){
              $filtro = 'N';
          }
       
          $qquery = array( 
              array( campo => 'fechap',   valor => $fecha1,  filtro => 'S',   visor => 'S'),
              array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'apagar',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'cierre',   valor => $cierre,  filtro => 'S',   visor => 'S'),
              array( campo => 'autorizacion',   valor =>  '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'id_renpago',   valor =>  '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'id_ren_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'envio',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'sesion_pago',   valor => $cajero,  filtro => 'S',   visor => 'N'),
              array( campo => 'proceso_modulo',     valor => $estado,  filtro => $filtro,   visor => 'S'),
              array( campo => 'id_par_ciu',   valor =>  '-',  filtro => 'N',   visor => 'S'),
          );
         
          
              
        $this->bd->_order_by('fechap,razon');
          
      	$resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_movimiento_pagos',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $lon            = strlen($fetch['autorizacion']);
      	    $envio          = trim($fetch['envio']);
            $tributario     = trim($fetch['proceso_modulo']);
      	    
            if (  $tributario == 'S'){

                    if ($lon==0){
                        $imagen =  '<img src="../../kimages/star.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';
                    }else{
                        if ( $envio == 'S'){
                            $imagen =  '<img src="../../kimages/starok.png"   title="'.$fetch['autorizacion'].'"/>';
                        }else{
                            $imagen =  '<img src="../../kimages/star_medio.png"   title="'.$fetch['autorizacion'].'"/>';
                        }
                     }
            }else   {

                $imagen =  '<img src="../../kimages/ok_no.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';

              }      
      		$output[] = array (
      		                    $fetch['id_ren_movimiento'],
      		                    $fetch['fechap'],
      		                    $fetch['fecha'],
      		                    $fetch['comprobante'],
      		                    $fetch['documento'],
      		                    $fetch['idprov'],
      		                    $fetch['razon'],
      		                    $fetch['apagar'],
      		                    $fetch['cierre'],
      		                    $imagen,
                                $fetch['id_renpago'],
                                $fetch['id_par_ciu']
                                
       					);
      	}	
      
      	echo json_encode($output);
       
      }
      
 
 }    
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
 $gestion   = 	new grilla_cierre;
     
   
    			 if (isset($_GET['estado']))	{
   			 
           			 	$estado = $_GET['estado'];
           			 	
           			 	$cajero = trim($_GET['cajero']);
           			 	
           			 	$fecha1 = $_GET['fecha1'];
           			 	
           			 	$cierre = $_GET['cierre'];
             			 	
           			 	$gestion->BusquedaGrilla($estado,$cajero,$fecha1,$cierre);
   			 	 
   			 }
 
  
  
   
 ?>