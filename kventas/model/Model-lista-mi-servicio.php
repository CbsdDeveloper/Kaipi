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
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function listar_actividad(   ){
        
        //------------ publico
  //      $idbodega = $_SESSION['idbodega']  ;
        
        
        $Qquery = array(
            
            array( campo => 'idproducto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'producto',   valor => 'Publico' ,  filtro => 'N',   visor => 'S'),
            array( campo => 'tipourl',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'registros',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => 'B' ,  filtro => 'N',   visor => 'N'),
            array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N') 
        );
        
        
        $this->bd->__limit('6', '0');
        
        $resultado1 = $this->bd->JqueryCursorVisor('view_producto_ventas',$Qquery);
        
        $DivProductoDisponible.= '<div class="col-md-12">';
        
        
        while ($fetch=$this->bd->obtener_fila($resultado1)){
            
            $evento = ' onClick="InsertaProductoImagen('.$fetch['idproducto'].')" ';
            
            $DivProductoDisponible .= '<a href="#" '.$evento.' class="list-group-item">
                                        <b>'.trim($fetch['producto']).'</b>   </a>';
            
        }
        
        /*
        $imagen = $this->pathFile(1) ;
      
        while ($fetch=$this->bd->obtener_fila($resultado1)){
            
            $ima = $imagen.trim($fetch['url']);
            
            if (empty($fetch['url']))
            {
                $ima = $imagen.'no.png';
            } else  {
                if(trim($fetch['url']) =='-'){
                    $ima = $imagen.'no.png';
                }
                
            }
            
            
            $evento = ' onClick="InsertaProductoImagen('.$fetch['idproducto'].')" ';
            
            $DivProductoDisponible.= '<a href="#" '.$evento.'>
                                <img src="'.$ima .'" width="90" height="95" title="'.trim($fetch['producto']).'" />
                                </a> ';
            
        }
        */
        
        $DivProductoDisponible.='</div>';
        
        echo $DivProductoDisponible;
        
    }
    //-------------------------
    function pathFile($id ){
        
        
        $ACarpeta = $this->bd->query_array('wk_config',
            'carpetasub',
            'tipo='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $carpeta = trim($ACarpeta['carpetasub']);
        
        return $carpeta;
        
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
 
  