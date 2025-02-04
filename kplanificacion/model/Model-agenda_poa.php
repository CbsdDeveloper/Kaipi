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
    private $login;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        
        $this->sesion 	 =  $_SESSION['email'];
        
        
        $this->login	 = $_SESSION['login'];
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function listar_actividad(   $periodo, $id ){
        
         
        $sql =  "SELECT idtarea, idactividad, estado, tarea, recurso, inicial, codificado, certificacion, 
                           ejecutado, disponible, aumentoreformas, disminuyereforma, cumplimiento, reprogramacion, 
                           responsable, nombre_funcionario, correo, movil, fechainicial, fechafinal, sesion, 
                           creacion, sesionm, modificacion, programa, clasificador, item_presupuestario, pac, actividad, 
                           fuente, producto, monto1, monto2, monto3, actividad_poa, beneficiario, producto_actividad, 
                           aportaen, id_departamento, anio, idperiodo, idobjetivo, idobjetivoindicador, fecha_termino, inicio, 
                           dias_trascurrido_inicio, anio_trascurrido_inicio, dias_trascurrido_fin
               FROM planificacion.view_tarea_poa
              WHERE cumplimiento <> 'S' and
                      id_departamento =".$this->bd->sqlvalue_inyeccion($id, true).' and
                      anio ='.$this->bd->sqlvalue_inyeccion($periodo , true).
                      ' order by idtarea  DESC limit 20';
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        $clientes = array(); //creamos un array
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $fecha = substr($fetch['fechainicial'], 0,10);
            
            $fecha1 = substr($fetch['fechafinal'], 0,10);
            
            $title		=trim( $fetch['nombre_funcionario'] ) .' - '.trim($fetch['tarea']);
            $start		=trim($fecha) .'T08:00';
            
            $end		=$fecha1;
      
            $id = $fetch['idtarea'];
            
            $evento		    =trim( $fetch['tarea'] ) ;
            $producto		=trim( $fetch['producto_actividad'] ) ;
            
            //  $web		='#';
            //   $clientes[] = array("title"=> $title,"url"=> $web,"start"=> $start, "end"=> $end );
            //   $clientes[] = array("title"=> $title,"start"=> $start, "end"=> $end );
            
            $clientes[] = array("title"=> $title,"start"=> $start ,"evento"=>$evento,"producto"=>$producto, "end"=> $end, "id"=> $id );
            
        }
        
        
 
        $json_string = json_encode($clientes);
        
        echo $json_string;
        
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

if (isset($_GET['periodo']))	{
    
    $periodo    = $_GET['periodo'];
    $id         = $_GET['id'];
    
    
    $gestion->listar_actividad($periodo, $id);
    
} 

 




?>
 
  