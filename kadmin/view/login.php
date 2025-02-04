<?php
session_start( );
 
?>	
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CBSD - Plataforma de Gestion Empresarial</title>
	
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	
<style type="text/css">
 body
{
    background-image: url(../../kimages/eps.jpg);
    background-size: cover;
    padding: 0;
    margin: 0;
}

.wrap
{
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 99;
}

p.form-title
{
    font-family: 'Open Sans' , sans-serif;
    font-size: 20px;
    font-weight: 600;
    text-align: center;
    color: #FFFFFF;
    margin-top: 5%;
    text-transform: uppercase;
    letter-spacing: 4px;
}

form
{
    width: 550px;
    margin: 0 auto;
}

form.login input[type="text"], form.login input[type="password"]
{
    width: 75%;
    margin: 0;
    padding: 5px 10px;
    /*background: 0;*/
    border: 0;
    border-bottom: 1px solid #FFFFFF;
    outline: 0;
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color:#151C3D;
    outline: 0;
}

form.login input[type="submit"]
{
    width: 75%;
    font-size: 20px;
   font-weight:600;
     margin-top: 40px; 
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

form.login input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}

form.login .remember-forgot
{
    float: left;
    width: 100%;
    margin: 10px 0 0 0;
}
	
form.login .remember-sup
{
    float: left;
    width: 100%;
    margin: 50px 5px 40px 5px;
}
	
form.login .forgot-pass-content
{
    min-height: 20px;
    margin-top: 10px;
    margin-bottom: 10px;
}
form.login label, form.login a
{
    font-size: 13px;
    font-weight: 400;
    color: #FFFFFF;
}

form.login a
{
    transition: color 0.5s ease;
}

form.login a:hover
{
    color: #2ecc71;
}

.pr-wrap
{
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 999;
    display: none;
}

.show-pass-reset
{
    display: block !important;
}

.pass-reset
{
    margin: 0 auto;
    width: 250px;
    position: relative;
    margin-top: 22%;
    z-index: 999;
    background: #FFFFFF;
    padding: 20px 15px;
}

.pass-reset label
{
    font-size: 12px;
    font-weight: 400;
    margin-bottom: 15px;
}

.pass-reset input[type="email"]
{
    width: 100%;
    margin: 5px 0 0 0;
    padding: 5px 10px;
    background: 0;
    border: 0;
    border-bottom: 1px solid #000000;
    outline: 0;
    font-style: italic;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #000000;
    outline: 0;
}

.pass-reset input[type="submit"]
{
    width: 100%;
    border: 0;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 10px;
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

.pass-reset input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}
.posted-by
{
    position: absolute;
    bottom: 26px;
    margin: 0 auto;
    color: #FFF;
    background-color: rgba(0, 0, 0, 0.66);
    padding: 10px;
    left: 45%;
}


</style>
	<script src="../js/jquery-1.11.1.min.js"></script>
	<link href="dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
 	<script src="dist/js/bootstrap.min.js"></script>
	
	<script>
		
		$(document).ready(function(){
			var prodId = getParameterByName('a');
			
			$("#Novedad").html('');
			
			if (prodId == '1'){
				$("#Novedad").html('<img src="../../kimages/alert.png" align="absmiddle"/><b> Limite de conexion</b>');
			}	
			
			if (prodId == '2'){
				$("#Novedad").html('<img src="../../kimages/alert.png" align="absmiddle"/><b> Acceso no valido</b>');
			}	
			
			if (prodId == '3'){
				$("#Novedad").html('<img src="../../kimages/alert.png" align="absmiddle"/><b> Acceso no valido/b>');
			}	
		
		});  
		
			function getParameterByName(name) {
			name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
			return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	</script>
	
</head>

<body>
	

 
 
         <div class="col-md-12">
              
            <div class="wrap">
 				
                <form class="login" action='../controller/Controller-login' method="post" enctype="application/x-www-form-urlencoded"   accept-charset="UTF-8">

					 	<div class="remember-sup">
						  <h4 style="color: aliceblue">Bienvenido a la<br>
				
               				 <span style="color: aliceblue;font-size:40px;font-weight: bold">Plataforma Administrativa Financiera del Cuerpo de Bomberos de Santo Domingo</span>
							</h4>
					
						</div>
                        <h4 style="color: aliceblue">Para ingresar, por favor digite sus credenciales de acceso: </h4> <br>
							<input class="form-control" type="text" placeholder="Usuario"   name="datoname" />
							<input class="form-control" type="password" placeholder="Contraseña" name="datolog" />
							<input name="dato_sx" type="hidden" id="dato_sx" value="register">
                
							<input type="submit" value="Iniciar Sesión" class="btn btn-primary btn-lg" />
					
                			<div class="remember-forgot">
					
                  				  <div class="row">
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-6 forgot-pass-content">
                          <!--===  <a href="javascript:void(0)" class="forgot-pass">Forgot Password</a> ===-->
                        </div>
						 <div class="col-md-6" align="center" style="color: #FFFFFF">
                             <div id="Novedad">    </div>
                        </div>
                    </div>
					
                			</div>
					
					
								<div class="container-fluid">
								  <div class="row" style="padding-bottom: 10px;padding-top: 10px">
	 
									<div class="col-sm-12">
									  <p><a href="#">GK Comunidad de Emprendimiento y Tecnologia</a><br>
 									  <span style="color: aliceblue">Copyright Gestiona &copy; 2017-2019</span></p>
									</div>
									  
								  </div>
								</div>
					
                </form>
				
            </div>
			  
        </div>
	 
	 
 
            
 
 
 	

	 
</body>
</html>