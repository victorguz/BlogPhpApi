<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if ($request->userid > 0) {
    return http_response_code(400);
  }

  // Sanitize.
  $estado = mysqli_real_escape_string($con, "eliminado");

  // Update.
  $sql = "UPDATE `usuarios` SET `estado`='$estado' WHERE `userid` = '{$userid}' LIMIT 1";

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