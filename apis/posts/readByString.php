<?php

require '../database.php';

// Extract, validate and sanitize the id.
$search = $_GET['search'];

if($search=="")
{
  return http_response_code(400);
}

$posts = [];
/*$sql = "SELECT `postid`, `userid`, `tipo`, `titulo`, `descripcion`,
 `contenido`, `categorias`, `created`, `modified`, `estado` 
 FROM `post` WHERE `titulo` LIKE `{$search}` 
 or `descripcion` LIKE `{$search}`
 or `contenido` LIKE `{$search}` 
 or `categorias` LIKE `{$search}`
 ORDER BY `titulo`, `descripcion`, `contenido`, `categorias`";
*/
$sql = "SELECT * FROM posts WHERE titulo LIKE '%{$search}%' or contenido LIKE '%{$search}%' or descripcion LIKE '%{$search}%' 
 ORDER BY titulo desc, contenido desc, descripcion desc";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $posts[$i]['id']    = $row['Id'];
    $posts[$i]['userid'] = $row['userid'];
    $posts[$i]['titulo'] = $row['titulo'];
    $posts[$i]['descripcion'] = $row['descripcion'];
    $posts[$i]['estado'] = $row['estado'];
    $posts[$i]['categorias'] = $row['categorias'];
    $posts[$i]['portada'] = $row['portada'];
    $i++;
  }

  echo json_encode($posts);
}
else
{
  //http_response_code(404);
  echo $con->error;
}
?>