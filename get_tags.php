<?Php
require "config.php"; // Database Connection
//////////////////////////////////////////////////////Gallery //////////////////

if(!isset($_GET["term"])){
 $term = "";
} else {
 $term = $_GET["term"];
}

$term = "%" . $term . "%";
$count=$dbo->prepare("select distinct tag from tags where tag like :term");
$count->bindParam(":term",$term,PDO::PARAM_STR,5);

if($count->execute()){
  $photos = $count->fetchAll(PDO::FETCH_OBJ);
} else {
  echo ' Database problem :'; 
  print_r($count->errorInfo());
}

$results = [];
foreach ($photos as $row) {
   $result["id"] = $row->tag;
   $result["label"] = $row->tag;
   $result["value"] = $row->tag;
   $results[] = $result;
}
print json_encode($results, JSON_PRETTY_PRINT);

?>
