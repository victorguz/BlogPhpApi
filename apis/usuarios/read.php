<?php
/**
 * Returns the list of usuarios.
 */
require '../database.php';

$usuarios = [];
$sql = "SELECT userid, nombres, apellidos, username, password, created, estado FROM usuarios";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $usuarios[$i]['userid']    = $row['userid'];
    $usuarios[$i]['nombres']    = $row['nombres'];
    $usuarios[$i]['apellidos'] = $row['apellidos'];
    $usuarios[$i]['username'] = $row['username'];
    $usuarios[$i]['password'] = $row['password'];
    $usuarios[$i]['created'] = $row['created'];
    $usuarios[$i]['estado'] = $row['estado'];
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