<?php
/**
 * Returns the list of posts.
 */
require '../database.php';
// Extract, validate and sanitize the id.
$limit = ($_GET['limit'] !== null && (int)$_GET['limit'] > 0)? mysqli_real_escape_string($con, (int)$_GET['limit']) : false;
$offset = ($_GET['offset'] !== null )? $_GET['offset'] : false;
$orderby = ($_GET['orderby'] !== null && trim($_GET['orderby'])!=="")? mysqli_real_escape_string($con,$_GET['orderby']) : false;

if(!$limit){

return "Falta la clausula 'limit' en la sentencia.";

}

$posts = [];
$sql = "SELECT * FROM languages ";

if(trim($orderby)!=""){

  $sql.=" order by {$orderby} ";

}

if($offset==0){

$sql.=" limit {$limit} ";

}else if($offset!=0){

$sql.=" limit {$limit} offset {$offset} ";

}

if($result = mysqli_query($con,$sql)){

$i = 0;
 
while($row = mysqli_fetch_assoc($result)){
  
$posts[$i]['id']    = $row['id'];
$posts[$i]['nombre'] = $row['nombre'];
$posts[$i]['descripcion'] = $row['descripcion'];
$posts[$i]['imagen'] = $row['imagen'];
$i++;

}

echo json_encode($posts);

}else{

echo $con->error;

}
?>