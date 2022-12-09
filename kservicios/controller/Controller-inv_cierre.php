<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
   
      private $obj;
      private $bd;
      private $set;
      
      private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
                 $this->evento_form = '../model/Model-ren_cierre.php';        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $this->set->_formulario( $this->evento_form,'inicio' ); 
   
     
        $datos      = array();

        $datos['fecha'] = date('Y-m-d');

        

        $ACaja      = $this->bd->query_array('par_usuario',
                            'caja, supervisor, url,completo,tipourl',
                            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        $tipo = $this->bd->retorna_tipo();
          
        echo'<div class="col-md-12"><br>
               <div class="alert alert-danger">
                <div class="row">
                  <div class="col-md-3">';
                        echo '<h6 align="center">
                               <img src="../../kimages/use.png" align="absmiddle" />
                               &nbsp;Caja Abierta : '.$ACaja['completo'] .' </h6></div>' ;
        
                        $this->obj->text->texto_oculto("id_movimiento",$datos); 
                        $this->obj->text->texto_oculto("comprobante",$datos); 
  
                        $this->obj->text->text('','date','fecha',10,10,$datos ,'required','','div-0-4') ;


                        $resultado = $this->bd->ejecutar("select '-' as codigo, 'Impresion Parte de caja ' as nombre ");

                        $evento = 'Onchange="ImpresionParte(this.value)"';


                     if ( $ACaja['supervisor'] == 'S') {


                        $resultado = $this->bd->ejecutar("select '-' as codigo , ' --- Impresion parte de caja  --- ' as nombre union
                                                         select parte as codigo, 'Parte Nro. ' || parte || ' Fecha: '  || fecha_pago   as nombre
                                                         from rentas.view_ren_diario_pagos
                                                         where cierre = 'X'   
                                                            order by 2 asc");

                        }   else   
                        {

                           $sql1 ="select parte as codigo, 'Parte Nro. ' || parte || ' Fecha: '  || fecha_pago   as nombre
                           from rentas.view_ren_diario_pagos
                           where 
                                 sesion=".$this->bd->sqlvalue_inyeccion($this->sesion, true)." and cierre ='S'
                               GROUP BY   parte,fecha_pago
                              order by fecha_pago desc";

                           $resultado = $this->bd->ejecutar($sql1);
   
                           }                 


                        $this->obj->list->listadbe($resultado,$tipo,'','reporte_dato',$datos,'required','',$evento,'div-0-4');

 

 

        
        echo '</div></div></div></div>';
        
        $this->set->div_label(12,'CIERRE DE CAJA ');	 
        
        
        echo '<div class="col-md-12">
                  <div class="alert alert-info">
                    <div class="row">
                     <h5 align="center"><b> CIERRE DE CAJA '.$ACaja['completo'] .'</b></h5>
                  </div>
                 </div>
              </div>
             <div class="col-md-12">
               <div class="col-md-7"> 
                    <h6><b> DETALLE TITULOS EMITIDOS </b></h6>
	                <div style="overflow-y:scroll; overflow-x:hidden; height:350px;padding: 5px"> 
                             <div id="DivDetalleMovimiento"> </div>
                    </div> 
                </div> 
               <div class="col-md-5">
                     <div class="alert alert-info">
                      <div class="row">
                     <h6 align="center"> <b>   RESUMEN DE VENTAS </b></h6>  
                        <div style="overflow-y:scroll; overflow-x:hidden; height:350px;padding: 5px"> 
                           <div id="DivMovimiento"> </div>
                        </div>
                     <h6 align="center"><b> DETALLE FORMA DE PAGO</b></h6>
                       <div id="DivDetallePago"> </div>
                     </div> 
                   </div> 
                </div> 
             </div> 
             <div class="col-md-12">
                  <div class="alert alert-warning">
                    <div class="row">
                     <h5 align="center"><b> NOVEDADES DE CIERRE DE CAJA</b></h5>
                  </div>
                 </div>
              </div>';
        
            $this->set->div_label(12,'DETALLE LAS NOVEDADES DEL CIERRE DE CAJA (OBLIGATORIO)');	 
        
            echo  ' <div class="col-md-12"> 
                     <div class="col-md-7"> 
                         <h5 align="center"> <b>   DETALLE DE BILLETES/MONEDA </b></h5> '; 
        
                    $cadena    = 'javascript:open_gasto('."'".'View-inv_gasto'."','".''."',".'740,370)';
        
                    $urlImagen =   '<a href="'.$cadena.'" ><img src="../../kimages/cnew.png"/></a> ';
        
                    $this->set->div_labelmin(12,'<h6>'.$urlImagen.' Agregar detalle de billetes/moneda<h6>');
            
           echo    '   <div div class="col-md-12" id="precio_grilla"></div>
                     </div>
                    <div class="col-md-5"> 
                         <h5 align="center"> <b>   CIERRE DE CAJA NOVEDAD </b></h5> ';
                                $this->obj->text->editor('Novedad','novedad',3,75,500,$datos,'','','div-2-10') ;
           echo    ' </div>
               </div> ';
        
       
          $this->obj->text->texto_oculto("estado",$datos); 
		    $this->obj->text->texto_oculto("action",$datos); 
		  
		  $this->set->_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
          
         
             $evento               = 'aprobacion()';
         
              
             $titulo = '<b><span style="font-size: 12px">[ PROCESO DE CIERRE DE CAJA ]</span></b>';
             
             $ToolArray = array(
                  array( boton => 'Aprobar Cierre de Caja',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger") 
             );
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
 
   
  }  
 
 }   
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
    
   
?>
 
  