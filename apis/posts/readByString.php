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
$sql = "SELECT postid, userid, tipo,   
  categorias, created, modified, estado, imgportada, publicado,
 (select presentacion from usuarios where usuarios.userid=post.userid) as username ,
 titulo, descripcion, contenido FROM post WHERE titulo LIKE '%{$search}%' or contenido LIKE '%{$search}%' 
 ORDER BY titulo, contenido ";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $posts[$i]['postid']    = $row['postid'];
    $posts[$i]['userid'] = $row['userid'];
    $posts[$i]['username'] = $row['username'];
    $posts[$i]['tipo'] = $row['tipo'];
    $posts[$i]['titulo'] = $row['titulo'];
    $posts[$i]['descripcion'] = $row['descripcion'];
    $posts[$i]['contenido'] = $row['contenido'];
    $posts[$i]['categorias'] = $row['categorias'];
    $posts[$i]['created'] = $row['created'];
    $posts[$i]['modified'] = $row['modified'];
    $posts[$i]['publicado'] = $row['publicado'];
    $posts[$i]['estado'] = $row['estado'];
    $posts[$i]['imgportada'] = $row['imgportada'];
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