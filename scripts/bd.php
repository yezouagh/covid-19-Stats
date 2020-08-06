<?php
session_write_close();
set_time_limit(0);
ignore_user_abort ( true );
class bd{
public static function connexion() {
$link=  mysql_connect("localhost","root","xxxxxxxxxx") or die ("Error Server");
$bd=  mysql_select_db('covid_19', $link) or die ("Error Data Base");
}
public static function query($rq) {
bd::connexion();
return mysql_query($rq);
}
}
?>

