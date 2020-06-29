<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if (trim($request->nombres) =="" 
  || trim($request->apellidos) =="" 
  || trim($request->username) =="" 
  || trim($request->password) =="" 
  || trim($request->imagen) =="") {
    return http_response_code(400);
  }

  // Sanitize.
  $nombres = mysqli_real_escape_string($con, $request->nombres);
  $apellidos = mysqli_real_escape_string($con, $request->apellidos);
  $username = mysqli_real_escape_string($con, $request->username);
  $password = mysqli_real_escape_string($con, $request->password);
  $imagen = mysqli_real_escape_string($con, $request->imagen);
  

  // Create.
  $sql = "INSERT INTO users( nombres,apellidos,username,password,imagen,rol,estado)
   VALUES ('{$nombres}','{$apellidos}','{$username}','{$password}','{$imagen}','usuario','normal')";
 
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $policy = [
      'result' => 'Usuario creado con exito',
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($policy);
  }
  else
  {
    http_response_code(422);
  }
}
?>