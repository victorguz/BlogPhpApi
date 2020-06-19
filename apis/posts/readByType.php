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
$sql = "SELECT * FROM posts WHERE categorias like '%{$type}%' ";

$posts = [];


if($limit>0 && $offset==0){
  $sql .=  " limit {$limit} ";
}else{
  $sql .= " offset {$offset} ";
}
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