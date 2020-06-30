<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{ 
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if ($request->userid > 0 
  || trim($request->nombre) =="" 
  || trim($request->apellidos) =="" 
  || trim($request->username) =="" 
  || trim($request->password) =="" 
  || trim($request->created) =="") {
    return http_response_code(400);
  }

  // Sanitize.
  $userid = mysqli_real_escape_string($con, $request->userid);
  $nombre = mysqli_real_escape_string($con, $request->nombre);
  $apellidos = mysqli_real_escape_string($con, $request->apellidos);
  $username = mysqli_real_escape_string($con, $request->username);
  $password = mysqli_real_escape_string($con, $request->password);
  $created = mysqli_real_escape_string($con, $request->created);

  // Update.
  $sql = "UPDATE `usuarios` 
  SET `nombre`='$nombre',
  `apellidos`='$apellidos' ,
  `username`='$username' ,
  `password`='$password' ,
  `created`='$created'
  WHERE `userid` = '{$userid}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}
?>