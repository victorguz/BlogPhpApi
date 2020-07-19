<?php
/**
 * Returns the list of posts.
 */
require '../database.php';
// Extract, validate and sanitize the id.
$limit = ($_GET['limit'] !== null && (int)$_GET['limit'] > 0)? mysqli_real_escape_string($con, (int)$_GET['limit']) : false;
$offset = ($_GET['offset'] !== null && (int)$_GET['offset'] > 0)? mysqli_real_escape_string($con, (int)$_GET['offset']) : false;
$orderby = ($_GET['orderby'] !== null && trim($_GET['orderby'])!=="")? mysqli_real_escape_string($con,$_GET['orderby']) : false;

$posts = [];
$sql = "SELECT * FROM posts ";

if($orderby!=false){

  $sql.=" order by {$orderby} ";

}

if($offset==0 && $limit==0){

  $sql.=" limit 100 ";
  
}else if($offset==0 && $limit!=0){

  $sql.=" limit {$limit} ";

}else if($offset!=0 && $limit!=0){
  
  $sql.=" limit {$limit} offset {$offset} ";
  
}

if($result = mysqli_query($con,$sql)){

$i = 0;

while($row = mysqli_fetch_assoc($result)){
  
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

}else{

  $policy = [
    'id'    => 0,
    'result' => $con->error,
    'sql_response_code'=> $con->errno,
    'http_response_code'=> 404
  ];
  echo json_encode($policy);

}
?>