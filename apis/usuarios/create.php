<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if (trim($request->nombre) =="" 
  || trim($request->username) =="" 
  || trim($request->password) =="" 
  || trim($request->imagen) =="") {
    return http_response_code(400);
  }

  // Sanitize.
  $nombre = mysqli_real_escape_string($con, $request->nombre);
  $username = mysqli_real_escape_string($con, $request->username);
  $password = mysqli_real_escape_string($con, $request->password);
  $imagen = mysqli_real_escape_string($con, $request->imagen);

  // Create.
  $sql = "INSERT INTO users( nombre,username,password,imagen,rol,estado)
   VALUES ('{$nombre}','{$username}','{$password}','{$imagen}','usuario','normal')";
 
  if(mysqli_query($con,$sql))
  {
    $policy = [
      'result' => 'Usuario creado con exito',
      'id'    => mysqli_insert_id($con),
      'response_code'=> 201
    ];
    echo json_encode($policy);
  }
  else
  {
    $policy = [
      'result' => $con->error,
      'id'    => 0,
      'sql_result'=> $con->errno
    ];
    echo json_encode($policy);
   /* echo $con->error;*/
  }
}
?>