<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php';        /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
 
      private $obj;
      private $bd;
      private $set;
      
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
      function FiltroFormulario( $id_par_ciu) {
      
          
          $sql = 'SELECT *
    			from rentas.view_ren_movimiento_emitido
			   where   id_par_ciu = '.$this->bd->sqlvalue_inyeccion($id_par_ciu, true).
               'order by periodo asc';

          $total = 0;

          $stmt = $this->bd->ejecutar($sql);
 
  
          $this->cabecera();
            
          while ($x=$this->bd->obtener_fila($stmt)){
              
           
              $id_ren_movimiento  = $x['id_ren_movimiento'] ;
              $ajaxPic            = ' ';
              
              if ( $this->_es_iva($x['id_rubro']) == 'S' ){
                  
                  $ajaxPic = ' data-toggle="modal" data-target="#myModalIva"  onclick="myFunctionIVA('.$id_ren_movimiento.')" ';
                  
              }
            
              
              $periodo = $x['anio'].'-'.$x['mes'];
              
              $chequeo = '  <input type="checkbox" id="myCheck'.$id_ren_movimiento.'" onclick="myFunction('.$id_ren_movimiento.',this)">';
           
              $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('.$id_ren_movimiento.')" ';
            

 
              echo '<tr>';
              echo '<td>'.
                      '<a class="btn btn-xs btn-info" title="Detalle Rubro" href="#" '.$ajaxCateg.'> <i class="icon-search icon-white"></i>  </a>
                       <a class="btn btn-xs btn-success" title="Factura Electronica" href="#" '.$ajaxPic.'> <i class="icon-globe icon-white"></i> </a>' .
                    ' </td>';
                  echo '<td> '.$x['id_ren_movimiento'].' </td>';
                  echo '<td> '.$x['fecha'].' </td>';
                  echo '<td> <b> '.$periodo.'</b>  </td>';
                  echo '<td> '.$x['nombre_rubro'].' </td>';
                  echo '<td> '.$x['detalle'].' </td>';
                  
                  echo '<td align="right" style="font-size:14px;color: #c5133c"><b> '.$x['apagar'].$chequeo.'</b> </td>';
           
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
           
           echo '<tr>';
           echo '<td></td>';
           echo '<td></td>';
           echo '<td></td>';
           echo '<td></td>';
           echo '<td></td>';
           echo '<td align="right" style="font-size:18px;color: #DB0014">Apagar $ </td>';
           echo '<td align="right" style="font-size:28px;color: #DB0014">
                 <input type="number" name="pagado" 
                                      id="pagado" 
                                      class="form-control input-lg" 
                                      placeholder="Monto a pagar" step="0.01" 
                                      style="text-align:right" readonly="readonly" value="0.00"> </td>';
           echo '</tr>';
           
          echo "</tbody></table>";
        
      }
      
     //-------------------------- 
      function cabecera( ){
          //inicializamos la clase para conectarnos a la bd
          
         
          
          
          echo '<table class="table table-striped  table-hover" width="100%">  
                <thead> 
                    <tr>
                     <th width="7%"> Accion</th>
                     <th width="5%"> Codigo </th>
                     <th width="10%"> Fecha </th>
                     <th width="10%"> Periodo </th>
                     <th width="20%"> Rubro </th>
                     <th width="30%"> Detalle </th>
                     <th width="18%">Total</th>
                    </tr>   
                  </thead> 
                <tbody>';
          
          
      }
      //--------------------------
      function _es_iva($id_rubro){
         
 
           $x = $this->bd->query_array('rentas.view_matriz_rubro',
           'count(*) as nn',
           "modulo = 'S' and id_rubro=".$this->bd->sqlvalue_inyeccion($id_rubro,true)
           );
        
           if ($x['nn'] > 0 )   {
               return 'S';
           }
           
           return 'N';
           
      }
       
 ///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
   if (isset($_GET['id']))	{
       
        
       $id_par_ciu      = $_GET['id'];
       
       if (  $id_par_ciu  <> 0)	{
  
            $gestion->FiltroFormulario( $id_par_ciu );

        }
       
   }

 ?>


 
  