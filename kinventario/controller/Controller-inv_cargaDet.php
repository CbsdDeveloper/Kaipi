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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_movimiento , $accion){
      
    
          $sql = 'SELECT idcarga_inicial, producto,saldo,costo ,cantidad, total, registro,  idproducto
                    FROM  inv_carga_inicial
                    where id_cmovimiento  = '.$this->bd->sqlvalue_inyeccion($id_movimiento, true);
 
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
          $total    = 0;
         
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id = $x['idcarga_inicial']; 
           
               $cadena =  $x['producto'] ;
               
               $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('."'".$cadena."'".')" ';
               
               $ajaxPic = ' data-toggle="modal" data-target="#myModal" onClick="PictureArticulo('.$id.')" ';
               
               $ajaxDEL = ' onClick="EliminarDet('.$id.')" ';
               
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
                    </a> '.
                    ' </td>
                   <td> '.$x['idcarga_inicial'].' </td>
                   <td> '.$x['producto'].' </td>
                    <td> '.$this->campo('saldo',$id,'-',$x['saldo'],'S').'  </td>
                    <td> '.$this->campo('costo',$id,'calcular('.$id .' )',$x['costo'],'S').'  </td>
                    <td> '.$this->campo('cantidad',$id,'calcular('.$id .' )',$x['cantidad'],'N').'  </td>
                    <td> '.$this->campo('total',$id, 'calcular('.$id .' )',$x['total'],'N').
                    ' <input name="tipourl_'. $id.'"     id="tipourl_'. $id.'"     type="hidden" value="1">'.
                    ' <input name="url_'. $id.'"         id="url_'. $id.'"         type="hidden" value="'.$x['registro'].' ">'.
                    '  </td>
                    </tr>';
               
             //  $total       = $total  +       $x['total'];
           }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento = '<div class="col-md-9">';
           $DivMovimiento .= '<h4>Total</h4></div></div>';
          
          $DivMovimiento .= ' <div class="col-md-3">';
          $DivMovimiento .= '<h4 id="TotalF"><b> '.number_format($total,2,",",".").'</b></h4></div>';
        
          
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover" width="100%">  
                <thead> 
                    <tr>
                    <th> Acciones </th>
                    <th> Id </th>
                    <th> Producto </th>
                    <th> Saldo </th>
                    <th> Costo </th>
                    <th> Cantidad </th>
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


 
  