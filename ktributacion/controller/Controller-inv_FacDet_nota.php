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
      
 

 
              $sql = 'SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,idproducto,sesion
    			from view_movimiento_det
			   where   id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true). ' order by id desc';
          
          
          $stmt = $this->bd->ejecutar($sql);
        
          
          
          echo '<div class="col-md-8">';
          
          $this->cabecera();
          
          $total    = 0;
          $monto_iva= 0;
          $tarifa_cero= 0;
          $baseiva= 0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id = $x['id']; 
  
               
               echo '<tr>
                   <td>'.$x['producto'].'  </td>
                   <td> '.$this->campo('cantidad',   $id,'-',$x['cantidad'],'N').'  </td>
                   <td> '.$this->campo('costo',      $id,'-',$x['costo'],'S').'  </td>
                   <td> '.$this->campo('monto_iva',  $id,'-',$x['monto_iva'],'S').'  </td>
                   <td> '.$this->campo('baseiva',    $id,'-',$x['baseiva'],'S').'  </td>
                   <td> '.$this->campo('tarifa_cero',$id,'-',$x['tarifa_cero'],'S').'  </td>
                    <td> '.$this->campo('total',     $id,'-',$x['total'],'N').'</td>
                    <td> 
                     <input name="saldo_'. $id.'"       id="saldo_'. $id.'"    type="hidden" value="'.$x['saldo'].' ">'.
                    ' <input name="idproducto_'. $id.'"  id="idproducto_'. $id.'"     type="hidden" value="'.$x['idproducto'].' ">'.
                    '  </td>
                    </tr>';
               
               $total       = $total +       $x['total'];
               $monto_iva   = $monto_iva +   $x['monto_iva'];
               $tarifa_cero = $tarifa_cero + $x['tarifa_cero'];
               $baseiva     = $baseiva +     $x['baseiva'] ;
               
          }
         
 
          echo "</tbody></table>";
          
         
          $DivMovimiento = 'datos generados';
         
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          
          
         
          
          echo '<table class="table table-striped  table-hover" width="100%"  style="font-size: 12px">  
                <thead> 
                    <tr>
                     <th width="50%">Articulos/Servicios</th>
                     <th  width="5%">Cantidad</th>
                     <th  width="5%">Costo</th>
                     <th  width="5%">IVA</th>
                     <th  width="5%">Base Imponible</th>
                     <th  width="5%">Tarifa Cero</th>
                     <th width="5%">Total</th>
                     <th width="5%">Modificar</th>
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
                        type="number" class="casillero"
                        required step="0.01"
                        min="0" max="999999999"'.$eventoObje.'
						value="'.$valor.'">';
              
          }elseif($tipo == 'T'){
              $cadena = '<input '.$idNombre.'
                        type="text"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						 '.$eventoObje.$v1.$v2.'
						value="'.$valor.'">';
          }elseif($tipo == 'S'){
              
              $cadena = '<input '.$idNombre.'
                        type="number"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
						step="0.01"
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


 
  