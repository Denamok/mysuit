<?Php
require "config.php"; // Database Connection
//////////////////////////////////////////////////////Gallery //////////////////
header('Content-type: application/json');
if(!isset($_POST["img_id"])){
 $response_array["status"] = "error"; 
 $response_array["msg"] = "Une erreur est survenue lors de l'ajout de l'époque : pas de img_id";
 echo json_encode($response_array);
 exit;
}
if(!isset($_POST["period"])){
 $response_array["status"] = "error"; 
 $response_array["msg"] = "Une erreur est survenue lors de l'ajout de l'époque : pas d'époque";
 echo json_encode($response_array);
 exit;
}
$img_id=$_POST["img_id"];
$period=$_POST["period"];

$sql=$dbo->prepare("insert into periods values('$img_id','$period')");
if($sql->execute()){
    $response_array["status"] = "success"; 
    $response_array["msg"] = "L'époque $period a correctement été ajouté à l'image";
} else{
 if ($sql->errorInfo()[1] != 1062){
   // Ignore duplicate entries
   $response_array["status"] = "error"; 
   $response_array["msg"] = $sql->errorInfo()[2];
 } else {
    $response_array["status"] = "success"; 
    $response_array["msg"] = "L'époque $period est déjà associé à l'image";
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
