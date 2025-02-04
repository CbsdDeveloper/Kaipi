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
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_movimiento , $accion){
      
        if ($accion == 'add'){
          $sql = 'SELECT   id,  
                           producto,
                            cantidad,
					       costo,
                           total,tributo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idclasebien,detalle
    			from activo.view_movimientoa_det
			   where   id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
        }else{
            $sql = 'SELECT   id,  
                           producto,
                            cantidad,
					       costo,
                           total,tributo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idclasebien,detalle
    			from activo.view_movimientoa_det
			   where  sesion        = '.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true).' AND
                      id_movimiento is null
                union
                    SELECT   id,  
                           producto,
                            cantidad,
					       costo,
                           total,tributo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idclasebien,detalle
    			from activo.view_movimientoa_det
			   where  id_movimiento   = '.$this->bd->sqlvalue_inyeccion( $id_movimiento, true).' order by id DESC';
        }
         
        
      
          
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
          $total    = 0;
          $monto_iva= 0;
          $tarifa_cero= 0;
          $baseiva= 0;
          $descuento = 0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id         = $x['id']; 
           
               $idproducto = $x['idclasebien']; 
               
                
               $serie ='';
    
 
               
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               
               echo '<tr>
                    <td> '. 
                    $serie.'
                   <a class="btn btn-xs" href="#" '.$ajaxDEL.'> 
                    <i class="icon-trash icon-white"></i>
                    </a> '.
                    ' </td>
                   <td> '.$idproducto.' </td>
                   <td> '.$x['producto'].' </td>
                   <td> '.$this->campo1('detalle',$id,'-',$x['detalle'],'C').'  </td>
                   <td> '.$this->campo('cantidad',$id,'calcular('.$id .' )',$x['cantidad'],'N').'  </td>
                   <td> '.$this->campo1('costo',$id,'calcular('.$id .' )',$x['costo'],'N').'  </td>
                   <td> '.$this->campo1('pdescuento',$id,'calculard('.$id .' )',$x['pdescuento'],'N').'  </td>
                   <td> '.$this->campo1('descuento',$id,'calcular('.$id .' )',$x['descuento'],'N').'  </td>
                    <td> '.$this->campo('total',$id, 'calcularT('.$id .' )',$x['total'],'N').
                    ' <input name="montoiva_'. $id.'"   id="montoiva_'. $id.'"   type="hidden" value="'.$x['monto_iva'].' ">'.
                    ' <input name="tarifacero_'. $id.'" id="tarifacero_'. $id.'" type="hidden" value="'.$x['tarifa_cero'].' ">'.
                    ' <input name="tipourl_'. $id.'"     id="tipourl_'. $id.'"     type="hidden" value="'.$x['tipourl'].' ">'.
                    ' <input name="url_'. $id.'"         id="url_'. $id.'"         type="hidden" value="'.$x['url'].' ">'.
                    ' <input name="baseiva_'. $id.'"     id="baseiva_'. $id.'"     type="hidden" value="'.$x['baseiva'].' ">'.
                    '  </td>
                    </tr>';
               
                
               $descuento       = $descuento +       $x['descuento'];
                    
               $total       = $total +       $x['total'];
               $monto_iva   = $monto_iva +   $x['monto_iva'];
               $tarifa_cero = $tarifa_cero + $x['tarifa_cero'];
               $baseiva     = $baseiva +     $x['baseiva'] ;
               
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-10">';
          $DivMovimiento .= '<div align="right"><h5>Base IVA</h5>';
          $DivMovimiento .= '<h5>Monto IVA</h5>';
          $DivMovimiento .= '<h5>Tarifa Cero</h5>';
          $DivMovimiento .= '<h5>Descuento</h5>';
          $DivMovimiento .= '<h5>Total</h5></div></div>';
          
          $DivMovimiento .= ' <div class="col-md-2">';
          $DivMovimiento .= '<h5 id="baseI">'.number_format($baseiva,2,",",".").'</h5>';
          $DivMovimiento .= '<h5 id="Iva">'.number_format($monto_iva,2,",",".").'</h5>';
          $DivMovimiento .= '<h5 id="Cero">'.number_format($tarifa_cero,2,",",".").'</h5>';
          $DivMovimiento .= '<h5 id="Descuento">'.number_format($descuento,2,",",".").'</h5>';
          $DivMovimiento .= '<h5 id="TotalF"><b> '.number_format($total,2,",",".").'</b></h5></div>';
        
          
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover" width="100%" id="tabla_mov" name="tabla_mov">  
                <thead> 
                    <tr>
                     <th width="5%"> Acciones </th>
                    <th width="5%"> Id </th>
                    <th width="23%"> Clase Bien </th>
                    <th width="24%"> Detalle </th>
                    <th width="8%"> Cantidad </th>
                    <th width="10%"> Costo </th>
                    <th width="7%"> % Descuento </th>
                    <th width="8%"> Descuento </th>
                    <th width="10%"> Total </th>
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
                        type="number" class="form-control"
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
          }elseif($tipo == 'P'){
              $cadena = '<input '.$idNombre.'
                        type="text"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						 '.$eventoObje.$v1.$v2.'
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
 //-----------
      //--------------------------
      function campo1($nombre,$id,$evento,$valor,$tipo ){
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
                        type="text" class="form-control"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						required  '.$eventoObje.'
						value="'.$valor.'">';
              
          }elseif($tipo == 'N'){
              
              $cadena = '<input '.$idNombre.'
                        type="number" class="form-control"
                        style="text-align:right; border:rgba(193,193,193,1.00)"
						required step="0.0001"
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
       
       $accion      = $_GET['accion'];
       
       $gestion->FiltroFormulario( $id_movimiento,$accion );
       
   }

 ?>


 
  