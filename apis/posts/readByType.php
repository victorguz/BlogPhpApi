<?php

require '../database.php';

// Extract, validate and sanitize the id.
$limit = ($_GET['limit'] !== null && (int)$_GET['limit'] > 0)? mysqli_real_escape_string($con, (int)$_GET['limit']) : false;
$offset = ($_GET['offset'] !== null )? $_GET['offset'] : false;
$type = $_GET['type'];

if($type=="" || !$limit)
{
  return http_response_code(400);
}

$posts = [];
if($limit==0 && $offset==0){
$sql = "SELECT postid, userid, tipo,   
  categorias, created, modified, estado, imgportada,
 (select presentacion from usuarios where usuarios.userid=post.userid) as username ,
 titulo, publicado FROM post WHERE tipo = '{$type}' order by publicado desc ";
}else if($limit>0 && $offset==0){
  $sql = "SELECT postid, userid, tipo,   
  categorias, created, modified, estado, imgportada,
 (select presentacion from usuarios where usuarios.userid=post.userid) as username ,
 titulo, publicado FROM post WHERE tipo = '{$type}' order by publicado desc limit {$limit} ";
}else{
  $sql = "SELECT postid, userid, tipo,   
  categorias, created, modified, estado, imgportada,
 (select presentacion from usuarios where usuarios.userid=post.userid) as username ,
 titulo, publicado FROM post WHERE tipo = '{$type}' 
 order by publicado desc limit {$limit} offset {$offset} ";
}
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
    $posts[$i]['descripcion'] = "";
    $posts[$i]['contenido'] = "";
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