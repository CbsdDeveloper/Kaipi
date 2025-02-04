<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_movimiento,$accion  ){
      
          
          if ($accion == 'add'){

              $sql = 'SELECT   *
                        from rentas.view_ren_fac_detalle
                    where   id_ren_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);

          }else{

              $sql = 'SELECT  *
    		  	        from rentas.view_ren_fac_detalle
			            where  sesion        = '.$this->bd->sqlvalue_inyeccion( $this->sesion, true).' AND   id_ren_movimiento = 0
                union
                    SELECT  *
    			     from rentas.view_ren_fac_detalle
			        where  id_ren_movimiento   = '.$this->bd->sqlvalue_inyeccion( $id_movimiento, true);
          }
          
      
        
          
          
          $stmt = $this->bd->ejecutar($sql);
          
   /*       <th  width="15%">  </th>
          <th  width="75%"> Servicio </th>
          <th  width="10%"> Total </th>*/
          
          $this->cabecera();
          
          $total    = 0;
          $monto_iva= 0;
          $tarifa_cero= 0;
          $baseiva= 0;
          $descuento=0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id = $x['id_ren_movimientod']; 
               
               $idproducto = $x['idproducto_ser']; 
           
               $cadena = substr($x['producto'],0,25);
               
               
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               

               echo '<tr>
                    <td> '. 
                    '
                   <a class="btn btn-xs" href="#" '.$ajaxDEL.'> 
                    <i class="icon-trash icon-white"></i>
                    </a> '.
                    ' </td>
                      <td> '.$x['producto'].' </td>
                       <td> '.$this->campo('total',$id, '',$x['total'],'N').

                     ' <input name="costo_'. $id.'" id="costo_'. $id.'" type="hidden" value="'.$x['costo'].' ">'.
                    ' <input name="tipo_'. $id.'"     id="tipo_'. $id.'"     type="hidden" value="'.trim($x['tipo']).' ">'.
                    '  </td>
                    </tr>';
               
               $total       = $total +       $x['total'];
                
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-9">';
          $DivMovimiento .= '<h4>Total</h4></div></div>';
          
          $DivMovimiento .= ' <div class="col-md-3">';
          $DivMovimiento .= '<h4 id="TotalF"><b> '.number_format($total,2,",",".").'</b></h4> 
                            <input name="xx" type="hidden" id="xx" value="'.$total.'"></div>';
        
          echo '<script>tt('.$total.')</script>';
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd   <th  width="10%"> Precio </th>
          echo '<table class="table table-striped  table-hover" width="100%">  
                <thead> 
                    <tr>
                    <th  width="15%">  </th>
                    <th  width="75%"> Servicio </th>
                    <th  width="10%"> Total </th>
                    </tr>   
                  </thead> 
                <tbody>';
          
          
      }
      //--------------------------
      function campo($nombre,$id,$evento,$valor,$tipo ){
          //inicializamos la clase para conectarnos a la bd
        
          $idNombre  = 'name="'.$nombre.'_'.$id.'" id="'.$nombre.'_'.$id.'"';
          
          $size      = 3;
          $maxlength = 3;
          
          $v1 = ' size ="'.$size.'" ' ;
          $v2 = ' maxlength  ="'.$maxlength.'" ' ;
          
          
          if ($evento == '-'){
              $eventoObje = '  ';
          }else{
              $eventoObje = ' onblur="'.$evento.'" ';
          }
          
          if ($tipo == 'C'){
              
              $cadena = '<input '.$idNombre.'
                        type="text"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						required  '.$eventoObje.'
						value="'.$valor.'">';
          
          }elseif($tipo == 'N'){
              
              $cadena = '<input '.$idNombre.'
                        type="number"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
						required step="0.01"
                        min="0" max="999999999"'.$eventoObje.'
						value="'.$valor.'">';
         
            }elseif($tipo == 'NE'){
                
                $cadena = '<input '.$idNombre.'
                        type="number"  class="input-lg"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
                        required step="1"
                        min="0" max="999999999"'.$eventoObje.'
                        value="'.$valor.'">';
            }elseif($tipo == 'DD'){
              
              $cadena = '<input '.$idNombre.'
                        type="number"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
						required step="0.01"
                        min="0" max="999999999"'.$eventoObje.'
						value="'.$valor.'">';
              
          }elseif($tipo == 'T'){
              $cadena = '<input '.$idNombre.'
                        type="text"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						readonly="readonly" '.$eventoObje.$v1.$v2.'
						value="'.$valor.'">';
          }elseif($tipo == 'S'){
              
              $cadena = '<input '.$idNombre.'
                        type="number"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
						readonly="readonly"  step="0.01"
                        min="0" max="999999999"'.$eventoObje.'
						value="'.$valor.'">';
              
          }
          
          return $cadena;
          
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
   if (isset($_GET['id']))	{
       
        
       $id_movimiento      = $_GET['id'];
       
       $accion             = $_GET['accion'];
       
       $gestion->FiltroFormulario( $id_movimiento,$accion );
       
   }

 ?>


 
  