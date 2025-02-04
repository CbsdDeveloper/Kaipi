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
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idproducto
    			from view_movimiento_det
			   where   id_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
        }else{
            $sql = 'SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idproducto
    			from view_movimiento_det
			   where  sesion        = '.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true).' AND
                      id_movimiento is null
                union
                    SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idproducto
    			from view_movimiento_det
			   where  id_movimiento   = '.$this->bd->sqlvalue_inyeccion( $id_movimiento, true).' order by id DESC';
        }
         
        
      
          
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
        
          $total = 0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id = $x['id']; 
           
               $idproducto = $x['idproducto']; 
               
               
               $cadena = substr($x['producto'],0,12);
               
               
               $cadena1 =  $x['producto'];
                
               
               
               $AResultado = $this->bd->query_array('web_producto',
                                                     'controlserie,costo', 
                                                     'producto='.$this->bd->sqlvalue_inyeccion($cadena1,true)
                   );
               
               if  ($AResultado['controlserie'] == 'S'){
                   $ajaxSerie = ' data-toggle="modal" data-target="#myModalSerie" onClick="RefSerie('."'".$cadena1."',".$id.')" ';
                   
                   $serie =  '<a class="btn btn-xs" href="#" '.$ajaxSerie.'>
                            <i class="icon-archive icon-white"></i>
                            </a> '  ;
               }else{
                   $ajaxSerie = ' ';
                   $serie = ' ';
               }
               
               
             
               
               $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('."'".$cadena."'".')" ';
               
               $ajaxPic = ' data-toggle="modal" data-target="#myModal" onClick="PictureArticulo('.$idproducto.')" ';
               
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               
               echo '<tr>
                    <td> '. 
                    $serie.'
                    <a class="btn btn-xs" href="#" '.$ajaxCateg.'> 
                    <i class="icon-search icon-white"></i>
                    </a>  
                    <a class="btn btn-xs" href="#" '.$ajaxPic.'> 
                    <i class="icon-picture icon-white"></i>
                    </a> 
                   <a class="btn btn-xs" href="#" '.$ajaxDEL.'> 
                    <i class="icon-trash icon-white"></i>
                    </a> '.
                    ' </td>
                   <td> '.$x['idproducto'].' </td>
                   <td> '.trim($x['producto']).' </td>
                   <td>  '.trim($x['unidad']).' </td>
                   <td> '.$this->campo('saldo',$id,'-',$x['saldo'],'S').'  </td>
                   <td> '.$this->campo('tipo',$id,'-',$x['tipo'],'P').' </td>
                   <td> '.$this->campo('cantidad',$id,'calcular('.$id .' )',$x['cantidad'],'N').'  </td>
                   <td> '.$this->campo1('costo',$id,'calcular('.$id .' )',$x['costo'],'N').'  </td>
                    <td> '.$this->campo('total',$id, 'calcular('.$id .' )',$x['total'],'N').
                    ' <input name="tipourl_'. $id.'"     id="tipourl_'. $id.'"     type="hidden" value="'.$x['tipourl'].' ">'.
                    ' <input name="url_'. $id.'"         id="url_'. $id.'"         type="hidden" value="'.$x['url'].' ">'.
                    '  </td>
                    </tr>';
               
               $total       = $total  +       $x['total'];
           
              
               
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-10" align="right">';
 
          $DivMovimiento .= '<h5>Total</h5></div></div>';
          
          $DivMovimiento .= ' <div class="col-md-2">';
          $DivMovimiento .= '<h5 id="TotalF"><b> '.number_format($total,2,",",".").'</b></h5></div>';
          
        
          
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover" width="100%" name="tabla_mov" id="tabla_mov">  
                <thead> 
                    <tr>
                     <th> Acciones </th>
                    <th> Id </th>
                    <th> Producto </th>
                    <th> Unidad </th>
                    <th> Saldo </th>
                    <th> Tipo </th>
                    <th> Cantidad </th>
                    <th> Costo </th>
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
                        type="text"
                        style="text-align:left; border:rgba(193,193,193,1.00)"
						required  '.$eventoObje.'
						value="'.$valor.'">';
              
          }elseif($tipo == 'N'){
              
              $cadena = '<input '.$idNombre.'
                        type="number"
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


 
  