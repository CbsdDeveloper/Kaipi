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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
        }
     //---------------------------------------
     function Formulario( $id){
      
         $tipo 		= $this->bd->retorna_tipo();
         
         $anio       =  $_SESSION['anio'];
         
         $sql = " SELECT  
	 	 	 		  CASE
			            WHEN mes = '1' THEN 'Enero'::text
			            WHEN mes = '2'  THEN 'Febrero'::text
			            WHEN mes = '3'  THEN 'Marzo'::text
			            WHEN mes = '4'  THEN 'Abril'::text
			            WHEN mes = '5'  THEN 'Mayo'::text
			            WHEN mes = '6'  THEN 'Junio'::text
			            WHEN mes = '7'  THEN 'Julio'::text
			            WHEN mes = '8'  THEN 'Agosto'::text
			            WHEN mes = '9'  THEN 'Septiembre'::text
			            WHEN mes = '10'  THEN 'Octubre'::text
			            WHEN mes = '11'  THEN 'Noviembre'::text
			            WHEN mes = '12'  THEN 'Diciembre'::text
			            ELSE NULL::text
			        END AS cmes,
	 	 	 		 min(cantidad) as minimo, 
	 	 	 		 max(cantidad) as maximo, 
	 	 	 		 sum(cantidad) as cantidad, 
                     min(total) as totalmin,
                     max(total) as totalmax,
	 	 	 		 sum(total) as total
FROM public.view_movimiento_det_cta
	 where   idproducto = ".$this->bd->sqlvalue_inyeccion($id,true)." and 
             tipo='I' and 
             anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
	 group by  anio,mes";
          
        
         echo '<div class="col-md-4"><h6><b>Resumen Ingresos</b></h6>';
                  $resultado  = $this->bd->ejecutar($sql);
                 $cabecera   =  "Mes,Minimo,Maximo,Cantidad,Minimo ($),Maximo ($),Total ($)";
                 $evento   = "";
                 $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
           echo '</div>';
         
       
           $sql = " SELECT
	 	 	 		  CASE
			            WHEN mes = '1' THEN 'Enero'::text
			            WHEN mes = '2'  THEN 'Febrero'::text
			            WHEN mes = '3'  THEN 'Marzo'::text
			            WHEN mes = '4'  THEN 'Abril'::text
			            WHEN mes = '5'  THEN 'Mayo'::text
			            WHEN mes = '6'  THEN 'Junio'::text
			            WHEN mes = '7'  THEN 'Julio'::text
			            WHEN mes = '8'  THEN 'Agosto'::text
			            WHEN mes = '9'  THEN 'Septiembre'::text
			            WHEN mes = '10'  THEN 'Octubre'::text
			            WHEN mes = '11'  THEN 'Noviembre'::text
			            WHEN mes = '12'  THEN 'Diciembre'::text
			            ELSE NULL::text
			        END AS cmes,
	 	 	 		 min(cantidad) as minimo,
	 	 	 		 max(cantidad) as maximo,
	 	 	 		 sum(cantidad) as cantidad,
                     min(total) as totalmin,
                     max(total) as totalmax,
	 	 	 		 sum(total) as total
FROM public.view_movimiento_det_cta
	 where   idproducto = ".$this->bd->sqlvalue_inyeccion($id,true)." and
             tipo='E' and
             anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
	 group by  anio,mes";
           
	 
           echo '<div class="col-md-4"><h6><b>Resumen Egresos</b></h6>';
           $resultado  = $this->bd->ejecutar($sql);
           $cabecera   =  "Mes,Minimo,Maximo,Cantidad,Minimo ($),Maximo ($),Total ($)";
           $evento   = "";
           $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
           echo '</div>';
		 
           
           $sql = " SELECT  b.nombre ,
                             min(cantidad) as minimo,
        	 	 	 		 max(cantidad) as maximo,
        	 	 	 		 sum(cantidad) as cantidad,
        	 	 	 		 sum(total) as total
                    FROM view_movimiento_det_cta a, nom_departamento b
                    	 where   a.idproducto = ".$this->bd->sqlvalue_inyeccion($id,true)." and
                                 a.tipo='E' and
                                  a.id_departamento = b.id_departamento and
                                 a.anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
                    group by b.nombre,a.id_departamento,a.anio ";
    
           
        
           
           echo '<div class="col-md-4"><h6><b>Egresos por Unidad</b></h6>';
           $resultado  = $this->bd->ejecutar($sql);
           
           $this->obj->grid->KP_sumatoria(4,'3','4', "","");
           
           $cabecera   =  "Unidad,Minimo,Maximo,Cantidad,Total ($)";
           $evento   = "";
           $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
           
      
           
           echo '</div>';
		 
   }
 //----------------------------------------------
   
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
 
  