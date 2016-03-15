<!doctype html public "-//w3c//dtd html 3.2//en">
<html>
<head>
<title>Admin area for photo gallery script</title>
<META NAME="DESCRIPTION" CONTENT=" ">
<META NAME="KEYWORDS" CONTENT="">
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
<?Php
///////////////////////////
if(@$_POST['todo']=="add_details"){
require "../config.php";
$userid=$_POST['userid'];
$password=$_POST['password'];
$password2=$_POST['password2'];
////////Start of  Validation of data input ////////////
$status = "OK";
$msg="";
if(!isset($userid) or strlen($userid) <3){
$msg=$msg."User id should be =3 or more than 3 char length<BR>";
$status= "NOTOK";} 
/// Alphanumeric userid only //
if(!ctype_alnum($userid)){
$msg=$msg."User id should contain alphanumeric chars only<BR>";
$status= "NOTOK";}	
if ( strlen($password) < 3 ){
$msg=$msg."Password must be more than 3 char legth<BR>";
$status= "NOTOK";}	

if ( $password <> $password2 ){
$msg=$msg."Both passwords are not matching<BR>";
$status= "NOTOK";}	
/////////End of  Validation of data input //////
if($status=="OK"){ 
////////// encryption stats ////////
$cost = 10;
$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
$salt = sprintf("$2a$%02d$", $cost) . $salt;
$hash = crypt($password, $salt);
//echo $hash;
$sql=$dbo->prepare("insert into plus2net_admin(userid,password) values(:userid,:password)");
$sql->bindParam(':userid',$userid,PDO::PARAM_STR, 100);
$sql->bindParam(':password',$hash,PDO::PARAM_STR, 100);
if($sql->execute()){
echo ' Admin details added ';
}
 
}// end of if checking status
else{
echo "<font face='Verdana' size='2' color=red>$msg</font><br><input type='button' value='Retry' onClick='history.go(-1)'>";
}
} // end of if checking variable todo


else{
////////////Checking installation support ///
$status_installation='';
$status_msg='';
if(!function_exists('mcrypt_create_iv')){
$status_msg .="<br>mcrypt_create_iv function support is NOT available ";
$status_installation='NOTOK';
}

if (!extension_loaded('mcrypt')) {
echo "<br>mcrypt support is loaded ";
$status_msg .="<br>mcrypt support is NOT loaded  ";
$status_installation='NOTOK';
}

if($status_installation<>'NOTOK'){

//////// display form /////////////
echo "<br><br><br><form name='myForm' action='' method=post>
<table class='t1'><input type=hidden name=todo value='add_details'>
";
echo "<tr class='r0'><td colspan=2>";
require '../check.php';
echo "</td></tr>";
echo "<tr class='r1'><td>User ID</td><td><input type=text name='userid'></td></tr>
<tr class='r0'><td>Password</td><td><input type=password name='password'></td></tr>
<tr class='r0'><td>Password ( Re type) </td><td><input type=password name='password2'></td></tr>

<tr class='r1'><td></td><td ><input type=submit value='Add details'></td></tr>

</table></form>";
}else{


}// end of if else checking installation 
} // end of else if status_form <>OK 



echo "</body></html>";
