<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
<script >// <![CDATA[
   jQuery.noConflict(); 

	var handleTabs = function() {
		// function to fix left/right tab contents
		var fixTabHeight = function(tab) {
			jQuery(tab).each(function() {
				var content = $($($(this).attr("href")));
				var tab = $(this).parent().parent();
				if (tab.height() > content.height()) {
					content.css('min-height', tab.height());
				}
			});
		}

		// fix tab content on tab click
		jQuery('body').on('click', '.nav.nav-tabs.tabs-left a[data-toggle="tab"], .nav.nav-tabs.tabs-right a[data-toggle="tab"]', function(){
			fixTabHeight($(this));
		});

		// fix tab contents for left/right tabs
		fixTabHeight('.nav.nav-tabs.tabs-left > li.active > a[data-toggle="tab"], .nav.nav-tabs.tabs-right > li.active > a[data-toggle="tab"]');

		// activate tab if tab id provided in the URL
		if (location.hash) {
			var tabid = location.hash.substr(1);
			jQuery('a[href="#'+tabid+'"]').click();
		}
	}


</script>	

<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
     
    class componente{
 
  
      private $obj;
      private $bd;
      private $tarea;
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
 
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
                
                $this->usuario 	 =  trim($_SESSION['usuario']);
        
 
                
      }
  ///------------------------------------------------------------------------
  
      function Formulario( ){
          
            
           echo '<div id="ViewFormularioTarea1"> </div>';
            
          
      }
      
     
 
 }   
 
 
   $gestion   = 	new componente;
  
 
   $gestion->Formulario( );
   

?>