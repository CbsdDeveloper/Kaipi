<?php session_start( );  ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form action="parametro.php" method="post" enctype="application/x-www-form-urlencoded" name="form1" id="form1" accept-charset="UTF-8">
<table width="50%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td> 
      </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><label for="textfield">host:</label></td>
    <td>
    <input name="host" type="text" id="host" value="localhost" size="30"> </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><label for="textfield2">user:</label></td>
    <td>
    <input name="user" type="text" id="user" value="root"> 
    - postgres</td>
  </tr>
  <tr>
    <td align="right" valign="middle"><label for="textfield3">password:</label></td>
    <td>
    <input type="text" name="password" id="password"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><label for="textfield4">db:</label></td>
    <td>
    <input type="text" name="db" id="db"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><label for="select">dbType:</label></td>
    <td> 
      
      <select name="dbType" id="dbType">
        <option value="mysql" selected="selected">mysql</option>
        <option value="oracle">oracle</option>
        <option value="postgress">postgress</option>
    </select></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>  <input name="submit" type="submit" id="submit" formmethod="POST" value="Enviar"></td>
  </tr>
</table>
</form>
</body>
</html>