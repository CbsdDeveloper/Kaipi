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
    function listar_actividad(   ){
 
        
        $sql1 = "SELECT id_chat, sesion, modulo, estado, fecha, mensaje, alerta, agenda, tipo, hora
            FROM  web_chat_directo
            where    alerta =  0 and
                     registro = ".$this->bd->sqlvalue_inyeccion( $this->ruc , true)."   and
                     tipo =".$this->bd->sqlvalue_inyeccion( 'publico' , true). ' union '.
           "SELECT id_chat, sesion, modulo, estado, fecha, mensaje, alerta, agenda, tipo, hora
                 FROM  web_chat_directo
                 where alerta =  0 and
                       registro = ".$this->bd->sqlvalue_inyeccion( $this->ruc , true)."   and
                       sesion =".$this->bd->sqlvalue_inyeccion( $this->login, true).' and
                       tipo ='.$this->bd->sqlvalue_inyeccion( 'privado' , true). " UNION " ;
       
        
        
        
        
        $sql = $sql1 . " SELECT id_chat, sesion, modulo, estado, fecha, mensaje, alerta, agenda, tipo, hora
               FROM  web_chat_directo
                where alerta =  0 and 
                      registro = '0000000000000'  and
                      tipo =".$this->bd->sqlvalue_inyeccion( 'publico' , true). ' union '.
             "SELECT id_chat, sesion, modulo, estado, fecha, mensaje, alerta, agenda, tipo, hora
               FROM  web_chat_directo
                where alerta =  0 and 
                       registro = '0000000000000'  and
                      sesion =".$this->bd->sqlvalue_inyeccion( $this->login, true).' and 
                      tipo ='.$this->bd->sqlvalue_inyeccion( 'privado' , true).
                ' order by id_chat  DESC limit 15';
         
     
        $resultado = $this->bd->ejecutar($sql);
        
        
        $clientes = array(); //creamos un array
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $fecha = substr($fetch['fecha'], 0,10);
            
            $title		=trim($fetch['sesion']).'-'.trim($fetch['mensaje']);
            $start		=trim($fecha) .'T'.trim($fetch['hora']);

            
            $evento		    =trim( $fetch['tipo'] ) ;
            $producto		=trim( $fetch['sesion'] ) ;
            
            //   $clientes[] = array("title"=> $title,"url"=> $web,"start"=> $start, "end"=> $end );
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
 
  