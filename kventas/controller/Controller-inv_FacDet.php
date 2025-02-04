<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_movimiento,$accion  ){
      
          
          if ($accion == 'add'){
              $sql = 'SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,idproducto
    			from view_movimiento_det
			   where   id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
          }else{
              $sql = 'SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,idproducto
    			from view_movimiento_det
			   where  sesion        = '.$this->bd->sqlvalue_inyeccion( $this->sesion, true).' AND
                      id_movimiento is null
                union
                    SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,idproducto
    			from view_movimiento_det
			   where  id_movimiento   = '.$this->bd->sqlvalue_inyeccion( $id_movimiento, true);
          }
          
      
        
          
          
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
          $total    = 0;
          $monto_iva= 0;
          $tarifa_cero= 0;
          $baseiva= 0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id = $x['id']; 
           
               $cadena = substr($x['producto'],0,12);
               
               $idproducto = $x['idproducto']; 
               
               $AResultado = $this->bd->query_array('web_producto',
                   'controlserie,activo',
                   'idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true)
                   );
               
               $activo = ' ';
               if ($AResultado['activo'] =='S'){
                   $activo = ' readonly="readonly" ';
               }
               
               
               $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('."'".$cadena."'".')" ';
               
               $ajaxPic = ' data-toggle="modal" data-target="#myModal" onClick="PictureArticulo('.$id.')" ';
               
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               
               
               $ajaxPRE = ' data-toggle="modal" data-target="#myModalPrecio" onClick="PrecioArticulo('.$idproducto.','.$id.')" ';
               
               echo '<tr>
                    <td> '. 
                    '<a class="btn btn-xs" href="#" '.$ajaxCateg.'> 
                    <i class="icon-search icon-white"></i>
                    </a>  
                    <a class="btn btn-xs" href="#" '.$ajaxPic.'> 
                    <i class="icon-picture icon-white"></i>
                    </a> 
                   <a class="btn btn-xs" href="#" '.$ajaxDEL.'> 
                    <i class="icon-trash icon-white"></i>
                    </a> 
                    <a class="btn btn-xs" title = "Seleccionar precios" href="#" '.$ajaxPRE.'> 
                    <i class="icon-money icon-white"></i>
                    </a> 
                    '.
                    ' </td>
                   <td> '.$x['producto'].' </td>
                   <td> <div id="unidad_'. $id.'">'.$x['unidad'].'</div> </td>
                   <td> '.$this->campo('cantidad',$id,'calcular('.$id .' )',$x['cantidad'],'N').'  </td>
                   <td> '.$this->campo1('costo',$id,'calcular('.$id .' )',$x['costo'],'N',$activo).'  </td>
                    <td> '.$this->campo('total',$id, 'calcularT('.$id .' )',$x['total'],'N').
                    ' <input name="montoiva_'. $id.'"   id="montoiva_'. $id.'"   type="hidden" value="'.$x['monto_iva'].' ">'.
                    ' <input name="tarifacero_'. $id.'" id="tarifacero_'. $id.'" type="hidden" value="'.$x['tarifa_cero'].' ">'.
                    ' <input name="tipourl_'. $id.'"     id="tipourl_'. $id.'"     type="hidden" value="'.trim($x['tipourl']).' ">'.
                    ' <input name="url_'. $id.'"         id="url_'. $id.'"         type="hidden" value="'.$x['url'].' ">'.
                    ' <input name="baseiva_'. $id.'"     id="baseiva_'. $id.'"     type="hidden" value="'.$x['baseiva'].' ">'.
                    ' <input name="tipo_'. $id.'"     id="tipo_'. $id.'"     type="hidden" value="'.trim($x['tipo']).' ">'.
                    ' <input name="saldo_'. $id.'"     id="saldo_'. $id.'"     type="hidden" value="'.$x['saldo'].' ">'.
                    '  </td>
                    </tr>';
               
               $total       = $total +       $x['total'];
               $monto_iva   = $monto_iva +   $x['monto_iva'];
               $tarifa_cero = $tarifa_cero + $x['tarifa_cero'];
               $baseiva     = $baseiva +     $x['baseiva'] ;
               
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-9">';
          $DivMovimiento .= '<div align="right"><h4>Base IVA</h4>';
          $DivMovimiento .= '<h4>Monto IVA</h4>';
          $DivMovimiento .= '<h4>Tarifa Cero</h4>';
          $DivMovimiento .= '<h4>Total</h4></div></div>';
          
          $DivMovimiento .= ' <div class="col-md-3">';
          $DivMovimiento .= '<h4 id="baseI">'.number_format($baseiva,2,",",".").'</h4>';
          $DivMovimiento .= '<h4 id="Iva">'.number_format($monto_iva,2,",",".").'</h4>';
          $DivMovimiento .= '<h4 id="Cero">'.number_format($tarifa_cero,2,",",".").'</h4>';
          $DivMovimiento .= '<h4 id="TotalF"><b> '.number_format($total,2,",",".").'</b></h4> 
                            <input name="xx" type="hidden" id="xx" value="'.$total.'"></div>';
        
          echo '<script>tt('.$total.')</script>';
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover" width="100%"  style="font-size: 13px">  
                <thead> 
                    <tr>
                     <th> Acciones </th>
                    <th> Producto </th>
                    <th> Unidd </th>
                     <th> Cantidad </th>
                    <th> Precio Venta </th>
                    <th> Total </th>
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
   ///-
      function campo1($nombre,$id,$evento,$valor,$tipo ,$activo){
          //inicializamos la clase para conectarnos a la bd
          
          $idNombre  = 'name="'.$nombre.'_'.$id.'" id="'.$nombre.'_'.$id.'"'.$activo;
          
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


 
  