<?Php
require "config.php"; // Database Connection
//////////////////////////////////////////////////////Gallery //////////////////
header('Content-type: application/json');
if(!isset($_POST["img_id"])){
 $response_array["status"] = "error"; 
 $response_array["msg"] = "Une erreur est survenue lors de l'ajout du tag : pas de img_id";
 echo json_encode($response_array);
 exit;
}
if(!isset($_POST["tag"])){
 $response_array["status"] = "error"; 
 $response_array["msg"] = "Une erreur est survenue lors de l'ajout du tag : pas de tag";
 echo json_encode($response_array);
 exit;
}
$img_id=$_POST["img_id"];
$tag=$_POST["tag"];

$sql=$dbo->prepare("insert into tags values('$img_id','$tag')");
if($sql->execute()){
    $response_array["status"] = "success"; 
    $response_array["msg"] = "Le tag $tag a correctement été ajouté à l'image";
} else{
 if ($sql->errorInfo()[1] != 1062){
   // Ignore duplicate entries
   $response_array["status"] = "error"; 
   $response_array["msg"] = $sql->errorInfo()[2];
 } else {
    $response_array["status"] = "success"; 
    $response_array["msg"] = "Le tag $tag est déjà associé à l'image";
 }
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
