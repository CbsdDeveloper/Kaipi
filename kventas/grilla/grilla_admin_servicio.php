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
    private $anio;
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
        
        $this->anio       =  $_SESSION['anio'];
        
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($tipo,$idcategoria1){
        
        // Soporte Tecnico
        
        $filtro1 = 'N';
         
        if ($idcategoria1 <> 0){
            $filtro1 = 'S';
        }
        
 
        $qquery = array(
            array( campo => 'idproducto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cuenta_ing',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cuenta_inv',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'partida',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => $tipo ,  filtro => 'S',   visor => 'N'),
            array( campo => 'idcategoria',   valor => $idcategoria1,  filtro => $filtro1,   visor => 'N') ,
            array( campo => 'registro',   valor =>   $this->ruc ,  filtro => 'S',   visor => 'N') 
        );
      
        
        $resultado = $this->bd->JqueryCursorVisor('web_producto',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            
            
            $x = $this->bd->query_array('presupuesto.pre_gestion',    
                                        'count(*) as nn,max(clasificador ) item',                      
                                        'partida='.$this->bd->sqlvalue_inyeccion(trim( $fetch['partida']),true) .' and 
                                         anio='.$this->bd->sqlvalue_inyeccion( $this->anio,true). " and 
                                         tipo= 'I' "
                );
            
            
            $y = $this->bd->query_array('co_plan_ctas',
                'count(*) as nn',
                'cuenta='.$this->bd->sqlvalue_inyeccion(trim( $fetch['cuenta_ing']),true) .' and
                 anio='.$this->bd->sqlvalue_inyeccion( $this->anio,true). " and
                 credito=".$this->bd->sqlvalue_inyeccion(trim( $x['item']),true)
                );
          
            
            if ( $x['nn'] > 0 ) {
                $imagen = '  ';
            }else{
                $imagen = '  <img src="../../kimages/m_advertencia.png"  align="absmiddle" />';
            }
            
         
            if ( $y['nn'] > 0 ) {
                $imagen1 = '  ';
            }else{
                $imagen1 = '  <img src="../../kimages/m_advertencia.png"  align="absmiddle" />';
            }
            
                
                
                
            $output[] = array ( 
                $fetch['idproducto'],
                $fetch['producto'],
                $fetch['cuenta_ing'].$imagen1,
                $fetch['cuenta_inv'],
                $fetch['partida'].$imagen,
                $fetch['estado']
                
            );
        }
        
        echo json_encode($output);
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ consulta grilla de informacion
if (isset($_GET['GrillaCodigo']))	{
    
    $tipo     = $_GET['GrillaCodigo'];
    $idcategoria1  = $_GET['idcategoria1'];
    
    
    
    $gestion->BusquedaGrilla($tipo,$idcategoria1);
    
}




?>
 
  