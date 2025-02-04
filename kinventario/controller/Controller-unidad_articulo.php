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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $tipourl, $url,$id ){
      
       
        $tipo 		= $this->bd->retorna_tipo();

      
        $xy = $this->bd->query_array('web_producto',   // TABLA
	        '*',                        // CAMPOS
	        'idproducto='.$this->bd->sqlvalue_inyeccion($id ,true) // CONDICION
	        );

       echo '<h4><b>Articulo/Producto '. $xy['producto'].'</b></h4>'    ;

        $anio       =  $_SESSION['anio'];

        if ( $tipourl == 'I'){
			
            $sql ="SELECT a.idprov as codigo, b.razon ,
            sum(a.cantidad)  || ' ' as cantidad,
            sum(coalesce(a.total)) as costo,
            sum(coalesce(a.total)) /  sum(a.cantidad)  as media,
            min(a.costo) as minimo,
            max(a.costo) as maximo
       from view_inv_movimiento_det a , par_ciu b
     where  a.tipo       ='".$tipourl."' and a.idprov = b.idprov and 
            a.idproducto = ".$this->bd->sqlvalue_inyeccion( $id, true)." and
            a.estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
            a.anio  = ".$this->bd->sqlvalue_inyeccion(    $anio, true)."  
       group by a.idprov,b.razon order by  b.razon ";


       $cabecera =  "Ruc ,Proveedor,Cantidad,Costo, Media,Minimo,Maximo";

		}else  {
			$sql ="SELECT a.id_departamento as codigo, b.nombre unidadd,
					  sum(a.cantidad)  || ' ' as cantidad,
					  sum(coalesce(a.total)) as costo,
					  sum(coalesce(a.total)) /  sum(a.cantidad)  as media,
					  min(a.costo) as minimo,
					  max(a.costo) as maximo
				 from view_inv_movimiento_det a , nom_departamento b
			   where  a.tipo       ='".$tipourl."' and a.id_departamento = b.id_departamento and 
			          a.idproducto = ".$this->bd->sqlvalue_inyeccion( $id, true)." and
					  a.estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  a.anio  = ".$this->bd->sqlvalue_inyeccion(    $anio, true)."  
				 group by a.id_departamento,b.nombre order by  b.nombre ";


                 $cabecera =  "Codigo ,Unidad,Cantidad,Costo, Media,Minimo,Maximo";
		 }
 

 
        
        
        $resultado  = $this->bd->ejecutar($sql);

       


        $evento   = "";
        $this->obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);
 

      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   if (isset($_GET['id']))	{
       
       
       $tipourl        = $_GET['tipourl'];
       $url            = $_GET['url'];
       
       $id            = $_GET['id'];
       
       $gestion->FiltroFormulario( $tipourl, $url,$id);
       
   }
 

 ?>


 
  