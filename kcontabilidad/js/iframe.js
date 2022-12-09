// JavaScript Document.
if (window.innerHeight){ 
			   //navegadores basados en mozilla 110
			   espacio_iframe = screen.height ; //window.innerHeight  - 50
			   
			}else{ 
			   if (document.body.clientHeight){ 
					//Navegadores basados en IExplorer, es que no tengo innerheight 
					espacio_iframe = document.body.clientHeight  - 50
			   }else{ 
					//otros navegadores 
					espacio_iframe = screen.height;
				   alert(espacio_iframe);
			   } 
			} 

document.write ('<iframe  id="miFrame" name="miFrame" scrolling="auto" frameborder="0" src="login.php" width="100%" height="' + espacio_iframe + '">') 

document.write ('</iframe>') 