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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id_par_ciu,$tipo) {
      
          
          if ( $tipo == '2'){
              $sql = 'SELECT *
    			from rentas.view_ren_movimiento_pagos
			   where   id_par_ciu = '.$this->bd->sqlvalue_inyeccion($id_par_ciu, true).
			   'order by fecha desc';
          }else {
              $sql = 'SELECT *
    			from rentas.view_ren_movimiento_emitido
			   where   id_par_ciu = '.$this->bd->sqlvalue_inyeccion($id_par_ciu, true).
			   'order by fecha desc';
          }

          
 
 
          //  ,,,,,,  id_par_ciu
          
          $this->cabecera();
          
          $stmt = $this->bd->ejecutar($sql);
          
          $total = 0;
          
          while ($x=$this->bd->obtener_fila($stmt)){
              
              $id_ren_movimiento = $x['id_ren_movimiento'] ;
              
              $periodo = $x['anio'].'-'.$x['mes'];
              
            
              $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('.$id_ren_movimiento.')" ';
              
 

              echo '<tr>';
              echo '<td>'.
                      '<a class="btn btn-xs" href="#" '.$ajaxCateg.'>
                            <i class="icon-search icon-white"></i>
                            </a> ' .
                    ' </td>';
                  echo '<td> '.$x['id_ren_movimiento'].' </td>';
                  echo '<td> '.$x['fecha'].' </td>';
                  echo '<td> '.$x['fechap'].' </td>';
                  echo '<td> '.$periodo.' </td>';
                  echo '<td> '.$x['nombre_rubro'].' </td>';
                  echo '<td> '.$x['detalle'].' </td>';
                  
                  echo '<td align="right" style="font-size:14px;color: #c5133c"><b> '.$x['apagar'].'</b> </td>';
           
              echo '</tr>';
              
              $total =  $x['apagar'] + $total ;
          }
          
          echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td align="right" style="font-size:18px;color: #DB0014">Total $ </td>';
            echo '<td align="right" style="font-size:24px;color: #DB0014"><b> '.number_format($total,2).'</b> </td>';
           echo '</tr>';
           
         
           
          echo "</tbody></table>";
       
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          
         
          
          
          echo '<table class="table table-striped  table-hover" width="100%">  
                <thead> 
                    <tr>
                     <th width="5%"> Accion</th>
                     <th width="5%"> Codigo </th>
                     <th width="10%"> Fecha </th>
                     <th width="10%"> Pago </th>
                     <th width="10%"> Periodo </th>
                     <th width="20%"> Rubro </th>
                     <th width="40%"> Detalle </th>
                     <th width="10%">Total</th>
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
  //-------------
      function campo1($nombre,$id,$evento,$valor,$tipo,$read ){
          //inicializamos la clase para conectarnos a la bd
          
          $idNombre  = 'name="'.$nombre.'_'.$id.'" id="'.$nombre.'_'.$id.'"'.$read;
          
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
       
        
       $id_par_ciu      = $_GET['id'];
       
       
       
       $tipo      = $_GET['tipo'];
       
         
       $gestion->FiltroFormulario( $id_par_ciu,$tipo );
       
   }

 ?>


 
  