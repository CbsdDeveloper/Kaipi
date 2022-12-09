<?php

class HtmlReport{

  function htmlHead(){
            //inicializamos la clase para conectarnos a la bd
 		  $html='<!DOCTYPE html>
		<html>
		<head lang="en">
			<meta charset="UTF-8">
			<title>Modulo de Reportes </title>
			<style>
				body{
 				     font-family: verdana, sans-serif;
					color: #000;
					background: #fff;
 				}
				.logo{
					font-size: 30px;
				}
				.orange{
					color:orange;
				}
				.titulo{
					font-size:11px;
   				}
				.nombre{
					border-bottom: 1px solid cornsilk;
					font-size: 24px;
					font-family: Courier, "Courier new", monospace;
					font-style: italic;
				}
				.descripcion{
					font-size: 24px;
					padding: 30px 0px;
				}
				.logoEmpresa{
					font-size: 11px;
 				}
				
			 table {
				border-collapse: collapse;
			  }
			  th, td {
				border: 1px solid #ccc;
				padding: 3px;
				text-align: left;
			  }
			  

				
			</style>
		</head>
		<body>';
	  
	  
		 
		  return $html;

      }  
	 function htmltitulo($titulo,$subtitulo){
            //inicializamos la clase para conectarnos a la bd  style="font-size: 11px"
 	  $html=' 
	  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
			  <tbody>
			    <tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 12px">GOBIERNO LOCAL DEL CANTON PELILEO</td> </tr>
				<tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 12px">GESTION TRIBUTARIA ERPCABILDO</td> </tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 11px">'.$titulo.'</td> </tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 11px">'.$subtitulo.'</td> </tr>
			  </tbody>
			</table>
			<br> 
 		';
		  
		  return $html;
       }  
    //--------------------------------------
	  function htmlFooter(){
            //inicializamos la clase para conectarnos a la bd
 		  $html='</body> </html> ';
		  
		  return $html;

      }   
	    //--------------------------------------
	  function certificado(){
            //inicializamos la clase para conectarnos a la bd
 		  $html='<div class="logo">MiCodigo<span class="orange">PHP.com</span></div>
				<div class="titulo">CERTIFICADO DE RECONOCIMIENTO<br>A</div>
				<div class="nombre">Andres Mendoza</div>
				<div class="descripcion">Por su exposici&oacute;n en el taller de PHP para la conversi&oacute;n de HTML a PDF en el
					campus de la universidad DE LA VIDA el d&iacute;a 25 de Abril del 2015</div>';
		  
		  return $html;

      }   
//---
	 function htmlelaborado(){
            //inicializamos la clase para conectarnos a la bd
 	  $html=' <br><br><br> <br><br><br>
	  		<table width="100%"  style="font-size: 11px">
				  <tbody>
					<tr>
					  <td style="padding-bottom: 30px">&nbsp;</td>
					  <td style="padding-bottom: 30px">&nbsp;</td>
					</tr>
					<tr>
					  <td style="padding-bottom: 5px; padding-top: 5px" align="center" valign="middle">ALCALDE</td>
					  <td style="padding-bottom: 5px; padding-top: 5px" align="center" valign="middle">CONTADORA GENERAL</td>
					</tr>
				  </tbody>
				</table>
			 
 		';
		  
		  return $html;
       }  	
}

 
 

?>