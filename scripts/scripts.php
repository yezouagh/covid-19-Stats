<?php
error_reporting(-1);
ini_set('display_errors', 'On'); 
//include_once '../account/session.php';
include_once 'bd.php';
if(isset($_GET['action'])){
$action=$_GET['action'];
if($action=='add')add();
if($action=='refresh_world')refresh_world();
if($action=='insert_all')insert_all_us();
if($action=='get')get();
if($action=='change_all')change_all();
if($action=='create_csv')create_csv();
}elseif(isset($argv[1]) && $argv[1]){
if($argv[1]=='upload_new_data')Update_and_replace_empty_data();
}
function add(){
$user_name=isset($_SESSION["username"])?$_SESSION["username"]:"Ezouagh";
$date_case=$_POST["date_case"];
$cc=$_POST["cc"];
$country_name=$_POST["country"];
$state=$_POST["state"];
$confirmed=$_POST["confirmed"];
$deaths=$_POST["deaths"];
$recovered=$_POST["recovered"];
$date_add=date('Y-m-d h:i:s');
$ok=0;
$rep=bd::query("INSERT INTO world_cases VALUES ('$user_name', '$date_case', '$cc', '$country_name', '$state', '$confirmed', '$deaths', '$recovered', '$date_add');");
if($rep){
$ok=1;
}
echo $ok;
}

function refresh_world(){
$list=array();
$sublist=array();
$data= bd::query("SELECT date_case as date, SUM( confirmed ) as confirmed , SUM( deaths ) as deaths, SUM( recovered ) as recovered , cc as id
FROM world_cases GROUP BY date_case, cc ORDER BY date_case ASC");
$date = "";
while ($row = mysql_fetch_array($data)) {
if($row['date']!=$date){
if(!empty($sublist)){
$inlist["date"]=$date;
$inlist["list"]=$sublist;
$list[]=$inlist;
$inlist=array();
$sublist=array();
}
$date = $row['date'];
}
unset($row["date"]);
$sublist[]=$row;
}
if(!empty($list))file_put_contents("/var/www/covid-19/data/js/world_timeline.js", "var covid_world_timeline = ".json_encode($list,JSON_NUMERIC_CHECK ));
$list=array();
$sublist=array();
$data= bd::query("SELECT SUM( confirmed ) as confirmed , SUM( deaths ) as deaths, SUM( recovered ) as recovered ,date_case as date
FROM world_cases  GROUP BY date_case ORDER BY date_case ASC");
while ($row = mysql_fetch_object($data)) {
$list[]=$row;
}
if(!empty($list))file_put_contents("/var/www/covid-19/data/js/total_timeline.js", "var covid_total_timeline = ".json_encode($list,JSON_NUMERIC_CHECK ));
}

function get(){
if(isset($_GET['cc'])){
$cc = $_GET['cc'];
$list=array();
$sublist=array();
$arr = json_decode(file_get_contents('/var/www/covid-19/deps/amcharts4-geodata/data/countriesMaps.json'), true);
$map = '';
if(isset($arr[ $cc ])){
$map = $arr[ $cc ][ 0 ];
if($cc!="US"){
$data= bd::query("SELECT date_case as date,SUM( confirmed ) as confirmed , SUM( deaths ) as deaths, SUM( recovered ) as recovered , state as id
FROM world_cases where cc='$cc' GROUP BY date_case, state ORDER BY date_case ASC,state desc");
$date = "";
if(mysql_num_rows($data)>0)
while ($row = mysql_fetch_array($data,MYSQL_ASSOC)) {
if($row['date']!=$date){
if(!empty($sublist)){
$inlist["date"]=$date;
$inlist["list"]=$sublist;
$list[]=$inlist;
$inlist=array();
$sublist=array();
}
$date = $row['date'];
}
unset($row["date"]);
$sublist[]=$row;
}
if(!empty($sublist)){
$inlist["date"]=$date;
$inlist["list"]=$sublist;
$list[]=$inlist;
$inlist=array();
$sublist=array();
}

//if(!empty($list))
file_put_contents("/var/www/covid-19/data/js/cc_timeline.js", "var covid_cc_timeline = ".json_encode($list,JSON_NUMERIC_CHECK ));
$list=array();
$sublist=array();
if(isset($arr[ $cc ])){
$data= bd::query("SELECT SUM( confirmed ) as confirmed , SUM( deaths ) as deaths, SUM( recovered ) as recovered ,date_case as date 
FROM world_cases where cc='$cc' GROUP BY date_case ORDER BY date_case ASC");
if(mysql_num_rows($data)>0)
while ($row = mysql_fetch_object($data)) {
$list[]=$row;
}
}
//if(!empty($list))
file_put_contents("/var/www/covid-19/data/js/cc_total_timeline.js", "var covid_cc_total_timeline = ".json_encode($list,JSON_NUMERIC_CHECK ));
}
}
return $map;
}
}

function insert_all_us(){
$elements =  json_decode(file_get_contents("https://raw.githubusercontent.com/amcharts/covid-charts/master/data/json/us_timeline.json"));
$user_name="Ezouagh";
$country_name="United States";
$cc="US";
$date_add=date('Y-m-d h:i:s');
foreach ($elements as $ele){
$date_case = $ele->date;
if(strtotime($date_case) === strtotime('today')){
foreach ($ele->list as $e){
$state=$e->id;
$confirmed=$e->confirmed;
$deaths=$e->deaths;
$recovered=$e->recovered;
bd::query("INSERT INTO world_cases VALUES ('$user_name', '$date_case', '$cc', '$country_name', '$state', '$confirmed', '$deaths', '$recovered', '$confirmed', '0', 'https://github.com/CSSEGISandData/COVID-19', '$date_add');");
}
}
}
}

function sample_data($map){
$elements =  json_decode(file_get_contents("/var/www/covid-19/deps/amcharts4-geodata/$map.js"));
foreach ($elements as $ele){
$date_case = $ele->date;
foreach ($ele->list as $e){
$state=$e->id;
$confirmed=$e->confirmed;
$deaths=$e->deaths;
$recovered=$e->recovered;
bd::query("INSERT INTO world_cases VALUES (NULL, '$user_name', '$date_case', '$cc', '$country_name', '$state', '$confirmed', '$deaths', '$recovered', '$date_add');");
}
}
}

function change_all(){
foreach (glob("/var/www/covid-19/deps/amcharts4-geodata/*.js") as $filename) {
$name = explode("/",$filename);
$name = str_replace(".js","",$name[count($name)-1]);
echo "<div>$filename---$name</div>";
var_dump(replace_in_file($filename, "/am4geodata_".$name."/", "am4geodata_cc"));
}
}

function replace_in_file($FilePath, $OldText, $NewText,$NewPath=""){
$NewPath=$NewPath==""?$FilePath:$NewPath;
$Result = array('status' => 'error', 'message' => '');
if(file_exists($NewPath)===TRUE){
if(is_writeable($NewPath)){
try{
$FileContent = file_get_contents($FilePath);
if($OldText!="")$FileContent = preg_replace($OldText, $NewText, $FileContent);
if(file_put_contents($NewPath, $FileContent) > 0){
$Result["status"] = 'success';
}
else{
$Result["message"] = 'Error while writing file';
}
}
catch(Exception $e){
$Result["message"] = 'Error : '.$e;
}
}
else{
$Result["message"] = 'File '.$NewPath.' is not writable !';
}
}
else{
$Result["message"] = 'File '.$NewPath.' does not exist !';
}
return $Result;
}

function Update_and_replace_empty_data(){
$replace = array('/,{"confirmed":0,"deaths":0,"recovered":0,"id":"AX"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"AI"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"AS"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"AQ"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"AW"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"BM"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"BQ"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"BV"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"IO"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"KY"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"CX"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"CC"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"CK"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"CW"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"FK"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"FO"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GF"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"PF"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"TF"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GI"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GL"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GP"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GU"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"PR"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GG"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"HM"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"IM"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"JE"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"KI"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"KP"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"MH"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"MQ"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"YT"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"FM"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"MS"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"NR"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"NC"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"NU"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"NF"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"MP"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"PW"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"PN"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"RE"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"BL"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"SH"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"PM"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"MF"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"WS"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"SX"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"SB"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"GS"}/'
,'/,{"confirmed":\d,"deaths":\d,"recovered":\d,"id":"EH"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"SJ"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"TK"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"TO"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"TC"}/'
,'/{"confirmed":0,"deaths":0,"recovered":0,"id":"TV"},/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"VU"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"VG"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"VI"}/'
,'/,{"confirmed":0,"deaths":0,"recovered":0,"id":"WF"}/'); 
replace_in_file("https://raw.githubusercontent.com/amcharts/covid-charts/master/data/js/world_timeline.js",$replace , "","/var/www/covid-19/data/js/world_timeline.js");
replace_in_file("https://raw.githubusercontent.com/amcharts/covid-charts/master/data/js/total_timeline.js","" , "","/var/www/covid-19/data/js/total_timeline.js");
replace_in_file("https://raw.githubusercontent.com/amcharts/covid-charts/master/data/js/us_timeline.js","/var covid_us_timeline =/" , "var covid_cc_timeline =","/var/www/covid-19/data/js/cc_timeline.js");
replace_in_file("https://raw.githubusercontent.com/amcharts/covid-charts/master/data/js/us_total_timeline.js","/var covid_us_total_timeline =/" , "var covid_cc_total_timeline =","/var/www/covid-19/data/js/cc_total_timeline.js");
}

function create_csv(){
setlocale(LC_ALL, 'en_US');
$cout = 0;
foreach (glob("/var/www/covid-19/deps/amcharts4-geodata/*.js") as $filename) {
$cout++;
$name = explode("/",$filename);
$country_name = str_replace("Low.js","",$name[count($name)-1]);
//echo "<div>$country_name</div>";
$json = explode("features:[",file_get_contents($filename));
$json = explode("]};",$json[1]);
$json = str_replace(array(':','{',']},','"},i',"'","[.","-.",",.","null,"),array('":','{"',']},"','"},"i',"","[0.","-0.",",0.",'null,"'),iconv('UTF-8', 'ASCII//TRANSLIT',"[".$json[0]."]"));
$json = str_replace('",','","',$json);
$elements =  json_decode($json);
//var_dump($json);
$date_add=date('Y-m-d');
$data="Country name,Country Code,State,State name,Confirmed,Recovered,Deaths"."\n";
$cc="";
foreach ($elements as $e){
$state=$e->properties->id;
$state_name=str_replace(',','-',$e->properties->name);
$cc=explode("-",$state);
$cc=$cc[0];
$data.="$country_name,$cc,$state,$state_name,0,0,0"."\n";
}
if(!isset($cc)){
$cc = $country_name;
}
//echo $data;$cout-
if(file_put_contents("medels/$date_add.$cc.csv",$data))echo "<div>$cout - $country_name created</div>";else echo "$country_name not created";
}

}
?>