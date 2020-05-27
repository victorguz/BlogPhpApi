<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if ((int)$request->id < 1 || trim($request->pdocumento) == '' 
  || trim($request->pnombres) == '' 
  || trim($request->papellidos) == '' 
  || trim($request->ptelefono) == '' 
  || trim($request->pdireccion) == '' 
  || trim($request->pcontrasena) == '') {
    return http_response_code(400);
  }

  // Sanitize.
  $pdocumento = mysqli_real_escape_string($con, trim($request->pdocumento));
  $pnombres = mysqli_real_escape_string($con, $request->pnombres);
  $papellidos = mysqli_real_escape_string($con, $request->papellidos);
  $ptelefono = mysqli_real_escape_string($con, trim($request->ptelefono));
  $pemail = mysqli_real_escape_string($con, $request->pemail);
  $pdireccion = mysqli_real_escape_string($con, $request->pdireccion);
  $pcontrasena = mysqli_real_escape_string($con, $request->pcontrasena);


  // Create.
  $sql = "INSERT INTO `propietarios`(`id`,`pdocumento`,`pnombres`,
  `papellidos`,`ptelefono`,`pemail`,`pdireccion`,`pcontrasena`)
   VALUES (null,'{$pdocumento}','{$pnombres}','{$papellidos}','{$ptelefono}'
   ,'{$pemail}','{$pdireccion}','{$pcontrasena}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $policy = [
      'pdocumento' => $pdocumento,
      'pnombres' => $pnombres,
      'papellidos' => $papellidos,
      'ptelefono' => $ptelefono,
      'pemail' => $pemail,
      'pdireccion' => $pdireccion,
      'pcontrasena' => $pcontrasena,
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