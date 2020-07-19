<?php

require '../database.php';

// Extract, validate and sanitize the id.
$limit = ($_GET['limit'] !== null && (int)$_GET['limit'] > 0)? mysqli_real_escape_string($con, (int)$_GET['limit']) : false;
$offset = ($_GET['offset'] !== null )? $_GET['offset'] : false;
$search = ($_GET['search'] !== null && trim($_GET['search'])!=="")? mysqli_real_escape_string($con,$_GET['search']) : false;

if($search=="")
{
  $policy = [
    'id'    => 0,
    'result' => "Nada que buscar",
    'http_response_code'=> 400
  ];
  echo json_encode($policy);
}

$posts = [];
$sql = "SELECT * FROM posts WHERE titulo LIKE '%{$search}%' or contenido LIKE '%{$search}%' or descripcion LIKE '%{$search}%' 
 ORDER BY titulo desc, contenido desc, descripcion desc";


if($offset==0){

  $sql.=" limit {$limit} ";
  
  }else if($offset!=0){
  
  $sql.=" limit {$limit} offset {$offset} ";
  
}
  

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $posts[$i]['id']    = $row['Id'];
    $posts[$i]['userid'] = $row['userid'];
    $posts[$i]['titulo'] = $row['titulo'];
    $posts[$i]['estado'] = $row['estado'];
    $posts[$i]['categorias'] = $row['categorias'];
    $posts[$i]['portada'] = $row['portada'];
    $posts[$i]['publicado'] = $row['publicado'];
    $i++;
  }

  echo json_encode($posts);
}
else
{
  $policy = [
    'id'    => 0,
    'result' => $con->error,
    'sql_response_code'=> $con->errno,
    'http_response_code'=> 404
  ];
  echo json_encode($policy);
}
?>
