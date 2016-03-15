<?Php
require "config.php"; // Database Connection
//////////////////////////////////////////////////////Gallery //////////////////
header('Content-type: application/json');
if(!isset($_POST["img_id"])){
 $response_array["status"] = "error"; 
 $response_array["msg"] = "Une erreur est survenue lors de la suppression de l'image : pas de img_id";
 echo json_encode($response_array);
 exit;
}

$img_id=$_POST["img_id"];

$sql=$dbo->prepare("delete from plus2net_image where img_id=$img_id");
if($sql->execute()){
    $response_array["status"] = "success"; 
    $response_array["msg"] = "L'image $img_id a correctement été supprimée";
} else{
   $response_array["status"] = "error"; 
   $response_array["msg"] = $sql->errorInfo()[2];
}

$sql=$dbo->prepare("delete from tags where img_id=$img_id");
if($sql->execute()){
    $response_array["status"] = "success"; 
    $response_array["msg"] = "Les tags de l'image $img_id ont correctement été supprimés";
} else{
   $response_array["status"] = "error"; 
   $response_array["msg"] = $sql->errorInfo()[2];
}
$sql=$dbo->prepare("delete from owners where img_id=$img_id");
if($sql->execute()){
    $response_array["status"] = "success"; 
    $response_array["msg"] = "Le propriétaire de l'image $img_id a correctement été supprimée";
} else{
   $response_array["status"] = "error"; 
   $response_array["msg"] = $sql->errorInfo()[2];
}

echo json_encode($response_array);


exit;


$count=$dbo->prepare("select * from plus2net_image");
//$count->bindParam(":query",$query,PDO::PARAM_STR,5);

if($count->execute()){
$photos = $count->fetchAll(PDO::FETCH_OBJ);
}else{
echo ' Database problem :'; 
print_r($count->errorInfo());
}
//print_r($photos);
//print json_encode($photos, JSON_PRETTY_PRINT);
//print_r($photos);
$results = [];
foreach ($photos as $row) {
   $result["id"] = $row->img_id;
   $result["label"] = $row->file_name;
   $result["value"] = $row->file_name;
   $results[] = $result;
}
print json_encode($results, JSON_PRETTY_PRINT);

?>
