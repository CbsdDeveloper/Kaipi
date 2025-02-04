<script type="text/javascript" src="formulario_result.js"></script> 
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
      private $anio;
      /*
      Constructor de la clase
      */
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;

                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->anio      =  $_SESSION['anio'];
                
        }
    /*
     Formulario de informacion de datos
      */
     function Formulario( $id){
      
         $tipo 		= $this->bd->retorna_tipo();
        
         
         $Aproducto = $this->bd->query_array('web_producto',
                                             ' producto, referencia, saldo,  url, promedio, lifo, unidad , 
                                               costo, idcategoria, tipourl, minimo', 
             'idproducto='.$this->bd->sqlvalue_inyeccion($id,true)
                                            );
         
         
       $ACarpeta = $this->bd->query_array('wk_config',
             'carpetasub',
            'tipo='.$this->bd->sqlvalue_inyeccion(1,true)
             );
         
         
         $folder = trim($ACarpeta['carpetasub']);
         
         $archivo = $folder.$Aproducto['url'];
         
         $x = $this->bd->query_array('view_movimiento_det_cta',
             'max(id_movimiento) id_movimiento',
             "tipo='I' and idproducto=".$this->bd->sqlvalue_inyeccion($id,true)
             );
         
         $y = $this->bd->query_array('view_inv_movimiento',
             'razon',
             "id_movimiento=".$this->bd->sqlvalue_inyeccion($x['id_movimiento'],true)
             );
         
         
         $xx = $this->bd->query_array('view_movimiento_det_cta',
             'max(id_movimiento) id_movimiento',
             "tipo='E' and idproducto=".$this->bd->sqlvalue_inyeccion($id,true)
             );
         
         $yy = $this->bd->query_array('view_inv_movimiento',
             'razon,unidad',
             "id_movimiento=".$this->bd->sqlvalue_inyeccion($xx['id_movimiento'],true)
             );
         
     
         echo '<div class="col-md-12">
                            <h5> <b> FICHA DE GESTION DE MOVIMIENTOS DE INVENTARIOS </b>  </h5>
               </div>

                   <div class="col-md-12">
                         <div class="col-md-2" align="center" > 
                           <img src='.$archivo.'  width="130" height="150" />  
                         </div>
                        <div class="col-md-5">
                              <h5>  <b>Nombre Producto   : '.$Aproducto['producto'].' </b></h5>
                              <h6>  Tipo de Medida    : '.$Aproducto['unidad'].'  </h6>
                              <h6>  <b>Costo producto : '.$Aproducto['costo'].'  </b></h6>
                              <h6>  <b>Saldo Actual   : '.$Aproducto['saldo'].'  </b></h6>
                              <h6>  Costo Promedio    : '.$Aproducto['promedio'].'  </h6>
                              <h6>  Costo Lifo        : '.$Aproducto['lifo'].'  </h6>
                         </div>
                        <div class="col-md-5">
                             <h5>  <b>Ultimas Transacciones</b></h5>
                              <h6> Compra </h6>
                              <h6>  Proveedor    : '.$y['razon'].'  </h6>
                              <h6> Egreso </h6>
                              <h6>  Unidad: '.$yy['unidad'].'  </h6>
                              <h6>  Solicitante : '.$yy['razon'].'  </h6>
                          </div> 
                    </div>';
         
         
         echo '  <div class="col-md-12">';
                    	 echo '<div class="col-md-6" style="overflow-y: auto; height:450px; "><h4>Ingresos</h4>';
                                  
                    		 $sql = "SELECT
                                      id_movimiento as Movimiento, fecha,
                                      razon as responsable,  
                                      cantidad, 
                                       round((total/cantidad),4) as costo,    
                                      total
                                    FROM  view_mov_aprobado
                                    where tipo = 'I' and tipo_inventario= 'B' and 
                                          anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true). " and
                                          idproducto = ".$id.' and
                                          registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true). ' order by fecha DESC';
                    	     
                    		 $formulario = '';
                    	     
                    		 $resultado  = $this->bd->ejecutar($sql);
                    	     
                    		 $this->obj->grid->KP_sumatoria(4,"cantidad","costo", 'total','');
                                          
                    		 $this->obj->grid->KP_GRID_kardex($resultado,$tipo,'id',$formulario,'N','','','','');
                                        
            		 echo '</div>';
                                        
		             echo '<div class="col-md-6" style="overflow-y: auto; height:450px; "><h4>Egresos</h4>';
                                              
                     		 $sql = "SELECT
                                      id_movimiento, fecha ,
                                       razon as responsable,  cantidad,
                                       costo,    
                                       total
                                    FROM  view_mov_aprobado
                                    where tipo = 'E' and    tipo_inventario= 'B' and 
                                          anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true). " and
                                          idproducto = ".$id.' and
                                          registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true). ' order by fecha DESC';
                                                  
                                                  
            		        $resultado  = $this->bd->ejecutar($sql);
                                                  
            		    
            		        echo '<table id="jsontable_Doc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                              <thead> <tr>
                                    <th> Movimiento </th>
                                    <th> Fecha </th>
                                    <th> Responsable </th>
                                    <th> Cantidad </th>
                                     <th> Costo </th>
                                     <th> Total </th>
                                     </thead> </tr>';
            		        
                        		        while ($fetch=$this->bd->obtener_fila($resultado)){
                        		            
                        		            $idproducto =  $fetch['id_movimiento'] ;
                        		            $sesion =  trim($fetch['responsable']) ;
 
                        		            
                        		            $evento1 = ' onClick="verificar_costo('.$id.','.$idproducto.','.$fetch['costo'].','.$fetch['cantidad'].');" ';
                        		            
                         		            
                        		            echo ' <tr>';
                        		            echo ' <td><a href="#" '.$evento1.' title="Verificar Informacion">'.$idproducto.'</a></td>';
                        		            echo ' <td>'.$fetch['fecha'].'</td>';
                        		            echo ' <td>'.$sesion.'</td>';
                        		            echo ' <td>'.$fetch['cantidad'].'</td>';
                        		            echo ' <td>'.$fetch['costo'].'</td>';
                        		            echo ' <td>'.$fetch['total'].'</td>';
                        		            
                        		            echo ' </tr>';
                        		        }
                        		        
                        		        
                        		        echo "   </tbody>
                           </table>";
            		        
            		        
            		        pg_free_result($resultado);
                                                  
		 
                                        
		 echo '</div></div>';
        
		 $result = 'Usuario '.$this->sesion ;
		 
		 echo $result;
		 
		 
		 
   }
 //----------------------------------------------
//----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
  //----------------------------------------------
 
  
 }    
  
 $gestion   = 	new componente;
   
 
   if (isset($_GET['id']))	{
       
       $id = $_GET['id']; 
       $gestion->Formulario( $id );
   
   }else{
       
       echo '<h5>Seleccione el articulo para visualizar los movimientos</h5>';
       
   }
 
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  