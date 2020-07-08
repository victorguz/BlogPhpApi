<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if (trim($request->username) =="") {

    $policy = [
      'result' => 'Faltan algunos parametros',
      'id'    => 0,
      'sql_result'=> 'Nada'
    ];
    return json_encode($policy);
  }

  // Sanitize.
  $username = mysqli_real_escape_string($con, $request->username);

  // Create.
  $sql = "select id from users where username = '{$username}' and password = ''";
 
  if($result = mysqli_query($con,$sql))
  {

  if($row = mysqli_fetch_assoc($result))
  {
      $id=$row['id'];
      if($id===0){
        $policy = [
          'result' => 'Usuario no encontrado',
          'id'    => 0,
          'sql_result'=> 'No hay registros relacionados con los datos'
        ];
        echo json_encode($policy);
      }else{
        $policy = [
          'result' => 'Exito',
          'id'    => $id,
          'sql_result'=> 'No hay registros relacionados con los datos'
        ];
        echo json_encode($policy);
      }

  }
  }
    
    else
    {
      $policy = [
        'result' => $con->error,
        'id'    => 0,
        'sql_result'=> $con->errno
      ];
      echo json_encode($policy);
    /* echo $con->error;*/
    }
}
?>