<?php
include_once '../account/session.php';
include_once '../scripts/bd.php';

function upload_file(){
if(!empty($_FILES["file1"]["tmp_name"])){
$target_dir = "../tmp/";
$target_file = $target_dir . uniqid().basename($_FILES["file1"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
if(isset($_POST["submit"])){
if (file_exists($target_file)){
echo "Error: File already exists Please rename the file!.\n";
$uploadOk = 0;
}
if ($_FILES["file1"]["size"] > 5000000){
echo "Error: File is too large. \n";
$uploadOk = 0;
}
if($FileType != "csv" ){
echo "Error: Only CSV files are allowed.\n";
$uploadOk = 0;
}
if ($uploadOk == 0){echo "Error: File was not uploaded.\n";}
else{
if(move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)){
//Get the offer creative image filename :
$filename   =   basename($_FILES["file1"]["name"]);
insert_all($target_file,$filename);
echo $filename. " has been uploaded.\n";
}else{echo "Error: There was an error uploading your file.\n";}
}
}
}
}

function insert_all($target_file,$filename){
$filename = explode(".","",$filename);
$user_name=isset($_SESSION["username"])?$_SESSION["username"]:"Ezouagh";
$date_add=date('Y-m-d h:i:s');
$handle = fopen($target_file, "r");
$date_case = isset($filename[0]) ? $filename[0]:date('Y-m-d');
$count = 0;
while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
$count++;
if ($count == 1) {continue;}
$country_name = isset($data[0]) ? mysql_real_escape_string($data[0]):"NULL";
$cc = isset($data[1])? mysql_real_escape_string($data[1]):"NULL";
$state = isset($data[2])? mysql_real_escape_string($data[2]):"NULL";
//$state_ = isset($data[3]): mysql_real_escape_string($data[3]):"NULL";
$confirmed = isset($data[4]) && $data[4]>=0 ? $data[4]:0;
$recovered = isset($data[5]) && $data[5]>=0 ? $data[5]:0;
$deaths = isset($data[6]) && $data[6]>=0 ? $data[6]:0;
$tested = isset($data[7]) && $data[7]>=0 ? $data[7]:0;
$testedN = $tested - $confirmed;
$source = isset($data[8]) && $data[8]!="" ? $data[8]:"";
//bd::query("INSERT INTO world_cases VALUES ('$user_name', '$date_case', '$cc', '$country_name', '$state', '$confirmed', '$deaths', '$recovered', '$tested', '$testedN', '$source', '$date_add');");
echo "INSERT INTO world_cases VALUES ('$user_name', '$date_case', '$cc', '$country_name', '$state', '$confirmed', '$deaths', '$recovered', '$tested', '$testedN', '$source', '$date_add');";
}
}

?>