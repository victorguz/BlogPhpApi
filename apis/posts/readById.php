<?php

require '../database.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

$posts = [];
$sql = "SELECT postid, userid, tipo,   
categorias, created, modified, estado, imgportada, publicado,
(select presentacion from usuarios where usuarios.userid=post.userid) as username ,
titulo, descripcion, contenido 
  FROM post WHERE postid = {$id}";

if($result = mysqli_query($con,$sql))
{
  
  if($row = mysqli_fetch_assoc($result))
  {
    $posts['postid']    = $row['postid'];
    $posts['userid'] = $row['userid'];
    $posts['username'] = $row['username'];
    $posts['tipo'] = $row['tipo'];
    $posts['titulo'] = $row['titulo'];
    $posts['descripcion'] = $row['descripcion'];
    $posts['contenido'] = $row['contenido'];
    $posts['categorias'] = $row['categorias'];
    $posts['created'] = $row['created'];
    $posts['modified'] = $row['modified'];
    $posts['publicado'] = $row['publicado'];
    $posts['estado'] = $row['estado'];
    $posts['imgportada'] = $row['imgportada'];

  }

  echo json_encode($posts);
}
else
{
  //http_response_code(404);
  echo $con->error;
}
?>