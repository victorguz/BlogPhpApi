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
  || trim($request->password) =="") {

    $policy = [
      'result' => 'Faltan algunos parametros',
      'id'    => 0,
      'sql_result'=> 'Nada'
    ];
    return json_encode($policy);
  }

  // Sanitize.
  $nombre = mysqli_real_escape_string($con, $request->nombre);
  $username = mysqli_real_escape_string($con, $request->username);
  $password = mysqli_real_escape_string($con, $request->password);

  // Create.
  $sql = "INSERT INTO users( nombre,username,password,rol,estado)
   VALUES ('{$nombre}','{$username}','{$password}','usuario','normal')";
 
  if(mysqli_query($con,$sql))
  {
    $policy = [
      'result' => 'Exito',
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