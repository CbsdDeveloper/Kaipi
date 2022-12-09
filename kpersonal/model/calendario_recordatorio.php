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
        
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function listar_actividad(   ){
 
 
        
        $sql = "SELECT trim(razon) as usuario, motivo, fecha_out as f1, fecha_in as f2,trim(razon) || '- ' || trim(unidad) || ' - ' || trim(novedad)  as mensaje
                FROM view_nomina_vacacion
                where anio = ".$this->bd->sqlvalue_inyeccion($_SESSION['anio'] ,true)." and 
                      motivo in ('Planificadas','Asuntos Oficiales') and 
                      cierre = 'N'";
         
     
        $resultado = $this->bd->ejecutar($sql);
        
        
        $clientes = array(); //creamos un array
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $fecha =  $fetch['f1'];
            
            
            $title		=trim($fetch['mensaje']);
            $start		=trim($fecha) .'T'.'00:00:00';
            $end		=$fetch['f2'];
            $web		='#';
            
            $evento		    =trim( $fetch['motivo'] ) ;
            $producto		=trim( $fetch['usuario'] ) ;
            
            //   $clientes[] = array("title"=> $title,"url"=> $web,"start"=> $start, "end"=> $end );
            //   $clientes[] = array("title"=> $title,"start"=> $start, "end"=> $end );
            
            $clientes[] = array("title"=> $title,"start"=> $start ,"end"=> $end ,"evento"=>$evento,"producto"=>$producto);
            
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
 
  