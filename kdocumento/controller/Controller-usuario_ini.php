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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_movimiento ){
      

          $datos_unidad = $this->bd->catalogo_unidad($id_movimiento);

          $this->set->div_htitulo(4,$datos_unidad['nombre'],'S');

          $sql = "SELECT idusuario, login, email, nombre, apellido, estado, clave, rol, direccion, telefono, caja, 
          supervisor, tipo, url, cedula, idciudad, movil, noticia, nomina, tarea, completo, tipourl, id_departamento, 
          responsable, enlace, smtp1, puerto1, acceso1, empresas, establecimiento, solicitud, inicial, adicional 
          FROM par_usuario
          where estado = 'S' and id_departamento=".$this->bd->sqlvalue_inyeccion($id_movimiento, true)." order by apellido";

            
          $stmt = $this->bd->ejecutar($sql);
          
          
          $this->cabecera();
          
          $total    = 0;
          $monto_iva= 0;
          $tarifa_cero= 0;
          $baseiva= 0;
          $descuento = 0;
          
          $ii = 1;
          
           while ($x=$this->bd->obtener_fila($stmt)){
            
               $id         =  $x['idusuario']; 
               $email      =  trim($x['email']); 

               $cadena     =  trim($x['completo'])   ;

               if ( trim($x['responsable'])  == 'S'){
                  $cadena     =  '<b>'.trim($x['completo']) .' (R) </b>'  ;
                }

               $inicial     =  trim($x['inicial'])  ;
               $adicional   =  trim($x['adicional'])  ;
              
               $id1 = 'name="'.'ini'.'_'.$id.'" id="'.'ini'.'_'.$id.'"';
               $id2 = 'name="'.'adi'.'_'.$id.'" id="'.'adi'.'_'.$id.'"';

               $evento = 'DatoUsuario(this.value,1,'. $id .')';
               $size      = 5;
               $maxlength = 5;
               $v1 = ' size ="'.$size.'" ' ;
               $v2 = ' maxlength  ="'.$maxlength.'" ' ;
               $eventoObje1 = ' onblur="'.$evento.'" ';
 
               $cadena1 = '<input '.$id1.'
               type="text" '. $v1 . $v2 .'
               style="text-align:left; border:rgba(193,193,193,1.00)" class="form-control"
               required  '.$eventoObje1.'
               value="'.$inicial.'">';
          
               $size      = 35;
               $maxlength = 35;
               $v1 = ' size ="'.$size.'" ' ;
               $v2 = ' maxlength  ="'.$maxlength.'" ' ;
               $evento = 'DatoUsuario(this.value,2,'. $id .')';
               $eventoObje2 = ' onblur="'.$evento.'" ';
               $cadena2 = '<input '.$id2.'
               type="text" '. $v1 . $v2 .'
               style="text-align:left; border:rgba(193,193,193,1.00)" class="form-control"
               required  '.$eventoObje2.'
               value="'.$adicional.'">';
             

               echo '<tr>
                    <td> '.$id.' </td>
                   <td> '.$cadena.'</td>
                   <td> '. $cadena1 .'</td>
                   <td> '. $cadena2 .'</td>
                    </tr>';
               
               
               $ii++;
               
          }
         
 
          echo "</tbody></table>";
          
          $DivMovimiento  = ' ';
        
          
          
          echo $DivMovimiento;
      }
      
     //-------------------------- 
      function cabecera( ){


          //inicializamos la clase para conectarnos a la bd
          echo '<table class="table table-striped  table-hover table-bordered" width="100%" id="tabla_mov" name="tabla_mov">  
                <thead> 
                    <tr>
                     <th> Id </th>
                    <th> Nombre </th>
                    <th> Siglas </th>
                    <th> Adicional </th>
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
						required step="0.000001"
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
       
        
       $id      = $_GET['id'];
       
      
       
       $gestion->FiltroFormulario( $id );
       
   }

 ?>


 
  