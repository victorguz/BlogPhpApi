<?php
/**
 * Returns the list of usuarios.
 */
require '../database.php';

$usuarios = [];
$sql = "SELECT * FROM users";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $usuarios[$i]['id']    = $row['Id'];
    $usuarios[$i]['nombres']    = $row['nombres'];
    $usuarios[$i]['apellidos'] = $row['apellidos'];
    $usuarios[$i]['username'] = $row['username'];
    $usuarios[$i]['password'] = $row['password'];
    $usuarios[$i]['estado'] = $row['estado'];
    $usuarios[$i]['rol'] = $row['rol'];
    $usuarios[$i]['imagen'] = $row['imagen'];
    $i++;
  }

  echo json_encode($usuarios);
}
else
{
  //http_response_code(404);
  echo $con->error;
}
?>