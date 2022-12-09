<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
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
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  $_SESSION['email'];
 		
		$this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	 
		
	}
	 
 
	//--------------------------------------------------------------------------------
	function ProcesoNombre($id,$accion){
		
		
		$flujo = $this->bd->query_array('ven_cliente_seg',
				'count(*) as existe,max(idvengestion) as idvengestion,max(razon) as razon',
				'idprov='.$this->bd->sqlvalue_inyeccion($id,true).' and 
                  estado in (0,1,2,3)'
				);
 
		//      sesion='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true).' and
		
		//------------
		$DatoProveedor = $this->bd->query_array('ven_cliente',
		    'telefono, correo, movil, contacto',
		    'idprov='.$this->bd->sqlvalue_inyeccion($id,true) 
		    );
		
		 
		$cadenaP = 'Contacto:&nbsp;&nbsp;'.$DatoProveedor['contacto'].'<br>Email:&nbsp;&nbsp;'.
		                       $DatoProveedor['correo'].'<br>Telefono:&nbsp;&nbsp;'.
		                       $DatoProveedor['telefono'].'<br>Movil:&nbsp;&nbsp;'.
		                       $DatoProveedor['movil'].'<br>';
	 		
		if ($flujo['existe'] == 0 )	{
		    $ViewFormActividad = '<h5> <img src="../controller/r.png" align="absmiddle"/>
                                      <b>No existe movimientos relacionados con el cliente '.$id.'</b><br>'.$cadenaP.'</h5>';
		    
		    echo '<script>$("#idvengestion").val('.''.');</script>';
		    
		} else{
		    
		           
		    $idvengestion = $flujo['idvengestion'];
		    
		    echo '<script>$("#idvengestion").val('.$idvengestion.');</script>';
		    
		    /*    No esta interesado    0
		     1 Interesado En espera   5
		     2 Interesado sin confirmar 10
		     3 Interesado confirmado  25 */
		    
		    $Actividad = $this->bd->query_array('ven_cliente_seg',
		        'razon, estado,   sesion, novedad, fecha,   porcentaje',
		        'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true) 
		        );
		    

		    if ($Actividad['estado'] == 0)
		        $mensaje = 'No esta interesado';
		    elseif($Actividad['estado'] == 1)
		       $mensaje = 'Interesado En espera';
		    elseif($Actividad['estado'] == 2)
		       $mensaje = 'Interesado sin confirmar';
		    elseif($Actividad['estado'] == 3)
		       $mensaje = 'Interesado confirmado';
		        
		       $ViewFormActividad = '<h5>'.$Actividad['razon'].'<br>'.$cadenaP.'</h5>';
		    
		    $ViewFormActividad .= '<div class="media">
			<div class="media-left">
			  <img src="../../kimages/if_comment_user_36887.png" class="media-object" style="width:32px">
			</div>
			<div class="media-body">
				  <h4 class="media-heading">'.$mensaje.' <small><i>'.$Actividad['fecha'].'</i></small></h4>
				  <p>'.$Actividad['novedad'].' .</p>';

		/*    $ViewFormActividad .='   <!-- Nested media object -->
				  <div class="media">
					<div class="media-left">
					  <img src="img_avatar2.png" class="media-object" style="width:45px">
					</div>
					<div class="media-body">
					  <h4 class="media-heading">John Doe <small><i>Posted on February 19, 2016</i></small></h4>
					  <p>detaa</p>
					</div>
				  </div>
				
				<div class="media">
					<div class="media-left">
					  <img src="img_avatar2.png" class="media-object" style="width:45px">
					</div>
					<div class="media-body">
					  <h4 class="media-heading">John Doe <small><i>Posted on February 19, 2016</i></small></h4>
					  <p>detaa</p>
					</div>
				  </div>
				 <!-- Nested media object -->
			</div>*/
		    $ViewFormActividad .= '</div>';
		    
		}
		
 
		
		echo $ViewFormActividad;
		
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
if (isset($_GET['idcliente']))	{
	
	 
	$id        = $_GET['idcliente'];
	$accion    = $_GET['accion'];
 
	
	$gestion->ProcesoNombre($id,$accion);
	
}

 


?>
 
  