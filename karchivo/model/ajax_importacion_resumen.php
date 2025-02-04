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
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
   public function Importacion_financiero( $id_importacionfac ){
        
       $tipo 		= $this->bd->retorna_tipo();
       $action      = 'visor';
       $formulario  = '';
       
        $sql ="SELECT a.id_asiento as asiento, 
                      a.fecha, 
                      a.detalle, 
                      a.cuenta  || ' ' || b.detalle as cuenta ,
                      a.debe as ingreso, a.haber  as egreso
                FROM view_diario a, co_plan_ctas b
                where  a.tipo='R' and 
                       a.idmovimiento = ". $this->bd->sqlvalue_inyeccion($id_importacionfac,true)."  and 
                       b.cuenta = a.cuenta and 
                       a.registro = b.registro and
                       a.registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true);

     
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->grid->KP_sumatoria(5,"ingreso","egreso", "","");
        
        $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
        
        
    }
    //------------
    public function Importacion_resumen( $id_importacionfac ){
        
         $tipo 		= $this->bd->retorna_tipo();
        
        
      
        
        $sql = "select 'Detalle Aprox Item' as tipo ,round(SUM(costo),2) as valor_fob,
                	   sum(cantidad) as cantidad,
                	   round(sum(advalorem/cantidad),2) as advalorem,
                	   sum(costo1) as importacion,
                	   sum(costo2) as financiero,
                	   sum(costoitem) as costo_inventario,
                	   sum(peso_item) as suma_peso
                from inv_importaciones_fac_item 
                where id_importacion = ". $this->bd->sqlvalue_inyeccion($id_importacionfac,true)."
                union
                select 'Resumen Total' as tipo ,
                        round(SUM(costo * cantidad),2) as valor_fob,
                        sum(cantidad) as cantidad,
                	   round(sum(advalorem),2) as advalorem,
                	   round(sum(costo1 * cantidad),2) as importacion,
                	   round(sum(costo2 * cantidad),2) as financiero,
                	   round(sum(costoitem * cantidad),2) as costo_inventario,
                	   round(sum(peso_item),2) as suma_peso
                from inv_importaciones_fac_item 
                where id_importacion = ". $this->bd->sqlvalue_inyeccion($id_importacionfac,true);
                
 
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $cabecera =  "Resumen,Valor FOB, Cantidad, Advalorem, Costo Importacion,Costo Financiero, Costo Total, Peso(kg)";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //-------------------------
    public function proveeedorv(){
        
        $anio = date ("Y");
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $AResultado = $this->bd->query_array('view_res_inv_prv',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
             registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
             tipo = 'F' "
            );
        
        $total = $AResultado['total'];
        
        
        $sql = "SELECT  razon,
                        cantida,
                        total,
                        round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_prv
			  WHERE tipo = 'F' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
			ORDER BY 2 desc limit 10";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $cabecera =  "Cliente Ventas,Cantidad vendida, Total,Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
$gestion   = 	new proceso;

//------ consulta grilla de informacion
if (isset($_GET['id_importacion']))	{
    
    $id_importacionfac  = $_GET['id_importacion'];
    $tipo  = $_GET['tipo'];
    
    if ( $tipo == 1){
        $gestion->Importacion_resumen($id_importacionfac);
    }
   
    if ( $tipo == 2){
        $gestion->Importacion_financiero($id_importacionfac);
    }
    
}





?>
 
  