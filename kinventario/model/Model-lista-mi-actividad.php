<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $idsesion;
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
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'web_notas';
                
                $this->idsesion 	 =  $_SESSION['usuario'];
                
       
      }
   
 
   
    	 
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function listar_actividad(   ){
     	
 
     	$qquery = array( 
     			 
     			array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'idusuario',   valor => $this->idsesion ,  filtro => 'S',   visor => 'S'),
     			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'leido',   valor => 'N',  filtro => 'N',   visor => 'S'),
     			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'adjunto',   valor => '-',  filtro => 'N',   visor => 'S')
     	);

     	$resultado = $this->bd->JqueryCursorVisor('view_actividad_blo',$qquery );
     	
     	$listaActividad.= '<div style="width:100%; height:220px; overflow: auto;padding: 5px" >';
 
     	
     	while ($fetch=$this->bd->obtener_fila($resultado)){
     		
     		$listaActividad.= '<div class="well well-lg" style="color: black;font-size: 12px;padding: 5px">
										 		<img src="../../kimages/notas/if_Twitter_UI-15_2310210.png" /><b>'.$fetch['login'].'</b>.'.$fetch['detalle']. '<br>'.
										 		' <img src="../../kimages/notas/datea.png" />  '.$fetch['vencimiento']. ' &nbsp;  
												<a  href="'.$fetch['adjunto'].'"  target="_blank"><img src="../../kimages/notas/if_Twitter_UI-25_2310207.png" /></a>   '.'
										  </div>
										  <br> ';
     		
     	 
     	}
     	//------------ publico 
     	$Qquery = array(
     			
     			array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'ambito',   valor => 'Publico' ,  filtro => 'S',   visor => 'S'),
     			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'leido',   valor => 'N',  filtro => 'N',   visor => 'S'),
     			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
     			array( campo => 'adjunto',   valor => '-',  filtro => 'N',   visor => 'S')
     	);
     	
     	$resultado1 = $this->bd->JqueryCursorVisor('view_actividad_publico',$Qquery);
     	
     	while ($fetch=$this->bd->obtener_fila($resultado1)){
     		
     		$listaActividad.= '<div class="well well-lg" style="color: black;font-size: 12px;padding: 5px">
										 		<img src="../../kimages/notas/if_Twitter_UI-15_2310210.png" /><b>'.$fetch['login'].'</b>.'.$fetch['detalle']. '<br>'.
										 		' <img src="../../kimages/notas/datea.png" />  '.$fetch['vencimiento']. ' &nbsp;
												<a  href="'.$fetch['adjunto'].'"  target="_blank"><img src="../../kimages/notas/if_Twitter_UI-25_2310207.png" /></a>   '.'
										  </div>
										  <br> ';
     		
     		
     	}
     	
     	$listaActividad.='</div>';
     	
     	echo $listaActividad;
     	
     }	

 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    
    $gestion->listar_actividad( );
     
   
 ?>
 
  