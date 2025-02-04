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
       private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
 
                $this->sesion 	 =  $_SESSION['login'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
     }
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function listar_actividad(   ){
     	
          
         
     	$AResultado = $this->bd->query_array('par_usuario',
     			'id_departamento, responsable', 
     			'login='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
     			);
     	
     	
     	if ( $AResultado['responsable'] == 'S'){
     		$qquery = array(
      				array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'usuario',   valor => '-' ,  filtro => 'N',   visor => 'S'),
     				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'leido',   valor => 'N',  filtro => 'S',   visor => 'S'),
     				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'adjunto',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'ambito',   valor => 'Actividad',  filtro => 'S',   visor => 'N')
      		);
     	}else{
     		$qquery = array(
     				array( campo => 'actividad',   valor =>  $AResultado['id_departamento'],  filtro => 'S',   visor => 'S'),
     				array( campo => 'usuario',   valor => '-' ,  filtro => 'N',   visor => 'S'),
     				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'leido',   valor => 'N',  filtro => 'S',   visor => 'S'),
     				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'adjunto',   valor => '-',  filtro => 'N',   visor => 'S'),
     				array( campo => 'ambito',   valor => 'Actividad',  filtro => 'S',   visor => 'N')
     		);
     	}
     	
     

     //	$resultado = $this->bd->JqueryCursorVisor('view_actividad_blo',$qquery );
     	
     	$listaActividad.= '<div style="width:100%; height:200px; overflow: auto;padding: 2px" >';
 /*
     	
     	while ($fetch=$this->bd->obtener_fila($resultado)){
     		
     		if (empty($fetch[6])){
     			$adj ='';
     		}else{
     			$adj ='<a  href="'.$fetch[6].'"  target="_blank"> <img src="../../kimages/notas/if_Twitter_UI-25_2310207.png" /></a> &nbsp;';
     		}
     		
     		$listaActividad.= '<div class="well well-lg" style="color: black;font-size: 12px;padding: 5px">
										 		<img src="../../kimages/notas/if_Twitter_UI-15_2310210.png" />
													<b>'.$fetch[1].'</b>.'.$fetch[5]. '<br>'.
													' <img src="../../kimages/notas/datea.png" />  '.$fetch[3]. ' &nbsp;'.$adj.'
										  </div>
										  <br> ';
     		
     	 
     	}
      */
     	
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
 
  