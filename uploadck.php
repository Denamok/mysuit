<?Php
require "config.php"; // Database Connection
set_time_limit (0);
$max_file_size=2000; // This is in KB
echo "<!doctype html public \"-//w3c//dtd html 3.2//en\">
<html>
<head>
<title> </title>
";
require "tags.php";
echo "
 <link href='assets/css/theme.css' rel='stylesheet'>
</head>
<body>";

//@$gal_id=$_POST['gal_id'];
$gal_id=1;
@$todo=$_POST['todo'];
$userid='root';  // change this to your userid system. 


/// for thumbnail image size //
$n_width=100;
$n_height=100;
$required_image_width=890; // Width of resized image after uploading
//////////////////


if($todo=='upload'){
if(!($gal_id > 0)){
echo "Aucune galerie selectionnée";
exit;
}



while(list($key,$value) = each($_FILES['userfile']['name']))
{
$dt=date("Y-m-d");

$sql=$dbo->prepare("insert into plus2net_image (gal_id,file_name,userid) values('$gal_id','$value','$userid')");
if($sql->execute()){
$id=$dbo->lastInsertId(); 
$file_name=$id."_".$value;
}
else{//echo mysql_error();
echo "There is a problem in server, not able to add records in database, contact site admin ";
exit;}


$add = $path_upload.$file_name;   // upload directory path is set

if (!copy($_FILES['userfile']['tmp_name'][$key], $add)) {
    //  upload the file to the server
    echo "L'upload du fichier a échoué...\n";
}

chmod("$add",0777);                 // set permission to the file.

$sql=$dbo->prepare("update plus2net_image set file_name = '$file_name' WHERE img_id=$id");
$sql->execute();

//////////ThumbNail creation //////////////////

if(file_exists($add)){
$tsrc=$path_thumbnail.$file_name; 
$im=ImageCreateFromJPEG($add); 
$width=ImageSx($im); // Original picture width is stored
$height=ImageSy($im); // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height); 
imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
ImageJpeg($newimage,$tsrc);
chmod("$tsrc",0777);
}// end of if
////////Ending of thumb nail ////////

/////////// Resize if width is more than 890 /////

if($required_image_width < $width){
$adjusted_height=round(($required_image_width/$width) * $height);
//echo $adjusted_height . " - ".$height."<br>";
$im=ImageCreateFromJPEG($add); 
$newimage=imagecreatetruecolor($required_image_width,$adjusted_height); 
imageCopyResized($newimage,$im,0,0,0,0,$required_image_width,$adjusted_height,$width,$height);
ImageJpeg($newimage,$add);
chmod("$add",0777);
} // end of if width of image  is more 

///////////////////////////////////////

if (!empty($im)){

echo "La photo (id=$id) a été uploadée avec succès.";
echo " &nbsp; <img src='$tsrc'/>";

echo "
<div id='add_title'>                <form>
                        <p><label>Ajouter un nom :</label>
                        <input type='text' id='title'/>
</p>
                </form>
 
 </div>
<div id='add_tag'>                <form>
                        <p><label>Ajouter des tags :</label>
                        <input id='tags' type='text' class='tags'></p>

                </form>
 
 </div>
<div id='add_owner'>                <form>
                        <p><label>Ajouter un propriétaire :</label>
           <select name='owner' id='owner'>
           <option value='nath'>Nath</option>
           <option value='jpig'>JPig</option>
           <option value='topik'>Topik</option>
</select>
</p>
                </form>
 
 </div>
<div id='add_period'>                <form>
                        <p><label>Ajouter une période :</label>
           <select name='period' id='period'>
           <option value='antiquite'>Antiquité</option>
           <option value='medieval'>Médiéval</option>
           <option value='renaissance'>Renaissance</option>
           <option value='farwest'>Far West</option>
           <option value='xvii-xviii'>XVIIe/XVIIIe</option>
           <option value='xix'>XIXe</option>
           <option value='1900-1920'>1900/1920</option>
           <option value='1920-1940'>1920/1940</option>
           <option value='1940-1960'>1940/1960</option>
           <option value='1960-1980'>1960/1980</option>
           <option value='xx'>XXe</option>
           <option value='contemporaine'>Contemporaine</option>
           <option value='futuriste'>Futuriste</option>
           <option value='autre'>Autre</option>
</select>
</p>
                </form>
 
 </div>
 <div>
 <button type='button' onclick='
saveTags(" . $id . ");
saveOwner("  . $id  .  ");
savePeriod("  . $id  .  ");
saveTitle("  .  $id  .  ");
saveDate("  .  $id  .  ");
alert(\"Envoi réussi !\");
window.top.location.href = \"upload.php\";
'>Enregistrer</button>
</div>


";

}
//sleep(5);
} // loop for all files
}// if todo 


