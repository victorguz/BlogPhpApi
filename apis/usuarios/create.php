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
  || trim($request->created) =="") {
    return http_response_code(400);
  }

  // Sanitize.
  $nombres = mysqli_real_escape_string($con, $request->nombres);
  $apellidos = mysqli_real_escape_string($con, $request->apellidos);
  $username = mysqli_real_escape_string($con, $request->username);
  $password = mysqli_real_escape_string($con, $request->password);
  $created = mysqli_real_escape_string($con, $request->created);
  $estado = mysqli_real_escape_string($con, "habilitado");


  // Create.
  $sql = "INSERT INTO `usuarios`(`userid`, `nombres`,`apellidos`,`username`,`password`,`created`)
   VALUES (null,'{$nombres}','{$apellidos}','{$username},'{$password},'{$created},'{$estado}')";
 
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $policy = [
      'nombres' => $nombres,
      'apellidos' => $apellidos,
      'username' => $username,
      'password' => $password,
      'created' => $created,
      'estado' => $estado,
      'userid'    => mysqli_insert_id($con)
    ];
    echo json_encode($policy);
  }
  else
  {
    http_response_code(422);
  }
}
?>