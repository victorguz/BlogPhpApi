<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{ 
  // Extract the data.
  $request = json_decode($postdata);

 // Validate.
 if (trim($request->imagen) == ""
 || trim($request->id) == ""
 || $request->id >0 ) {
   
    $policy = [
      'result' => 'Faltan algunos parametros',
      'id'    => 0,
      'sql_result'=> 'Nada'
    ];
    
    echo json_encode($policy);

 }

  // Sanitize.
  $id = mysqli_real_escape_string($con, $request->id);
  $imagen = mysqli_real_escape_string($con, $request->imagen);

  // Update.
  $sql = "UPDATE `users` 
  SET `imagen`='$imagen' 
  WHERE `id` = {$id} LIMIT 1";

if(mysqli_query($con,$sql))
{
  $policy = [
    'result' => 'Exito',
    'id'    => $id,
    'response_code'=> 201
  ];
  echo json_encode($policy);
}
else
{
  $policy = [
    'result' => $con->error,
    'id'    => $id,
    'sql_result'=> $con->errno
  ];
  echo json_encode($policy);
 /* echo $con->error;*/
}
}
?>