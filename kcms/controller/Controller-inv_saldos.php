<script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
	             jQuery('#result').html(data);
	             
	             
	             jQuery('#result').slideUp( 300 ).delay( 0 ).fadeIn( 400 ); 
            
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php'; 
  
    class componente{
 
       
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
        }
     //---------------------------------------
     function Formulario( $id){
      
         $tipo 		= $this->bd->retorna_tipo();
        
 
         $Aproducto = $this->bd->query_array('web_producto',
                                             ' producto, referencia, saldo,  url, promedio, lifo, unidad , costo, idcategoria, tipourl, minimo', 
             'idproducto='.$this->bd->sqlvalue_inyeccion($id,true)
                                            );
         
 
         
         
       $ACarpeta = $this->bd->query_array('wk_config',
             'carpetasub',
            'tipo='.$this->bd->sqlvalue_inyeccion(1,true)
             );
         
         
         $folder = trim($ACarpeta['carpetasub']);
         
         $archivo = $folder.$Aproducto['url'];
         
     
         echo '<div class="col-md-12" id="ImprimeK">
                    <div class="col-md-12">
                            <h5> <b> FICHA DE GESTION DE MOVIMIENTOS DE INVENTARIOS </b>  </h5>
                    </div>

                   <div class="col-md-12">
                         <div class="col-md-2" align="center" > 
                           <img src='.$archivo.'  width="130" height="150" />  
                         </div>
                        <div class="col-md-10">
                              <h5>  <b>Nombre Producto   : '.$Aproducto['producto'].' </b></h5>
                              <h6>  Tipo de Medida    : '.$Aproducto['unidad'].'  </h6>
                              <h6>  <b>Costo producto : '.$Aproducto['costo'].'  </b></h6>
                              <h6>  <b>Saldo Actual   : '.$Aproducto['saldo'].'  </b></h6>
                              <h6>  Costo Promedio    : '.$Aproducto['promedio'].'  </h6>
                              <h6>  Costo Lifo        : '.$Aproducto['lifo'].'  </h6>
                         </div>
                    </div>
                <div class="col-md-12">';
         
      	 $this->set->div_label(12,'<h6> Detalle de Ingresos<h6>');
	 	 
      	 echo '<div class="col-md-12" style="width:100%; height:300px;">';
 
		 $sql = "SELECT
                  id_movimiento as Movimiento, fecha, 
                  detalle, comprobante,  
                   identificacion, 
                  razon as responsable,  cantidad, costo, (cantidad *  costo) as total, unidad    
                FROM  view_mov_aprobado
                where tipo = 'I' and 
                      idproducto = ".$id.' and 
                      registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true);
		 
		 $formulario = '';
		 
		 $resultado  = $this->bd->ejecutar($sql);
		 
		 $this->obj->grid->KP_sumatoria(8,"costo","total", '','');
		 
		 $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'id',$formulario,'N','','','','');
		 
		 echo '</div>';
		 
		 $this->set->div_label(12,'<h6> Detalle de Egresos<h6>');
		 
		 echo '<div class="col-md-12" style="width:100%; height:300px;">';
		 
		 $sql = "SELECT
                  id_movimiento as Movimiento, fecha ,
                  detalle, comprobante,
                   identificacion,
                  razon as responsable,  cantidad, costo as venta,  (cantidad *  costo) as total, unidad
                FROM  view_mov_aprobado
                where tipo <> 'I' and 
                      idproducto = ".$id.' and
                      registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true);;
		 
		 
		 $resultado  = $this->bd->ejecutar($sql);
	
		 
		 $this->obj->grid->KP_sumatoria(8,"venta","total", '','');

		 $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'id',$formulario,'N','','','','');
		 
  
		 
		 echo '</div></div></div>';
		 
		
		 
		 $result = 'Usuario '.$this->sesion ;
		 
		 echo $result;
		 
		 
		 
   }
 //----------------------------------------------
//----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
  //----------------------------------------------
 
  
 }    
  
 $gestion   = 	new componente;
   
 
   if (isset($_GET['id']))	{
       
       $id = $_GET['id']; 
       $gestion->Formulario( $id );
   
   }else{
       
       echo '<h5>Seleccione el articulo para visualizar los movimientos</h5>';
       
   }
 
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  