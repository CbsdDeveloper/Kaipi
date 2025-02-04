<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function grilla(  ){
		
  
	   
	    
	    $sql ="SELECT item, 
                      marca, 
                      codigo   , 
                      detalle, 
                      partida , 
                      factor, 
                      salvaguardia, 
                      fob, 
                      isd, 
                      advalorem, 
                      salvaguardia1, 
                      transporte, 
                      subtotal, 
                      vip, integrador, v1, v2, v3
              FROM temp_cotiza";
	    
        	
			$resultado  = $this->bd->ejecutar($sql);
			
		    $i = 1;
			
			while ($fetch=$this->bd->obtener_fila($resultado)){
			    
			    $output[] = array (
			        $i ,
			        $fetch['marca'],
			        $fetch['codigo'],
			        $fetch['detalle'],
			        $fetch['partida'],
			        $fetch['factor'],
			        $fetch['salvaguardia'],
			        $fetch['fob'],
			        $fetch['isd'],
			        $fetch['advalorem'],
			        $fetch['salvaguardia1'],
			        $fetch['transporte'],
			        $fetch['subtotal'],
			        $fetch['vip'],
			        $fetch['integrador'],
			        $fetch['v1'],
			        $fetch['v2'],
			        $fetch['v3'] 
			        
			     
			    );
			    $i ++;
			}
			
			
			
			pg_free_result($resultado);
			
			
			echo json_encode($output);
 
		 
	//		$this->grilla_datos($resultado,$tipo);
			
		 
 
	}
  ///------------------------------------------
	function grilla_datos($resultado,$tipo )  {
	    
 
	     $numero_campos = pg_num_fields($resultado) - 1;
	            
 
	    
	    //echo '<table class="table table-striped table-bordered table-hover table-checkable datatable" border="0" width="100%" style="font-size: 10px">';
	    
	   

	    echo '<table id="example" class="display nowrap" style="width:100%">';

 	    echo '<thead> <tr>';
	    
	    $k = 0;
	    
	    for ($i = 0; $i<= $numero_campos; $i++){
	        
  	                $cabecera = pg_field_name($resultado,$k) ;
 	        
	                echo "<th>".$cabecera.'</th>';
	        
	        $k++;
	        
	    }
	    
	    echo '</tr></thead>';
	    
	    echo '<tbody>';
	 
	      
	            while($row=pg_fetch_assoc($resultado)) {
	                
	                echo "<tr>";
	                $i = 1;
	                
	                foreach ($row as $item){
	                  
	                    if(is_numeric($item)){
	                        
	                        $clase ='';
	                        if ($i == 8)  {
	                            
	                            $clase =' bgcolor="#F47275" ';
	                           
	                        }
	                        
	                        if ($i == 13)  {
	                            
	                            $clase =' bgcolor="#ffe630" ';
	                            
	                        }
	                        
	                        
	                        if ($i == 1)  {
	                            
	                            echo "<td align='right'>".$item;
	                            
	                        }else{
	                            
	                            echo "<td align='right' ".$clase.">".number_format(round($item,2),2);
	                            
	                        }
	                    }else{
	                        
	                        echo "<td>".trim($item) ;
	                        
	                    }
	                    echo "</td>";
	                    $i++;
	                }
	                
	                echo "</tr>";
	           
	            }
	            
	          
	            
	            echo "<tr>";
	            
	            
	            echo "</tbody></table>";
	            
	            pg_free_result ($resultado) ;
	     
	    
	   
	    
	    
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
 
    $gestion->grilla(  );
 
	
 
?>
 
  