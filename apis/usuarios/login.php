<?php

require '../database.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] >= 0)? 
mysqli_real_escape_string($con, (int)$_GET['id']) : false;
if($id<0)
{
  echo "No se está recibiendo los campos solicitados";
  //return http_response_code(400);
}

$usuarios = [];
$sql = "SELECT * FROM usuarios WHERE username = {$id}";

if($result = mysqli_query($con,$sql))
{ 
  
  if($row = mysqli_fetch_assoc($result))
  {
    $usuarios['id']    = $row['Id'];
    $usuarios['nombres']    = $row['nombres'];
    $usuarios['apellidos'] = $row['apellidos'];
    $usuarios['username'] = $row['username'];
    $usuarios['password'] = $row['password'];
    $usuarios['estado'] = $row['estado'];
    $usuarios['rol'] = $row['rol'];
    $usuarios['imagen'] = $row['imagen'];
  }

  echo json_encode($usuarios);

}else{
  //http_response_code(404);
  echo $con->error;
}
?>