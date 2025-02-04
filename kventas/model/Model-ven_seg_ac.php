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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
    
    
    //--------------------------------------------------------------------------------
    function ProcesoNombre($id,$accion,$idvengestion){
        
        
        $Actividad = $this->bd->query_array('ven_cliente_seg',
            'razon, estado, medio, canal, sesion, novedad, fecha, producto, porcentaje',
            'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true) 
            );
        
             
            /*  3 Interesado confirmado  25
                4seguimiento introduccion producto 30
                5seguimiento campo    35
                6seguimiento en espera  40
                7en cotizacion  50
                8en negociacion y condiciones 75 */
            
     
        
        $DatoProveedor = $this->bd->query_array('ven_cliente',
            'telefono, correo, movil, contacto',
            'idprov='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        $cadenaP = '<h6>Contacto:&nbsp;&nbsp;'.$DatoProveedor['contacto'].'<br>Email:&nbsp;&nbsp;'.
            $DatoProveedor['correo'].'<br>Telefono:&nbsp;&nbsp;'.
            $DatoProveedor['telefono'].'<br>Movil:&nbsp;&nbsp;'.
            $DatoProveedor['movil'].'</h6><br>';
        
            
            
            echo '<script>
                    $("#temail").val("'.$DatoProveedor['correo'].'");
                    $("#idtransaccion").val('.$idvengestion.');   
                    $("#para_email").val("'.$Actividad['razon'].'");
                    $("#tfono").val("'.$DatoProveedor['movil'].'");
                      $("#tasunto").val("");     
                  </script>';
          
            
            
        $sqlTareas = 'SELECT idventarea, idvengestion,  estado, canal, sesion, novedad, fecha, hora, mensaje
                  FROM  ven_cliente_task
                  where idvengestion ='.$this->bd->sqlvalue_inyeccion( $idvengestion, true).'
                    order by 1 desc LIMIT 10' ;
 
     
            
            if ($Actividad['estado'] == 6)
                $mensaje = 'Interesado confirmado';
                elseif($Actividad['estado'] == 7)
                $mensaje = 'seguimiento introduccion producto';
                elseif($Actividad['estado'] == 8)
                $mensaje = 'seguimiento campo';
                elseif($Actividad['estado'] == 9)
                $mensaje = 'seguimiento en espera';
                elseif($Actividad['estado'] == 10)
                $mensaje = 'En cotizacion';
                elseif($Actividad['estado'] == 11)
                $mensaje = 'En negociacion y condiciones';
                
                
                
                $ViewFormActividad = '<h5><b>'.$Actividad['razon'].'</b><br>'.$cadenaP.'</h5>';
                
                $ViewFormActividad .= '<div class="media">
			                <div class="media-left">
			            <img src="../../kimages/if_comment_user_36887.png" class="media-object" style="width:24px">
			       </div>
			     <div class="media-body">
				    <h5 class="media-heading"><b>Estado: '.$mensaje.' <small><i>'.$Actividad['fecha'].'</b></i></small></h5>
				      <p>'.$Actividad['novedad'].' .</p>';
 
                $numero=0;
                $resultadoTarea  = $this->bd->ejecutar($sqlTareas);
                while ($fetch=$this->bd->obtener_fila($resultadoTarea)){
                    
                    $imagen = '../../kimages/star.png';
                    if($fetch['estado']== 0){
                        $imagen = '../../kimages/starok.png';
                    }
                    
                    if ($numero%2==0){
                        $ViewFormActividad .='<div class="media">
                                         <div class="media-left">
                                            <img src="'.$imagen.'" class="media-object" style="width:18px">
                                        </div>
                                         <div class="media-body">
                                            <h5 class="media-heading">'.$fetch['novedad'].' <small><i> '.$fetch['fecha'].'</i></small></h5>
                                            <p>canal de comunicacion '.$fetch['canal'].'</p>
                                        </div>
                                    </div>';
                    }else{
                        $ViewFormActividad .='<div class="media">
                         <div class="media-left">
                             <img src="'.$imagen.'"  class="media-object" style="width:18px">
                         </div>
                         <div class="media-body">
                             <h5 class="media-heading">'.$fetch['novedad'].'<small> <i> '.$fetch['fecha'].'</i></small></h5>
                             <p>canal de comunicacion '.$fetch['canal'].'</p>
                         </div>
                 </div> ';
                    }
                    $numero ++;
                }
                  
                $ViewFormActividad .= '</div>';
             
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
    
    
    $id           = $_GET['idcliente'];
    $accion       = $_GET['accion'];
    $idvengestion = $_GET['idvengestion'];
    
    $gestion->ProcesoNombre($id,$accion,$idvengestion);
    
}




?>
 
  