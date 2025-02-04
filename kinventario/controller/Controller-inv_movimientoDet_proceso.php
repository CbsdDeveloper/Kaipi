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
      function FiltroFormulario( $id_tramite , $accion){
   
        
          $sql = 'SELECT   id,
                           producto,
	 				       unidad,
                           saldo ,
                           cantidad,
					       costo,
                           total,tipourl,url,tipo, monto_iva,tarifa_cero,baseiva,pdescuento,descuento,idproducto
    			from view_movimiento_det
			   where   idproceso = '.$this->bd->sqlvalue_inyeccion($id_tramite, true);
          
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
        
          $total = 0;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id         = $x['id']; 
                 
                
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               
               echo '<tr>
                    <td> '.'<a class="btn btn-xs" href="#" '.$ajaxDEL.'> 
                    <i class="icon-trash icon-white"></i></a> '.' </td>
                   <td> '.$x['idproducto'].' </td>
                   <td> '.trim($x['producto']).' </td>
                   <td>  '.trim($x['unidad']).' </td>
                   <td> '.$this->campo('cantidad',$id,'calcular('.$id .' )',$x['cantidad'],'N').'  
                     <input name="tipourl_'. $id.'" id="tipourl_'. $id.'"  type="hidden" value="'.$x['tipourl'].' ">'.
                    ' <input name="url_'. $id.'"    id="url_'. $id.'"    type="hidden" value="'.$x['url'].' ">'.
                    ' <input name="saldo_'. $id.'"  id="saldo_'. $id.'"  type="hidden" value="'.$x['saldo'].' ">'.
                    ' <input name="tipo_'. $id.'"   id="tipo_'. $id.'"   type="hidden" value="'.$x['tipo'].' ">'.
                    ' <input name="costo_'. $id.'"  id="costo_'. $id.'"  type="hidden" value="'.$x['costo'].' ">'.
                    ' <input name="total_'. $id.'"  id="total_'. $id.'"  type="hidden" value="'.$x['total'].' ">'.
                    '  </td>
                    </tr>';
               
               $total       = $total  +       $x['total'];
               
               
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-10" align="right">';
 
          $DivMovimiento .= '</div></div>';
          
            
        
          
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover" width="100%" name="tabla_mov" id="tabla_mov">  
                <thead> 
                    <tr>
                     <th> Acciones </th>
                    <th> Referencia </th>
                    <th> Producto </th>
                    <th> Unidad </th>
                    <th> Cantidad </th>
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
						required step="0.01" class="form-control"
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
       
        
       $id_tramite         = $_GET['id'];
       
       $accion             = $_GET['accion'];
       
       $gestion->FiltroFormulario( $id_tramite,$accion );
       
   }

 ?>


 
  