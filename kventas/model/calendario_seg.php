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
        
           
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function listar_actividad(   ){
        
 
        
        $qquery = array(
            array( campo => 'detalle_evento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha_evento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'hora_evento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'mensaje',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'canal',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'usuario_evento',   valor => trim($this->sesion) ,  filtro => 'S',   visor => 'S')
        );
        
 
        
        $resultado = $this->bd->JqueryCursorVisor('view_venta_evento_agenda',$qquery );
        
        
        $clientes = array(); //creamos un array
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $title		=trim($fetch['mensaje']).' '.trim($fetch['detalle_evento']);
         
            $hora       = trim($fetch['hora_evento']);
            
            if (empty($hora)){
                $hora = '08:00';
            }
            
            $start		=trim($fetch['fecha_evento']).'T'.$hora.':00';
            
       //     $end		=$fetch['fecha_evento'];
       //     $web		='#';
            
            $evento		    =trim( $fetch['canal'] ) ;
            $producto		=trim( $fetch['detalle_evento'] ) ;
            
          //  $clientes[] = array("title"=> $title,"url"=> $web,"start"=> $start, "end"=> $end );
          
         //   $clientes[] = array("title"=> $title,"start"=> $start, "end"=> $end );
            
            $clientes[] = array("title"=> $title,"start"=> $start ,"evento"=>$evento,"producto"=>$producto);
            
        }
        
        
        
        //Creamos el JSON
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



$gestion->listar_actividad( );


?>
 
  