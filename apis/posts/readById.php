<?php

require '../database.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

$posts = [];
$sql = "SELECT * FROM posts WHERE id = {$id}";

if($result = mysqli_query($con,$sql))
{
  
  if($row = mysqli_fetch_assoc($result))
  {
    $posts['id']    = $row['Id'];
    $posts['userid'] = $row['userid'];
    $posts['titulo'] = $row['titulo'];
    $posts['descripcion'] = $row['descripcion'];
    $posts['contenido'] = $row['contenido'];
    $posts['estado'] = $row['estado'];
    $posts['categorias'] = $row['categorias'];
    $posts['portada'] = $row['portada'];
  }

  echo json_encode($posts);
}
else
{
  //http_response_code(404);
  echo $con->error;
}
?>